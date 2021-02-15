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
    $_SESSION['urlpage'] = "<a href='adminpanel.php'>Главная</a> / <a href='clients.php'>Клиенты</a>";
    include("dbconnect.php");
    $action = $_GET["action"];
    if (isset($action))
    {
        $id = (int)$_GET["id"];
        switch ($action)
        {
            case 'delete':
                $delete = mysqli_query($link, "DELETE FROM `клиенты` WHERE `Код клиента`='$id'"); 
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
<title>Панель управления клиентами</title>

</head>
<body>
<div class="block-body">
<?php
    include("block-header.php");
    $all_client = mysqli_query($link, "SELECT * FROM `клиенты`");
    $result_count = mysqli_num_rows($all_client);
?> 
    <div class="block-content">

        <div class="block-info">
        <p id="count-style">Всего клиентов - <strong><?php echo $result_count; ?></strong></p>  
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
$res_count = mysqli_query($link, "SELECT COUNT(*) FROM `клиенты` $cat");
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

$result = mysqli_query($link,"SELECT * FROM `клиенты` $cat ORDER BY  `Код клиента` DESC LIMIT $number, $limit");
$myrow = mysqli_fetch_array($result);

do
{
    
 echo '
 <div class="block-clients">
 
 <p class="client-datetime" >'.$myrow["Дата и время регистрации"].'</p>
 <p class="client-email" ><strong>'.$myrow["Email"].'</strong></p>
 <p class="client-links" ><a class="delete" rel="clients.php?id='.$myrow["Код клиента"].'&action=delete" >Удалить</a></p>
 
 
 <ul>
 <li><strong>Email</strong> - '.$myrow["Email"].'</li><br>
 <li><strong>Ф.И.О.</strong> - '.$myrow["Фамилия"].' '.$myrow["Имя"].' '.$myrow["Отчество"].'</li><br>
 <li><strong>Адрес</strong> - '.$myrow["Адрес даставки"].'</li><br>
 <li><strong>Телефон</strong> - '.$myrow["Телефон"].'</li><br>
 <li><strong>IP</strong> - '.$myrow["ip"].'</li><br>
 <li><strong>Дата регистрации</strong> - '.$myrow["Дата и время регистрации"].'</li>
 </ul>
 
 
 
 </div>
 ';   

}
while($myrow=mysqli_fetch_array($result));

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