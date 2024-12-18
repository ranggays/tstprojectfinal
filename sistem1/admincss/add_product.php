<?php

include '../db_connection.php';

// Ambil data kategori dari tabel categories
$categories = [];
$result = $conn->query("SELECT category_name FROM categories");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category_name'];
    }
}

// Proses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    
    // Upload file gambar
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    $upload_dir = "../assets/products/";
    $image_path = $upload_dir . basename($image);

    if (move_uploaded_file($image_tmp, $image_path)) {
        // Simpan data produk ke database
        $stmt = $conn->prepare("INSERT INTO products (title, description, image, price, category, quantity) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdsd", $title, $description, $image_path, $price, $category, $quantity);
        $stmt->execute();
        $stmt->close();

        echo "Product added successfully!";
    } else {
        echo "Failed to upload image.";
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <?php
      include('admin.css.php')
    ?>
    
    <style type="text/css">

        .div_deg
        {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 60px;
        }

        h1
        {
            color: white;
        }

        label
        {
            display: inline-block;
            width: 250px;
            font-size: 18px;
            color: white!important;
        }

        input[tuye='text']
        {
            width: 350px;
            height: 50px;
        }

        textarea
        {
            width: 450px;
            height: 80px;
        }

        .input_deg
        {
            padding: 15px;
        }

    </style>
  </head>
  <body>
      <?php
        include('admin.header.php')
      ?>

      <?php
        include('admin.sidebar.php')
      ?>
    
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h1>Add Product</h1>

                <div class="div_deg">
                <form action="add_product.php" method="post" enctype="multipart/form-data">
                    <div class="input_deg">
                        <label>Product Title</label>
                        <input type="text" name="title" required>
                    </div>

                    <div class="input_deg">
                        <label>Description</label>
                        <textarea name="description" required></textarea>
                    </div>

                    <div class="input_deg">
                        <label>Price</label>
                        <input type="text" name="price" required>
                    </div>

                    <div class="input_deg">
                        <label>Product Category</label>
                        <select name="category" required>
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input_deg">
                        <label>Quantity</label>
                        <input type="text" name="quantity" required>
                    </div>

                    <div class="input_deg">
                        <label>Product Image</label>
                        <input type="file" name="image" required>
                    </div>

                    <div class="input_deg">
                        <input class="btn btn-success" type="submit" value="Add Product">
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/charts-home.js"></script>
    <script src="js/front.js"></script>
  </body>
</html>
