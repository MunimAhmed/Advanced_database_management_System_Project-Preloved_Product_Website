<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_user = oci_parse($conn, "DELETE FROM users WHERE id = :delete_id");
   oci_bind_by_name($delete_user, ":delete_id", $delete_id);
   oci_execute($delete_user);

   $delete_orders = oci_parse($conn, "DELETE FROM orders WHERE user_id = :delete_id");
   oci_bind_by_name($delete_orders, ":delete_id", $delete_id);
   oci_execute($delete_orders);

   $delete_messages = oci_parse($conn, "DELETE FROM messages WHERE user_id = :delete_id");
   oci_bind_by_name($delete_messages, ":delete_id", $delete_id);
   oci_execute($delete_messages);

   $delete_cart = oci_parse($conn, "DELETE FROM cart WHERE user_id = :delete_id");
   oci_bind_by_name($delete_cart, ":delete_id", $delete_id);
   oci_execute($delete_cart);

   $delete_wishlist = oci_parse($conn, "DELETE FROM wishlist WHERE user_id = :delete_id");
   oci_bind_by_name($delete_wishlist, ":delete_id", $delete_id);
   oci_execute($delete_wishlist);

   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">user accounts</h1>

   <div class="box-container">

   <?php
      $select_accounts = oci_parse($conn, "SELECT * FROM users");
      oci_execute($select_accounts);
      if (oci_fetch_all($select_accounts, $fetch_accounts) > 0) {
         for ($i = 0; $i < count($fetch_accounts['ID']); $i++) {
   ?>
   <div class="box">
      <p> user id : <span><?= $fetch_accounts['ID'][$i]; ?></span> </p>
      <p> username : <span><?= $fetch_accounts['NAME'][$i]; ?></span> </p>
      <p> email : <span><?= $fetch_accounts['EMAIL'][$i]; ?></span> </p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['ID'][$i]; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
