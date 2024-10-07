<div class="container">
    <h1 class="title">Neuen Lieferanten erstellen</h1>

    <form action="/suppliers/create" method="POST">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Kontaktperson</label>
            <div class="control">
                <input class="input" type="text" name="contact_person">
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email">
            </div>
        </div>

        <div class="field">
            <label class="label">Telefon</label>
            <div class="control">
                <input class="input" type="tel" name="phone">
            </div>
        </div>

        <div class="field">
            <label class="label">Adresse</label>
            <div class="control">
                <textarea class="textarea" name="address"></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-primary">Lieferant erstellen</button>
            </div>
        </div>
    </form>
</div>