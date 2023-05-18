<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = oci_parse($conn, "UPDATE orders SET payment_status = :payment_status WHERE id = :order_id");
   oci_bind_by_name($update_payment, ":payment_status", $payment_status);
   oci_bind_by_name($update_payment, ":order_id", $order_id);
   oci_execute($update_payment);
   $message[] = 'payment status updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = oci_parse($conn, "DELETE FROM orders WHERE id = :delete_id");
   oci_bind_by_name($delete_order, ":delete_id", $delete_id);
   oci_execute($delete_order);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">placed orders</h1>

<div class="box-container">

   <?php
      $select_orders = oci_parse($conn, "SELECT * FROM orders");
      oci_execute($select_orders);
      $select_orders_count = oci_fetch_all($select_orders, $fetch_orders, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
      if($select_orders_count > 0){
         foreach($fetch_orders as $order){
   ?>
   <div class="box">
      <p> Placed on : <span><?= $order['PLACED_ON']; ?></span> </p>
      <p> Name : <span><?= $order['NAME']; ?></span> </p>
      <p> Number : <span><?= $order['PHONE_NUMBER']; ?></span> </p>
      <p> Address : <span><?= $order['ADDRESS']; ?></span> </p>
      <p> Total products : <span><?= $order['TOTAL_PRODUCTS']; ?></span> </p>
      <p> Total price : <span>$<?= $order['TOTAL_PRICE']; ?>/-</span> </p>
      <p> Payment method : <span><?= $order['METHOD']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $order['ID']; ?>">
         <select name="payment_status" class="select">
            <option selected disabled><?= $order['PAYMENT_STATUS']; ?></option>
            <option value="pending">pending</option>
            <option value="completed">completed</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="update" class="option-btn" name="update_payment">
         <a href="placed_orders.php?delete=<?= $order['ID']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>

</div>

</section>

</section>

