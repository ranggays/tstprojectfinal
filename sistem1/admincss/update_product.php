<?php

include '../db_connection.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Ambil data produk berdasarkan ID
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found!");
    }
} else {
    die("Invalid request!");
}

// Proses pembaruan data produk
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Cek apakah pengguna mengunggah gambar baru
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $target_dir = "../assets/products/";
        $target_file = $target_dir . $image;

        // Hapus gambar lama
        if (file_exists($target_dir . $product['image'])) {
            unlink($target_dir . $product['image']);
        }

        // Pindahkan gambar baru
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $image = $product['image'];
    }

    // Update data produk
    $sql_update = "UPDATE products 
                   SET title = '$title', description = '$description', price = '$price', category = '$category', image = '$image'
                   WHERE id = $product_id";
    if ($conn->query($sql_update)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='view_product.php';</script>";
    } else {
        echo "Error updating product: " . $conn->error;
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
            <h1>Update Product</h1>

                <div class="div_deg">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="input_deg">
                            <label>Product Title</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required>
                        </div>

                        <div class="input_deg">
                            <label>Description</label>
                            <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <div class="input_deg">
                            <label>Price</label>
                            <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                        </div>

                        <div class="input_deg">
                            <label>Product Category</label>
                            <select name="category" required>
                                <option value="<?php echo htmlspecialchars($product['category']); ?>" selected><?php echo htmlspecialchars($product['category']); ?></option>
                                <?php
                                // Ambil semua kategori
                                $sql_categories = "SELECT * FROM categories";
                                $categories_result = $conn->query($sql_categories);
                                while ($category_row = $categories_result->fetch_assoc()) {
                                    if ($category_row['category_name'] !== $product['category']) {
                                        echo "<option value='" . htmlspecialchars($category_row['category_name']) . "'>" . htmlspecialchars($category_row['category_name']) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input_deg">
                            <label>Product Image</label>
                            <input type="file" name="image">
                            <br>
                            <img src="../assets/products/<?php echo htmlspecialchars($product['image']); ?>" height="100" alt="Current Image">
                        </div>

                        <div class="input_deg">
                            <input class="btn" type="submit" value="Update Product">
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
