<?php
use Inventory\Helpers\Auth;
use Inventory\Helpers\Authorization;
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="de-DE">

<head>
    <link rel="icon" href="/assets/images/logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Inventory Management System' ?></title>
    <!-- Link zur vollständigen Bulma CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css">
    <!--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <style>
        <?php if ( !Auth::isLoggedIn()): // Wenn der Benutzer nicht eingeloggt ist, das Hintergrundbild laden ?>
        /*
        Hintergrundbild
        */
        html,
        body
        {
        height:
        100%;
        margin:
        0;
        padding:
        0;
        background:
        url('/assets/images/inventory_bg.jpg')
        no-repeat
        center
        center
        fixed;
        background-size:
        cover;
        }
        /*
        Container
        für
        das
        zentrierte
        Formular
        */
        .login-container
        {
        display:
        flex;
        justify-content:
        center;
        align-items:
        center;
        min-height:
        100vh;
        /*
        Volle
        Höhe
        des
        Viewports
        */
        }
        /*
        Formular-Box
        mit
        Schatten
        und
        abgerundeten
        Ecken
        */
        .login-box
        {
        background-color:
        rgba(255,
        255,
        255,
        0.9);
        /*
        Leicht
        transparenter
        Hintergrund
        */
        padding:
        2rem;
        border-radius:
        10px;
        box-shadow:
        0px
        4px
        10px
        rgba(0,
        0,
        0,
        0.1);
        width:
        100%;
        max-width:
        400px;
        }
        <?php endif;
        ?>
        .navbar-item
        img
        {
        max-height:
        3rem;
        }
        .image.is-100x100
        img
        {
        max-width:
        100px;
        height:
        auto;
        }
        [data-tooltip]
        {
        position:
        relative;
        cursor:
        pointer;
        }
        [data-tooltip]::before
        {
        position:
        absolute;
        top:
        -30px;
        left:
        50%;
        transform:
        translateX(-50%);
        z-index:
        20;
        display:
        none;
        content:
        attr(data-tooltip);
        padding:
        0.5em
        1em;
        white-space:
        nowrap;
        background-color:
        #333;
        color:
        #fff;
        font-size:
        0.75rem;
        line-height:
        1.2;
        border-radius:
        4px;
        }
        [data-tooltip]::after
        {
        position:
        absolute;
        top:
        -10px;
        left:
        50%;
        transform:
        translateX(-50%);
        z-index:
        21;
        display:
        none;
        width:
        0;
        height:
        0;
        border-left:
        6px
        solid
        transparent;
        border-right:
        6px
        solid
        transparent;
        border-top:
        6px
        solid
        #333;
        content:
        '';
        }
        [data-tooltip]:hover::before,
        [data-tooltip]:hover::after
        {
        display:
        block;
        }
        .footer.is-dark
        {
        background-color:
        #2F2F2F;
        /*
        Anthrazit
        (Dunkelgrau)
        */
        color:
        #ffffff;
        /*
        Weißer
        Text
        für
        guten
        Kontrast
        */
        }
    </style>
</head>

