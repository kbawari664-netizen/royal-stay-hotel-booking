<?php
session_start();
require_once "config/database.php";

$hotelName = "Royal Grand Hotel";
$hotelLocation = "Karachi, Pakistan";

$roomTypes = [
    ["Superior Room", 7500],
    ["Grand Deluxe Room", 8500],
    ["Deluxe Room", 10000],
    ["Luxury Room", 12000],
    ["Executive Room", 13500],
    ["Premium Room", 15000],
    ["Royal Suite", 18000],
    ["Presidential Suite", 25000]
];

$roomImages = [
    "https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=1200&q=80"
];

$rooms = [];

for ($i = 0; $i < 44; $i++) {

    $roomId = 135 + $i;

    $typeIndex = $i % count($roomTypes);
    $imageIndex = $i % count($roomImages);

    $rooms[] = [
        "id" => $roomId,
        "room_number" => "R-" . $roomId,
        "type" => $roomTypes[$typeIndex][0],
        "price" => $roomTypes[$typeIndex][1],
        "image" => $roomImages[$imageIndex]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Rooms - Royal Stay</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#090909;
    color:#fff;
    font-family:'Montserrat',sans-serif;
}

.navbar{
    height:75px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 7%;
    background:#050505;
    border-bottom:1px solid rgba(212,175,55,.3);
    position:sticky;
    top:0;
    z-index:1000;
}

.logo{
    color:#d4af37;
    font-family:'Playfair Display',serif;
    font-size:27px;
    font-weight:700;
    text-decoration:none;
}

.logo i{
    margin-right:8px;
}

.nav-links{
    display:flex;
    gap:25px;
}

.nav-links a{
    color:#ddd;
    text-decoration:none;
    font-size:14px;
    transition:.3s;
}

.nav-links a:hover{
    color:#d4af37;
}

.hero{
    min-height:350px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    background:
    linear-gradient(rgba(0,0,0,.7),rgba(0,0,0,.85)),
    url("https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80")
    center/cover;
}

.hero h1{
    font-family:'Playfair Display',serif;
    color:#d4af37;
    font-size:55px;
    margin-bottom:10px;
}

.hero p{
    color:#ddd;
    font-size:16px;
}

.container{
    width:86%;
    max-width:1400px;
    margin:70px auto;
}

.section-title{
    text-align:center;
    margin-bottom:45px;
}

.section-title h2{
    font-family:'Playfair Display',serif;
    color:#d4af37;
    font-size:38px;
}

.section-title p{
    color:#999;
    margin-top:10px;
}

.rooms-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
}

.room-card{
    background:#111;
    border:1px solid rgba(212,175,55,.2);
    border-radius:14px;
    overflow:hidden;
    transition:.4s;
}

.room-card:hover{
    transform:translateY(-10px);
    border-color:#d4af37;
    box-shadow:0 20px 50px rgba(212,175,55,.12);
}

.room-image{
    height:220px;
    overflow:hidden;
}

.room-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.5s;
}

.room-card:hover img{
    transform:scale(1.08);
}

.room-content{
    padding:22px;
}

.room-content h3{
    font-family:'Playfair Display',serif;
    color:#fff;
    font-size:22px;
    margin-bottom:10px;
}

.room-number{
    color:#999;
    font-size:13px;
    margin-bottom:12px;
}

.price{
    color:#d4af37;
    font-size:22px;
    font-weight:700;
    margin-bottom:18px;
}

.price span{
    color:#777;
    font-size:12px;
    font-weight:400;
}

.btn{
    width:100%;
    display:block;
    padding:12px;
    text-align:center;
    border-radius:7px;
    text-decoration:none;
    margin-top:9px;
    transition:.3s;
}

.btn-details{
    color:#d4af37;
    border:1px solid #d4af37;
}

.btn-details:hover{
    background:#d4af37;
    color:#000;
}

.btn-book{
    background:#d4af37;
    color:#000;
    font-weight:700;
}

.btn-book:hover{
    background:#fff;
}

@media(max-width:1100px){
    .rooms-grid{
        grid-template-columns:repeat(3,1fr);
    }
}

@media(max-width:800px){
    .rooms-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .nav-links{
        display:none;
    }

    .hero h1{
        font-size:40px;
    }
}

@media(max-width:550px){
    .rooms-grid{
        grid-template-columns:1fr;
    }

    .container{
        width:92%;
    }
}

</style>
</head>

<body>

<?php

$page_title = "Rooms";

require_once "header.php";

?>
<section class="hero">

<div>
<h1>Luxury Rooms</h1>
<p>Experience comfort, elegance and unforgettable hospitality.</p>
</div>

</section>

<div class="container">

<div class="section-title">
<h2>Our Rooms</h2>
<p>Choose your perfect room at Royal Grand Hotel</p>
</div>

<div class="rooms-grid">

<?php foreach($rooms as $room): ?>

<div class="room-card">

<div class="room-image">
<img src="<?= htmlspecialchars($room['image']) ?>"
alt="<?= htmlspecialchars($room['type']) ?>">
</div>

<div class="room-content">

<h3>
<?= htmlspecialchars($room['type']) ?>
</h3>

<div class="room-number">
<i class="fa-solid fa-door-open"></i>
Room <?= htmlspecialchars($room['room_number']) ?>
</div>

<div class="price">
PKR <?= number_format($room['price']) ?>
<span>/ night</span>
</div>

<a class="btn btn-details"
href="rooms-details.php?id=<?= $room['id'] ?>">
View Details
</a>

<a class="btn btn-book"
href="booking.php?room_id=<?= $room['id'] ?>">
Book Now
</a>

</div>

</div>

<?php endforeach; ?>

</div>

</div>
<?php
require_once "footer.php";
?>

</body>
</html>