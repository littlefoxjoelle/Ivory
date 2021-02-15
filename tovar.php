<?php
session_start();
ob_start();

if ($_SESSION['auth_admin'] == "yes_auth")
{
    if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: autorizationadmin.php");
        ob_end_flush();
    }
    $_SESSION['urlpage'] = "<a href='adminpanel.php'>Главная</a> / <a href='tovar.php'>Товары</a>";
    include("dbconnect.php");

    $action = $_GET["action"];
    if (isset($action))
    {
        $id = (int)$_GET["id"];
        switch ($action)
        {
            case 'delete':
                $delete = mysqli_query($link, "CALL `deltovar`('$id')"); //Хранимая процедура
            break;
        }
    }
?> 
<!DOCTYPE html>
<html lang="ru_BY">
<head>
<meta http-equiv="Content-Type" content = "text/html; charset = utf-8">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.cookie.min.js"></script>
<script type="text/javascript" src="js/script2.js"></script>
<script type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script>
<link rel="stylesheet" href="adminpanel.css">
<link rel="stylesheet" href="jquery_confirm/jquery_confirm.css">
<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kaushan+Script|Montserrat|Neucha&display=swap" rel="stylesheet">
<title>Товары</title>

</head>
<body>
<div class="block-body">
<?php
    include("block-header.php");
    $all_count = mysqli_query($link, "SELECT * FROM tovar"); //представление
    $all_count_result = mysqli_num_rows($all_count);
?> 
    <div class="block-content">

        <div class="block-info">
        <p id="count-style">Всего товаров - <strong><?php echo $all_count_result; ?></strong></p>
        <p align="right" id="add-style"><a href="add_product.php">Добавить товар</a></p>    
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

$limit = 6;
$number = ($page * $limit) - $limit;
$res_count = mysqli_query($link, "SELECT `countProductFunction`() AS `countProductFunction`"); //Хранимая функция
$row = mysqli_fetch_row($res_count);
$total = $row[0];
$str_page = ceil($total / $limit);

for ($i = 1; $i <= $str_page; $i++)
{
    echo '
    <ul class="hr">
    <li>
    <a href = tovar.php?page='.$i.'>'.$i.'</a>
    </li>
    </ul>';
}
?>
</div>

<ul id="block-tovar">
<?php
// Запрос и вывод записей

$result = mysqli_query($link,"SELECT * FROM `товары` $cat ORDER BY  `Код платья` DESC LIMIT $number, $limit");
$myrow = mysqli_fetch_array($result);

do
{

    if ($myrow["Фото"] !="" && file_exists ("img/Платья/".$myrow["Фото"]))
    {
        $img_path='img/Платья/'.$myrow["Фото"];
        $max_width = 200;
        $max_height = 350;
        list($width, $height) = getimagesize($img_path);
        $ratioh = $max_height/$height;
        $ratiow = $max_width/$width;
        $ratio = min($ratioh, $ratiow);
        $width = intval($ratio*$width);
        $height = intval($ratio*$height);
    }
    else{
        $img_path="img/Платья/no-image.jpg";
        $width = 200;
        $height = 350;
    }

    echo '
        <li>
        <center>
        <p>'.$myrow["Название"].'</p>
        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'""/>
        </center> 
        <p align="center" class="link-action">
        <a class="deleteProduct" href="edit_product.php?id='.$myrow["Код платья"].'">Изменить</a> | <a rel="tovar.php?'.$url.'id='.$myrow["Код платья"].'&action=delete" class="delete">Удалить</a>
        </p>
        </li>
        ';

}
while($myrow=mysqli_fetch_array($result));
echo '</ul>';
?>
</div>
</div>


</body>
</html>
<?php
    }
    else{
        header("Location: autorizationadmin.php");
        ob_end_flush();  
    }
?> 