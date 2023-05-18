<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
<head>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-+ztUjILiU6y7W8PvdmgeXN/6R38BK2NlL8nHQaL1xAVh/EXqyzz7VKTsKjFg7TEwlM3q3EzV8ajSZtjK7dRkQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<header class="header">
   <section class="flex">
   <a href="home.php" class="logo-image">
   <img src="project images/logo.png" alt="Logo" style="max-width: 100px;">
   </a>
      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About</a>
         <a href="orders.php">Orders</a>
         <a href="shop.php">Shop</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         <?php
            $count_wishlist_items = oci_parse($conn, "SELECT * FROM wishlist WHERE user_id = :user_id");
            oci_bind_by_name($count_wishlist_items, ":user_id", $user_id);
            oci_execute($count_wishlist_items);
            $total_wishlist_counts = oci_fetch_all($count_wishlist_items, $count_wishlist_items_arr);

            $count_cart_items = oci_parse($conn, "SELECT * FROM cart WHERE user_id = :user_id");
            oci_bind_by_name($count_cart_items, ":user_id", $user_id);
            oci_execute($count_cart_items);
            $total_cart_counts = oci_fetch_all($count_cart_items, $count_cart_items_arr);
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i></a>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
      <?php          
            $select_profile = oci_parse($conn, "SELECT * FROM users WHERE id = :user_id");
            oci_bind_by_name($select_profile, ":user_id", $user_id);
            oci_execute($select_profile);
            $fetch_profile = oci_fetch_assoc($select_profile);
            
            if($fetch_profile) {
      ?>
            <p><?= isset($fetch_profile["name"]) ? $fetch_profile["name"] : ""; ?></p>
            <p>Hey, <?= $fetch_profile['NAME']; ?> !!</p>
            <a href="update_user.php" class="btn">update profile</a>
            <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
         <?php
            } else {
         ?>
            <p>Please Login or Register First!</p>
            <div class="flex-btn">
               <a href="user_register.php" class="option-btn">register</a>
               <a href="user_login.php" class="option-btn">login</a>
            </div>
         <?php
            }
         ?>      

         
      </div>

</section>

</header>