<?php

include '../components/connect.php';
include '../components/admin_header.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

// Fetching admin profile data from admins table
$fetch_profile = oci_parse($conn, "SELECT * FROM admins WHERE id='$admin_id'");
oci_execute($fetch_profile);
$profile_data = oci_fetch_assoc($fetch_profile);

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];
   $prev_pass = $profile_data['PASSWORD']; // Previous password fetched from database

   // Checking if old password matches the previous password
   if ($old_pass == $prev_pass) {

      // If new password and confirm password match, update the profile
      if ($new_pass == $confirm_pass) {
         $update_profile = oci_parse($conn, "UPDATE admins SET name='$name', password='$new_pass' WHERE id='$admin_id'");
         oci_execute($update_profile);
         oci_commit($conn);
         $error_msg = "Password changed successfully.";
      } else {
         $error_msg = "New password and confirm password do not match";
      }

   } else {
      $error_msg = "Old password is incorrect";
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<section class="form-container">

   <form action="" method="post">
      <h3>update profile</h3>
      <?php if (isset($error_msg)) { ?>
         <h4><div class="error-msg"><?= $error_msg ?></div></h4>
      <?php } ?>
      <input type="hidden" name="prev_pass" value="<?= $profile_data['PASSWORD']; ?>">
      <input type="text" name="name" value="<?= $profile_data['NAME']; ?>" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" placeholder="enter old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="confirm new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
