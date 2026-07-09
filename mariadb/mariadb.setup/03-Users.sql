-- Adds authentication support to the pizzaservice database.
-- Roles: customer (self-registration), baker/driver (seeded here for staff).

USE pizzaservice;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('customer','baker','driver') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed staff accounts (customers self-register through the app instead).
-- Dev-only passwords: baker -> "baker-dev-pw1", driver -> "driver-dev-pw1"
INSERT INTO `users` (`username`, `password_hash`, `role`) VALUES
  ('baker1',  '$2y$12$xyW9fZLRsV5K0N4DhiY1ueRLh54Qo3jxroBK6lmXvjgn5LVAefLfS', 'baker'),
  ('driver1', '$2y$12$ais6o67oDElFXiRFGujyb.SvnlyaLp.FRw1FeTF1q.tfPyGJjeGvS', 'driver');
