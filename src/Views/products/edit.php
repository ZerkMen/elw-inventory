<h1 class="title">Edit Product</h1>
<form method="POST" enctype="multipart/form-data">
    <div class="field">
        <label class="label">Artikelnummer</label>
        <div class="control">
            <input class="input" type="text" name="article_number"
                value="<?= htmlspecialchars($product['article_number']) ?>" required>
        </div>
    </div>


    <div class="field">
        <label class="label">Artikelbezeichnung</label>
        <div class="control">
            <input class="input" type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Artikelbeschreibung</label>
        <div class="control">
            <textarea class="textarea" name="description"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
    </div>

    <div class="field">
        <label class="label">Presi</label>
        <div class="control">
            <input class="input" type="number" step="0.01" name="price"
                value="<?= htmlspecialchars($product['price']) ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Quantity</label>
        <div class="control">
            <input class="input" type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>"
                required>
        </div>
    </div>

    <div class="field">
        <label class="label">Artikelgruppe</label>
        <div class="control">
            <div class="select">
                <select name="category_id">
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"
                        <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Lieferant</label>
        <div class="control">
            <div class="select">
                <select name="supplier_id">
                    <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?= $supplier['id'] ?>"
                        <?= $supplier['id'] == $product['supplier_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($supplier['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Mindestbestand</label>
        <div class="control">
            <input class="input" type="number" name="min_stock_level"
                value="<?= htmlspecialchars($product['min_stock_level']) ?>" required>
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
    <?php if ($product['image_path']): ?>
    <div class="field">
        <label class="label">Aktuelles Bild</label>
        <div class="control">
            <figure class="image is-100x100" data-tooltip="Artikelnummer: <?= htmlspecialchars($product['article_number']) ?> - <?= htmlspecialchars($product['name']) ?>">
                <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['article_number'] . ' - ' . $product['name']) ?>" />
            </figure>
        </div>
    </div>
    <?php endif; ?>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-primary">Aktualisieren</button>
        </div>
    </div>
</form>