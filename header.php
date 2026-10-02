<?php

/*
|--------------------------------------------------------------------------
| Royal Stay - Common Header
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);

$isLoggedIn = isset($_SESSION['user_id']);

$userName = $_SESSION['user_name'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php
        echo isset($page_title)
            ? htmlspecialchars($page_title) . " - Royal Stay"
            : "Royal Stay";
        ?>
    </title>

    <!-- Google Fonts -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


<style>

/* =====================================================
   RESET
===================================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: "Montserrat", Arial, sans-serif;
    background: #f7f5f0;
    color: #222;
    overflow-x: hidden;
}

a {
    text-decoration: none;
}

:root {
    --gold: #d4af37;
    --gold-dark: #b28d1c;
    --dark: #111;
    --dark-2: #181818;
    --white: #fff;
}


/* =====================================================
   HEADER
===================================================== */

.site-header {

    position: sticky;

    top: 0;

    left: 0;

    width: 100%;

    z-index: 9999;

    background:
        rgba(17,17,17,.96);

    backdrop-filter:
        blur(12px);

    border-bottom:
        1px solid
        rgba(212,175,55,.20);

    box-shadow:
        0 5px 30px
        rgba(0,0,0,.20);

}


/* =====================================================
   HEADER CONTAINER
===================================================== */

.header-container {

    max-width: 1400px;

    margin: auto;

    padding:
        15px 5%;

    min-height: 75px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 25px;

}


/* =====================================================
   LOGO
===================================================== */

.site-logo {

    display: flex;

    align-items: center;

    gap: 8px;

    color: var(--gold);

    font-family:
        "Playfair Display",
        serif;

    font-size: 29px;

    font-weight: 700;

    letter-spacing: 1px;

    white-space: nowrap;

    transition: .3s ease;

}

.site-logo i {

    font-size: 22px;

}

.site-logo span {

    color: white;

}

.site-logo:hover {

    transform:
        scale(1.04);

    text-shadow:
        0 0 18px
        rgba(212,175,55,.55);

}


/* =====================================================
   NAVIGATION
===================================================== */

.main-nav {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 5px;

}

.main-nav a {

    position: relative;

    color: #eee;

    padding:
        10px 13px;

    border-radius: 7px;

    font-size: 13px;

    font-weight: 600;

    transition: .3s ease;

}


/* GOLD UNDERLINE */

.main-nav a::after {

    content: "";

    position: absolute;

    left: 50%;

    bottom: 4px;

    width: 0;

    height: 2px;

    background:
        var(--gold);

    transform:
        translateX(-50%);

    transition: .3s ease;

}

.main-nav a:hover {

    color:
        var(--gold);

}

.main-nav a:hover::after {

    width: 65%;

}


/* =====================================================
   ACTIVE LINK
===================================================== */

.main-nav a.active {

    color:
        var(--gold);

}

.main-nav a.active::after {

    width: 65%;

}


/* =====================================================
   ICON
===================================================== */

.main-nav a i {

    margin-right: 5px;

}


/* =====================================================
   LOGIN
===================================================== */

.login-btn {

    background:
        var(--gold) !important;

    color:
        #111 !important;

    padding:
        10px 17px !important;

    border-radius:
        25px !important;

    margin-left: 7px;

    font-weight: 700 !important;

}

.login-btn::after {

    display: none !important;

}

.login-btn:hover {

    background:
        white !important;

    color:
        #111 !important;

    transform:
        translateY(-2px);

}


/* =====================================================
   REGISTER
===================================================== */

.register-btn {

    border:
        1px solid
        var(--gold);

    color:
        var(--gold) !important;

    border-radius:
        25px !important;

    padding:
        9px 16px !important;

}

.register-btn::after {

    display: none !important;

}

.register-btn:hover {

    background:
        var(--gold);

    color:
        #111 !important;

}


/* =====================================================
   LOGOUT
===================================================== */

.logout-btn {

    background:
        #222 !important;

    color:
        var(--gold) !important;

    border:
        1px solid
        rgba(212,175,55,.5);

    border-radius:
        25px !important;

    padding:
        9px 16px !important;

}

.logout-btn::after {

    display: none !important;

}

.logout-btn:hover {

    background:
        var(--gold) !important;

    color:
        #111 !important;

}


/* =====================================================
   USER NAME
===================================================== */

.user-name {

    color:
        #ccc;

    font-size: 12px;

    padding:
        5px 8px;

    white-space: nowrap;

}

.user-name i {

    color:
        var(--gold);

}


/* =====================================================
   MOBILE BUTTON
===================================================== */

.menu-toggle {

    display: none;

    width: 45px;

    height: 45px;

    border:
        1px solid
        rgba(212,175,55,.4);

    border-radius: 8px;

    background:
        #181818;

    color:
        var(--gold);

    font-size: 22px;

    cursor: pointer;

    transition: .3s ease;

}

.menu-toggle:hover {

    background:
        var(--gold);

    color:
        #111;

}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 1100px) {

    .header-container {

        padding:
            14px 4%;

    }

    .main-nav {

        gap: 0;

    }

    .main-nav a {

        padding:
            9px 9px;

        font-size: 12px;

    }

}


/* =====================================================
   TABLET / MOBILE
===================================================== */

@media (max-width: 900px) {

    .header-container {

        position: relative;

        min-height: 70px;

    }

    .menu-toggle {

        display: flex;

        align-items: center;

        justify-content: center;

    }

    .main-nav {

        display: none;

        position: absolute;

        top: 70px;

        left: 0;

        width: 100%;

        padding:
            15px 20px 20px;

        background:
            #111;

        border-top:
            1px solid
            rgba(212,175,55,.2);

        box-shadow:
            0 15px 30px
            rgba(0,0,0,.3);

        flex-direction: column;

        align-items: stretch;

        gap: 5px;

    }

    .main-nav.show {

        display: flex;

        animation:
            menuDown .3s ease;

    }

    .main-nav a {

        width: 100%;

        text-align: center;

        padding:
            12px;

    }

    .main-nav a::after {

        display: none;

    }

    .login-btn,
    .register-btn,
    .logout-btn {

        margin:
            4px 0 0 !important;

    }

    .user-name {

        text-align: center;

        padding:
            10px;

    }

}


