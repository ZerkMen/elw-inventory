<h1 class="title">Create Order</h1>

<form id="orderForm" method="POST">
    <div class="field">
        <label class="label">Kunden</label>
        <div class="control">
            <div class="select">
                <select name="customer_id" required>
                    <option value="">Ein Kunden wählen</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>"><?= htmlspecialchars($customer['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div id="orderItems">
        <div class="order-item field is-grouped">
            <div class="control">
                <div class="select">
                    <select name="product_id[]" required>
                        <option value="">Ein Produkt wählen</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>"><?= htmlspecialchars($product['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="control">
                <input class="input" type="number" name="quantity[]" placeholder="Quantity" required min="1">
            </div>
            <div class="control">
                <input class="input" type="number" name="price[]" placeholder="Price" required min="0" step="0.01">
            </div>
            <div class="control">
                <button type="button" class="button is-danger remove-item">Löschen</button>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="button" id="addItem" class="button is-info">Artikel hinzufügen</button>
        </div>
    </div>

    <div class="field">
        <label class="label">Gesamtsumme</label>
        <div class="control">
            <input class="input" type="number" name="total_amount" id="totalAmount" readonly>
        </div>
    </div>

    <input type="hidden" name="items" id="itemsJson">

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-primary">Bestellung erstellen</button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderItems = document.getElementById('orderItems');
    const addItemButton = document.getElementById('addItem');
    const orderForm = document.getElementById('orderForm');
    const totalAmountInput = document.getElementById('totalAmount');
    const itemsJsonInput = document.getElementById('itemsJson');

    addItemButton.addEventListener('click', function() {
        const newItem = orderItems.children[0].cloneNode(true);
        newItem.querySelector('select').selectedIndex = 0;
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        orderItems.appendChild(newItem);
    });

    orderItems.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            if (orderItems.children.length > 1) {
                e.target.closest('.order-item').remove();
            }
        }
    });

    orderItems.addEventListener('change', function(e) {
        if (e.target.name === 'product_id[]') {
            const priceInput = e.target.closest('.order-item').querySelector('input[name="price[]"]');
            priceInput.value = e.target.options[e.target.selectedIndex].dataset.price;
        }
        calculateTotal();
    });

    orderItems.addEventListener('input', calculateTotal);

    function calculateTotal() {
        let total = 0;
        const items = [];
        orderItems.querySelectorAll('.order-item').forEach(item => {
            const quantity = parseFloat(item.querySelector('input[name="quantity[]"]').value) || 0;
            const price = parseFloat(item.querySelector('input[name="price[]"]').value) || 0;
            total += quantity * price;
            items.push({
                product_id: item.querySelector('select[name="product_id[]"]').value,
                quantity: quantity,
                price: price
            });
        });
        totalAmountInput.value = total.toFixed(2);
        itemsJsonInput.value = JSON.stringify(items);
    }

    orderForm.addEventListener('submit', function(e) {
        calculateTotal();
    });
});
</script>