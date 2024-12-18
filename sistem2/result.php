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
    <link rel="stylesheet" href="assets/css/style2.css">

    <title>Hasil Tracking</title>
</head>
<body>
    <header class="header" id="header">
        <nav class="nav container">
           <a href="#" class="nav__logo">E-Commerce</a>
           <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li class="nav__item"><a href="dashboard.php" class="nav__link">Home</a></li>
                  <li class="nav__item"><a href="product.php" class="nav__link">Product</a></li>
                  <li class="nav__item"><a href="pay.php" class="nav__link">Pay</a></li>
               </ul>
            </div>
        </nav>
    </header>

    <main class="main">
        <section class="home section" id="home">
           <img src="assets/img/logistic.jpg" alt="home image" class="home__bg1">
           <div class="home__shadow"></div>

           <div class="home__container container grid">
              <div class="home__data">
                 <h1 class="home__subtitle">Hasil Tracking</h1>
                 <div class="services__container grid">
                    <div class="services__card">
                        <div class="services__img">
                            <i class="ri-truck-line"></i>
                        </div>
                        <h3 class="services__title">Tracking Details</h3>
                        <div class="content">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $id = $_POST['id'] ?? null;

                                if ($id) {
                                    $url = "http://localhost/sistem2/service/api2.php/tracking/check";
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $url);
                                    curl_setopt($ch, CURLOPT_POST, true);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['id' => $id]));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $response = curl_exec($ch);
                                    curl_close($ch);

                                    $result = json_decode($response, true);
                                    
                                    
                                    if (isset($result['error'])) {
                                        echo "<p class='error'>Error: " . $result['error'] . "</p>";
                                    } else {
                                        echo "<ul class='tracking-details'>";
                                        echo "<li><strong>Order ID:</strong> " . htmlspecialchars($result['orderId']) . "</li>";
                                        echo "<li><strong>No Resi:</strong> " . htmlspecialchars($result['no_resi']) . "</li>";
                                        echo "<li><strong>Shipping Method:</strong> " . htmlspecialchars($result['shippingMethod']) . "</li>";
                                        // echo "<li><strong>Status:</strong> " . htmlspecialchars($result['status']) . "</li>";
                                        $status = $result['status'] ?? 'Belum tersedia';
                                        echo "<p><strong>Status:</strong> " . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . "</p>";

                                        echo "<li><strong>Location:</strong> " . htmlspecialchars($result['location']) . "</li>";
                                        echo "<li><strong>Estimated Delivery:</strong> " . htmlspecialchars($result['estimated_delivery']) . "</li>";
                                        echo "</ul>";
                                    }
                                } else {
                                    echo "<p class='error'>ID Checkout is required.</p>";
                                }
                            } else {
                                echo "<p class='error'>Invalid request method.</p>";
                            }
                            ?>
                        </div>
                    </div>
                 </div>
              </div>
           </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer__container container grid">
            <span class="footer__copy">
                &#169; Copyright Ranggays. All rights reserved
            </span>
        </div>
    </footer>
</body>
</html>
