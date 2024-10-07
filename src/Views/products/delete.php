<h2>Möchten Sie das Produkt "<?= htmlspecialchars($product['name']) ?>" wirklich löschen?</h2>
<form method="POST" action="/products/delete/<?= $product['id'] ?>">
    <button type="submit" class="button is-danger">Ja, löschen</button>
    <a href="/products" class="button">Abbrechen</a>
</form>
