<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
     
    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/style.css">

    
    <title>Document</title>
</head>
<body>
    <header class="header" id="header">
        <nav class="nav container">
           <a href="#" class="nav__logo">
              E-Commerce
           </a>
           <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li class="nav__item">
                     <a href="dashboard.php" class="nav__link active-link">Home</a>
                  </li>
                  
                  <!-- <li class="nav__item">
                     <a href="{{url('about')}}" class="nav__link">Article</a>
                  </li> -->
                  
                  <li class="nav__item">
                     <a href="product.php" class="nav__link">Product</a>
                  </li>
                  
                  <li class="nav__item">
                     <a href="pay.php" class="nav__link">Pay</a>
                  </li>
                  
                  <!-- Form logout -->
                  <form id="logout-form" method="POST" action="admincss/logout.php" style="display: none;">
                  </form>
                  <!-- Tombol logout -->
                  <li class="nav__item">
                     <a href="admincss/logout.php" class="nav__link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-logout-circle-r-line"></i>
                     </a>
                  </li>
                  <!-- Tombol login -->
                  <!-- <li class="nav__item">
                     <a href="{{ url('/login') }}" class="nav__link">
                        <i class="ri-login-circle-line"></i>
                     </a>
                  </li> -->

               </ul>

               <!-- Close button -->
                <div class="nav__close" id="nav-close">
                  <i class="ri-close-line"></i>
                </div>
            </div>

            <!-- Toggle button -->
            <div class="nav__toggle" id="nav-toggle">
               <i class="ri-menu-line"></i>
            </div>
        </nav>
     </header>

     <main class="main">
        <!--==================== HOME ====================-->
        <section class="home section" id="home">
           <img src="assets/img/logistic.jpg" alt="home image" class="home__bg1">
           <div class="home__shadow"></div>
        
           <div class="home__container container grid">
              <div class="home__data">
                 <h1 class="home__subtitle">
                    Pilih Layanan
                 </h1>

                 <div class="services__container grid">
                        <!-- Card for Checkout -->
                        <div class="services__card">
                            <div class="services__img">
                                <i class="ri-shopping-cart-2-line"></i>
                            </div>
                            <h3 class="services__title">Cek Nomor Resi</h3>
                            <p class="services__description">Proses mendapatkan no resi untuk proses pengiriman barang</p>
                            <a href="getResi2.php" class="services__button">Lanjutkan</a>
                        </div>
                        <!-- Card for Cek Pengiriman -->
                        <div class="services__card">
                            <div class="services__img">
                            <i class="ri-shield-check-line"></i>
                            </div>
                            <h3 class="services__title">Cek Pengiriman</h3>
                            <p class="services__description">Lacak status pengiriman produk yang sudah dibeli.</p>
                            <a href="getTracking.php" class="services__button">Lanjutkan</a>
                        </div>
                    </div>

              </div>

              
           </div>
        </section>
     </main>

     <!--==================== FOOTER ====================-->
     <footer class="footer">
      <div class="footer__container container grid">
         <div class="footer__content grid">
            <div>
               <a href="#" class="footer__logo">E-Commerce</a>

               <p class="footer__description">
                  Buy in our platform. <br>
                  Its feels special
               </p>
            </div>

            <div class="footer__data grid">
               <div>
                  <h3 class="footer__title">About</h3>
               
                  <ul class="footer__links">
                     <li>
                        <a href="#" class="footer__link">About Us</a>
                     </li>
                     
                     <li>
                        <a href="#" class="footer__link">Features</a>
                     </li>
                     
                     <li>
                        <a href="#" class="footer__link">News & Blog</a>
                     </li>
                  </ul>
               </div>

               <div>
                  <h3 class="footer__title">Company</h3>
               
                  <ul class="footer__links">
                     <li>
                        <a href="#" class="footer__link">FAQs</a>
                     </li>
                     
                     <li>
                        <a href="#" class="footer__link">History</a>
                     </li>
                     
                     <li>
                        <a href="#" class="footer__link">Testimonials</a>
                     </li>
                  </ul>
               </div>
               
               <div>
                  <h3 class="footer__title">Contact</h3>
               
                  <ul class="footer__links">
                     <li>
                        <a href="#" class="footer__link">Call Center</a>
                     </li>
                     
                     <li>
                        <a href="#" class="footer__link">Support Center</a>
                     </li>
                     
                     <li>
                        <a href="#" class="footer__link">Contact Us</a>
                     </li>
                  </ul>
               </div>
               
               <div>
                  <h3 class="footer__title">Support</h3>
               
                  <ul class="footer__links">
                     <li>
                        <a href="#" class="footer__link">Privacy Policy</a>
                     </li>
                     
                     <li>
                        <a href="#" class="footer__link">Terms & Services</a>
                     </li>
                     
                     <li>
                        <a href="#" class="footer__link">Payments</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>

         <div class="footer__group">
            <div class="footer__social">
               <a href="https://www.facebook.com/" target="_blank" class="footer__social-link">
                  <i class="ri-facebook-line"></i>
               </a>
               
               <a href="https://www.instagram.com/" target="_blank" class="footer__social-link">
                  <i class="ri-instagram-line"></i>
               </a>
               
               <a href="https://twitter.com/" target="_blank" class="footer__social-link">
                  <i class="ri-twitter-x-line"></i>
               </a>
               
               <a href="https://www.youtube.com/" target="_blank" class="footer__social-link">
                  <i class="ri-youtube-line"></i>
               </a>
            </div>

            <span class="footer__copy">
               &#169; Copyright Ranggays. All rights reserved
            </span>
         </div>
      </div>
   </footer>

   <!--========== SCROLL UP ==========-->
   <a href="#" class="scrollup" id="scroll-up">
      <i class="ri-arrow-up-line"></i>
   </a>

   <!--=============== SCROLLREVEAL ===============-->
   <script src=""></script>

   <!--=============== MAIN JS ===============-->
   <script src="assets/js/main.js"></script>
</body>
</html>