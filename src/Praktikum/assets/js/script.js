document.addEventListener("DOMContentLoaded", () => {

    // ── Baker / Driver: auto-submit radio buttons ────────────────────────────
    // Runs on every page; is a no-op when no .auto-submit elements exist.
    document.querySelectorAll('.auto-submit').forEach(radio => {
        radio.addEventListener('click', () => {          // React to user actions
            radio.form.submit();
        });
    });

    // ── Order page: cart logic ───────────────────────────────────────────────
    const cartSelect = document.getElementById('cart-select');          // Find elements on the page
    if (!cartSelect) return;

    const totalPriceEl    = document.getElementById('total-price');     // Find elements on the page
    const orderBtn        = document.getElementById('order-btn');
    const addressInput    = document.getElementById('user-address');
    const deleteSelectedBtn = document.getElementById('delete-selected-btn');
    const deleteAllBtn    = document.getElementById('delete-all-btn');
    const orderForm       = document.getElementById('order-form');

    function updateTotal() {
        let total = 0;
        for (const option of cartSelect.options) {
            total += parseFloat(option.dataset.price);
        }
        totalPriceEl.textContent = total.toFixed(2).replace('.', ',');
    }

    function validateOrder() {
        const valid = addressInput.value.trim() !== '' && cartSelect.options.length > 0;
        orderBtn.disabled = !valid;
        orderBtn.classList.toggle('btn-disabled', !valid);
    }

    // Clicking a pizza image adds it to the cart select
    document.querySelectorAll('.article-item').forEach(article => {
        article.style.cursor = 'pointer';
        article.addEventListener('click', () => {
            const option = document.createElement('option');   // Create new elements & add them
            option.value = article.dataset.id;          // Find elements on the page

            option.textContent =
                `${article.dataset.name} – ${parseFloat(article.dataset.price).toFixed(2).replace('.', ',')}€`;
            option.dataset.price = article.dataset.price;
            cartSelect.appendChild(option);
            updateTotal();
            validateOrder();
        });
    });

    // Delete only the currently highlighted options
    deleteSelectedBtn.addEventListener('click', () => {
        Array.from(cartSelect.selectedOptions).forEach(opt => opt.remove());
        updateTotal();
        validateOrder();
    });

    // Clear entire cart
    deleteAllBtn.addEventListener('click', () => {
        cartSelect.innerHTML = '';
        updateTotal();
        validateOrder();
    });

    addressInput.addEventListener('input', validateOrder);  //React to user actions (Events)

    // Before submit: select ALL options so they are all sent
    orderForm.addEventListener('submit', () => {
        for (const option of cartSelect.options) {
            option.selected = true;
        }
    });

    validateOrder();
});
