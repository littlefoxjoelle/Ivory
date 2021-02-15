<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    include("dbconnect.php");

    $id = $_POST["id"];

$result = mysqli_query($link,"SELECT * FROM `корзина` WHERE `Код корзины` = '$id' AND `cart_ip`= '{$_SERVER['REMOTE_ADDR']}'");
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
            $new_count = (int)$_POST['count'];

            if ($new_count > 0)
            {
            $update = mysqli_query($link,"UPDATE `корзина` SET `Количество`= '$new_count' WHERE `Код корзины` = '$id' AND `cart_ip`='{$_SERVER['REMOTE_ADDR']}'");
            echo $new_count;
        }
        
        else{
           echo $row["Количество"];
        }
    }
}
?>