<div class="container">
    <h1 class="title">Lieferant bearbeiten</h1>

    <form action="/suppliers/edit/<?php echo $supplier['id']; ?>" method="POST">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" value="<?php echo htmlspecialchars($supplier['name']); ?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Kontaktperson</label>
            <div class="control">
                <input class="input" type="text" name="contact_person" value="<?php echo htmlspecialchars($supplier['contact_person']); ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" value="<?php echo htmlspecialchars($supplier['email']); ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">Telefon</label>
            <div class="control">
                <input class="input" type="tel" name="phone" value="<?php echo htmlspecialchars($supplier['phone']); ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">Adresse</label>
            <div class="control">
                <textarea class="textarea" name="address"><?php echo htmlspecialchars($supplier['address']); ?></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-primary">Lieferant aktualisieren</button>
            </div>
        </div>
    </form>
</div>