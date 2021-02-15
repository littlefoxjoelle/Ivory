<?php 
    include("dbconnect.php");

    $sorting = $_GET["sort"];

    switch ($sorting)
    {
        case 'price-asc';
        $sorting = 'Цена ASC';
        $sort_name = 'От дешёвых к дорогим';
        break;

        case 'price-desc';
        $sorting = 'Цена DESC';
        $sort_name = 'От дорогих к дешёвым';
        break;

        case 'brand';
        $sorting = 'brand';
        $sort_name = 'От А до Я';
        break;

        default:
        $sorting = '`Код платья` ASC';
        $sort_name = 'Без сортировки';
        break;
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
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="trackbar/trackbar.css">
<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kaushan+Script|Montserrat|Neucha&display=swap" rel="stylesheet">
<title>Каталог</title>

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


<div class="w">
    <div class="container2">
        <div class="block_search">
            <div class="search">
                <form  method="GET" action="search.php?q=">
                <p class="header-title">Категории</p>
                
                    <span></span>
                <input type="text" id="input-search" name="q" placeholder="Поиск">
                <input type="submit" name="" id="button-search" value="Поиск">
                </form>
            </div>

    <div class="categories">
        <ul>
            <li><img src="/img/icons8-новинка-25.png" alt="" class="img1"><a href="view_aystopper.php?go=news">Новинки</a></li>
            <li><img src="/img/icons8-предложение-горячая-цена-25.png" alt=""><a href="view_aystopper.php?go=leaders">Лидеры продаж</a></li>
            <li><img src="/img/icons8-скидка-25.png" alt=""><a href="view_aystopper.php?go=sale">Распродажа</a></li>
         </ul>
        <ul id="options-list">
            <li>Сортировка:</li>
            <br>
            <li><a id="select-sort"><?php echo $sort_name; ?></a></li>
        <ul class="sorting-list">
            <li><a href="Catalog.php?sort=none">Без сортировки</a></li>
            <li><a href="Catalog.php?sort=price-asc">От дешёвых к дорогим</a></li>
            <li><a href="Catalog.php?sort=price-desc">От дорогих к дешёвым</a></li>
            <li><a href="Catalog.php?sort=brand">От А до Я</a></li>
        </ul>
        </ul>
    </div>

        <?php
        include("block-parametr.php");
        ?>


    </div>
    
<div class="pagination">
<?php

if (isset($_GET['page']))
{
    $page = $_GET['page'];
}
else
{
    $page = 1;
}

$limit = 9;
$number = ($page * $limit) - $limit;
$res_count = mysqli_query($link, "SELECT COUNT(*) FROM `товары` INNER JOIN `Категории`ON `товары`.`Код категории` = `категории`.`Код категории` ORDER BY  $sorting");
$row = mysqli_fetch_row($res_count);
$total = $row[0];
$str_page = ceil($total / $limit);

for ($i = 1; $i <= $str_page; $i++)
{
    echo '
    <ul class="hr">
    <li>
    <a href = Catalog.php?page='.$i.'>'.$i.'</a>
    </li>
    </ul>';
}
?>

</div>
<ul class="block_tovari_grid">
<?php
// Запрос и вывод записей
$result = mysqli_query($link,"SELECT * FROM `товары` INNER JOIN `Категории`ON `товары`.`Код категории` = `категории`.`Код категории` ORDER BY  $sorting LIMIT $number, $limit");
$myrow = mysqli_fetch_array($result);
echo "<br><br>";
do
{

    if ($myrow["Фото"] !="" && file_exists ("img/Платья/".$myrow["Фото"]))
    {
        $img_path='img/Платья/'.$myrow["Фото"];
        $max_width = 400;
        $max_height = 550;
        list($width, $height) = getimagesize($img_path);
        $ratioh = $max_height/$height;
        $ratiow = $max_width/$width;
        $ratio = min($ratioh, $ratiow);
        $width = intval($ratio*$width);
        $height = intval($ratio*$height);
    }
    else{
        $img_path="img/Платья/no-image.jpg";
        $width = 400;
        $height = 550;
    }

    echo '
        <li>
        <p class="style_title_grid">'.$myrow["Название"].'</p>
        <div class="block_images_grid">
        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'""/> 
        <div class="opisanie">'.$myrow["Описание"].'</div>
        <div class="opisanie2">Бренд: '.$myrow["brand"].'
        <br>Цвет: '.$myrow["Цвет"].'
        <br>Размер: '.$myrow["Размер"].'
        <br>Силуэт: '.$myrow["Силуэт"].'
        <br>Цена: '.$myrow["Цена"].' руб
        <br>Год коллекции: '.$myrow["Год коллекции"].' год</p></div>
        </div>
        <div class="arr">
        <a class="add-cart-style-list" tid="'.$myrow["Код платья"].'"></a>
        </div>
        </li>';

}
while($myrow=mysqli_fetch_array($result));

?>
</ul>
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