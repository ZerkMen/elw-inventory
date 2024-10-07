<div class="container">
    <h1 class="title">Artikel</h1>

    <a href="/products/create" class="button is-primary mb-4">Artikel anlegen</a>

    <table class="table is-fullwidth">
        <thead>
            <tr>
                <th>Bild</th>
                <th>Lieferant</th>
                <th>Art.-Nr.</th>
                <th>Artikelbezeichnung</th>
                <th>Artikelbeschreibung</th>
                <th>Preis</th>
                <th>Bestand</th>
                <th>Artikelgruppe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <figure class="image is-100x100" data-tooltip="Artikelnummer: <?= htmlspecialchars($product['article_number']) ?> - <?= htmlspecialchars($product['name']) ?>">
                            <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['article_number'] . ' - ' . $product['name']) ?>" />
                        </figure>
                    </td>
                    <td><?= htmlspecialchars($product['supplier_name']) ?></td>
                    <td><?= htmlspecialchars($product['article_number']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                    <td>
                        <div class="buttons">
                            <a href="/products/edit/<?= $product['id'] ?>" class="button is-small is-info" data-tooltip="Ändern">
                                <span class="icon is-small">
                                    <i class="mdi mdi-pencil"></i>
                                </span>
                            </a>
                            <form method="POST" action="/products/delete/<?= $product['id'] ?>" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                <button type="submit" class="button is-small is-danger" data-tooltip="Löschen">
                                    <span class="icon is-small">
                                        <i class="mdi mdi-delete"></i>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>