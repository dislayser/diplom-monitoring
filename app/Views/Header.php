
<?php include ("Noscript.php")?>


<!-- HEADER -->
<header class="container-fluid shadow bg-primary">

    <div class="container">
        <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand position-relative" href="<?=BASE_URL;?>">
                    <span class="text-warning"><?=SITE_LOGO?></span>
                    <?=SITE_NAME_HTML?>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                    <?php foreach($main_links as $link => $nav_item): ?>
                        <?php if(($link == '/login.php' && !isset($_SESSION['auth'])) || ($link == '/logout.php' && isset($_SESSION['auth'])) || $link != '/login.php' && $link != '/logout.php'): ?>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-1" href="<?=$nav_item[1]?>">
                                    <?=$nav_item[0]?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
</header>

<script src="<?=BASE_URL?>assets/js/header.js"></script>