<div class="container">
    <h1 class="title">Lieferanten</h1>

    <a href="/suppliers/create" class="button is-primary mb-4">Neuen Lieferanten erstellen</a>

    <table class="table is-fullwidth">
        <thead>
            <tr>
                <th>Name</th>
                <th>Kontaktperson</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($suppliers as $supplier): ?>
                <tr>
                    <td><?php echo htmlspecialchars($supplier['name']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['contact_person']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['email']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['phone']); ?></td>
                    <td>
                        <a href="/suppliers/edit/<?php echo $supplier['id']; ?>" class="button is-small is-info">Bearbeiten</a>
                        <form action="/suppliers/delete/<?php echo $supplier['id']; ?>" method="POST" style="display:inline;">
                            <button type="submit" class="button is-small is-danger" onclick="return confirm('Sind Sie sicher, dass Sie diesen Lieferanten löschen möchten?')">Löschen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>