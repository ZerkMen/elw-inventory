<?php echo "<!-- Start of discounts/index.php -->"; ?>
<div class="container">
    <h1 class="title">Rabatte</h1>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="notification is-success">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="notification is-danger">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <a href="/discounts/create" class="button is-primary mb-4">Neuen Rabatt erstellen</a>

    <table class="table is-fullwidth">
        <thead>
            <tr>
                <th>Name</th>
                <th>Typ</th>
                <th>Wert</th>
                <th>Startdatum</th>
                <th>Enddatum</th>
                <th>Produkt</th>
                <th>Kunde</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($discounts as $discount): ?>
                <tr>
                    <td><?php echo htmlspecialchars($discount['name']); ?></td>
                    <td><?php echo htmlspecialchars($discount['type']); ?></td>
                    <td><?php echo htmlspecialchars($discount['value']); ?></td>
                    <td><?php echo htmlspecialchars($discount['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($discount['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($discount['product_name'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($discount['customer_name'] ?? 'N/A'); ?></td>
                    <td>
                        <a href="/discounts/edit/<?php echo $discount['id']; ?>" class="button is-small is-info">Bearbeiten</a>
                        <a href="/discounts/delete/<?php echo $discount['id']; ?>" class="button is-small is-danger" onclick="return confirm('Sind Sie sicher, dass Sie diesen Rabatt löschen möchten?')">Löschen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php echo "<!-- End of discounts/index.php -->"; ?>
