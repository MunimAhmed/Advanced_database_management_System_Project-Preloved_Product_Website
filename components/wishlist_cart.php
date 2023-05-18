<?php

if(isset($_POST['add_to_wishlist'])){

   if($user_id == ''){
      header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);

      $check_wishlist_numbers = oci_parse($conn, "SELECT * FROM wishlist WHERE name = :name AND user_id = :user_id");
      oci_bind_by_name($check_wishlist_numbers, ":name", $name);
      oci_bind_by_name($check_wishlist_numbers, ":user_id", $user_id);
      oci_execute($check_wishlist_numbers);

      $check_cart_numbers = oci_parse($conn, "SELECT * FROM cart WHERE name = :name AND user_id = :user_id");
      oci_bind_by_name($check_cart_numbers, ":name", $name);
      oci_bind_by_name($check_cart_numbers, ":user_id", $user_id);
      oci_execute($check_cart_numbers);

      if(oci_fetch_assoc($check_wishlist_numbers)){
         $message[] = 'already added to wishlist!';
      }elseif(oci_fetch_assoc($check_cart_numbers)){
         $message[] = 'already added to cart!';
      }else{
         $insert_wishlist = oci_parse($conn, "INSERT INTO wishlist(id, user_id, pid, name, price, image) VALUES(wishlist_seq.nextval, :user_id, :pid, :name, :price, :image)");
         oci_bind_by_name($insert_wishlist, ":user_id", $user_id);
         oci_bind_by_name($insert_wishlist, ":pid", $pid);
         oci_bind_by_name($insert_wishlist, ":name", $name);
         oci_bind_by_name($insert_wishlist, ":price", $price);
         oci_bind_by_name($insert_wishlist, ":image", $image);
         oci_execute($insert_wishlist);
         $message[] = 'added to wishlist!';
      }

   }

}

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
    
      $check_cart_numbers = oci_parse($conn, "SELECT * FROM cart WHERE name = :name AND user_id = :user_id");
      oci_bind_by_name($check_cart_numbers, ":name", $name);
      oci_bind_by_name($check_cart_numbers, ":user_id", $user_id);
      oci_execute($check_cart_numbers);

      if(oci_fetch_assoc($check_cart_numbers)){
         $message[] = 'already added to cart!';
      }else{
      
         $check_wishlist_numbers = oci_parse($conn, "SELECT * FROM wishlist WHERE name = :name AND user_id = :user_id");
         oci_bind_by_name($check_wishlist_numbers, ":name", $name);
         oci_bind_by_name($check_wishlist_numbers, ":user_id", $user_id);
         oci_execute($check_wishlist_numbers);
      
         if(oci_fetch_assoc($check_wishlist_numbers)){
            $delete_wishlist = oci_parse($conn, "DELETE FROM wishlist WHERE name = :name AND user_id = :user_id");
            oci_bind_by_name($delete_wishlist, ":name", $name);
            oci_bind_by_name($delete_wishlist, ":user_id", $user_id);
            oci_execute($delete_wishlist);
         }
      
         $insert_cart = oci_parse($conn, "INSERT INTO cart(id, user_id, pid, name, price, image) VALUES(cart_seq.nextval, :user_id, :pid, :name, :price, :image)");
         oci_bind_by_name($insert_cart, ":user_id", $user_id);
         oci_bind_by_name($insert_cart, ":pid", $pid);
         oci_bind_by_name($insert_cart, ":name", $name);
         oci_bind_by_name($insert_cart, ":price", $price);
         oci_bind_by_name($insert_cart, ":image", $image);
         oci_execute($insert_cart);
         $message[] = 'added to cart!';
         
      }

   }

}

?>