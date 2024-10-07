<h1 class="title">Benutzer bearbeiten</h1>

<form method="POST" enctype="multipart/form-data">
    <div class="field">
        <label class="label">Benutzername</label>
        <div class="control">
            <input
                class="input"
                type="text"
                name="username"
                value="<?= htmlspecialchars($user['username']) ?>"
                required="required">
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input
                class="input"
                type="email"
                name="email"
                value="<?= htmlspecialchars($user['email']) ?>"
                required="required">
        </div>
    </div>

    <div class="field">
        <label class="label">Neues Passwort (leer lassen, wenn nicht geändert werden soll)</label>
        <div class="control">
            <input class="input" type="password" name="password">
        </div>
    </div>

    <div class="field">
        <label class="label">Rolle</label>
        <div class="control">
            <div class="select">
                <select name="role">
                    <option
                        value="admin"
                        <?= isset($user) && $user['role'] == 'admin' ? 'selected' : '' ?>>Administrator</option>
                    <option
                        value="manager"
                        <?= isset($user) && $user['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
                    <option
                        value="employee"
                        <?= isset($user) && $user['role'] == 'employee' ? 'selected' : '' ?>>Mitarbeiter</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Avatar</label>
        <div class="control">
            <input type="file" name="avatar" accept="image/*">
        </div>
    </div>

    <?php if ($user['avatar_path']): ?>
    <div class="field">
        <label class="label">Avatar aktuell</label>
        <div class="control">
            <img
                src="<?= htmlspecialchars($user['avatar_path']) ?>"
                alt="Current Avatar"
                style="max-width: 100px; border-radius: 50%;">
        </div>
    </div>
    <?php endif; ?>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-primary">Update Benutzer</button>
        </div>
    </div>
</form>