<?php  
session_start();
ob_start();
include("dbconnect.php");
if (!$_SESSION['user'])
    {
        header('Location: autorization.php');
        ob_end_flush();
    }
?>

<!DOCTYPE html>
<html lang="ru_BY">
<head>
<meta http-equiv="Content-Type" content = "text/html; charset = utf-8">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.cookie.min.js"></script>
<script src="js/shop-script.js"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="registrationcss.css">
<link rel="stylesheet" href="profile.css">
<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kaushan+Script|Montserrat|Neucha&display=swap" rel="stylesheet">
<title>Профиль</title>

</head>
<body>
<header class="header">
    <div class="container">
        <div class="header__inner">
            <div class="header__logo1">Ivory</div>
            <nav class="nav1"> 
                <a class="nav__link1" href="index.html">Главная</a>
                <a class="nav__link1" href="Catalog.php">Каталог</a>
                <a class="nav__link1" href="about.html">О салоне</a>
                <a class="nav__link1" href="autorization.php"><img src="img/icons8-женщина-пользователь-25.png" alt="" title="Войти"></a>
                <a class="nav__link1" href="cart.php?action=oneclick"><img src="img/icons8-корзина-25.png" alt=""></a>
            </nav>
        </div>
    </div>
</header>
<div class="profile">
    <div class="form_profile">
    <form action="">
    <h2 class="h2-title">Профиль</h2>
        <img src="<?= $_SESSION['user']['reg_photo']?>" alt="" class="img_profile">
        <p class="p_spisok"><?= $_SESSION['user']['surname']?>
        <?= $_SESSION['user']['name']?>
        <?= $_SESSION['user']['patronymic']?></p>
        <a href="#" class="s"><?= $_SESSION['user']['Email']?></a>
        <p class="p_logout"><a href="logout.php">Выход</a></p>
    </form>
    </div>
</div>
<footer class="foot">

    <div class="textrazr">
        <p>Разработка сайта &#10084; bylittlefoxjoelle</p>
    </div>

    <div class="footer">
    <img src="img/footer.jpg" alt="">
    </div>
    
</footer>
</body>
</html>