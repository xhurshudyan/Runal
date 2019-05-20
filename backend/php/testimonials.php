<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INNOVA</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="../../frontend/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../frontend/fonts/font-awesome/css/font-awesome.css">

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../../frontend/css/style.css">
    <link rel="stylesheet" type="text/css" href="../../frontend/css/nivo-lightbox/nivo-lightbox.css">
    <link rel="stylesheet" type="text/css" href="../../frontend/css/nivo-lightbox/default.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<!-- Navigation -->
<nav id="menu-admin" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="about.php" class="page-scroll">О НАС</a></li>
                <li><a href="services.php" class="page-scroll">УСЛУГИ</a></li>
                <li><a href="projects.php" class="page-scroll">НАШЫ РАБОТЫ</a></li>
                <li><a href="testimonials.php" class="page-scroll">ОТЗЫВЫ</a></li>
                <li><a href="contact.php" class="page-scroll">КОНТАКТ</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" class="page-scroll">ГЛАВНАЯ</a></li>
                <li><a href="#" class="page-scroll">ВЫХОД</a></li>
            </ul>
        </div>
    </div>
</nav>
<div id="about">
    <div class="container">
        <h2>ОТЗЫВЫ</h2>
    </div>
</div>
<!--Content-->
<input type="hidden" name="hidden_upload" id="hidden_upload" value="">
<input type="hidden" name="id" id="id" value="">
<form id="form" action="testimonials_data.php" method="post" enctype="multipart/form-data" >
    <div  class="row col-sm-9 " style="margin-left: 13%; background-color: #fff;box-shadow: 0 2px 4px #f4d3d3;padding: 10px;">
        <div id="testimonials_div"></div>
        <div style="display: flex" >
            <div class="form-group col-sm-8">
                <h4>Контент</h4>
                <textarea class="form-control" rows="2" id="insert-content" name="content" maxlength="250"></textarea>
            </div>
            <div class="form-row col-sm-9">
                <div class="form-group col-sm-8">
                    <h4>Автор</h4>
                    <input type="text" class="form-control" id="actors" name="actors" >
                </div>
            </div>
        </div>
        <div  class="custom-file col-sm-7">
            <h4>Картинка</h4>
            <img style="max-width:180px;" id="img_response"  src="http://placehold.it/180" alt="your image" />
            <input type="file"  accept="image/*" class="custom-file-input" name="image" id="customFile" onchange="readURL(this);">
            <label tabindex="0"  class="custom-file-label" for="customFile">Добавить картинку</label>
            <input type="hidden" name="insert"  value="insert">
            <p id="error1" style="display: none">
                Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
            </p>
            <p id="error2" style="display: none">
                Maximum File Size Limit is 1MB.
            </p>
            <p></p>
        </div>
        <div class="mt-3 col-sm-2">
            <input style="background-color: #e18484;color: #fff;" type="submit" id="btn_image" name="btn_image" class="btn" value="Добавить">
        </div>
</form>
</div>
<!--Content-->
<?php
include "db_connect.php";
$query= "SELECT * FROM `testimonials` ";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result))
    {
        $directory = "../../frontend/img/testimonials/";
        $images = glob($directory . "/{$row['id']}.jpg");
        foreach($images as $image) {
            $datalist ="<div style='margin-left: 13%; background-color: #fff;box-shadow: 0 2px 4px #f4d3d3;padding: 10px;'  class='col-md-12'>
<div class='msg' id='msg".$row['id']."'></div>
<div style='display: flex;margin-left: 1%; background-color: #fff;box-shadow: 0 2px 4px #f4d3d3;padding: 10px;' class='card' >
<img class='card-img-top' style='width: 259px;height: 180px;margin-right: 50px' src='{$image}' alt='Card image cap'>
<form  class='forms' id='form".$row['id']."' action='testimonials_data.php' method='post' enctype='multipart/form-data' >
<input  type='file' style='display: none'   class='custom' name='image' id='custom".$row['id']."'>
<label tabindex='0'  class='custom' for='custom".$row['id']."'>Изминить картинку</label>
<input type='hidden' name='update'  value='update' style='display: none'> 
<input type='submit' id='btn_update".$row['id']."' name='btn_update' class='btn_update' onclick='isset_id(".$row['id'].")' value='Добавить'>
<input type='hidden' name='form_id' id='id".$row['id']."' value=''>
</form>
<div class='card-body'>
<form action='testimonials_data.php' method='post'>
<input id='authors".$row['id']."' type='text' class='update_authors' value='{$row['authors']}'>
<textarea id='content".$row['id']."' class='update_content' type='text' >{$row['content']}</textarea>
<input id='update_content".$row['id']."' onclick='give_id(".$row['id'].")' class='update_content' type='submit' value='Изменить' >
</form><input type='submit' class='delete' id='delete".$row['id']."' value='Удалить' onclick='delete_data(".$row['id'].")' ></div></div></div>";
            echo $datalist;
        }}}
?>
<div id="footer-admin">
    <div class="container text-center">
        <p>&copy; 2019</p>
    </div>
</div>
<script type="text/javascript" src="../../frontend/js/jquery.1.11.1.js"></script>
<script src="../js/testimonials_admin.js"></script>
<script type="text/javascript" src="../../frontend/js/bootstrap.js"></script>
</body>
</html>