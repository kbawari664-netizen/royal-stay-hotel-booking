<?php

session_start();

require_once "config/database.php";

/*
|--------------------------------------------------------------------------
| Check Login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;

}

$user_id = $_SESSION["user_id"];


/*
|--------------------------------------------------------------------------
| Get Logged-in User
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id, name, email, role
    FROM users
    WHERE id = ?
");

$stmt->execute([$user_id]);

$admin = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| User Not Found
|--------------------------------------------------------------------------
*/

if (!$admin) {

    session_destroy();

    header("Location: login.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Admin Role Check
|--------------------------------------------------------------------------
*/

if (($admin["role"] ?? "") !== "admin") {

    http_response_code(403);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Access Denied - Royal Stay</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                radial-gradient(
                    circle at top,
                    #292929,
                    #111 60%
                );

        }

        .denied {

            width: 90%;

            max-width: 500px;

            padding: 45px 35px;

            text-align: center;

            background: #171717;

            border: 1px solid rgba(212,175,55,0.35);

            border-radius: 20px;

            box-shadow:
                0 20px 60px
                rgba(0,0,0,0.6);

            animation: deniedIn 0.7s ease;

        }

        @keyframes deniedIn {

            from {
                opacity: 0;
                transform: translateY(30px) scale(.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

        }

        .denied-icon {

            width: 80px;

            height: 80px;

            margin: 0 auto 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: rgba(212,175,55,0.1);

            border: 1px solid #d4af37;

            font-size: 35px;

        }

        .denied h1 {

            color: #d4af37;

            margin-bottom: 15px;

        }

        .denied p {

            color: #aaa;

            line-height: 1.6;

            margin-bottom: 25px;

        }

        .denied a {

            display: inline-block;

            padding: 13px 28px;

            border-radius: 30px;

            background: #d4af37;

            color: #111;

            text-decoration: none;

            font-weight: bold;

            transition: .3s;

        }

        .denied a:hover {

            transform: translateY(-3px);

            box-shadow:
                0 8px 25px
                rgba(212,175,55,.35);

        }

    </style>

</head>

<body>

    <div class="denied">

        <div class="denied-icon">
            🔒
        </div>

        <h1>
            Access Denied
        </h1>

        <p>
            You do not have permission to access
            the Royal Stay admin panel.
        </p>

        <a href="index.php">
            Back to Home
        </a>

    </div>

</body>

</html>

<?php

    exit;

}


/*
|--------------------------------------------------------------------------
| Dashboard Counts
|--------------------------------------------------------------------------
*/


/* Total Users */

$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM users
");

$total_users = $stmt->fetchColumn();


/* Total Hotels */

$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM hotels
");

$total_hotels = $stmt->fetchColumn();


/* Total Rooms */

$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM rooms
");

$total_rooms = $stmt->fetchColumn();


/* Total Bookings */

$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM bookings
");

$total_bookings = $stmt->fetchColumn();


/* Pending Bookings */

$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM bookings
    WHERE status = 'pending'
");

$pending_bookings = $stmt->fetchColumn();


/*
|--------------------------------------------------------------------------
| Total Payments
|--------------------------------------------------------------------------
*/

$total_payments = 0;

try {

    $stmt = $pdo->query("
        SELECT COALESCE(SUM(total_price), 0)
        FROM bookings
    ");

    $total_payments = $stmt->fetchColumn();

} catch (PDOException $e) {

    $total_payments = 0;

}


/*
|--------------------------------------------------------------------------
| Confirmed Payments
|--------------------------------------------------------------------------
*/

$confirmed_payments = 0;

try {

    $stmt = $pdo->query("
        SELECT COALESCE(SUM(total_price), 0)
        FROM bookings
        WHERE status = 'confirmed'
    ");

    $confirmed_payments = $stmt->fetchColumn();

} catch (PDOException $e) {

    $confirmed_payments = 0;

}


/*
|--------------------------------------------------------------------------
| Total Contact Messages
|--------------------------------------------------------------------------
*/

$total_messages = 0;

try {

    $stmt = $pdo->query("
        SELECT COUNT(*)
        FROM contact_messages
    ");

    $total_messages = $stmt->fetchColumn();

} catch (PDOException $e) {

    $total_messages = 0;

}


/*
|--------------------------------------------------------------------------
| Recent Bookings
|--------------------------------------------------------------------------
*/

$recent_bookings = [];

try {

    $stmt = $pdo->query("
        SELECT

            bookings.id,

            bookings.check_in,

            bookings.check_out,

            bookings.guests,

            bookings.status,

            bookings.total_price,

            users.name AS user_name,

            rooms.room_number,

            rooms.room_type,

            hotels.name AS hotel_name

        FROM bookings

        INNER JOIN users
            ON bookings.user_id = users.id

        INNER JOIN rooms
            ON bookings.room_id = rooms.id

        INNER JOIN hotels
            ON rooms.hotel_id = hotels.id

        ORDER BY bookings.id DESC

        LIMIT 10
    ");

    $recent_bookings =
        $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $recent_bookings = [];

}


/*
|--------------------------------------------------------------------------
| Recent Contact Messages
|--------------------------------------------------------------------------
*/

$recent_messages = [];

try {

    $stmt = $pdo->query("
        SELECT

            id,

            name,

            email,

            subject,

            message,

            created_at

        FROM contact_messages

        ORDER BY id DESC

        LIMIT 5
    ");

    $recent_messages =
        $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $recent_messages = [];

}

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
        Admin Dashboard - Royal Stay
    </title>


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <!-- Google Fonts -->

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >


<style>

/* =====================================================
   RESET
===================================================== */

* {

    box-sizing: border-box;

    margin: 0;

    padding: 0;

}


/* =====================================================
   BODY
===================================================== */

body {

    font-family: "Montserrat", sans-serif;

    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(212,175,55,.08),
            transparent 30%
        ),

        radial-gradient(
            circle at 90% 90%,
            rgba(212,175,55,.06),
            transparent 30%
        ),

        #f4f4f4;

    color: #171717;

    min-height: 100vh;

}


/* =====================================================
   SIDEBAR
===================================================== */

.sidebar {

    position: fixed;

    left: 0;

    top: 0;

    width: 255px;

    height: 100vh;

    padding: 28px 16px;

    background:
        linear-gradient(
            180deg,
            #0b0b0b,
            #161616
        );

    color: white;

    overflow-y: auto;

    border-right:
        1px solid
        rgba(212,175,55,.25);

    box-shadow:
        10px 0 35px
        rgba(0,0,0,.15);

    z-index: 1000;

}


/* Sidebar scrollbar */

.sidebar::-webkit-scrollbar {

    width: 5px;

}

.sidebar::-webkit-scrollbar-thumb {

    background: #d4af37;

    border-radius: 10px;

}


/* =====================================================
   LOGO
===================================================== */

.logo {

    text-align: center;

    color: #d4af37;

    font-family:
        "Playfair Display",
        serif;

    font-size: 27px;

    font-weight: 700;

    letter-spacing: 1px;

    margin-bottom: 35px;

    position: relative;

}


.logo::after {

    content: "";

    display: block;

    width: 60px;

    height: 2px;

    margin: 10px auto 0;

    background:
        linear-gradient(
            90deg,
            transparent,
            #d4af37,
            transparent
        );

}


/* =====================================================
   ADMIN NAME
===================================================== */

.admin-name {

    text-align: center;

    color: #ddd;

    font-size: 14px;

    margin-bottom: 28px;

    line-height: 1.8;

    padding: 15px;

    background:
        rgba(255,255,255,.04);

    border:
        1px solid
        rgba(255,255,255,.08);

    border-radius: 12px;

}


.admin-name small {

    color: #d4af37;

    font-weight: 600;

}


/* =====================================================
   SIDEBAR LINKS
===================================================== */

.sidebar a {

    display: flex;

    align-items: center;

    gap: 12px;

    color: #ddd;

    text-decoration: none;

    padding: 14px 15px;

    border-radius: 10px;

    margin-bottom: 8px;

    transition:
        .3s ease;

    position: relative;

    overflow: hidden;

}


.sidebar a i {

    width: 20px;

    text-align: center;

}


.sidebar a:hover {

    background:
        linear-gradient(
            90deg,
            #d4af37,
            #f0d878
        );

    color: #111;

    transform:
        translateX(4px);

    box-shadow:
        0 7px 20px
        rgba(212,175,55,.18);

}


.sidebar .active {

    background:
        linear-gradient(
            90deg,
            #d4af37,
            #f0d878
        );

    color: #111;

    font-weight: 700;

    box-shadow:
        0 8px 25px
        rgba(212,175,55,.18);

}


.sidebar .logout {

    margin-top: 30px;

    background:
        rgba(153,27,27,.85);

    color: white;

}


.sidebar .logout:hover {

    background: #dc2626;

    color: white;

}


/* =====================================================
   MAIN
===================================================== */

.main {

    margin-left: 255px;

    padding: 35px;

    min-height: 100vh;

}


/* =====================================================
   TOPBAR
===================================================== */

.topbar {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 32px;

    padding: 25px 28px;

    background:
        linear-gradient(
            135deg,
            #151515,
            #252525
        );

    border-radius: 18px;

    color: white;

    position: relative;

    overflow: hidden;

    box-shadow:
        0 15px 40px
        rgba(0,0,0,.16);

}


.topbar::before {

    content: "";

    position: absolute;

    width: 250px;

    height: 250px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.08);

    right: -100px;

    top: -130px;

}


.topbar::after {

    content: "";

    position: absolute;

    width: 100%;

    height: 1px;

    left: 0;

    bottom: 0;

    background:
        linear-gradient(
            90deg,
            transparent,
            #d4af37,
            transparent
        );

}


.topbar h1 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 32px;

    color: #fff;

}


.topbar p {

    color: #aaa;

    margin-top: 8px;

    font-size: 14px;

}


/* =====================================================
   STATISTICS
===================================================== */

.stats {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 20px;

    margin-bottom: 32px;

}


/* =====================================================
   STAT CARD
===================================================== */

.stat-card {

    background: white;

    padding: 24px;

    min-height: 140px;

    border-radius: 16px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.07);

    border:
        1px solid
        rgba(0,0,0,.04);

    border-left:
        5px solid
        #d4af37;

    position: relative;

    overflow: hidden;

    transition:
        .35s ease;

}


.stat-card::before {

    content: "";

    position: absolute;

    width: 100px;

    height: 100px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.08);

    right: -35px;

    top: -35px;

    transition: .4s ease;

}


.stat-card:hover {

    transform:
        translateY(-7px);

    box-shadow:
        0 15px 35px
        rgba(0,0,0,.12);

}


.stat-card:hover::before {

    transform:
        scale(1.5);

}


.stat-icon {

    position: absolute;

    right: 20px;

    bottom: 18px;

    width: 48px;

    height: 48px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        rgba(212,175,55,.12);

    color: #b18b17;

    font-size: 20px;

}


.stat-card h3 {

    color: #777;

    font-size: 14px;

    margin-bottom: 12px;

    font-weight: 600;

}


.stat-number {

    font-size: 30px;

    font-weight: 800;

    color: #111;

}


.payment-number {

    color: #a47e0c;

}


/* =====================================================
   SECTIONS
===================================================== */

.section {

    background: white;

    padding: 26px;

    border-radius: 16px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.06);

    margin-bottom: 30px;

    overflow-x: auto;

}


.section h2 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 24px;

    margin-bottom: 22px;

    color: #171717;

    position: relative;

    padding-left: 15px;

}


.section h2::before {

    content: "";

    position: absolute;

    left: 0;

    top: 3px;

    width: 4px;

    height: 25px;

    border-radius: 10px;

    background: #d4af37;

}


/* =====================================================
   TABLE
===================================================== */

table {

    width: 100%;

    border-collapse: collapse;

    min-width: 900px;

}


th {

    background:
        linear-gradient(
            135deg,
            #111,
            #252525
        );

    color: #d4af37;

    padding: 15px;

    text-align: left;

    font-size: 12px;

    text-transform: uppercase;

    letter-spacing: .5px;

}


td {

    padding: 14px 15px;

    border-bottom:
        1px solid #eee;

    font-size: 13px;

    color: #444;

}


tbody tr {

    transition: .25s ease;

}


tbody tr:hover {

    background:
        #fffaf0;

    transform:
        scale(1.002);

}


td small {

    color: #888;

}


/* =====================================================
   STATUS
===================================================== */

.status {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 11px;

    border-radius: 30px;

    font-size: 11px;

    font-weight: 700;

    text-transform: capitalize;

}


.pending {

    background: #fef3c7;

    color: #92400e;

}


.confirmed {

    background: #dcfce7;

    color: #166534;

}


.cancelled {

    background: #fee2e2;

    color: #991b1b;

}


.completed {

    background: #dbeafe;

    color: #1e40af;

}


/* =====================================================
   MESSAGE CARDS
===================================================== */

.message {

    background:
        linear-gradient(
            135deg,
            #fafafa,
            #fff
        );

    padding: 20px;

    border-radius: 12px;

    margin-bottom: 14px;

    border-left:
        4px solid
        #d4af37;

    box-shadow:
        0 5px 15px
        rgba(0,0,0,.04);

    transition: .3s ease;

}


.message:hover {

    transform:
        translateX(5px);

    box-shadow:
        0 10px 25px
        rgba(0,0,0,.08);

}


.message h3 {

    margin-bottom: 7px;

    color: #222;

    font-size: 16px;

}


.message .email {

    color: #888;

    font-size: 12px;

    margin-bottom: 10px;

}


.message p {

    color: #555;

    line-height: 1.7;

    font-size: 13px;

}


/* =====================================================
   EMPTY
===================================================== */

.empty {

    color: #888;

    text-align: center;

    padding: 35px;

    background: #fafafa;

    border-radius: 10px;

}


/* =====================================================
   ANIMATION
===================================================== */

.stat-card {

    animation:
        cardIn .6s ease both;

}


.stat-card:nth-child(1) {
    animation-delay: .05s;
}

.stat-card:nth-child(2) {
    animation-delay: .10s;
}

.stat-card:nth-child(3) {
    animation-delay: .15s;
}

.stat-card:nth-child(4) {
    animation-delay: .20s;
}

.stat-card:nth-child(5) {
    animation-delay: .25s;
}

.stat-card:nth-child(6) {
    animation-delay: .30s;
}

.stat-card:nth-child(7) {
    animation-delay: .35s;
}


@keyframes cardIn {

    from {

        opacity: 0;

        transform:
            translateY(25px);

    }

    to {

        opacity: 1;

        transform:
            translateY(0);

    }

}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 1100px) {

    .stats {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media (max-width: 900px) {

    .sidebar {

        position: relative;

        width: 100%;

        height: auto;

        padding: 20px;

    }


    .sidebar a {

        display: inline-flex;

        width: auto;

        margin-right: 5px;

    }


    .sidebar .logout {

        margin-top: 10px;

    }


    .main {

        margin-left: 0;

        padding: 20px;

    }


    .stats {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media (max-width: 600px) {

    .main {

        padding: 12px;

    }


    .sidebar {

        padding: 15px;

    }


    .sidebar a {

        display: flex;

        width: 100%;

    }


    .stats {

        grid-template-columns: 1fr;

        gap: 14px;

    }


    .topbar {

        padding: 22px;

    }


    .topbar h1 {

        font-size: 25px;

    }


    .section {

        padding: 18px;

    }


    .section h2 {

        font-size: 21px;

    }

}

</style>

</head>


<body>


<!-- =====================================================
     SIDEBAR
===================================================== -->

<aside class="sidebar">


    <div class="logo">

        <i class="fa-solid fa-crown"></i>

        Royal Stay

    </div>


    <div class="admin-name">

        <i class="fa-solid fa-user-shield"></i>

        <br>

        <?php

        echo htmlspecialchars(
            $admin["name"]
        );

        ?>

        <br>

        <small>
            Administrator
        </small>

    </div>


    <a
        href="admin.php"
        class="active"
    >

        <i class="fa-solid fa-chart-pie"></i>

        Dashboard

    </a>


    <a href="hotels.php">

        <i class="fa-solid fa-hotel"></i>

        Hotels

    </a>


    <a href="rooms.php">

        <i class="fa-solid fa-bed"></i>

        Rooms

    </a>


    <a href="my-bookings.php">

        <i class="fa-solid fa-calendar-check"></i>

        Bookings

    </a>


    <a href="contact.php">

        <i class="fa-solid fa-envelope"></i>

        Contact

    </a>


    <a href="index.php">

        <i class="fa-solid fa-globe"></i>

        Visit Website

    </a>


    <a
        href="logout.php"
        class="logout"
    >

        <i class="fa-solid fa-right-from-bracket"></i>

        Logout

    </a>


</aside>


<!-- =====================================================
     MAIN
===================================================== -->

<main class="main">


    <!-- =================================================
         TOPBAR
    ================================================= -->

    <div class="topbar">

        <div>

            <h1>

                Royal Stay Dashboard

            </h1>

            <p>

                Welcome back,

                <strong>

                    <?php

                    echo htmlspecialchars(
                        $admin["name"]
                    );

                    ?>

                </strong>

                — Manage your hotel system.

            </p>

        </div>

    </div>


    <!-- =================================================
         STATISTICS
    ================================================= -->

    <div class="stats">


        <!-- Users -->

        <div class="stat-card">

            <h3>
                Total Users
            </h3>

            <div class="stat-number">

                <?php

                echo (int)$total_users;

                ?>

            </div>

            <div class="stat-icon">

                <i class="fa-solid fa-users"></i>

            </div>

        </div>


        <!-- Hotels -->

        <div class="stat-card">

            <h3>
                Total Hotels
            </h3>

            <div class="stat-number">

                <?php

                echo (int)$total_hotels;

                ?>

            </div>

            <div class="stat-icon">

                <i class="fa-solid fa-hotel"></i>

            </div>

        </div>


        <!-- Rooms -->

        <div class="stat-card">

            <h3>
                Total Rooms
            </h3>

            <div class="stat-number">

                <?php

                echo (int)$total_rooms;

                ?>

            </div>

            <div class="stat-icon">

                <i class="fa-solid fa-bed"></i>

            </div>

        </div>


        <!-- Bookings -->

        <div class="stat-card">

            <h3>
                Total Bookings
            </h3>

            <div class="stat-number">

                <?php

                echo (int)$total_bookings;

                ?>

            </div>

            <div class="stat-icon">

                <i class="fa-solid fa-calendar-check"></i>

            </div>

        </div>


        <!-- Pending -->

        <div class="stat-card">

            <h3>
                Pending Bookings
            </h3>

            <div class="stat-number">

                <?php

                echo (int)$pending_bookings;

                ?>

            </div>

            <div class="stat-icon">

                <i class="fa-solid fa-clock"></i>

            </div>

        </div>


        <!-- Messages -->

        <div class="stat-card">

            <h3>
                Contact Messages
            </h3>

            <div class="stat-number">

                <?php

                echo (int)$total_messages;

                ?>

            </div>

            <div class="stat-icon">

                <i class="fa-solid fa-envelope"></i>

            </div>

        </div>


        <!-- TOTAL PAYMENTS -->

        <div class="stat-card">

            <h3>
                Total Payments
            </h3>

            <div class="stat-number payment-number">

                Rs.

                <?php

                echo number_format(
                    (float)$total_payments,
                    2
                );

                ?>

            </div>

            <div class="stat-icon">

                <i class="fa-solid fa-money-bill-wave"></i>

            </div>

        </div>


    </div>


    <!-- =================================================
         PAYMENT SUMMARY
    ================================================= -->

    <div class="section">

        <h2>
            Payment Summary
        </h2>


        <div
            style="
                display:grid;
                grid-template-columns:
                    repeat(2,1fr);
                gap:20px;
            "
        >


            <div
                style="
                    padding:25px;
                    border-radius:14px;
                    background:
                        linear-gradient(
                            135deg,
                            #111,
                            #292929
                        );
                    color:white;
                    position:relative;
                    overflow:hidden;
                "
            >

                <div
                    style="
                        font-size:13px;
                        color:#aaa;
                        margin-bottom:10px;
                    "
                >
                    Total Revenue
                </div>

                <div
                    style="
                        font-size:28px;
                        font-weight:800;
                        color:#d4af37;
                    "
                >

                    Rs.

                    <?php

                    echo number_format(
                        (float)$total_payments,
                        2
                    );

                    ?>

                </div>

            </div>


            <div
                style="
                    padding:25px;
                    border-radius:14px;
                    background:
                        linear-gradient(
                            135deg,
                            #d4af37,
                            #f1d77a
                        );
                    color:#111;
                    position:relative;
                    overflow:hidden;
                "
            >

                <div
                    style="
                        font-size:13px;
                        margin-bottom:10px;
                        opacity:.75;
                    "
                >
                    Confirmed Payments
                </div>

                <div
                    style="
                        font-size:28px;
                        font-weight:800;
                    "
                >

                    Rs.

                    <?php

                    echo number_format(
                        (float)$confirmed_payments,
                        2
                    );

                    ?>

                </div>

            </div>


        </div>

    </div>


    <!-- =================================================
         RECENT BOOKINGS
    ================================================= -->

    <div class="section">


        <h2>
            Recent Bookings
        </h2>


        <?php if (!empty($recent_bookings)): ?>


            <table>


                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Guest
                        </th>

                        <th>
                            Hotel
                        </th>

                        <th>
                            Room
                        </th>

                        <th>
                            Check-in
                        </th>

                        <th>
                            Check-out
                        </th>

                        <th>
                            Guests
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php foreach (
                    $recent_bookings
                    as $booking
                ): ?>


                    <?php

                    $status = strtolower(
                        trim(
                            $booking["status"] ?? ""
                        )
                    );

                    ?>


                    <tr>


                        <td>

                            #

                            <?php

                            echo (int)
                                $booking["id"];

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $booking["user_name"]
                                ?? "Unknown"
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $booking["hotel_name"]
                                ?? "Unknown"
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $booking["room_type"]
                                ?? "Room"
                            );

                            ?>

                            <br>

                            <small>

                                Room

                                <?php

                                echo htmlspecialchars(
                                    $booking["room_number"]
                                    ?? ""
                                );

                                ?>

                            </small>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $booking["check_in"]
                                ?? ""
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $booking["check_out"]
                                ?? ""
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo (int)(
                                $booking["guests"]
                                ?? 0
                            );

                            ?>

                        </td>


                        <td>

                            <strong
                                style="
                                    color:#a47e0c;
                                "
                            >

                                Rs.

                                <?php

                                echo number_format(
                                    (float)(
                                        $booking[
                                            "total_price"
                                        ] ?? 0
                                    ),
                                    2
                                );

                                ?>

                            </strong>

                        </td>


                        <td>

                            <span
                                class="
                                    status
                                    <?php
                                    echo htmlspecialchars(
                                        $status
                                    );
                                    ?>
                                "
                            >

                                <?php

                                echo htmlspecialchars(
                                    $booking[
                                        "status"
                                    ] ?? "Unknown"
                                );

                                ?>

                            </span>

                        </td>


                    </tr>


                <?php endforeach; ?>


                </tbody>


            </table>


        <?php else: ?>


            <div class="empty">

                <i
                    class="fa-solid fa-calendar-xmark"
                    style="
                        font-size:30px;
                        color:#d4af37;
                        margin-bottom:10px;
                    "
                ></i>

                <br>

                No bookings found.

            </div>


        <?php endif; ?>


    </div>


    <!-- =================================================
         CONTACT MESSAGES
    ================================================= -->

    <div class="section">


        <h2>
            Recent Contact Messages
        </h2>


        <?php if (!empty($recent_messages)): ?>


            <?php foreach (
                $recent_messages
                as $msg
            ): ?>


                <div class="message">


                    <h3>

                        <?php

                        echo htmlspecialchars(
                            $msg["subject"]
                            ?? "No Subject"
                        );

                        ?>

                    </h3>


                    <div class="email">

                        <i
                            class="fa-solid fa-user"
                        ></i>

                        <?php

                        echo htmlspecialchars(
                            $msg["name"]
                            ?? "Unknown"
                        );

                        ?>


                        &nbsp; • &nbsp;


                        <i
                            class="fa-solid fa-envelope"
                        ></i>

                        <?php

                        echo htmlspecialchars(
                            $msg["email"]
                            ?? ""
                        );

                        ?>


                        &nbsp; • &nbsp;


                        <i
                            class="fa-solid fa-clock"
                        ></i>

                        <?php

                        echo htmlspecialchars(
                            $msg["created_at"]
                            ?? ""
                        );

                        ?>

                    </div>


                    <p>

                        <?php

                        echo nl2br(
                            htmlspecialchars(
                                $msg["message"]
                                ?? ""
                            )
                        );

                        ?>

                    </p>


                </div>


            <?php endforeach; ?>


        <?php else: ?>


            <div class="empty">

                <i
                    class="fa-solid fa-envelope-open"
                    style="
                        font-size:30px;
                        color:#d4af37;
                        margin-bottom:10px;
                    "
                ></i>

                <br>

                No contact messages found.

            </div>


        <?php endif; ?>


    </div>


</main>


</body>

</html>