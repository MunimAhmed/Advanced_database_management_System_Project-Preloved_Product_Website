<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   
   $update_product = oci_parse($conn, "UPDATE products SET name = :name, price = :price, details = :details, category = :category WHERE id = :pid");

   oci_bind_by_name($update_product, ":name", $name);
   oci_bind_by_name($update_product, ":price", $price);
   oci_bind_by_name($update_product, ":details", $details);
   oci_bind_by_name($update_product, ":category", $category);
   oci_bind_by_name($update_product, ":pid", $pid);

   oci_execute($update_product);

   $message[] = 'product updated successfully!';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_01 = oci_parse($conn, "UPDATE products SET image_01 = :image_01 WHERE id = :pid");
         oci_bind_by_name($update_image_01, ":image_01", $image_01);
         oci_bind_by_name($update_image_01, ":pid", $pid);
         oci_execute($update_image_01);

         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $message[] = 'image 01 updated successfully!';
      }
   }

   $old_image_02 = $_POST['old_image_02'];
   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   if(!empty($image_02)){
      if($image_size_02 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_02 = oci_parse($conn, "UPDATE products SET image_02 = :image_02 WHERE id = :pid");
         oci_bind_by_name($update_image_02, ":image_02", $image_02);
         oci_bind_by_name($update_image_02, ":pid", $pid);
         oci_execute($update_image_02);

         move_uploaded_file($image_tmp_name_02, $image_folder_02);
         unlink('../uploaded_img/'.$old_image_02);
         $message[] = 'image 02 updated successfully!';
      }
   }

   $old_image_03 = $_POST['old_image_03'];
   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;
   
   if(!empty($image_03)){
       if($image_size_03 > 2000000){
           $message[] = 'image size is too large!';
       }else{
           $update_image_03 = oci_parse($conn, "UPDATE products SET image_03 = :image_03 WHERE id = :pid");
           oci_bind_by_name($update_image_03, ':image_03', $image_03);
           oci_bind_by_name($update_image_03, ':pid', $pid);
           oci_execute($update_image_03);
   
           move_uploaded_file($image_tmp_name_03, $image_folder_03);
           unlink('../uploaded_img/'.$old_image_03);
           $message[] = 'image 03 updated successfully!';
       }
   }
}
   
   ?>
   
   <!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>update product</title>
   
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   
      <link rel="stylesheet" href="../css/admin_style.css">
   
   </head>
   <body>
   <?php include '../components/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">update product</h1>  
   <?php
  $update_id = $_GET['update'];
  $select_products = oci_parse($conn, "SELECT * FROM products WHERE id = :id");
  oci_bind_by_name($select_products, ":id", $update_id);
  oci_execute($select_products);
  if(oci_fetch($select_products)){
?>
<form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="pid" value="<?= oci_result($select_products, 'ID'); ?>">
  <input type="hidden" name="old_image_01" value="<?= oci_result($select_products, 'IMAGE_01'); ?>">
  <input type="hidden" name="old_image_02" value="<?= oci_result($select_products, 'IMAGE_02'); ?>">
  <input type="hidden" name="old_image_03" value="<?= oci_result($select_products, 'IMAGE_03'); ?>">
  <div class="image-container">
    <div class="main-image">
      <img src="../uploaded_img/<?= oci_result($select_products, 'IMAGE_01'); ?>" alt="">
    </div>
    <div class="sub-image">
      <img src="../uploaded_img/<?= oci_result($select_products, 'IMAGE_01'); ?>" alt="">
      <img src="../uploaded_img/<?= oci_result($select_products, 'IMAGE_02'); ?>" alt="">
      <img src="../uploaded_img/<?= oci_result($select_products, 'IMAGE_03'); ?>" alt="">
    </div>
  </div>
  <span>update name</span>
  <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= oci_result($select_products, 'NAME'); ?>">
  <span>update price</span>
  <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= oci_result($select_products, 'PRICE'); ?>">
  <span>update details</span>
  <textarea name="details" class="box" required cols="30" rows="10"><?= oci_result($select_products, 'DETAILS'); ?></textarea>
  <span>update image 01</span>
  <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
  <span>update image 02</span>
  <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
  <span>update image 03</span>
  <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
  <div class="inputBox">
         <span>product category (required)</span>
         <select name="category" class="box" required>
            <option value="" disabled selected>Choose a category</option>
            <option value="laptop">Laptop</option>
            <option value="tv">TV</option>
            <option value="smartphone">Smartphone</option>
            <option value="computer accessories">Computer Accessories</option>
            <option value="fridge">Fridge</option>
            <option value="washing machine">Washing Machine</option>
            <option value="watch">Watch</option>
            <option value="household">Household</option>
            <option value="camera">Camera</option>
            <option value="clothings">Clothings</option>
            <option value="furniture">Furniture</option>
         </select>
         </div>
  <div class="flex-btn">
    <input type="submit" name="update" class="btn" value="update">
    <a href="products.php" class="option-btn">go back</a>
  </div>
</form>
<?php
  } 
   else{
      echo '<p class="empty">no product found!</p>';
   }
?>

</section>
