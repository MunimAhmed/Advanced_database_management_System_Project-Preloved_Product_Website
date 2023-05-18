<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>category</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <?php
     if(isset($_GET['category'])){
      $category = $_GET['category'];
   }else{
      $category = '';
   }
   ?>
   <h1 class="heading"><?php echo $category ?></h1>
   <?php
     $select_products = oci_parse($conn, "SELECT * FROM products WHERE category = '$category'");
     oci_execute($select_products);
     if(oci_fetch_all($select_products, $fetch_product) > 0){
      for($i = 0; $i < count($fetch_product['ID']); $i++){
   ?>
   <div class="box-container">
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['ID'][$i]; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['NAME'][$i]; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['PRICE'][$i]; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['IMAGE_01'][$i]; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['ID'][$i]; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['IMAGE_01'][$i]; ?>" alt="">
      <div class="name"><?= $fetch_product['NAME'][$i]; ?></div>
      <div class="flex">
         <div class="price"><span>$</span><?= $fetch_product['PRICE'][$i]; ?><span>/-</span></div>
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products found!</p>';
   }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
