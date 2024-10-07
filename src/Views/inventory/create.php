<div class="container">
    <h1 class="title">Neues Inventar anlegen</h1>

    <form action="/inventory/create" method="POST">
        <div class="field">
            <label class="label">Artikelname</label>
            <div class="control">
                <input class="input" type="text" name="item_name" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Bestand</label>
            <div class="control">
                <input class="input" type="number" name="quantity" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Lieferant</label>
            <div class="control">
                <div class="select">
                    <select name="supplier_id" required>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?= $supplier['id'] ?>"><?= htmlspecialchars($supplier['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label">Kategorie</label>
            <div class="control">
                <div class="select">
                    <select name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label">Mindestbestand</label>
            <div class="control">
                <input class="input" type="number" name="min_stock_level" required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-primary">Inventar erstellen</button>
            </div>
        </div>
    </form>
</div>
