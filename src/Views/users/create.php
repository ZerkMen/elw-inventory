<h1 class="title">Neuer Benutzer</h1>

<form method="POST" enctype="multipart/form-data">
    <div class="field">
        <label class="label">Benutzername</label>
        <div class="control">
            <input class="input" type="text" name="username" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input class="input" type="email" name="email" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Passwort</label>
        <div class="control">
            <input class="input" type="password" name="password" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Avatar</label>
        <div class="control">
            <input type="file" name="avatar" accept="image/*">
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-primary">Benutzer anlegen</button>
        </div>
    </div>
</form>