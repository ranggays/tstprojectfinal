<?php
include('db_connection.php');

    $sql = "SELECT * FROM products WHERE id = 2"; // Ganti ID sesuai kebutuhan
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ambil data produk
        $product = $result->fetch_assoc();
    }
?>

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
    <link rel="stylesheet" href="assets/css/styleship.css">

    
    
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
                  
                  <li class="nav__item">
                     <a href="product.php" class="nav__link">Product</a>
                  </li>
                  
                  <li class="nav__item">
                     <a href="pay.php" class="nav__link">Pay</a>
                  </li>
                  
                  @if (Auth::check())
                  <!-- Form logout -->
                  <form id="logout-form" method="POST" action="{{ route('logout" style="display: none;">
                     @csrf
                  </form>

                  <!-- Tombol logout -->
                  <li class="nav__item">
                     <a href="#" class="nav__link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-user-line"></i>
                     </a>
                  </li>
                  @else
                  <!-- Tombol login -->
                  <li class="nav__item">
                     <a href="{{ url('/login" class="nav__link">
                        <i class="ri-user-line"></i>
                     </a>
                  </li>
                  @endif

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
           <img class="home__bg1" src="assets/img/banyuwangi-bg1.jpg" alt="as">
           <div class="home__shadow"></div>
           <div class="container_shop">
            <h1 class="shop_title" style="color: white;">Shopping Cart</h1>
            <table class="shop_table">
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <tr style="border-bottom: 1px solid white;">
                    <td class="shop_product">
                        <img class="shop_img" src="products/<?php echo $product['image']; ?>" alt="as">

                        <div class="shop_desc">
                            <p class="title_desc">
                                <?php echo $product['title']; ?>
                            </p>
                            <p class="title_description">
                                <?php echo $product['description'];?>
                            </p>
                        </div>
                    </td>
                    <td>
                        <select name="pilihan" id="pilihan">
                            <option value="">S</option>
                            <option value="">M</option>
                            <option value="">L</option>
                            <option value="">XL</option>
                        </select>
                    </td>
                    <td>
                        <div class="counter-container">
                            <button class="button2" onclick="decrement(1)">-</button>
                            <span class="number" id="count1">0</span>
                            <button onclick="increment(1)">+</button>
                        </div>
                    </td>
                    <td>
                        <span>
                            <?php echo $product['price'];?>
                        </span>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid white;">
                    <td class="shop_product">
                        <img class="shop_img" src="assets/img/shirt.jpg" alt="as">

                        <div class="shop_desc">
                            <p class="title_desc">Henley T-Shirt</p>
                            <p class="title_description">Black Top</p>
                        </div>
                    </td>
                    <td>
                        <select name="pilihan" id="pilihan">
                            <option value="">S</option>
                            <option value="">M</option>
                            <option value="">L</option>
                            <option value="">XL</option>
                        </select>
                    </td>
                    <td>
                        <div class="counter-container">
                            <button class="button2" onclick="decrement(2)">-</button>
                            <span class="number" id="count2">0</span>
                            <button onclick="increment(2)">+</button>
                        </div>
                    </td>
                    <td>
                        <span>Rp150.000</span>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid white; ">
                    <td class="shop_product">
                        <img class="shop_img" src="assets/img/shirt.jpg" alt="as">

                        <div class="shop_desc">
                            <p class="title_desc">Henley T-Shirt</p>
                            <p class="title_description">Black Top</p>
                        </div>
                    </td>
                    <td>
                        <select name="pilihan" id="pilihan">
                            <option value="">S</option>
                            <option value="">M</option>
                            <option value="">L</option>
                            <option value="">XL</option>
                        </select>
                    </td>
                    <td>
                        <div class="counter-container">
                            <button class="button2" onclick="decrement(3)">-</button>
                            <span class="number" id="count3">0</span>
                            <button onclick="increment(3)">+</button>
                        </div>
                    </td>
                    <td>
                        <span>Rp150.000</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Available Shipping Method</p>
                    </td>
                </tr>
            </table>
            <div class="ship">
                <img class="shop_img" src="assets/img/shirt.jpg" alt="as" id="imagemethod">
                <div class="ship_desc">
                    <h3 class="ship_title">Fedex Delivery</h3>
                    <p class="ship_description" id="result"></p>
                </div>
                <div class="ship_desc2">
                    <form action="">
                        <input type="checkbox" name="shippingMethod" value="Same-Day">
                        <span>Same-Day</span>
                        <input type="checkbox" name="shippingMethod" value="Express">
                        <span>Express</span>
                        <input type="checkbox" name="shippingMethod" value="Longer">
                        <span>Longer</span>
                        <button class="button_desc" type="button" onclick="setShippingMethod()">Set</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="container2">
            <table class="payment">
                <tr style="border-bottom: 1px solid white;">
                    <td>
                        <h1>Payment Info</h1>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="payment desc">
                        <p>Payment Method:</p>
                    </td>
                    <td></td>
                </tr>
                <tr class="payment" style="border-bottom: 1px solid white;">
                    <td>
                        <div class="payment">
                            <img src="/assets/img/bank-card-fill (1).png" alt="">
                            <p>Credit card</p>
                        </div>
                        <div class="payment">
                            <img src="" alt="">
                            <p>E-Wallet</p>
                        </div>
                    </td>
                </tr>
                <tr class="name" style="border-bottom: 1px solid white;">
                    <td>
                        <form action="">
                            <label for="name">Name</label>
                            <input class="name" type="text" id="nameInput" name="name">
                        </form>
                    </td>
                </tr>
                <tr class="name" style="border-bottom: 1px solid white;">
                    <td>
                        <form action="">
                            <label for="number">Number</label>
                            <input class="name" type="number" id="numberInput" name="number">
                        </form>
                    </td>
                </tr>
                <tr class="name" style="border-bottom: 1px solid white;">
                    <td>
                        <form action="">
                            <label for="Address">Address</label>
                            <input class="name" type="text" id="addressInput" name="address">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="checkout">
                            <p>Subtotal</p>
                            <span>Rp0</span>
                            <p>Fee</p>
                            <span>Rp0</span>
                            <p>Total</p>
                            <span>Rp0</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="co" id="submitCheckout">
                            Check Out
                        </button>
                    </td>
                </tr>
            </table>
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
   <script src="assets/js/ship.js"></script>
   <script src="assets/js/main.js"></script>
</body>
</html>