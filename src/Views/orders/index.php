<h1 class="title">Betellungen</h1>

<a href="/orders/create" class="button is-primary mb-4">Neue Bestellung</a>

<table class="table is-fullwidth">
    <thead>
        <tr>
            <th>Kunde</th>
            <th>Gesamtsumme</th>
            <th>Status</th>
            <th>Bestelldatum</th>
            <th>Aktionen</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <?php
    $timestamp = htmlspecialchars($order['order_date']);
    $date = new DateTime($timestamp);
    $formattedDate = $date->format('d.m.Y H:i');
    ?>
        <tr>
            <td><?= htmlspecialchars($order['customer_name']) ?></td>
            <td><?= htmlspecialchars($order['total_amount']) ?></td>
            <td><?= htmlspecialchars($order['status']) ?></td>
            <td><?= $formattedDate ?></td>
            <td>
                <a href="/orders/view/<?= htmlspecialchars($order['id']) ?>" class="button is-small is-info">Ansehen</a>
                <form action="/orders/delete/<?= htmlspecialchars($order['id']) ?>" method="post"
                    style="display:inline;">
                    <button type="submit" class="button is-small is-danger"
                        onclick="return confirm('Are you sure you want to delete this order?');">Löschen</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (isset($_GET['message'])): ?>
<div class="notification is-success">
    <?= htmlspecialchars($_GET['message']) ?>
</div>
<?php endif; ?>