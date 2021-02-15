<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    include("dbconnect.php");

$result = mysqli_query($link,"SELECT * FROM `корзина` WHERE `cart_ip`= '{$_SERVER['REMOTE_ADDR']}'");
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
        do
        {
            $int = $int + ($row["Общая цена"]*$row["Количество"]);
        }
        while ($row = mysqli_fetch_array($result));
        echo $int;
        }
}
?>