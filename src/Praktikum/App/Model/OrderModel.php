<?php
declare(strict_types=1);

require_once 'App/Core/BaseModel.php';

class OrderModel extends BaseModel
{
    public function getAll(): array
    {
        $data = $this->db->query("SELECT * FROM `article`");
        return $data->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Insert a new order; returns the new ordering_id or false on failure.
     */
    public function create(string $address, array $selectedPizzas): int|false
    {
        $this->db->begin_transaction();

        try { // Security  :
            $stmtOrder = $this->db->prepare("INSERT INTO `ordering` (`address`) VALUES (?)");
            $stmtOrder->bind_param("s", $address);
            $stmtOrder->execute();

            $orderingId = $this->db->insert_id;

            $stmtArticle = $this->db->prepare("INSERT INTO `ordered_article` (`ordering_id`, `article_id`) VALUES (?, ?)");
            foreach ($selectedPizzas as $articleId) {
                $articleIdInt = (int)$articleId;
                $stmtArticle->bind_param("ii", $orderingId, $articleIdInt);
                $stmtArticle->execute();
            }

            $this->db->commit();
            return $orderingId;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    // --- Baker ---

    /**
     * Returns all ordered_article rows with status 0 (bestellt) or 1 (im Ofen),
     * joined with the article name.
     */
    public function getBakerPizzas(): array
    {
        $result = $this->db->query("
            SELECT oa.ordered_article_id, oa.ordering_id, oa.status, a.name
            FROM ordered_article oa
            JOIN article a ON oa.article_id = a.article_id
            WHERE oa.status IN (0, 1)
            ORDER BY oa.ordering_id, oa.ordered_article_id
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Updates the status of a single ordered_article row.
     */
    public function updatePizzaStatus(int $orderedArticleId, int $status): void
    {
        $stmt = $this->db->prepare("UPDATE `ordered_article` SET `status` = ? WHERE `ordered_article_id` = ?");
        $stmt->bind_param("ii", $status, $orderedArticleId);
        $stmt->execute();
    }

    // --- Driver ---

    /**
     * Returns orders ready for delivery (all pizzas fertig, ordering.status = 0)
     * and orders currently in delivery (ordering.status = 1).
     */
    public function getDeliveryOrders(): array
    {
        $result = $this->db->query("
            SELECT o.ordering_id, o.address, o.status
            FROM ordering o
            WHERE o.status IN (0, 1)
              AND (
                SELECT COUNT(*) FROM ordered_article oa
                WHERE oa.ordering_id = o.ordering_id AND oa.status < 2
              ) = 0
            ORDER BY o.ordering_id
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Updates the delivery status of an order.
     */
    public function updateOrderStatus(int $orderingId, int $status): void
    {
        $stmt = $this->db->prepare("UPDATE `ordering` SET `status` = ? WHERE `ordering_id` = ?");
        $stmt->bind_param("ii", $status, $orderingId);
        $stmt->execute();
    }

    /**
     * Deletes an order and all its ordered_article rows.
     */
    public function delete(int $orderId): bool
    {
        $this->db->begin_transaction();

        try {
            $stmtArticles = $this->db->prepare("DELETE FROM `ordered_article` WHERE `ordering_id` = ?");
            $stmtArticles->bind_param("i", $orderId);
            $stmtArticles->execute();

            $stmtOrder = $this->db->prepare("DELETE FROM `ordering` WHERE `ordering_id` = ?");
            $stmtOrder->bind_param("i", $orderId);
            $stmtOrder->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    // --- API / Customer ---

    /**
     * Returns the status of a specific order for the customer page.
     */
    public function getOrderStatus(int $orderingId): array
    {
        $stmt = $this->db->prepare("
            SELECT o.ordering_id, o.address, o.status AS delivery_status,
                   a.name, oa.status AS pizza_status
            FROM ordering o
            JOIN ordered_article oa ON o.ordering_id = oa.ordering_id
            JOIN article a ON oa.article_id = a.article_id
            WHERE o.ordering_id = ?
        ");
        $stmt->bind_param("i", $orderingId);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($rows)) {
            return ['ordering_id' => null];
        }

        return [
            'ordering_id'      => (int)$rows[0]['ordering_id'],
            'address'          => $rows[0]['address'],
            'delivery_status'  => (int)$rows[0]['delivery_status'],
            'pizzas'           => array_map(fn($r) => [
                'name'   => $r['name'],
                'status' => (int)$r['pizza_status'],
            ], $rows),
        ];
    }
}
