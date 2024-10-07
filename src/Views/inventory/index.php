<?php
// Fehlerbericht aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<style>
    .min-width-span {
        min-width: 50px;
        display: inline-block;
        text-align: center;
    }
</style>
<div class="container">
    <h1 class="title is-2 mb-4">Bestandsverwaltung</h1>

    <?php if (isset($_SESSION['flash'])): ?>
    <div class="notification is-<?= $_SESSION['flash']['type'] ?>">
        <?= $_SESSION['flash']['message'] ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Kategorie</th>
                    <th>Aktueller Bestand</th>
                    <th>Mindestbestand</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventory as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['category_name'] ?? 'Keine Kategorie') ?></td>

                    <!-- Überprüfung der Bestandsmenge und Farbanpassung mit Bulma -->
                    <td>
                        <span
                            class="tag <?= $item['quantity'] < $item['min_stock_level'] ? 'has-background-danger has-text-white' : 'has-background-success has-text-white'; ?> min-width-span"><?= htmlspecialchars($item['quantity']) ?>
                        </span>

                    </td>

                    <td><?= htmlspecialchars($item['min_stock_level']) ?></td>

                    <td>
                        <a href="/inventory/edit/<?= $item['id'] ?>" class="button is-small is-info">Bearbeiten</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>