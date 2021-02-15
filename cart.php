<?php 
session_start();
ob_start();
include("dbconnect.php");


    $id = $_GET["id"];
    $action = $_GET["action"];

    switch ($action)
    {
        case 'clear':
            $clear = mysqli_query($link,"DELETE FROM `корзина` WHERE `cart_ip`= '{$_SERVER['REMOTE_ADDR']}'");
        break;

        case 'delete':
             $delete = mysqli_query($link,"DELETE FROM `корзина` WHERE `Код корзины`= '$id' AND `cart_ip`= '{$_SERVER['REMOTE_ADDR']}'");
        break;
    }

    if (isset($_POST["submitdata"]))
    {
        $_SESSION["order_delivery"] = $_POST["order_delivery"];
        $_SESSION["order_f"] = $_POST["order_f"];
        $_SESSION["order_i"] = $_POST["order_i"];
        $_SESSION["order_o"] = $_POST["order_o"];
        $_SESSION["order_email"] = $_POST["order_email"];
        $_SESSION["order_phone"] = $_POST["order_phone"];
        $_SESSION["order_adress"] = $_POST["order_adress"];
        $_SESSION["order_note"] = $_POST["order_note"];

        header("Location: cart.php?action=completion");
        ob_end_flush();
    }
    $result = mysqli_query($link,"SELECT * FROM `корзина`,`товары` WHERE `корзина`.`cart_ip`= '{$_SERVER['REMOTE_ADDR']}' AND `товары`.`Код платья` = `корзина`.`Код платья`");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        do
        {
            $int = $int + ($row["Общая цена"] * $row["Количество"]);          
        }
        while ($row = mysqli_fetch_array($result));
        $itogpricecart = $int;
    }
    

?>

<!DOCTYPE html>
<html lang="ru_BY">
<head>
<meta http-equiv="Content-Type" content = "text/html; charset = utf-8">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.cookie.min.js"></script>
<script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
<script src="js/shop-script.js"></script>
<script src="/js/jquery.maskedinput.min.js"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="trackbar/trackbar.css">
<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kaushan+Script|Montserrat|Neucha&display=swap" rel="stylesheet">
<title>Корзина</title>

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


<div class="content">



<?php
    $action = $_GET["action"];

