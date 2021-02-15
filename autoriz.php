<?php  
        session_start();
        ob_start();
        require_once 'dbconnect.php';

        $login = $_POST['auth_login'];
        $password = md5($_POST['auth_pass']);

        $check_user = mysqli_query($link, "SELECT * FROM `клиенты` WHERE `Логин`='$login' AND `Пароль`='$password'");
        if (mysqli_num_rows($check_user) > 0)
        {
            $user = mysqli_fetch_assoc($check_user);
            $_SESSION['user'] = ["Код клиента" => $user['Код клиента'], 
            "surname" => $user['Фамилия'],
            "name" => $user['Имя'],
            "patronymic" => $user['Отчество'],
            "reg_photo" => $user['Фото'],
            "Email" => $user['Email'],
        ];

        header('Location: profile.php');
        ob_end_flush();
        }

        else if ($login == "" || $password == "" || $login && $password=="")
        {
            $_SESSION['msg4'] = 'Вы не ввели данные!';
            header('Location: autorization.php');
            ob_end_flush(); 
        }

        
        else if($login !== "Логин" || $password == "Пароль" ){
            $_SESSION['msg3'] = 'Логин и (или) пароль не верны!';
            header('Location: autorization.php');
            ob_end_flush();
        }

        
        else{
            header('Location: profile.php');
            ob_end_flush(); 
        }

?>

