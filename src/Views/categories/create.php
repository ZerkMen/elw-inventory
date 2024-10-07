<h1>Neue Kategorie erstellen</h1>

<form action="/categories/create" method="POST">
    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input" type="text" name="name" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Beschreibung</label>
        <div class="control">
            <textarea class="textarea" name="description"></textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button class="button is-primary" type="submit">Erstellen</button>
        </div>
    </div>
</form>
