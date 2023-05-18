<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = oci_parse($conn, "DELETE FROM messages WHERE id = :id");
   oci_bind_by_name($delete_message, ':id', $delete_id);
   oci_execute($delete_message);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="contacts">

<h1 class="heading">messages</h1>

<div class="box-container">

   <?php
      $select_messages = oci_parse($conn, "SELECT * FROM messages");
      oci_execute($select_messages);
      if(oci_fetch_all($select_messages, $messages) > 0){
         for ($i = 0; $i < count($messages['ID']); $i++) {
   ?>
   <div class="box">
   <p> user id : <span><?= $messages['USER_ID'][$i]; ?></span></p>
   <p> name : <span><?= $messages['NAME'][$i]; ?></span></p>
   <p> email : <span><?= $messages['EMAIL'][$i]; ?></span></p>
   <p> number : <span><?= $messages['PHONE_NUMBER'][$i]; ?></span></p>
   <p> message : <span><?= $messages['MESSAGE_TEXT'][$i]; ?></span></p>
   <a href="messages.php??delete=<?= $messages['ID'][$i]; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages</p>';
      }
   ?>

</div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
