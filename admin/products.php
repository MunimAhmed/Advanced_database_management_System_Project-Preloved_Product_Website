<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   $select_products = oci_parse($conn, "SELECT * FROM products WHERE name = :name");
   oci_bind_by_name($select_products, ':name', $name);
   oci_execute($select_products);

   if(oci_fetch($select_products)){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = oci_parse($conn, "INSERT INTO products(id, name, details, price, image_01, image_02, image_03, category) VALUES(products_seq.nextval, :name, :details, :price, :image_01, :image_02, :image_03, :category)");
      oci_bind_by_name($insert_products, ':name', $name);
      oci_bind_by_name($insert_products, ':details', $details);
      oci_bind_by_name($insert_products, ':price', $price);
      oci_bind_by_name($insert_products, ':image_01', $image_01);
      oci_bind_by_name($insert_products, ':image_02', $image_02);
      oci_bind_by_name($insert_products, ':image_03', $image_03);
      oci_bind_by_name($insert_products, ':category', $category);
      oci_execute($insert_products);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'new product added!';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = oci_parse($conn, "SELECT * FROM products WHERE id = :id");
   oci_bind_by_name($delete_product_image, ":id", $delete_id);
   oci_execute($delete_product_image);
   $fetch_delete_image = oci_fetch_assoc($delete_product_image);
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
   $delete_product = oci_parse($conn, "DELETE FROM products WHERE id = :id");
   oci_bind_by_name($delete_product, ":id", $delete_id);
   oci_execute($delete_product);
   $delete_cart = oci_parse($conn, "DELETE FROM cart WHERE pid = :pid");
   oci_bind_by_name($delete_cart, ":pid", $delete_id);
   oci_execute($delete_cart);
   $delete_wishlist = oci_parse($conn, "DELETE FROM wishlist WHERE pid = :pid");
   oci_bind_by_name($delete_wishlist, ":pid", $delete_id);
   oci_execute($delete_wishlist);
   header('location:products.php');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Product Name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Enter Product Name" name="name">
         </div>
         <div class="inputBox">
            <span>Product Price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="Enter Product Price" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
        <div class="inputBox">
            <span>Image 01 (required)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Image 02 (required)</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Image 03 (required)</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>Product Details (required)</span>
            <textarea name="details" placeholder="Enter Product Details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
         <div class="inputBox">
         <span>Product Category (required)</span>
         <select name="category" class="box" required>
            <option value="" disabled selected>Choose a category</option>
            <option value="laptop">Laptop</option>
            <option value="tv">TV</option>
            <option value="smartphone">Smartphone</option>
            <option value="computer accessories">Computer Accessories</option>
            <option value="refrigerator">Refrigerator</option>
            <option value="washing machine">Washing Machine</option>
            <option value="watch">Watch</option>
            <option value="household">Household</option>
            <option value="camera">Camera</option>
            <option value="clothings">Clothings</option>
            <option value="furniture">Furniture</option>
         </select>
         </div>
      </div>
      
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">products added</h1>

   <div class="box-container">
   <?php
    $select_products = oci_parse($conn, "SELECT * FROM products");
    oci_execute($select_products);
    if(oci_fetch_all($select_products, $fetch_products, null, null, OCI_FETCHSTATEMENT_BY_ROW)){ 
        foreach($fetch_products as $row){ 
?>
        <div class="box">
            <img src="../uploaded_img/<?= $row['IMAGE_01']; ?>" alt="">
            <div class="name"><?= $row['NAME']; ?></div>
            <div class="price">$<span><?= $row['PRICE']; ?></span>/-</div>
            <div class="details"><span><?= $row['DETAILS']; ?></span></div>
            <div class="flex-btn">
                <a href="update_product.php?update=<?= $row['ID']; ?>" class="option-btn">update</a>
                <a href="products.php?delete=<?= $row['ID']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
            </div>
        </div>
<?php
        }
    }else{
        echo '<p class="empty">no products added yet!</p>';
    }
?>
</div>

</section>








<script src="../js/admin_script.js"></script>
   
</body>
</html>
