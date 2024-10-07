<h1 class="title">Artikel anlegen</h1>
<form method="POST" enctype="multipart/form-data">
    <div class="field">
        <label class="label">Article Number</label>
        <div class="control">
            <input class="input" type="text" name="article_number" required>
        </div>
    </div>
        <div class="field">
            <label class="label">Artikelbezeichnung</label>
            <div class="control">
                <input class="input" type="text" name="name" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Artikelbeschreibung</label>
            <div class="control">
                <textarea class="textarea" name="description"></textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">Preis</label>
            <div class="control">
                <input class="input" type="number" step="0.01" name="price" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Menge</label>
            <div class="control">
                <input class="input" type="number" name="quantity" required>
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
            <label class="label">Mindestbestand</label>
            <div class="control">
                <input class="input" type="number" name="min_stock_level" required>
            </div>
        </div>

        <div class="field">
    <label class="label">Image</label>
    <div class="control">
        <div class="file has-name is-fullwidth">
            <label class="file-label">
                <input class="file-input" type="file" name="image" accept="image/*">
                <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Choose a file…
                    </span>
                </span>
                <span class="file-name">
                    No file selected
                </span>
            </label>
        </div>
    </div>
</div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-primary">Produkt erstellen</button>
            </div>
        </div>
    </form>
</div>