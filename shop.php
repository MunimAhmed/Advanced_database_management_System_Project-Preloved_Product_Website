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
   <title>shop</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h1 class="heading">latest products</h1>

   <div class="box-container">

   <?php
     $select_products = oci_parse($conn, "SELECT * FROM products"); 
     oci_execute($select_products);
     while($fetch_product = oci_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['ID']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['NAME']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['PRICE']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['IMAGE_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['ID']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['IMAGE_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['NAME']; ?></div>
      <div class="flex">
         <div class="price"><span>$</span><?= $fetch_product['PRICE']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
