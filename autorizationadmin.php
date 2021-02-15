<?php
session_start();
ob_start();
include("dbconnect.php");

if ($_POST["submit_enter"])
{
    $login = $_POST["input_login"];
    $pass = $_POST["input_pass"];

    if ($login && $pass)
    {
        

        $result = mysqli_query($link, "SELECT * FROM admin WHERE `login` = '$login' AND `pass` = '$pass'");

        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
            if ($_SESSION['auth_admin'] = 'yes_auth')
                {
                 header('Location: adminpanel.php');
                 ob_end_flush();
                }
            }
                else{
                    $msqerror = "Неверный логин и (или) пароль!";
                }

        }
        else{
            $msqerror = "Заполните все поля!";
        }
    
}
?>


<!DOCTYPE html>
<html lang="ru_BY">
<head>
<meta http-equiv="Content-Type" content = "text/html; charset = utf-8">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.cookie.min.js"></script>
<link rel="stylesheet" href="admin.css">
<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kaushan+Script|Montserrat|Neucha&display=swap" rel="stylesheet">
<title>Вход в панель управления</title>

</head>
<body>


<div class="autorizationadmin">

    <form method="post">
    <div class="block-form-autorizationadmin">
    <h2 class="h2-titlea">Вход</h2>
    <ul id="pass-login">
        <li><label>Логин</label><input type="text" name="input_login" id="input_login"></li>
        <li><label>Пароль</label><input type="password" id="input_pass" name="input_pass"></li>
    </ul>
<?php 
if ($msqerror)
{
    echo '<p id="msqerror">'.$msqerror.'</p>';
}
?>
    <p align="right"><input type="submit" name="submit_enter" id="submit_enter" value="Войти"></p>
    </form>


</div>


    

</body>
</html>