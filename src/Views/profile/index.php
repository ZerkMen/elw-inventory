<?php
    $timestamp = htmlspecialchars($user['created_at']);
    $date = new DateTime($timestamp);
    $formattedDate = $date->format('d.m.Y H:i');
    ?>
<h1 class="title">Mein Profil</h1>

<div class="columns">
    <div class="column is-one-third">
        <div class="card">
            <div class="card-image">
                <figure class="image is-square">
                    <img src="<?= $user['avatar_path'] ? htmlspecialchars($user['avatar_path']) : '/assets/images/default-avatar.png' ?>" alt="Profile picture">
                </figure>
            </div>
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4"><?= htmlspecialchars($user['username']) ?></p>
                        <p class="subtitle is-6"><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                </div>
                <div class="content">
                    <p><strong>Rolle:</strong> <?= ucfirst(htmlspecialchars($user['role'])) ?></p>
                    <p><strong>Angelegt am:</strong> <?= $formattedDate ?></p>
                </div>
            </div>
        </div>
        <a href="/profile/edit" class="button is-primary is-fullwidth mt-4">Profil bearbeiten</a>
    </div>
</div>