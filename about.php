<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" /> -->
   <link rel="stylesheet" href="css/style2.css">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="project images/cover1.png" alt="">
      </div>

      <div class="content">
         <h3>Know about Preownedtreasure.com!</h3>
         <p>Welcome to PreOwnedTreasures.com, your one-stop-shop for affordable, high-quality second-hand products. At PreOwnedTreasures.com, we believe that every item has a story to tell and that these treasures deserve a second chance to be loved and appreciated. We offer a wide range of products, from clothing and accessories to electronics and home goods, all carefully selected and thoroughly inspected to ensure their quality and freshness. Our prices are always fair, and our inventory is constantly updated with new and exciting finds. But our commitment to our customers goes beyond just offering great products at affordable prices. We pride ourselves on providing top-notch customer service, with a dedicated 24-hour support team ready to answer any questions or concerns you may have.
            We believe in the power of second-hand shopping to not only save you money but also to reduce waste and promote sustainability. When you shop with us, you can feel good knowing that you are making a positive impact on the environment while also getting great deals on quality products. So come explore our treasure trove of pre-loved items, and see for yourself why PreOwnedTreasures.com is the ultimate destination for budget-conscious shoppers who refuse to compromise on quality or style.
         </p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">Customer's Review</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="images/pic-1.png" alt="">
         <p>I'm blown away by the quality of the second-hand products I've received from PreOwnedTreasures.com. The clothing and accessories are in amazing condition, and the electronics are working perfectly. Plus, the customer service team is always friendly and helpful. I highly recommend this site to anyone looking for affordable and sustainable shopping options..</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Ethan Johnson</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-2.png" alt="">
         <p>"As a college student on a tight budget, I'm always on the lookout for good deals. PreOwnedTreasures.com has been a lifesaver for me! I've found some amazing pieces for my wardrobe and dorm room, all at prices I can actually afford. I love that I'm able to shop sustainably without breaking the bank</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Ava Martinez</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-3.png" alt="">
         <p>I was skeptical about shopping for second-hand products online, but PreOwnedTreasures.com exceeded my expectations. The site is easy to navigate, and the descriptions and photos of each item are accurate and helpful. I've purchased several items from the site now and have been impressed with the quality of everything. I appreciate that the site is committed to promoting sustainability, and I'll definitely be shopping here again.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Jacob Patel</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-4.png" alt="">
         <p>I recently discovered PreOwnedTreasures.com and I have to say, I am absolutely thrilled with my shopping experience! As someone who loves sustainable fashion, I was delighted to find such a wide range of high-quality, affordable pre-loved clothing options. The website is easy to navigate, and I appreciate the attention to detail that goes into each product listing. Shipping was fast and hassle-free, and I even received a personalized thank-you note with my purchase. I will definitely be shopping here again and recommending PreOwnedTreasures.com to all my friends!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Emily Smith</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-5.png" alt="">
         <p>As someone who is always on the lookout for a good deal, I was excited to stumble upon PreOwnedTreasures.com. I have to say, I was not disappointed! The selection of pre-owned items is truly impressive, and the prices are unbeatable. I was a bit skeptical about buying electronics online, but the website's thorough inspection process put my mind at ease. I ended up snagging a great deal on a refurbished laptop, and it works perfectly. I also appreciate the website's commitment to sustainability and reducing waste. Overall, a great experience and I will definitely be shopping here again.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Victor Smith</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-6.png" alt="">
         <p> I cannot recommend PreOwnedTreasures.com enough! As someone who loves to decorate my home, I was thrilled to find such a wide selection of pre-owned home goods on the website. The quality of the items is top-notch, and I was pleasantly surprised by how affordable everything was. I ended up purchasing a beautiful vintage rug and some unique, one-of-a-kind decor pieces that really make my apartment feel like home. The shipping was fast and the customer service was fantastic. I will definitely be a returning customer!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Sarah Johnson</h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>