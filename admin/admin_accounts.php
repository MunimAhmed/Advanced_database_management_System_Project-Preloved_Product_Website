<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = oci_parse($conn, "DELETE FROM admins WHERE id = :id");
   oci_bind_by_name($delete_admins, ":id", $delete_id);
   oci_execute($delete_admins);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">admin accounts</h1>

   <div class="box-container">

   <div class="box">
      <p>add new admin</p>
      <a href="register_admin.php" class="option-btn">register admin</a>
   </div>

   <?php
      $select_accounts = oci_parse($conn, "SELECT * FROM admins");
      oci_execute($select_accounts);
      $rowCount = oci_fetch_all($select_accounts, $fetch_accounts, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
      if($rowCount > 0){
         foreach ($fetch_accounts as $row) {  
   ?>
   <div class="box">
      <p> admin id : <span><?= $row['ID']; ?></span> </p>
      <p> admin name : <span><?= $row['NAME']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $row['ID']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
         <?php
            if($row['ID'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
