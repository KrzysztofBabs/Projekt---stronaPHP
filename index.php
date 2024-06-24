<?php
session_start();

// Domyślne preferencje
$preferences=[
    'language'=>'pl',
    'theme'=>'light'
];

if(isset($_GET['lang'])){
    $lang=$_GET['lang'];
    $preferences['language']=$lang;

    // Zapisz preferencje w sesji i w cookie
    $_SESSION['preferences']=$preferences;
    setcookie('preferences', json_encode($preferences),time()+(86400* 30),"/");
}

// Pobierz preferencje z cookies lub sesji, jeśli są ustawione
if(isset($_COOKIE['preferences'])){
    $preferences = json_decode($_COOKIE['preferences'], true);
}
elseif(isset($_SESSION['preferences'])){
    $preferences= $_SESSION['preferences'];
}

// Zmień język zgodnie z preferencjami
$lang =$preferences['language'];

// Załaduj plik językowy
$language=include "languages/$lang.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $language['title']; ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>

        .social-media-share{
            text-align: center;
            margin:20px 0;
        }

        .social-media-share h3{
            margin-bottom: 10px;
        }


        .social-media-share a{
            display:inline-block;
            margin: 0 10px;
        }
        .social-media-share img {
            width:40px;
            height:40px;

        }
    </style>
    <script>
        function validateForm() {
            var name = document.forms["contactForm"]["name"].value;
            var email = document.forms["contactForm"]["email"].value;
            var phone = document.forms["contactForm"]["phone"].value;
            var message = document.forms["contactForm"]["message"].value;
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var phonePattern = /^[0-9\s+()-]*$/;

            if (name == "") {
                alert("<?php echo $language['name']; ?>");
                return false;
            }
            if (!emailPattern.test(email)) {
                alert("<?php echo $language['email']; ?>");
                return false;
            }
            if (phone != "" && !phonePattern.test(phone)) {
                alert("<?php echo $language['phone']; ?>");
                return false;
            }
            if (message == "") {
                alert("<?php echo $language['message']; ?>");
                return false;
            }
            if (name.length < 2) {
                alert("<?php echo $language['name_too_short']; ?>");
                return false;
            }
            if (message.length < 5) {
                alert("<?php echo $language['message_too_short']; ?>");
                return false;
            }
            return true;
        }

        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        function shareOnTwitter() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(document.title);
            const shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        function shareOnLinkedIn() {
            const url = encodeURIComponent(window.location.href);
            const shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>
</head>
<body class="<?php echo $preferences['theme']; ?>">
<header role="banner">
    <div class="logo">
        <img src="images/logo.png" alt="Logo firmy">
    </div>
    <div class="slogan">
        <h1><?php echo $language['slogan']; ?></h1>
    </div>
    <nav role="navigation">
        <ul>
            <li><a href="#home"><?php echo $language['home']; ?></a></li>
            <li><a href="#about"><?php echo $language['about']; ?></a></li>
            <li><a href="#services"><?php echo $language['services']; ?></a></li>
            <li><a href="#contact-form"><?php echo $language['contact']; ?></a></li>

        </ul>
        <ul>
            <li><a href="?lang=pl">PL</a></li>
            <li><a href="?lang=en">EN</a></li>
            <li><a href="?lang=es">ES</a></li>
        </ul>
    </nav>
</header>
<main role="main">
    <section id="hero" class="hero" aria-labelledby="hero-heading">
        <div class="hero-content">
            <h2 id="hero-heading"><?php echo $language['hero_message']; ?></h2>
            <a href="#contact-form" class="cta-button"><?php echo $language['cta_button']; ?></a>
        </div>
    </section>
    <section id="services">
        <h2><?php echo $language['services']; ?></h2>
        <p><?php echo $language['promo_message']; ?></p>
    </section>
    <section id="contact">
        <h2><?php echo $language['contact']; ?></h2>
        <p><?php echo $language['contact_message']; ?></p>
    </section>

    <section id="preferences" class="preferences" aria-labelledby="preferences-heading">
        <h2 id="preferences-heading"><?php echo $language['preferences']; ?></h2>
        <form action="preferences.php" method="post">
            <label for="language"><?php echo $language['choose_language']; ?>:</label>
            <select id="language" name="language">
                <option value="pl" <?php if ($preferences['language'] == 'pl') echo 'selected'; ?>>Polski</option>
                <option value="en" <?php if ($preferences['language'] == 'en') echo 'selected'; ?>>English</option>
                <option value="es" <?php if ($preferences['language'] == 'es') echo 'selected'; ?>>Español</option>
            </select>

            <label for="theme"><?php echo $language['choose_theme']; ?>:</label>
            <select id="theme" name="theme">
                <option value="light" <?php if ($preferences['theme']=='light') echo 'selected'; ?>>Jasny</option>
                <option value="dark" <?php if ($preferences['theme']=='dark') echo 'selected'; ?>>Ciemny</option>
            </select>

            <button type="submit"><?php echo $language['save_preferences']; ?></button>
        </form>
        <p><?php echo $language['preferences_message']; ?></p>
    </section>
    <hr>
    <section id="about" class="about" aria-labelledby="about-heading">
        <h2 id="about-heading"><?php echo $language['about_us']; ?></h2>
        <p><?php echo $language['promo_message']; ?></p>
        <hr>
        <h3><?php echo $language['values']; ?></h3>
        <ul>
            <li><?php echo $language['value_item_1']; ?></li>
            <li><?php echo $language['value_item_2']; ?></li>
            <li><?php echo $language['value_item_3']; ?></li>
            <li><?php echo $language['value_item_4']; ?></li>
        </ul>
        <hr>
        <h3><?php echo $language['team']; ?></h3>
        <div class="team" role="list">
            <div class="team-member" role="listitem">
                <img src="images/team-member01.jpg" alt="<?php echo $language['team_member_01']; ?>">
                <h4><?php echo $language['team_member_01']; ?></h4>
                <p>CEO</p>
                <p><?php echo $language['team_member_01_desc']; ?></p>
            </div>
            <div class="team-member" role="listitem">
                <img src="images/team-member2.jpg" alt="<?php echo $language['team_member_2']; ?>">
                <h4><?php echo $language['team_member_2']; ?></h4>
                <p>CTO</p>
                <p><?php echo $language['team_member_2_desc']; ?></p>
            </div>
            <div class="team-member" role="listitem">
                <img src="images/team-member3.jpg" alt="<?php echo $language['team_member_3']; ?>">
                <h4><?php echo $language['team_member_3']; ?></h4>
                <p>CMO</p>
                <p><?php echo $language['team_member_3_desc']; ?></p>
            </div>
            <div class="team-member" role="listitem">
                <img src="images/team-member4.jpg" alt="<?php echo $language['team_member_4']; ?>">
                <h4><?php echo $language['team_member_4']; ?></h4>
                <p>CFO</p>
                <p><?php echo $language['team_member_4_desc']; ?></p>
            </div>
        </div>
    </section>
    <hr>
    <section id="testimonials" class="testimonials" aria-labelledby="testimonials-heading">
        <h2 id="testimonials-heading"><?php echo $language['testimonials']; ?></h2>
        <div class="testimonial-container">
            <div class="testimonial">
                <img src="images/client1.jpg" alt="Anna Kowalska, <?php echo $language['director']; ?>, <?php echo $language['company']; ?> XYZ">
                <p>"<?php echo $language['testimonial_1']; ?>"</p>
                <h4>Anna Kowalska</h4>
                <p><?php echo $language['director']; ?>, <?php echo $language['company']; ?> XYZ</p>
            </div>
            <div class="testimonial">
                <img src="images/client2.jpg" alt="Piotr Nowak, <?php echo $language['manager']; ?>, <?php echo $language['company']; ?> ABC">
                <p>"<?php echo $language['testimonial_2']; ?>"</p>
                <h4>Piotr Nowak</h4>
                <p><?php echo $language['manager']; ?>, <?php echo $language['company']; ?> ABC</p>
            </div>
            <div class="testimonial">
                <img src="images/client3.jpg" alt="Katarzyna Kowalska, <?php echo $language['director']; ?>, <?php echo $language['company']; ?> LMN">
                <p>"<?php echo $language['testimonial_3']; ?>"</p>
                <h4>Paweł Kolarz</h4>
                <p><?php echo $language['director']; ?>, <?php echo $language['company']; ?> LMN</p>
            </div>
            <div class="testimonial">
                <img src="images/client4.jpg" alt="Jan Nowak, <?php echo $language['manager']; ?>, <?php echo $language['company']; ?> OPQ">
                <p>"<?php echo $language['testimonial_4']; ?>"</p>
                <h4>Jan Nowak</h4>
                <p><?php echo $language['manager']; ?>, <?php echo $language['company']; ?> OPQ</p>
            </div>
        </div>
    </section>

    <section id="portfolio" class="portfolio" aria-labelledby="portfolio-heading">
        <h2 id="portfolio-heading"><?php echo $language['portfolio']; ?></h2>
        <div class="gallery" role="list">
            <div class="gallery-item" role="listitem">
                <img src="images/project1.jpg" alt="<?php echo $language['project_1']; ?>">
                <h4><?php echo $language['project_1']; ?></h4>
                <p><?php echo $language['project_1_desc']; ?></p>
            </div>
            <div class="gallery-item" role="listitem">
                <img src="images/project2.jpg" alt="<?php echo $language['project_2']; ?>">
                <h4><?php echo $language['project_2']; ?></h4>
                <p><?php echo $language['project_2_desc']; ?></p>
            </div>
            <div class="gallery-item" role="listitem">
                <img src="images/project3.jpg" alt="<?php echo $language['project_3']; ?>">
                <h4><?php echo $language['project_3']; ?></h4>
                <p><?php echo $language['project_3_desc']; ?></p>
            </div>
        </div>
    </section>

    <section id="contact-form" class="contact-form" aria-labelledby="contact-form-heading">
        <h2 id="contact-form-heading"><?php echo $language['contact_form']; ?></h2>
        <form name="contactForm" action="send_message.php" method="post" onsubmit="return validateForm()">
            <label for="name"><?php echo $language['name']; ?>:</label>
            <input type="text" id="name" name="name" required aria-required="true">

            <label for="email"><?php echo $language['email']; ?>:</label>
            <input type="email" id="email" name="email" required aria-required="true">

            <label for="phone"><?php echo $language['phone']; ?>:</label>
            <input type="tel" id="phone" name="phone">

            <label for="message"><?php echo $language['message']; ?>:</label>
            <textarea id="message" name="message" required aria-required="true"></textarea>

            <button type="submit"><?php echo $language['send']; ?></button>
        </form>
    </section>

</main>

<footer role="contentinfo">
    <div class="footer-content">
        <div class="contact-info">
            <h3><?php echo $language['footer_contact']; ?></h3>
            <p><?php echo $language['address']; ?></p>
            <p><?php echo $language['phone']; ?>: <a href="tel:+48123456789">+48 111 222 333</a></p>
            <p><?php echo $language['email']; ?>: <a href="mailto:kontakt@przyklad.pl">kontakt@strona.pl</a></p>
        </div>
        <div class="social-media">
            <h3><?php echo $language['social_media']; ?></h3>
            <a href="https://www.facebook.com" aria-label="Facebook" target="_blank"><img src="images/facebook.png" alt="Facebook"></a>
            <a href="https://www.twitter.com" aria-label="Twitter" target="_blank"><img src="images/twitter.png" alt="Twitter"></a>
            <a href="https://www.linkedin.com" aria-label="LinkedIn" target="_blank"><img src="images/linkedin.png" alt="LinkedIn"></a>
        </div>
        <div class="social-media-share">
            <h3><?php echo $language['share_on_social_media']; ?></h3>
            <a href="#" onclick="shareOnFacebook()" aria-label="Share on Facebook"><img src="images/facebook.png" alt="Facebook"></a>
            <a href="#" onclick="shareOnTwitter()" aria-label="Share on Twitter"><img src="images/twitter.png" alt="Twitter"></a>
            <a href="#" onclick="shareOnLinkedIn()" aria-label="Share on LinkedIn"><img src="images/linkedin.png" alt="LinkedIn"></a>
        </div>
        <div class="sitemap">
            <h3><?php echo $language['sitemap']; ?></h3>
            <ul>
                <li><a href="#home"><?php echo $language['home']; ?></a></li>
                <li><a href="#about"><?php echo $language['about']; ?></a></li>
                <li><a href="#services"><?php echo $language['services']; ?></a></li>
                <li><a href="#contact-form"><?php echo $language['contact']; ?></a></li>
                <li><a href="#portfolio"><?php echo $language['portfolio']; ?></a></li>
                <li><a href="#testimonials"><?php echo $language['testimonials']; ?></a></li>
            </ul>
        </div>
        <div class="legal">
            <h3><?php echo $language['legal']; ?></h3>
            <ul>
                <li><a href="privacy.html"><?php echo $language['privacy_policy']; ?></a></li>
                <li><a href="terms.html"><?php echo $language['terms_of_use']; ?></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Your Company. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
