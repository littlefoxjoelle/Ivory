<?php

$error_img = array();

if ($_FILES['upload_image']['error'] > 0)
{
    switch ($_FILES['upload_image']['error'])
    {
    case 1 : $error_img[] = 'Размер файла превышает допустимое значение UPLOAD_MAX_FILE_SIZE';break;
    case 2 : $error_img[] = 'Размер файла превышает допустимое значение MAX_FILE_SIZE';break;
    case 3 : $error_img[] = 'Не удалось загрузить часть файла';break;
    case 4 : $error_img[] = 'Файл не был загружен';break;
    case 5 : $error_img[] = 'Отсутствует временная папка';break;
    case 6 : $error_img[] = 'Не удалось записать файл на диск';break;
    case 7 : $error_img[] = 'PHP-расширение остановило загрузку файла';break;
    }
}
else{
        if ($_FILES['upload_image']['type'] == 'image/jpeg' || $_FILES['upload_image']['type'] == 'image/jpg' || $_FILES['upload_image']['type'] == 'image/png')
        {
            $imgext = strtolower(preg_replace("#.+\.([a-z]+)$#i","$1", $_FILES['upload_image']['name']));
            $uploaddir = 'img/Платья/';
            $newfilename = $_POST["form_type"].'-'.$id.rand(10,100).'.'.$imgext;
            $uploadfile = $uploaddir.$newfilename;

            if (move_uploaded_file($_FILES['upload_image']['tmp_name'], $uploadfile))
            {
            $update = mysqli_query($link, "UPDATE `товары` SET `Фото`='$newfilename' WHERE `Код платья`={$id['max']}");
            }
            else{
                $error_img[] = "Ошибка загрузки файла. Допустимые расширения: jpeg, jpg, png";
            }
        }
    }

?>