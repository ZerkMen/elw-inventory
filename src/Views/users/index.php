<h1 class="title">Benutzer</h1>

<a href="/users/create" class="button is-primary mb-4">Neuer Benutzer</a>

<table class="table is-fullwidth">
    <thead>
        <tr>
            <th>Avatar</th>
            <th>Benutzername</th>
            <th>Email</th>
            <th>Aktionen</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <?php if ($user['avatar_path']): ?>
                        <img src="<?= htmlspecialchars($user['avatar_path']) ?>" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                    <?php else: ?>
                        <span class="icon is-large">
                            <i class="fas fa-user fa-2x"></i>
                        </span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <a href="/users/edit/<?= $user['id'] ?>" class="button is-small is-info">Bearbeiten</a>
                    <form method="POST" action="/users/delete/<?= $user['id'] ?>" style="display:inline;">
                        <button type="submit" class="button is-small is-danger" onclick="return confirm('Are you sure?')">Löschen</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>