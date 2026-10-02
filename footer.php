
<?php
/*
|--------------------------------------------------------------------------
| Royal Stay - Footer
|--------------------------------------------------------------------------
*/
?>

<footer class="royal-footer">

    <!-- Gold Top Line -->
    <div class="footer-top-line"></div>

    <div class="footer-container">

        <!-- =========================================================
             BRAND
        ========================================================== -->

        <div class="footer-column footer-brand">

            <a href="index.php" class="footer-logo">

                <span class="logo-icon">
                    <i class="fa-solid fa-crown"></i>
                </span>

                <span>
                    Royal <b>Stay</b>
                </span>

            </a>

            <p class="footer-description">
                Experience luxury, comfort and unforgettable hospitality
                with Royal Stay. Discover beautiful hotels and make your
                next journey truly special.
            </p>

            <!-- Social Icons -->

            <div class="footer-social">

                <a
                    href="#"
                    aria-label="Facebook"
                    title="Facebook"
                >
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

                <a
                    href="#"
                    aria-label="Instagram"
                    title="Instagram"
                >
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a
                    href="#"
                    aria-label="Twitter"
                    title="Twitter"
                >
                    <i class="fa-brands fa-x-twitter"></i>
                </a>

                <a
                    href="#"
                    aria-label="YouTube"
                    title="YouTube"
                >
                    <i class="fa-brands fa-youtube"></i>
                </a>

            </div>

        </div>


        <!-- =========================================================
             QUICK LINKS
        ========================================================== -->

        <div class="footer-column">

            <h3>
                Quick Links
            </h3>

            <ul>

                <li>
                    <a href="index.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Home
                    </a>
                </li>

                <li>
                    <a href="hotels.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Hotels
                    </a>
                </li>

                <li>
                    <a href="search.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Search Hotels
                    </a>
                </li>

                <li>
                    <a href="about.php">
                        <i class="fa-solid fa-angle-right"></i>
                        About Us
                    </a>
                </li>

                <li>
                    <a href="contact.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Contact
                    </a>
                </li>

            </ul>

        </div>


        <!-- =========================================================
             SERVICES
        ========================================================== -->

        <div class="footer-column">

            <h3>
                Our Services
            </h3>

            <ul>

                <li>
                    <a href="hotels.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Luxury Hotels
                    </a>
                </li>

                <li>
                    <a href="hotels.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Hotel Booking
                    </a>
                </li>

                <li>
                    <a href="hotels.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Premium Rooms
                    </a>
                </li>

                <li>
                    <a href="hotels.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Free WiFi
                    </a>
                </li>

                <li>
                    <a href="contact.php">
                        <i class="fa-solid fa-angle-right"></i>
                        Customer Support
                    </a>
                </li>

            </ul>

        </div>


        <!-- =========================================================
             CONTACT
        ========================================================== -->

        <div class="footer-column footer-contact">

            <h3>
                Contact Us
            </h3>

            <div class="contact-item">

                <span class="contact-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </span>

                <div>
                    <strong>
                        Location
                    </strong>

                    <p>
                        Karachi, Pakistan
                    </p>
                </div>

            </div>


            <div class="contact-item">

                <span class="contact-icon">
                    <i class="fa-solid fa-phone"></i>
                </span>

                <div>
                    <strong>
                        Phone
                    </strong>

                    <p>
                        +92 300 0000000
                    </p>
                </div>

            </div>


            <div class="contact-item">

                <span class="contact-icon">
                    <i class="fa-solid fa-envelope"></i>
                </span>

                <div>
                    <strong>
                        Email
                    </strong>

                    <p>
                        info@royalstay.com
                    </p>
                </div>

            </div>


            <div class="contact-item">

                <span class="contact-icon">
                    <i class="fa-solid fa-clock"></i>
                </span>

                <div>
                    <strong>
                        Support
                    </strong>

                    <p>
                        24/7 Available
                    </p>
                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         FOOTER BOTTOM
    ========================================================== -->

    <div class="footer-bottom">

        <div class="footer-bottom-container">

            <p>
                ©
                <span id="footerYear"></span>
                <strong>Royal Stay</strong>.
                All Rights Reserved.
            </p>


            <div class="footer-bottom-links">

                <a href="#">
                    Privacy Policy
                </a>

                <span>
                    |
                </span>

                <a href="#">
                    Terms & Conditions
                </a>

            </div>

        </div>

    </div>

</footer>


<style>

/* =========================================================
   ROYAL STAY FOOTER
========================================================= */

.royal-footer {

    position: relative;

    background:
        linear-gradient(
            145deg,
            #111111,
            #080808
        );

    color: #ffffff;

    margin-top: 40px;

    overflow: hidden;

    border-top:
        1px solid
        rgba(212,175,55,.12);
}


/* =========================================================
   TOP GOLD LINE
========================================================= */

.footer-top-line {

    width: 100%;

    height: 2px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #d4af37,
            #f1d77a,
            #d4af37,
            transparent
        );

    box-shadow:
        0 0 18px
        rgba(212,175,55,.25);
}


/* =========================================================
   CONTAINER
========================================================= */

.footer-container {

    width: 92%;

    max-width: 1400px;

    margin: auto;

    padding:
        75px 0 65px;

    display: grid;

    grid-template-columns:
        1.5fr
        1fr
        1fr
        1.3fr;

    gap: 55px;
}


/* =========================================================
   BRAND
========================================================= */

