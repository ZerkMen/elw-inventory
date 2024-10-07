<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<div class="container">
    <h1 class="title">Inventar bearbeiten</h1>

    <form action="/inventory/edit/<?= $inventory['id'] ?>" method="POST">
        <!-- Artikelname -->
        <div class="field">
            <label class="label">Artikelname</label>
            <div class="control">
                <input class="input" type="text" name="name" value="<?= htmlspecialchars($inventory['name'] ?? '') ?>" required>
            </div>
        </div>

        <!-- Bestand -->
        <div class="field">
            <label class="label">Bestand</label>
            <div class="control">
                <input class="input" type="number" name="quantity" value="<?= htmlspecialchars($inventory['quantity']) ?>" required>
            </div>
        </div>

        <!-- Lieferant -->
        <div class="field">
            <label class="label">Lieferant</label>
            <div class="control">
                <div class="select is-fullwidth">
                    <select name="supplier_id" required>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?= $supplier['id'] ?>" <?= $supplier['id'] == $inventory['supplier_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($supplier['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Kategorie -->
        <div class="field">
            <label class="label">Kategorie</label>
            <div class="control">
                <div class="select is-fullwidth">
                    <select name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $inventory['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Mindestbestand -->
        <div class="field">
            <label class="label">Mindestbestand</label>
            <div class="control">
                <input class="input" type="number" name="min_stock_level" value="<?= htmlspecialchars($inventory['min_stock_level']) ?>" required>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-primary">Inventar aktualisieren</button>
            </div>
        </div>
    </form>
</div>
