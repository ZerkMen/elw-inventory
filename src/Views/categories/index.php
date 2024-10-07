<h1 class="title">Produktkategorien</h1>

<a href="/categories/create" class="button is-primary">Neue Kategorie erstellen</a>

<?php if (!empty($categories)) : ?>
    <table class="table is-fullwidth is-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Beschreibung</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td><?php echo htmlspecialchars($category['description']); ?></td>
                    <td>
                        <a href="/categories/edit/<?php echo $category['id']; ?>" class="button is-small is-info">Bearbeiten</a>
                        <form action="/categories/delete/<?php echo $category['id']; ?>" method="POST" style="display:inline;">
                            <button type="submit" class="button is-small is-danger">Löschen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Keine Kategorien vorhanden.</p>
<?php endif; ?>
