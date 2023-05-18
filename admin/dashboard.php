<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>Welcome!</h3>
         <?php
            $select_profile = oci_parse($conn, "BEGIN :cur := get_row_by_id('admins', :id ); END;");
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($select_profile, ':id', $admin_id);
            oci_bind_by_name($select_profile, ':cur', $cursor, -1, OCI_B_CURSOR);
            oci_execute($select_profile);
            oci_execute($cursor);
            $fetch_profile = oci_fetch_assoc($cursor);
         ?>
         <p><?= $fetch_profile['NAME']; ?></p>
         <a href="update_profile.php" class="btn">Update Profile</a>
      </div>

      <div class="box">
      <?php
         $total_pendings = 0;
         $cursor = oci_new_cursor($conn);
         $statement = oci_parse($conn, "BEGIN :result := get_orders_by_payment_status('pending'); END;");
         oci_bind_by_name($statement, ":result", $cursor, -1, OCI_B_CURSOR);
         oci_execute($statement);
         oci_execute($cursor);
         while($fetch_pendings = oci_fetch_assoc($cursor)){
            $total_pendings += $fetch_pendings['TOTAL_PRICE'];
         }
      ?>

         <h3><span>$</span><?= $total_pendings; ?><span>/-</span></h3>
         <p>Total Pendings</p>
         <a href="placed_orders.php" class="btn">see orders</a>
      </div>

      <div class="box">
      <?php
         $total_completes = 0;
         $cursor = oci_new_cursor($conn);
         $statement = oci_parse($conn, "BEGIN :result := get_orders_by_payment_status('completed'); END;");
         oci_bind_by_name($statement, ":result", $cursor, -1, OCI_B_CURSOR);
         oci_execute($statement);
         oci_execute($cursor);
         while($fetch_completes = oci_fetch_assoc($cursor)){
            $total_completes += $fetch_completes['TOTAL_PRICE'];
         }
      ?>
         <h3><span>$</span><?= $total_completes; ?><span>/-</span></h3>
         <p>Completed Orders</p>
         <a href="placed_orders.php" class="btn">See orders</a>
      </div>

      <div class="box">
         <?php
            $select_orders = oci_parse($conn, "SELECT * FROM orders");
            oci_execute($select_orders);
            $number_of_orders = oci_fetch_all($select_orders, $orders);
         ?>
         <h3><?= $number_of_orders; ?></h3>
         <p>Orders Placed</p>
         <a href="placed_orders.php" class="btn">See orders</a>
      </div>

      <div class="box">
         <?php
            $select_products = oci_parse($conn, "SELECT * FROM products");
            oci_execute($select_products);
            $number_of_products = oci_fetch_all($select_products, $products);
         ?>
         <h3><?= $number_of_products; ?></h3>
         <p>Products Added</p>
         <a href="products.php" class="btn">see products</a>
      </div>
      <div class="box">
     <?php
        $select_users = oci_parse($conn,"SELECT * FROM users");
        oci_execute($select_users);
        $number_of_users = oci_fetch_all($select_users, $users, null, null, OCI_FETCHSTATEMENT_BY_ROW);
     ?>
     <h3><?= $number_of_users; ?></h3>
     <p>Normal Users</p>
     <a href="users_accounts.php" class="btn">see users</a>
  </div>

  <div class="box">
     <?php
        $select_admins = oci_parse($conn,"SELECT * FROM admins");
        oci_execute($select_admins);
        $number_of_admins = oci_fetch_all($select_admins, $admins, null, null, OCI_FETCHSTATEMENT_BY_ROW);
     ?>
     <h3><?= $number_of_admins; ?></h3>
     <p>Admin Users</p>
     <a href="admin_accounts.php" class="btn">see admins</a>
  </div>

  <div class="box">
     <?php
        $select_messages = oci_parse($conn,"SELECT * FROM messages");
        oci_execute($select_messages);
        $number_of_messages = oci_fetch_all($select_messages, $messages, null, null, OCI_FETCHSTATEMENT_BY_ROW);
     ?>
     <h3><?= $number_of_messages; ?></h3>
     <p>New Messages</p>
     <a href="messages.php" class="btn">see messages</a>
     </div>

</div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>