/* =====================================================
   SMALL MOBILE
===================================================== */

@media (max-width: 500px) {

    .site-logo {

        font-size: 23px;

    }

    .site-logo i {

        font-size: 18px;

    }

    .header-container {

        padding:
            12px 15px;

    }

}


/* =====================================================
   ANIMATION
===================================================== */

@keyframes menuDown {

    from {

        opacity: 0;

        transform:
            translateY(-10px);

    }

    to {

        opacity: 1;

        transform:
            translateY(0);

    }

}

</style>

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="site-header">

    <div class="header-container">


        <!-- LOGO -->

        <a
            href="index.php"
            class="site-logo"
        >

            <i class="fa-solid fa-crown"></i>

            Royal <span>Stay</span>

        </a>


        <!-- MOBILE MENU BUTTON -->

        <button
            type="button"
            class="menu-toggle"
            onclick="toggleMenu()"
            aria-label="Open Menu"
        >

            <i class="fa-solid fa-bars"></i>

        </button>


        <!-- NAVIGATION -->

        <nav
            class="main-nav"
            id="mainNav"
        >


            <!-- HOME -->

            <a
                href="index.php"
                class="<?php
                    echo $current_page === 'index.php'
                        ? 'active'
                        : '';
                ?>"
            >

                <i class="fa-solid fa-house"></i>

                Home

            </a>


            <!-- ABOUT -->

            <a
                href="about.php"
                class="<?php
                    echo $current_page === 'about.php'
                        ? 'active'
                        : '';
                ?>"
            >

                <i class="fa-solid fa-circle-info"></i>

                About

            </a>


            <!-- HOTELS -->

            <a
                href="hotels.php"
                class="<?php
                    echo $current_page === 'hotels.php'
                        ? 'active'
                        : '';
                ?>"
            >

                <i class="fa-solid fa-hotel"></i>

                Hotels

            </a>


            <!-- ROOMS -->

            <a
                href="room.php"
                class="<?php
                    echo $current_page === 'room.php'
                        ? 'active'
                        : '';
                ?>"
            >

                <i class="fa-solid fa-bed"></i>

                Rooms

            </a>


            <!-- SEARCH -->

            <a
                href="search.php"
                class="<?php
                    echo $current_page === 'search.php'
                        ? 'active'
                        : '';
                ?>"
            >

                <i class="fa-solid fa-magnifying-glass"></i>

                Search

            </a>


            <?php if ($isLoggedIn): ?>


                <!-- USER NAME -->

                <span class="user-name">

                    <i class="fa-solid fa-user"></i>

                    <?php
                    echo htmlspecialchars($userName);
                    ?>

                </span>


                <!-- MY BOOKINGS -->

                <a
                    href="my-bookings.php"
                    class="<?php
                        echo $current_page === 'my-bookings.php'
                            ? 'active'
                            : '';
                    ?>"
                >

                    <i class="fa-solid fa-calendar-check"></i>

                    My Bookings

                </a>


                <!-- PROFILE -->

                <a
                    href="profile.php"
                    class="<?php
                        echo $current_page === 'profile.php'
                            ? 'active'
                            : '';
                    ?>"
                >

                    <i class="fa-solid fa-user-circle"></i>

                    Profile

                </a>


                <!-- CONTACT -->

                <a
                    href="contact.php"
                    class="<?php
                        echo $current_page === 'contact.php'
                            ? 'active'
                            : '';
                    ?>"
                >

                    <i class="fa-solid fa-envelope"></i>

                    Contact

                </a>


                <!-- LOGOUT -->

                <a
                    href="logout.php"
                    class="logout-btn"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </a>


            <?php else: ?>


                <!-- CONTACT -->

                <a
                    href="contact.php"
                    class="<?php
                        echo $current_page === 'contact.php'
                            ? 'active'
                            : '';
                    ?>"
                >

                    <i class="fa-solid fa-envelope"></i>

                    Contact

                </a>


                <!-- LOGIN -->

                <a
                    href="login.php"
                    class="login-btn"
                >

                    <i class="fa-solid fa-right-to-bracket"></i>

                    Login

                </a>


                <!-- REGISTER -->

                <a
                    href="register.php"
                    class="register-btn"
                >

                    <i class="fa-solid fa-user-plus"></i>

                    Register

                </a>


            <?php endif; ?>


        </nav>

    </div>

</header>


<script>

/* =====================================================
   MOBILE MENU
===================================================== */

function toggleMenu() {

    const menu =
        document.getElementById("mainNav");

    const button =
        document.querySelector(".menu-toggle i");

    menu.classList.toggle("show");


    if (menu.classList.contains("show")) {

        button.classList.remove("fa-bars");

        button.classList.add("fa-xmark");

    } else {

        button.classList.remove("fa-xmark");

        button.classList.add("fa-bars");

    }

}


/* =====================================================
   CLOSE MENU AFTER CLICK
===================================================== */

document.querySelectorAll(".main-nav a")
    .forEach(function(link) {

        link.addEventListener("click", function() {

            const menu =
                document.getElementById("mainNav");

            const button =
                document.querySelector(".menu-toggle i");

            menu.classList.remove("show");

            button.classList.remove("fa-xmark");

            button.classList.add("fa-bars");

        });

    });

</script>