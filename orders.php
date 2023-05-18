<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = oci_parse($conn, "SELECT * FROM orders WHERE user_id = :user_id");
         oci_bind_by_name($select_orders, ':user_id', $user_id);
         oci_execute($select_orders);
         if(oci_fetch_all($select_orders, $fetch_orders, null, null, OCI_FETCHSTATEMENT_BY_ROW) > 0){
            foreach($fetch_orders as $order){
   ?>
   <div class="box">
      <p>placed on : <span><?= $order['PLACED_ON']; ?></span></p>
      <p>name : <span><?= $order['NAME']; ?></span></p>
      <p>email : <span><?= $order['EMAIL']; ?></span></p>
      <p>number : <span><?= $order['PHONE_NUMBER']; ?></span></p>
      <p>address : <span><?= $order['ADDRESS']; ?></span></p>
      <p>payment method : <span><?= $order['METHOD']; ?></span></p>
      <p>your orders : <span><?= $order['TOTAL_PRODUCTS']; ?></span></p>
      <p>total price : <span>$<?= $order['TOTAL_PRICE']; ?>/-</span></p>
      <p> payment status : <span style="color:<?php if($order['PAYMENT_STATUS'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $order['PAYMENT_STATUS']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
