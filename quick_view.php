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
   <title>quick view</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1 class="heading">quick view</h1>

   <?php
$pid = $_GET['pid'];

$sql = "SELECT * FROM products WHERE id = :pid";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':pid', $pid);
oci_execute($stmt);

if (($row = oci_fetch_assoc($stmt)) !== false) {
?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $row['ID']; ?>">
      <input type="hidden" name="name" value="<?= $row['NAME']; ?>">
      <input type="hidden" name="price" value="<?= $row['PRICE']; ?>">
      <input type="hidden" name="image" value="<?= $row['IMAGE_01']; ?>">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="uploaded_img/<?= $row['IMAGE_01']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploaded_img/<?= $row['IMAGE_01']; ?>" alt="">
               <img src="uploaded_img/<?= $row['IMAGE_02']; ?>" alt="">
               <img src="uploaded_img/<?= $row['IMAGE_03']; ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name"><?= $row['NAME']; ?></div>
            <div class="flex">
               <div class="price"><span>$</span><?= $row['PRICE']; ?><span>/-</span></div>
            </div>
            <div class="details"><?= $row['DETAILS']; ?></div>
            <div class="flex-btn">
               <input type="submit" value="add to cart" class="btn" name="add_to_cart">
               <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
            </div>
         </div>
      </div>
   </form>
<?php
} else {
   echo '<p class="empty">no products added yet!</p>';
}
?>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>