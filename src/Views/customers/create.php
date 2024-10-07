<h1 class="title"><?= isset($customer) ? 'Edit' : 'Create' ?> Customer</h1>

<form method="POST">
    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input" type="text" name="name" value="<?= isset($customer) ? htmlspecialchars($customer['name']) : '' ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input class="input" type="email" name="email" value="<?= isset($customer) ? htmlspecialchars($customer['email']) : '' ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Telefon</label>
        <div class="control">
            <input class="input" type="tel" name="phone" value="<?= isset($customer) ? htmlspecialchars($customer['phone']) : '' ?>">
        </div>
    </div>

    <div class="field">
        <label class="label">Addresse</label>
        <div class="control">
            <textarea class="textarea" name="address"><?= isset($customer) ? htmlspecialchars($customer['address']) : '' ?></textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-primary"><?= isset($customer) ? 'Update' : 'Create' ?> Kunde</button>
        </div>
    </div>
</form>