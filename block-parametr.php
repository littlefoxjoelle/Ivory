<script type="text/javascript">
$(document).ready(function() {
    $('#blocktrackbar').trackbar({
    onMove: function() {
        document.getElementById("start-price").value = this.leftValue;
        document.getElementById("end-price").value = this.rightValue;
    },
    width : 200,
    leftLimit : 100,
    leftValue : <?php 

        if ((int)$_GET["start_price"] >=100 AND (int)$_GET["start_price"] <=5000)
        {
            echo (int)$_GET["start_price"];
        }
        else{
            echo "100";
        }

    ?> ,
    rightLimit : 5000,
    rightValue : <?php 

if ((int)$_GET["end_price"] >=100 AND (int)$_GET["end_price"] <=5000)
{
    echo (int)$_GET["end_price"];
}
else{
    echo "3000";
}

?> ,
    roundUp : 100
});
});
</script>


<div class="block-parametr">
<p class="header-title">Поиск по параметрам</p>
<p class="title-filter">Стоимость</p>

<form method="GET" action="search_filter.php">

<div class="block-input-price">
    <ul>
        <li>от</li>
        <li><input type="number" min="1" step="1" id="start-price" name="start_price" value="100"> руб</li>
        <li>до</li>
        <li><input type="number" min="1" step="1" class="raz" id="end-price" name="end_price" value="3000"> руб</li>
    </ul>
</div>
<br>
<div id="blocktrackbar"></div>
<div class="b">
<p class="title-filter2">Бренды</p>
    <ul class="checkbox-brand">

        <?php 
        $result = mysqli_query($link, "SELECT * FROM category"); //Представление
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
            do
            {
                $checked_brand = "";
                if ($_GET["brand"])
                {
                    if (in_array($row["Код категории"], $_GET["brand"]))
                    {
                        $checked_brand = "checked";
                    }
                }

                echo '
                <li><input '.$checked_brand.' type="checkbox" name="brand[]" value="'.$row["Код категории"].'" id="checkbrand'.$row["Код категории"].'"><label for="checkbrand'.$row["Код категории"].'">'.$row["brand"].'</label></li>
                ';

            }
            while ($row = mysqli_fetch_array($result));
        }
        
        ?> 

    </ul>
</div>
<input type="submit" name="submit" id="button-param-search" value="Найти">

</form>
</div>