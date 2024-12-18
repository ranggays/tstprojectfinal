<?php
 include '../db_connection.php';

 $id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid ID");
}

// Ambil data kategori
$stmt = $conn->prepare("SELECT category_name FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

// Update kategori jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
    $category = $_POST['category'];
    $stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE id = ?");
    $stmt->bind_param("si", $category, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: category.php"); // Kembali ke halaman kategori
    exit();
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
            margin: 60px;
        }

        input[type='text']
        {
            width: 400px;
            height: 50px;
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
            <h1 style="color: white;">Update Category</h1>
                <div class="div_deg">
                    <form method="post" action="">
                        <input type="text" name="category" value="<?php echo htmlspecialchars($data['category_name']); ?>" required>
                        <input class="btn btn-secondary" type="submit" name="update_category" value="Update Category">
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