.footer-logo {

    display: inline-flex;

    align-items: center;

    gap: 12px;

    color: #ffffff;

    font-family:
        "Playfair Display",
        serif;

    font-size: 29px;

    font-weight: 700;

    margin-bottom: 22px;

    transition:
        .3s ease;
}


.footer-logo b {

    color: #d4af37;
}


.footer-logo:hover {

    transform:
        translateY(-3px);
}


.logo-icon {

    width: 47px;

    height: 47px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    color: #111;

    background:
        linear-gradient(
            135deg,
            #f1d77a,
            #d4af37
        );

    box-shadow:
        0 8px 25px
        rgba(212,175,55,.2);

    font-size: 18px;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.footer-description {

    max-width: 380px;

    color: #888;

    font-size: 12px;

    line-height: 1.9;

    margin-bottom: 25px;
}


/* =========================================================
   SOCIAL
========================================================= */

.footer-social {

    display: flex;

    align-items: center;

    gap: 10px;
}


.footer-social a {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    color: #aaa;

    background:
        rgba(255,255,255,.035);

    border:
        1px solid
        rgba(255,255,255,.08);

    font-size: 13px;

    transition:
        .35s ease;
}


.footer-social a:hover {

    color: #111;

    background:
        #d4af37;

    border-color:
        #d4af37;

    transform:
        translateY(-5px);

    box-shadow:
        0 8px 25px
        rgba(212,175,55,.2);
}


/* =========================================================
   COLUMN TITLE
========================================================= */

.footer-column h3 {

    position: relative;

    font-family:
        "Playfair Display",
        serif;

    color: #ffffff;

    font-size: 19px;

    margin-bottom: 25px;

    padding-bottom: 12px;
}


.footer-column h3::after {

    content: "";

    position: absolute;

    left: 0;

    bottom: 0;

    width: 45px;

    height: 2px;

    background:
        linear-gradient(
            90deg,
            #d4af37,
            transparent
        );
}


/* =========================================================
   LIST
========================================================= */

.footer-column ul {

    list-style: none;

    padding: 0;

    margin: 0;
}


.footer-column ul li {

    margin-bottom: 13px;
}


.footer-column ul li a {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    color: #858585;

    font-size: 11px;

    transition:
        .3s ease;
}


.footer-column ul li a i {

    color: #d4af37;

    font-size: 8px;

    transition:
        transform .3s ease;
}


.footer-column ul li a:hover {

    color: #ffffff;

    transform:
        translateX(5px);
}


.footer-column ul li a:hover i {

    transform:
        translateX(3px);
}


/* =========================================================
   CONTACT
========================================================= */

.contact-item {

    display: flex;

    align-items: flex-start;

    gap: 13px;

    margin-bottom: 18px;
}


.contact-icon {

    flex-shrink: 0;

    width: 36px;

    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    color: #d4af37;

    background:
        rgba(212,175,55,.055);

    border:
        1px solid
        rgba(212,175,55,.14);

    font-size: 12px;

    transition:
        .3s ease;
}


.contact-item:hover
.contact-icon {

    background:
        #d4af37;

    color: #111;

    transform:
        translateY(-2px);
}


.contact-item strong {

    display: block;

    color: #dddddd;

    font-size: 10px;

    margin-bottom: 4px;
}


.contact-item p {

    color: #777;

    font-size: 10px;

    line-height: 1.5;

    margin: 0;
}


/* =========================================================
   FOOTER BOTTOM
========================================================= */

.footer-bottom {

    border-top:
        1px solid
        rgba(255,255,255,.06);

    background:
        rgba(0,0,0,.25);
}


.footer-bottom-container {

    width: 92%;

    max-width: 1400px;

    min-height: 70px;

    margin: auto;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;
}


.footer-bottom p {

    color: #666;

    font-size: 10px;

    margin: 0;
}


.footer-bottom p strong {

    color: #d4af37;
}


.footer-bottom-links {

    display: flex;

    align-items: center;

    gap: 10px;

    color: #555;

    font-size: 9px;
}


.footer-bottom-links a {

    color: #666;

    transition:
        .3s ease;
}


.footer-bottom-links a:hover {

    color: #d4af37;
}


/* =========================================================
   RESPONSIVE 1000
========================================================= */

@media (max-width: 1000px) {

    .footer-container {

        grid-template-columns:
            repeat(2, 1fr);

        gap: 45px;
    }

}


/* =========================================================
   RESPONSIVE 600
========================================================= */

@media (max-width: 600px) {

    .footer-container {

        grid-template-columns: 1fr;

        gap: 35px;

        padding:
            55px 0 45px;
    }


    .footer-description {

        max-width: 100%;
    }


    .footer-bottom-container {

        min-height: auto;

        padding:
            22px 0;

        flex-direction: column;

        justify-content: center;

        text-align: center;
    }


    .footer-bottom-links {

        flex-wrap: wrap;

        justify-content: center;
    }

}


/* =========================================================
   RESPONSIVE 400
========================================================= */

@media (max-width: 400px) {

    .footer-logo {

        font-size: 25px;
    }


    .logo-icon {

        width: 42px;

        height: 42px;
    }


    .footer-column h3 {

        font-size: 18px;
    }

}

</style>


<script>

/*
|--------------------------------------------------------------------------
| CURRENT YEAR
|--------------------------------------------------------------------------
*/

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const year =
            document.getElementById("footerYear");

        if (year) {

            year.textContent =
                new Date().getFullYear();

        }

    }
);

</script>

