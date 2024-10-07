<div class="container">
    <h1 class="title">Neuen Rabatt erstellen</h1>

    <form action="/discounts/create" method="POST">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Typ</label>
            <div class="control">
                <div class="select">
                    <select name="type" required>
                        <option value="percentage">Prozentual</option>
                        <option value="fixed">Fester Betrag</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label">Wert</label>
            <div class="control">
                <input class="input" type="number" name="value" step="0.01" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Startdatum</label>
            <div class="control">
                <input class="input" type="date" name="start_date" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Enddatum</label>
            <div class="control">
                <input class="input" type="date" name="end_date" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Produkt (optional)</label>
            <div class="control">
                <div class="select">
                    <select name="product_id">
                        <option value="">Kein spezifisches Produkt</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label">Kunde (optional)</label>
            <div class="control">
                <div class="select">
                    <select name="customer_id">
                        <option value="">Kein spezifischer Kunde</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo $customer['id']; ?>"><?php echo htmlspecialchars($customer['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-primary">Rabatt erstellen</button>
            </div>
        </div>
    </form>
</div>