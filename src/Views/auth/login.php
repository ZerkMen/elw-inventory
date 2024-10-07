<div class="login-container">
    <div class="login-box box">
        <h1 class="title has-text-centered">Login</h1>

        <?php if (isset($error)): ?>
            <div class="notification is-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <div class="field">
                <label class="label">Benutzername</label>
                <div class="control">
                    <input class="input" type="text" name="username" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Passwort</label>
                <div class="control">
                    <input class="input" type="password" name="password" required>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-primary is-fullwidth">Login</button>
                </div>
            </div>
        </form>
    </div>
</div>