<body>
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <img src="/assets/images/logo.png" alt="Inventory Management System Logo">
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbarBasicExample" class="navbar-menu">
            <?php if (Auth::isLoggedIn()): ?>
            <div class="navbar-start">
                <?php if (Authorization::hasPermission($user['role'], 'viewDashboard')): ?>
                <a class="navbar-item" href="/dashboard">
                    <span class="icon"><i class="fas fa-chart-bar"></i></span>
                    <span>Dashboard</span>
                </a>
                <?php endif; ?>
                <?php if (Authorization::hasPermission($user['role'], 'viewCategories')): ?>
                <a class="navbar-item" href="/categories">
                    <span class="icon"><i class="fas fa-tags"></i></span>
                    <span>Artikelgruppen</span>
                </a>
                <?php endif; ?>
                <?php if (Authorization::hasPermission($user['role'], 'viewSuppliers')): ?>
                <a class="navbar-item" href="/suppliers">
                    <span class="icon"><i class="fas fa-truck"></i></span>
                    <span>Lieferanten</span>
                </a>
                <?php endif; ?>
                <?php if (Authorization::hasPermission($user['role'], 'viewProducts')): ?>
                <a class="navbar-item" href="/products">
                    <span class="icon"><i class="fas fa-box"></i></span>
                    <span>Artikel</span>
                </a>
                <?php endif; ?>
                <?php if (Authorization::hasPermission($user['role'], 'viewInventory')): ?>
                <a class="navbar-item" href="/inventory">
                <span class="icon"><i class="fas fa-boxes"></i></span>
                    <span>Bestand</span>
                </a>
                <?php endif; ?>
                <?php if (Authorization::hasPermission($user['role'], 'viewDiscounts')): ?>
                <a class="navbar-item" href="/discounts">
                    <span class="icon"><i class="fas fa-percent"></i></span>
                    <span>Rabatte</span>
                </a>
                <?php endif; ?>
                <?php if (Authorization::hasPermission($user['role'], 'viewCustomers')): ?>
                <a class="navbar-item" href="/customers">
                    <span class="icon"><i class="fas fa-users"></i></span>
                    <span>Kunden</span>
                </a>
                <?php endif; ?>
                <?php if (Authorization::hasPermission($user['role'], 'viewOrders')): ?>
                <a class="navbar-item" href="/orders">
                    <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                    <span>Bestellungen</span>
                </a>
                <?php endif; ?>
                <?php if (Authorization::hasPermission($user['role'], 'manageUsers')): ?>
                <a class="navbar-item" href="/users">
                    <span class="icon"><i class="fas fa-user-cog"></i></span>
                    <span>Benutzer</span>
                </a>
                <?php endif; ?>
            </div>
            <div class="navbar-end">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <span class="icon"><i class="fas fa-user"></i></span>
                        <span><?= htmlspecialchars($user['username']) ?></span>
                    </a>

                    <div class="navbar-dropdown is-right">
                        <a class="navbar-item" href="/profile">
                            <span class="icon"><i class="fas fa-id-card"></i></span>
                            <span>Benutzerkonto</span>
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="/logout">
                            <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                            <span>Verlassen</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <section class="section">
        <div class="container">
            <?php if (isset($_SESSION['flash'])): ?>
            <div class="notification is-<?= $_SESSION['flash']['type'] ?>">
                <button class="delete"></button>
                <?= $_SESSION['flash']['message'] ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </section>

    <footer class="footer is-dark">
        <div class="content has-text-centered">
            <p class="has-text-white">
                <strong class="has-text-white">ELW Systems</strong>
                <br>
                © <?= date('Y') ?> All rights reserved.
            </p>
        </div>
    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Functions to open and close a modal
            function openModal($el) {
                $el.classList.add('is-active');
            }

            function closeModal($el) {
                $el.classList.remove('is-active');
            }

            function closeAllModals() {
                (document.querySelectorAll('.modal') || []).forEach(($modal) => {
                    closeModal($modal);
                });
            }

            // Add a click event on buttons to open a specific modal
            (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
                const modal = $trigger.dataset.target;
                const $target = document.getElementById(modal);

                $trigger.addEventListener('click', () => {
                    openModal($target);
                });
            });

            // Add a click event on various child elements to close the parent modal
            (document.querySelectorAll(
                    '.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') ||
            []).forEach(($close) => {
                const $target = $close.closest('.modal');

                $close.addEventListener('click', () => {
                    closeModal($target);
                });
            });

            // Add a keyboard event to close all modals
            document.addEventListener('keydown', (event) => {
                const e = event || window.event;

                if (e.keyCode === 27) { // Escape key
                    closeAllModals();
                }
            });

            // Navbar burger menu for mobile
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
            if ($navbarBurgers.length > 0) {
                $navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }

            // Close flash messages
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;

                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
</body>

</html>