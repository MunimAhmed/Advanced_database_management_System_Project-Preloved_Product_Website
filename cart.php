<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
}

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = oci_parse($conn, "DELETE FROM cart WHERE id = :cart_id");
   oci_bind_by_name($delete_cart_item, ":cart_id", $cart_id);
   oci_execute($delete_cart_item);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = oci_parse($conn, "DELETE FROM cart WHERE user_id = :user_id");
   oci_bind_by_name($delete_cart_item, ":user_id", $user_id);
   oci_execute($delete_cart_item);
   header('location:cart.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products shopping-cart">

   <h3 class="heading">shopping cart</h3>

   <div class="box-container">

   <?php
$grand_total = 0;
$select_cart = oci_parse($conn, "SELECT * FROM cart WHERE user_id = :user_id");
oci_bind_by_name($select_cart, ":user_id", $user_id);
oci_execute($select_cart);

if (oci_fetch_all($select_cart, $fetch_cart, null, null, OCI_FETCHSTATEMENT_BY_ROW) > 0) {
    foreach ($fetch_cart as $cart_item) {
        $sub_total = ($cart_item['PRICE']);
        $grand_total += $sub_total;
?>
        <form action="" method="post" class="box">
            <input type="hidden" name="cart_id" value="<?= $cart_item['ID']; ?>">
            <a href="quick_view.php?pid=<?= $cart_item['PID']; ?>" class="fas fa-eye"></a>
            <img src="uploaded_img/<?= $cart_item['IMAGE']; ?>" alt="">
            <div class="name"><?= $cart_item['NAME']; ?></div>
            <div class="flex">
                <div class="price">$<?= $cart_item['PRICE']; ?>/-</div>
                <button type="submit" class="fas fa-edit" name="update_qty"></button>
            </div>
            <div class="sub-total"> sub total : <span>$<?= $sub_total ?>/-</span> </div>
            <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
        </form>
<?php
    }
} else {
    echo '<p class="empty">your cart is empty</p>';
}
?>

   </div>
   
   <div class="cart-total">
      <p>grand total : <span>$<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all item</a>
      <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div> 
   </section>