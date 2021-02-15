<?php 
    session_start();
    ob_start();
    include("dbconnect.php");

    if ($_SESSION['user'])
    {
        header('Location: profile.php');
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
<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kaushan+Script|Montserrat|Neucha&display=swap" rel="stylesheet">
<title>Вход</title>

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

<div class="autorization">
    <form method="post" action="autoriz.php">
    <div class="block-form-autorization">
    <h2 class="h2-titlea">Вход</h2>
    <ul id="form-autorization">
        <li><label for="" class="l_l">Логин</label>
        <input type="text" name="auth_login" id="auth_login"></li>
        <li><label for="" class="l_p">Пароль</label>
        <input type="password" id="auth_pass" name="auth_pass"><span id="button-pass-show-hide" class="pass-show"></span></li>

    </ul>
<?php 
if ($_SESSION['msg3'])
{
    echo '<p class="message3">'.$_SESSION['msg3'].'</p>';
}
unset($_SESSION['msg3']);
?>
<?php 
if ($_SESSION['msg4'])
{
    echo '<p class="message4">'.$_SESSION['msg4'].'</p>';
}
unset($_SESSION['msg4']);
?>
    <p align="right"><input type="submit" name="reg_submit" id="form_submit2" value="Вход"></p>
    <p class="p12">У вас нет аккаунта? - <a href="registration.php" class="reg">Зарегистрируйтесь</a>!</p>
    </div>

    </form>


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