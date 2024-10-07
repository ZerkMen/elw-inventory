<h1 class="title">Edit Profile</h1>

<form action="/profile/edit" method="POST" enctype="multipart/form-data">
    <div class="field">
        <label class="label">Username</label>
        <div class="control">
            <input class="input" type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input class="input" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">New Password (leave blank to keep current)</label>
        <div class="control">
            <input class="input" type="password" name="password">
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
            <label class="label">Current Avatar</label>
            <div class="control">
                <img src="<?= htmlspecialchars($user['avatar_path']) ?>" alt="Current Avatar" style="max-width: 100px;">
            </div>
        </div>
    <?php endif; ?>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-primary">Update Profile</button>
        </div>
    </div>
</form>