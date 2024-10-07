<h1>Kategorie bearbeiten</h1>

<form action="/categories/edit/<?php echo $category['id']; ?>" method="POST">
    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input" type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Beschreibung</label>
        <div class="control">
            <textarea class="textarea" name="description"><?php echo htmlspecialchars($category['description']); ?></textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button class="button is-primary" type="submit">Aktualisieren</button>
        </div>
    </div>
</form>
