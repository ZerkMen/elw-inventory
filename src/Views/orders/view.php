<h1 class="title">Bestelldetails</h1>

<div class="box">
    <h2 class="subtitle">Bestellung #<?= htmlspecialchars($order['id']) ?></h2>
    <p><strong>Kunde:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
    <p><strong>Gesamtsumme:</strong> <?= htmlspecialchars($order['total_amount']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <?php
    $timestamp = htmlspecialchars($order['order_date']);
    $date = new DateTime($timestamp);
    $formattedDate = $date->format('d.m.Y H:i');
    ?>
    <p><strong>Bestelldatum:</strong> <?= $formattedDate ?></p>
</div>

<h3 class="subtitle">Bestellte Artikel</h3>
<table class="table is-fullwidth">
    <thead>
        <tr>
            <th>Artikel</th>
            <th>Menge</th>
            <th>Preis</th>
            <th>Zwischensumme</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orderItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td><?= htmlspecialchars($item['price']) ?></td>
                <td><?= htmlspecialchars($item['quantity'] * $item['price']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<form method="POST" action="/orders/updateStatus/<?= $order['id'] ?>" class="mt-4">
    <div class="field has-addons">
        <div class="control">
            <div class="select">
                <select name="status">
                    <option value="Ausstehend" <?= $order['status'] == 'Ausstehend' ? 'selected' : '' ?>>in Arbeit</option>
                    <option value="Bearbeitung" <?= $order['status'] == 'Bearbeitung' ? 'selected' : '' ?>>in Bearbeitung</option>
                    <option value="Erledigt" <?= $order['status'] == 'Erledigt' ? 'selected' : '' ?>>Erledigt</option>
                    <option value="Storniert" <?= $order['status'] == 'Storniert' ? 'selected' : '' ?>>Storniert</option>
                </select>
            </div>
        </div>
        <div class="control">
            <button type="submit" class="button is-primary">Update Status</button>
        </div>
    </div>
</form>