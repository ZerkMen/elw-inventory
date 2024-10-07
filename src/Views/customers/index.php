<h1 class="title">Kunden</h1>

<a href="/customers/create" class="button is-primary mb-4">Neuer Kunde</a>

<table class="table is-fullwidth">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Aktionen</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= htmlspecialchars($customer['name']) ?></td>
                <td><?= htmlspecialchars($customer['email']) ?></td>
                <td><?= htmlspecialchars($customer['phone']) ?></td>
                <td>
                    <a href="/customers/edit/<?= $customer['id'] ?>" class="button is-small is-info">Bearbeiten</a>
                    <form method="POST" action="/customers/delete/<?= $customer['id'] ?>" style="display:inline;">
                        <button type="submit" class="button is-small is-danger" onclick="return confirm('Möchtest du den Kunden wirklich löschen?')">Löschen</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>