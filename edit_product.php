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
    $_SESSION['urlpage'] = "<a href='adminpanel.php'>Главная</a> / <a href='tovar.php'>Товары</a> / <a>Изменение товара</a>";
    include("dbconnect.php");
    $id = $_GET["id"];
    $action = $_GET["action"];
    if (isset($action))
    {
       switch ($action)
       {
          case 'delete':
            if (file_exists("img/Платья/".$_GET["img"]))
            {
               unlink("img/Платья/".$_GET["img"]);
            }
         break;
       }
    }
    if ($_POST["submit_save"])
    {
      $error = array();
        
       if (!$_POST["form_title"])
      {
         $error[] = "Укажите название товара";
      }

      if (!$_POST["form_color"])
      {
         $error[] = "Укажите цвет товара";
      }

      if (!$_POST["form_size"])
      {
         $error[] = "Укажите размер товара";
      }

      if (!$_POST["form_sil"])
      {
         $error[] = "Укажите силуэт товара";
      }
      
       if (!$_POST["form_price"])
      {
         $error[] = "Укажите цену товара";
      }

      if (!$_POST["form_col"])
      {
         $error[] = "Укажите количество товара";
      }

      if (!$_POST["form_date"])
      {
         $error[] = "Укажите год коллекции товара";
      }

      if (!$_POST["form_category"])
      {
         $error[] = "Укажите бренд товара";         
      }else
      {
       	$result = mysqli_query($link, "SELECT * FROM `категории` WHERE `Код категории`='{$_POST["form_category"]}'");
        $row = mysqli_fetch_array($result);
        $selectbrand = $row["brand"];
      }

      if (empty($_POST["upload_image"]))
     {        
        include("upload-image.php");
        unset($_POST["upload_image"]);           
     } 
          
      if ($_POST["chk_visible"])
      {
         $chk_visible = "0";
      }else { $chk_visible = "1"; }
     
      if ($_POST["chk_new"])
      {
         $chk_new = "1";
      }else { $chk_new = "0"; }
     
      if ($_POST["chk_leader"])
      {
         $chk_leader= "1";
      }else { $chk_leader = "0"; }
     
      if ($_POST["chk_sale"])
      {
         $chk_sale = "1";
      }else { $chk_sale = "0"; }                   
     
                                     
      if (count($error))
      {           
           $_SESSION['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";
           
      }else
      {      
         $querynew = "`Код категории`='{$_POST["form_category"]}',`Название`='{$_POST["form_title"]}',`Цвет`='{$_POST["form_color"]}',`Размер`='{$_POST["form_size"]}',`Силуэт`='{$_POST["form_sil"]}',`Цена`='{$_POST["form_price"]}',`Количество на складе`='{$_POST["form_col"]}',`Год коллекции`='{$_POST["form_date"]}',`Описание`='{$_POST["txt1"]}',`Новинки`='$chk_new',`Лидер`='$chk_leader',`Распродажа`='$chk_sale',`Видимость`='$chk_visible'"; 
         $update = mysqli_query($link, "UPDATE `товары` SET $querynew WHERE `Код платья` = '$id'");           
         $_SESSION['message'] = "<p id='form-success'>Товар успешно изменён!</p>";      
      }
}
    else 
    {
    $msgerror = 'Ошибка при изменении товара'; 
    }            
   
?> 
<!DOCTYPE html>
<html lang="ru_BY">
<head>
<meta http-equiv="Content-Type" content = "text/html; charset = utf-8">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.cookie.min.js"></script>
<script type="text/javascript" src="js/script2.js"></script>
<script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="adminpanel.css">
<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kaushan+Script|Montserrat|Neucha&display=swap" rel="stylesheet">
<title>Изменение товара</title>

</head>
<body>
<div class="block-body">
<?php
    include("block-header.php");
?> 
<div class="block-content">
<div class="block-info2">
        <p id="count-style2">Изменение товара</p>   
    </div>

<?php
    if (isset($_SESSION['message']))
    {
        echo $_SESSION['message'];
        unset ($_SESSION['message']);
    }
?>
<?php
$result = mysqli_query($link, "SELECT * FROM `товары` WHERE `Код платья`='$id'");
if (mysqli_num_rows($result) > 0)
{
   $row = mysqli_fetch_array($result);
   do
   {
      echo '<form enctype="multipart/form-data" method="POST">
      <ul id="edit-tovar">
      
      <li>
      <label>Название товара</label>
      <input type="text" name="form_title" value="'.$row["Название"].'">
      </li>
      
      <li>
      <label>Цвет</label>
      <input type="text" name="form_color" value="'.$row["Цвет"].'">
      </li>
      
      <li>
      <label>Размер</label>
      <input type="text" name="form_size" value="'.$row["Размер"].'">
      </li>
      
      <li>
      <label>Силуэт</label>
      <input type="text" name="form_sil" value="'.$row["Силуэт"].'">
      </li>
      
      <li>
      <label>Цена</label>
      <input type="text" name="form_price" value="'.$row["Цена"].'">
      </li>
      
      <li>
      <label>Количество</label>
      <input type="text" name="form_col" value="'.$row["Количество на складе"].'">
      </li>
      
      <li>
      <label>Год коллекции</label>
      <input type="text" name="form_date" value="'.$row["Год коллекции"].'">
      </li>
      
      
      
      ';
  
$category = mysqli_query($link, "SELECT * FROM category"); //Представление
    
if (mysqli_num_rows($category) > 0)
{
$result_category = mysqli_fetch_array($category);

if ($row["type_tovara"] == "Свадебное платье") $type_dress = "selected";

echo '<li>
<label>Тип товара</label>
<select name="form_type" id="type" size="1" >
<option '.$type_dress.' value="Свадебное платье">Свадебное платье</option>
</select>
</li>

<li>
<label>Бренд</label>
<select name="form_category" size="7" >';
do
{
  
  echo '
  
  <option value="'.$result_category["Код категории"].'" >'.$result_category["brand"].'</option>
  
  ';
    
}
 while ($result_category = mysqli_fetch_array($category));
}
echo '
</select>
</ul> 
';

if  (strlen($row["Фото"]) > 0 && file_exists("img/Платья/".$row["Фото"]))
{
$img_path = 'img/Платья/'.$row["Фото"];
$max_width = 120; 
$max_height = 120; 
list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
$width = intval($ratio*$width); 
$height = intval($ratio*$height); 

echo '
<label class="stylelabel" >Фото</label>
<div id="baseimg">
<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
<a href="edit_product.php?id='.$row["Код платья"].'&img='.$row["Фото"].'&action=delete" ></a>
</div>
';
}else
{ 
echo '<label class="stylelabel">Фото</label>

<div id="baseimg-upload">
<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
<input type="file" name="upload_image">
</div>
';
}
echo'


<h3 class="h3click">Описание</h3>
<div class="div-editor1">
<textarea id="editor1" name="txt1" cols="100" rows="20">'.$row["Описание"].'</textarea>

 </div>       
';

if ($row["Видимость"] == '0') $checked1 = "checked";
if ($row["Новинки"] == '1') $checked2 = "checked";
if ($row["Лидер"] == '1') $checked3 = "checked";
if ($row["Распродажа"] == '1') $checked4 = "checked";
 
echo' 
<h3 class="h3title" >Настройки товара</h3>   
<ul id="chkbox">
<li><input type="checkbox" name="chk_visible" id="chk_visible" '.$checked1.'><label for="chk_visible">Показывать товар</label></li>
<li><input type="checkbox" name="chk_new" id="chk_new" '.$checked2.'><label for="chk_new">Новый товар</label></li>
<li><input type="checkbox" name="chk_leader" id="chk_leader" '.$checked3.'><label for="chk_leader">Популярный товар</label></li>
<li><input type="checkbox" name="chk_sale" id="chk_sale" '.$checked4.'><label for="chk_sale">Товар со скидкой</label></li>
</ul> 


    <p align="right" ><input type="submit" id="submit_form" name="submit_save" value="Сохранить"></p>     
</form>
';
}
while ($row = mysqli_fetch_array($result));
}
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