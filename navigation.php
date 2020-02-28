<?php
session_start();

?>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            Blog
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <?php if (empty($_SESSION['user_data'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            Войти
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">
                            Регистрация
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($_SESSION['user_data'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-success" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_SESSION['user_data']['name']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="profile.php">
                                Профиль
                            </a>
                            <a class="dropdown-item" href="admin.php">
                                Администратор
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="components/auth/logout.php?logout=true">
                                Выйти
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>