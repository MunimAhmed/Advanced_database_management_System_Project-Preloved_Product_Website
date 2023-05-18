<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = oci_parse($conn, "SELECT * FROM cart WHERE user_id = :user_id");
   oci_bind_by_name($check_cart, ':user_id', $user_id);
   oci_execute($check_cart);

   if(oci_fetch($check_cart)){

      $insert_order = oci_parse($conn, "INSERT INTO orders (id, user_id, name, phone_number, email, method, address, total_products, total_price) VALUES (orders_seq.nextval, :user_id, :name, :phone_number, :email, :method, :address, :total_products, :total_price)");
      oci_bind_by_name($insert_order, ':user_id', $user_id);
      oci_bind_by_name($insert_order, ':name', $name);
      oci_bind_by_name($insert_order, ':phone_number', $number);
      oci_bind_by_name($insert_order, ':email', $email);
      oci_bind_by_name($insert_order, ':method', $method);
      oci_bind_by_name($insert_order, ':address', $address);
      oci_bind_by_name($insert_order, ':total_products', $total_products);
      oci_bind_by_name($insert_order, ':total_price', $total_price);
      oci_execute($insert_order);

      $delete_cart = oci_parse($conn, "DELETE FROM cart WHERE user_id = :user_id");
      oci_bind_by_name($delete_cart, ':user_id', $user_id);
      oci_execute($delete_cart);

      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

   <div class="display-orders">
  <?php
     $grand_total = 0;
     $cart_items = array();
     $select_cart = oci_parse($conn, "SELECT * FROM cart WHERE user_id = :user_id");
     oci_bind_by_name($select_cart, ':user_id', $user_id);
     oci_execute($select_cart);
     if(oci_fetch_all($select_cart, $fetch_cart, null, null, OCI_FETCHSTATEMENT_BY_ROW) > 0){
        foreach($fetch_cart as $cart){
           $cart_items[] = $cart['NAME'].' ('.$cart['PRICE'].' ) ';
           $total_products = implode($cart_items);
           $grand_total += ($cart['PRICE']);
  ?>
     <p> <?= $cart['NAME']; ?> <span>(<?= '$'.$cart['PRICE']; ?>)</span> </p>
  <?php
        }
     }else{
        echo '<p class="empty">your cart is empty!</p>';
     }
  ?>
     <input type="hidden" name="total_products" value="<?= $total_products; ?>">
     <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
     <div class="grand-total">grand total : <span>$<?= $grand_total; ?>/-</span></div>
  </div>

  <h3>place your orders</h3>

  <div class="flex">
     <div class="inputBox">
        <span>Your Name :</span>
        <input type="text" name="name" placeholder="Enter Your Name" class="box" maxlength="20" required>
     </div>
     <div class="inputBox">
        <span>Your Name :</span>
        <input type="number" name="number" placeholder="Enter Your Number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 11) return false;" required>
     </div>
     <div class="inputBox">
        <span>Your EMAIL :</span>
        <input type="email" name="email" placeholder="Enter Your Email" class="box" maxlength="50" required>
     </div>
     <div class="inputBox">
        <span>Payment Method :</span>
        <select name="method" class="box" required>
           <option value="cash on delivery">Cash on delivery</option>
           <option value="credit card">Credit card</option>
           <option value="bkash">Bkash</option>
           <option value="nagad">Nagad</option>
        </select>
     </div>
     <div class="inputBox">
        <span>Address Line 01 :</span>
        <input type="text" name="flat" placeholder="e.g. Flat number" class="box" maxlength="50" required>
     </div>
     <div class="inputBox">
        <span>Address Line 02 :</span>
        <input type="text" name="street" placeholder="e.g. Street name" class="box" maxlength="50" required>
     </div>
     <div class="inputBox">
        <span>City :</span>
        <input type="text" name="city" placeholder="e.g. Dhaka, Rajshahi, Sylhet etc." class="box" maxlength="50" required>
     </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" placeholder="e.g. Bangladesh" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Zip Code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 1203" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
