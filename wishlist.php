<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

include 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = oci_parse($conn, "DELETE FROM wishlist WHERE id = :wishlist_id");
   oci_bind_by_name($delete_wishlist_item, ':wishlist_id', $wishlist_id);
   oci_execute($delete_wishlist_item);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = oci_parse($conn, "DELETE FROM wishlist WHERE user_id = :user_id");
   oci_bind_by_name($delete_wishlist_item, ':user_id', $user_id);
   oci_execute($delete_wishlist_item);
   header('location:wishlist.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h3 class="heading">your wishlist</h3>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_wishlist = oci_parse($conn, "SELECT * FROM wishlist WHERE user_id = :user_id");
      oci_bind_by_name($select_wishlist, ":user_id", $user_id);
      oci_execute($select_wishlist);
      if(oci_fetch_all($select_wishlist, $wishlist_items) > 0){
         for($i=0; $i<count($wishlist_items['ID']); $i++){
            $grand_total += $wishlist_items['PRICE'][$i];  
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $wishlist_items['PID'][$i]; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $wishlist_items['ID'][$i]; ?>">
      <input type="hidden" name="name" value="<?= $wishlist_items['NAME'][$i]; ?>">
      <input type="hidden" name="price" value="<?= $wishlist_items['PRICE'][$i]; ?>">
      <input type="hidden" name="image" value="<?= $wishlist_items['IMAGE'][$i]; ?>">
      <a href="quick_view.php?pid=<?= $wishlist_items['PID'][$i]; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $wishlist_items['IMAGE'][$i]; ?>" alt="">
      <div class="name"><?= $wishlist_items['NAME'][$i]; ?></div>
      <div class="flex">
         <div class="price">$<?= $wishlist_items['PRICE'][$i]; ?>/-</div>
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
      <input type="submit" value="delete item" onclick="return confirm('delete this from wishlist?');" class="delete-btn" name="delete">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">your wishlist is empty</p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      <p>grand total : <span>$<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from wishlist?');">delete all item</a>
   </div>

</section>














<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>