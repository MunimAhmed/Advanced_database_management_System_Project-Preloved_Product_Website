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
   <title>Search Page</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_box" placeholder="search here..." maxlength="100" class="box" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>
</section>

<section class="products" style="padding-top: 0; min-height:100vh;">

   <div class="box-container">

   <?php
     if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
     $search_box = $_POST['search_box'];
     $select_products = oci_parse($conn, "SELECT * FROM products WHERE UPPER(category) = UPPER('$search_box') or UPPER(name) LIKE UPPER('%" . $search_box . "%')");
     oci_execute($select_products);
     $product_count = oci_fetch_all($select_products, $products, null, null, OCI_FETCHSTATEMENT_BY_ROW);
     if($product_count > 0){
      foreach($products as $product){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $product['ID']; ?>">
      <input type="hidden" name="name" value="<?= $product['NAME']; ?>">
      <input type="hidden" name="price" value="<?= $product['PRICE']; ?>">
      <input type="hidden" name="image" value="<?= $product['IMAGE_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $product['ID']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $product['IMAGE_01']; ?>" alt="">
      <div class="name"><?= $product['NAME']; ?></div>
      <div class="flex">
         <div class="price"><span>$</span><?= $product['PRICE']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products found!</p>';
      }
   }
   ?>

   </div>

</section>












<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