switch ($action){
    case 'oneclick':

        echo '
        <div class="block-step">
        <div class="name-step">
        <ul>
        <li><a a href="cart.php?action=oneclick" class="b">1. Корзина</a></li>
        <li><span>&rarr;</span></li>
        <li><a a href="cart.php?action=confirm" class="b">2. Контактная информация</a></li>
        <li><span>&rarr;</span></li>
        <li><a href="cart.php?action=completion" class="b">3. Завершение</a></li>
        <li><a href="cart.php?action=clear" class="button_clear">Очистить</a></li>
        </ul>
        </div>
        
        ';

        $result = mysqli_query($link,"SELECT * FROM `корзина`,`товары` WHERE `корзина`.`cart_ip`= '{$_SERVER['REMOTE_ADDR']}' AND `товары`.`Код платья` = `корзина`.`Код платья`");
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
            
                echo '<div class="header-list-cart">
                <div class="head1">Изображение</div>
                <div class="head2">Наименование товара</div>
                <div class="head3">Количество</div>
                <div class="head4">Цена</div>
                </div>';
            do
            {
                $int = $row["Общая цена"] * $row["Количество"];
                $all_price = $all_price + $int;

                if(strlen($row["Фото"]) > 0 && file_exists("img/Платья/".$row["Фото"]))
                {
                    $img_path = 'img/Платья/'.$row["Фото"];
                    $max_width = 300;
                    $max_height = 375;
                    list($width, $height) = getimagesize($img_path);
                    $ratioh = $max_height/$height;
                    $ratiow = $max_width/$width;
                    $ratio = min($ratioh, $ratiow);

                    $width = intval($ratio*$width);
                    $height = intval($ratio*$height);
                }
                else
                {
                    $img_path="img/Платья/no-image.jpg";
                    $width = 300;
                    $height = 375;
                }
                echo '
            <div class="block-list-cart">
            <div class="img-cart"><p align="center"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"</p></div>
            <div class="title-cart"><p>'.$row["Название"].'</p></div>

            <div class="count-cart">
            <ul class="input-count-style">
            <li><p align="center" iid="'.$row["Код корзины"].'" class="count-plus">+</p></li>
            <li><p align="center"><input id="input-id'.$row["Код корзины"].'" iid="'.$row["Код корзины"].'" class="count-input" maxlength="3" type="text" value="'.$row["Количество"].'"></p></li>
            <li><p align="center" iid="'.$row["Код корзины"].'" class="count-minis">-</p></li>
            </ul>
            </div>';

            echo '<div id="tovar'.$row["Код корзины"].'" class="price-product"><h5><span class="span-count">'.$row["Количество"].'</span> x <span>'.$row["Общая цена"].' руб</span></h5><p price="'.$row["Общая цена"].'">'.$int.' руб</p></div>
            <div class="delete-cart"><a href="cart.php?id='.$row["Код корзины"].'&action=delete"><img src="img/icons8-удалить-35.png"></a></div>
            
            
            
            ';
            }
            while ($row = mysqli_fetch_array($result));
            echo '<p><h2 class="itog-price" align="right">Итого (с НДС): <strong>'.$all_price.' руб</strong></h2></p>
            <p class="button-next"><a href="cart.php?action=confirm">Далее</a></p></div></div>';
        }
        else
        {
            echo '<h3 id="clear-cart" align="center">Корзина пуста</h3>';
        }
        
        
    break;

    case 'confirm':

        echo '
        <div class="block-step">
        <div class="name-step">
        <ul>
        <li><a a href="cart.php?action=oneclick" class="b">1. Корзина</a></li>
        <li><span>&rarr;</span></li>
        <li><a a href="cart.php?action=confirm" class="b">2. Контактная информация</a></li>
        <li><span>&rarr;</span></li>
        <li><a href="cart.php?action=completion" class="b">3. Завершение</a></li>
        <li><a href="cart.php?action=clear" class="button_clear">Очистить</a></li>
        </ul>
        </div>
        
        ';

        $chck = "";
        if ($_SESSION['order_delivery'] == "По почте") $chck1 = "checked";
        if ($_SESSION['order_delivery'] == "Курьером") $chck2 = "checked";
        if ($_SESSION['order_delivery'] == "Самовывоз") $chck3 = "checked";

        echo '
        <div class="block-list-confirm">
        <h3 class="title-h3">Способы доставки:</h3>
        <form method="post">
        <ul id="info-radio">
        <li><input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="По почте" '.$chck1.'>
        <label class="label_delivery" for="order_delivery1">По почте</label></li>

        <li><input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="Курьером" '.$chck2.'>
        <label class="label_delivery" for="order_delivery2">Курьером</label></li>

        <li><input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="Самовывоз" '.$chck3.'>
        <label class="label_delivery" for="order_delivery3">Самовывоз</label></li>

        </ul>

        <h3 class="title-h3">Информация для доставки: </h3>
        <ul id="info-order">';
        if (!$_SESSION['user'])
        {
            echo '
            <li><label for="order_f"><span class="star2">*</span>Фамилия</label><input type="text" name="order_f" id="order_f" value="'.$_SESSION["order_f"].'"></li>
            <li><label for="order_i"><span class="star2">*</span>Имя</label><input type="text" name="order_i" id="order_i" value="'.$_SESSION["order_i"].'"></li>
            <li><label for="order_o"><span class="star2">*</span>Отчество</label><input type="text" name="order_o" id="order_o" value="'.$_SESSION["order_o"].'"></li>
            <li><label for="order_email"><span class="star2">*</span>Email</label><input type="text" name="order_email" id="order_email" value="'.$_SESSION["order_email"].'"></li>
            <li><label for="order_phone"><span class="star2">*</span>Телефон</label><input type="text" name="order_phone" id="order_phone" value="'.$_SESSION["order_phone"].'"><script>
            $(function(){
                $("#order_phone").mask("+375(99) 999-99-99");
            });
            </script></li>
            <li><label class="order_label_style" for="order_adress"><span class="star2">*</span>Адрес</label><input type="text" name="order_adress" id="order_adress" value="'.$_SESSION["order_adress"].'"></li>
            ';
        }

        echo'
        <li><label class="order_label_style" for="order_note">Пожелания к заказу</label><textarea name="order_note">'.$_SESSION["order_note"].'</textarea></li>
        </ul>
        <p align="right"><input type="submit" name="submitdata" id="confirm-button-next" value="Далее"></p>
        </form>
        </div>
        </div>
        ';
        

    break;

    case 'completion':

        echo '
        
        <div class="block-step">
        <div class="name-step">
        <ul>
        <li><a a href="cart.php?action=oneclick" class="b">1. Корзина</a></li>
        <li><span>&rarr;</span></li>
        <li><a a href="cart.php?action=confirm" class="b">2. Контактная информация</a></li>
        <li><span>&rarr;</span></li>
        <li><a href="cart.php?action=completion" class="b">3. Завершение</a></li>
        <li><a href="cart.php?action=clear" class="button_clear">Очистить</a></li>
        </ul>
        </div>
        <p class="button-complete" onClick="print()"><a href="#">Печать</a></p>
        ';

        if ($_SESSION['user'])
        {
            echo '
            <div class="block-list-completion">
            <ul id="list-info">
            <li><strong>Способ доставки:</strong>'.$_SESSION['order_delivery'].'</li>
            <li><strong>Email:</strong>'.$_SESSION['reg_email'].'</li>
            <li><strong>Фамилия:</strong>'.$_SESSION['order_f'].'</li>
            <li><strong>Имя:</strong>'.$_SESSION['order_i'].'</li>
            <li><strong>Отчество:</strong>'.$_SESSION['order_o'].'</li>
            <li><strong>Адрес доставки:</strong>'.$_SESSION['order_adress'].'</li>
            <li><strong>Телефон:</strong>'.$_SESSION['order_phone'].'</li>
            <li><strong>Примечание:</strong>'.$_SESSION['order_note'].'</li>

            </ul>
            <p><h2 class="itog-price" align="right">Итого (с НДС): <strong>'.$itogpricecart.' руб</strong></h2></p>
            <p class="button-complete"><a href="#">Оплатить</a></p>
            </div>
            ';

        }
        else{
            echo '
            <div class="block-list-completion">
            <ul id="list-info">
            <li><strong>Способ доставки:</strong>'.$_SESSION['order_delivery'].'</li>
            <li><strong>Email:</strong>'.$_SESSION['order_email'].'</li>
            <li><strong>Фамилия:</strong>'.$_SESSION['order_f'].'</li>
            <li><strong>Имя:</strong>'.$_SESSION['order_i'].'</li>
            <li><strong>Отчество:</strong>'.$_SESSION['order_o'].'</li>
            <li><strong>Адрес доставки:</strong>'.$_SESSION['order_adress'].'</li>
            <li><strong>Телефон:</strong>'.$_SESSION['order_phone'].'</li>
            <li><strong>Примечание:</strong>'.$_SESSION['order_note'].'</li>
            </ul>
            <p><h2 class="itog-price" align="right">Итого: <strong>'.$itogpricecart.' руб</strong></h2></p>
            <p class="button-complete"><a href="#">Оплатить</a></p>
            </div>
            </div>
            ';
        }

    break;

    default:
    
    echo '
    <div class="block-step">
    <div class="name-step">
    <ul>
    <li><a a href="cart.php?action=oneclick" class="b">1. Корзина</a></li>
    <li><span>&rarr;</span></li>
    <li><a a href="cart.php?action=confirm" class="b">2. Контактная информация</a></li>
    <li><span>&rarr;</span></li>
    <li><a href="cart.php?action=completion" class="b">3. Завершение</a></li>
    <li><a href="cart.php?action=clear" class="button_clear">Очистить</a></li>
    </ul>
    </div>
    
    ';

    $result = mysqli_query($link,"SELECT * FROM `корзина`,`товары` WHERE `корзина`.`cart_ip`= '{$_SERVER['REMOTE_ADDR']}' AND `товары`.`Код платья` = `корзина`.`Код платья`");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        
            echo '<div class="header-list-cart">
            <div class="head1">Изображение</div>
            <div class="head2">Наименование товара</div>
            <div class="head3">Количество</div>
            <div class="head4">Цена</div>
            </div>';
        do
        {
            $int = $row["Общая цена"] * $row["Количество"];
            $all_price = $all_price + $int;

            if(strlen($row["Фото"]) > 0 && file_exists("img/Платья/".$row["Фото"]))
            {
                $img_path = 'img/Платья/'.$row["Фото"];
                $max_width = 300;
                $max_height = 375;
                list($width, $height) = getimagesize($img_path);
                $ratioh = $max_height/$height;
                $ratiow = $max_width/$width;
                $ratio = min($ratioh, $ratiow);

                $width = intval($ratio*$width);
                $height = intval($ratio*$height);
            }
            else
            {
                $img_path="img/Платья/no-image.jpg";
                $width = 300;
                $height = 375;
            }
            echo '
        <div class="block-list-cart">
        <div class="img-cart"><p align="center"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"</p></div>
        <div class="title-cart"><p>'.$row["Название"].'</p></div>

        <div class="count-cart">
        <ul class="input-count-style">
        <li><p align="center" iid="'.$row["Код корзины"].'" class="count-plus">+</p></li>
        <li><p align="center"><input id="input-id'.$row["Код корзины"].'" iid="'.$row["Код корзины"].'" class="count-input" maxlength="3" type="text" value="'.$row["Количество"].'"></p></li>
        <li><p align="center" iid="'.$row["Код корзины"].'" class="count-minis">-</p></li>
        </ul>
        </div>';

        echo '<div id="tovar'.$row["Код корзины"].'" class="price-product"><h5><span class="span-count">'.$row["Количество"].'</span> x <span>'.$row["Общая цена"].' руб</span></h5><p price="'.$row["Общая цена"].' руб">'.$int.' руб</p></div>
        <div class="delete-cart"><a href="cart.php?id='.$row["Код корзины"].'&action=delete"><img src="img/icons8-удалить-35.png"></a></div>
        
        
        
        ';
        }
        while ($row = mysqli_fetch_array($result));
        echo '<p><h2 class="itog-price" align="right">Итого: <strong>'.$all_price.' руб</strong></h2></p>
        <p class="button-next"><a href="cart.php?action=confirm">Далее</a></p></div>';
    }
    else
    {
        echo '<h3 id="clear-cart" align="center">Корзина пуста</h3>';
    }
break;
}
?>



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