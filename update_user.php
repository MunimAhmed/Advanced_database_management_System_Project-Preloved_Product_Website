<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

$fetch_profile = oci_parse($conn, "SELECT * FROM users WHERE id='$user_id'");
oci_execute($fetch_profile);
$profile_data = oci_fetch_assoc($fetch_profile);

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];
   $prev_pass = $profile_data['PASSWORD']; // Previous password fetched from database

   // Checking if old password matches the previous password
   if ($old_pass == $prev_pass) {

      // If new password and confirm password match, update the profile
      if ($new_pass == $confirm_pass) {
         $update_profile = oci_parse($conn, "UPDATE users SET name='$name', email ='$email' , password='$new_pass' WHERE id='$user_id'");
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
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Update profile</h3>
      <?php if (isset($error_msg)) { ?>
         <h4><div class="error-msg"><?= $error_msg ?></div></h4>
      <?php } ?>
      <input type="hidden" name="prev_pass" value="<?= isset($profile_data ["password"]) ? $profile_data ["password"] : '' ?>">
      <input type="text" name="name" required placeholder="Enter your username" maxlength="20"  class="box" value="<?= isset($profile_data ["name"]) ? $profile_data ["name"] : '' ?>">
      <input type="email" name="email" required placeholder="Enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= isset($profile_data ["email"]) ? $profile_data ["email"] : '' ?>">
      <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="confirm your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>