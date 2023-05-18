<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){
   $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
   $number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_NUMBER_INT);
   $msg = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_STRING);

   $select_message = oci_parse($conn, "SELECT * FROM messages WHERE name = :name AND email = :email AND phone_number = :phone_number AND message_text = :msg");

   oci_bind_by_name($select_message, ":name", $name);
   oci_bind_by_name($select_message, ":email", $email);
   oci_bind_by_name($select_message, ":phone_number", $number);
   oci_bind_by_name($select_message, ":msg", $msg);
   if (!oci_execute($select_message)) {
       $error = oci_error($select_message);
       die(htmlspecialchars($error['message_text']));
   }

   if(oci_fetch($select_message)){
      $message[] = 'already sent message!';
   }else{
      $insert_message = oci_parse($conn, "INSERT INTO messages (id, user_id, name, email, phone_number, message_text) VALUES (message_seq.nextval, :user_id, :name, :email, :phone_number, :msg)");
      oci_bind_by_name($insert_message, ":user_id", $user_id);
      oci_bind_by_name($insert_message, ":name", $name);
      oci_bind_by_name($insert_message, ":email", $email);
      oci_bind_by_name($insert_message, ":phone_number", $number);
      oci_bind_by_name($insert_message, ":msg", $msg);
      if (!oci_execute($insert_message)) {
         $error = oci_error($insert_message);
         die(htmlspecialchars($error['message_text']));
      }

      $message[] = 'sent message successfully!';
   }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>get in touch</h3>
      <input type="text" name="name" placeholder="Enter Your Name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="Enter Your Email" required maxlength="50" class="box">
      <input type="number" name="phone_number" min="0" max="9999999999" placeholder="Enter Your Number" required onkeypress="if(this.value.length == 11) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Enter Your Message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>