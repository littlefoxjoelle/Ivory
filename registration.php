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
<script src="/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.cookie.min.js"></script>
<script type="text/javascript" src="/js/jquery.form.js"></script>
<script src="js/shop-script.js"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="registrationcss.css">
<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kaushan+Script|Montserrat|Neucha&display=swap" rel="stylesheet">

<title>Регистрация</title>

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

<div class="registration">
    

    <form method="post" id="form_reg" action="reg.php" enctype="multipart/form-data">

    <div class="block-form-registration">
    <h2 class="h2-title">Регистрация</h2>
    <ul id="form-registration">
        <li><label for="">Логин</label><input type="text" name="reg_login" id="reg_login"><span class="star">*</span></li>
        <li><label for="">Пароль</label><input type="text" name="reg_pass" id="reg_pass"><span class="star">*</span></li>
        <li><label for="">Подтвердите пароль</label><input type="text" name="reg_podt_pass" id="reg_pass"><span class="star">*</span>
<?php 
if ($_SESSION['msg'])
{
    echo '<span class="message">'.$_SESSION['msg'].'</span>';
}
unset($_SESSION['msg']);
?>

</li>
        <li><label for="">Фамилия</label><input type="text" name="reg_surname" id="reg_surname"><span class="star">*</span></li>
        <li><label for="">Имя</label><input type="text" name="reg_name" id="reg_name"><span class="star">*</span></li>
        <li><label for="">Отчество</label><input type="text" name="reg_patronymic" id="reg_patronymic"><span class="star">*</span></li>
        <li><label for="">E-mail</label><input type="text" name="reg_email" id="reg_email"><span class="star">*</span></li>
        <li><label for="">Телефон</label><input type="text" name="reg_phone" id="reg_phone">
        <script>
        $(function(){
            $("#reg_phone").mask("+375(99) 999-99-99");
        });
        </script>
    <span class="star">*</span></li>
        <li><label for="">Адрес доставки</label><input type="text" name="reg_adress" id="reg_adress"><span class="star">*</span></li>
        <li><label for="">Фото профиля</label><input type="file" name="reg_photo" id="reg_photo">
        <?php 
if ($_SESSION['msg2'])
{
    echo '<p class="message2">'.$_SESSION['msg2'].'</p>';
}
unset($_SESSION['msg2']);
?>
    </ul>
    <p align="right"><input type="submit" name="reg_submit" id="form_submit" value="Регистрация"><a href="handler_reg.php"></a></p>
    <p class="p13">У вас уже есть аккаунт? - <a href="autorization.php" class="reg">Авторизируйтесь</a>!</p>
    
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