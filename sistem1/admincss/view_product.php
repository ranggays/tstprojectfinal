<?php
 include '../db_connection.php';

 $sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Hapus produk jika `delete_id` ada di URL
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Hapus gambar terkait
    $sql_image = "SELECT image FROM products WHERE id = $delete_id";
    $image_result = $conn->query($sql_image);
    if ($image_result && $image_row = $image_result->fetch_assoc()) {
        $image_path = "../products/" . $image_row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Hapus file gambar
        }
    }

    // Hapus data produk dari database
    $sql_delete = "DELETE FROM products WHERE id = $delete_id";
    if ($conn->query($sql_delete)) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='view_product.php';</script>";
    } else {
        echo "Error deleting product: " . $conn->error;
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

    .table_deg
    {
        border: 2px solid greenyellow;
    }

    th
    {
        background-color: skyblue;
        color: white;
        font-size: 19px;
        font-weight: bold;
        padding: 15px;
    }

    td
    {
        border: 1px solid skyblue;
        text-align: center;
        color: white;
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
            <div class="div_deg">
              <table class="table_deg">
                  <tr>
                      <th>Product Title</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Image</th>
                      <th>Edit</th>
                      <th>Delete</th>
                  </tr>
                  <?php if ($result && $result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                          <tr>
                              <td><?php echo htmlspecialchars($row['title']); ?></td>
                              <td><?php echo htmlspecialchars(substr($row['description'], 0, 50)); ?></td>
                              <td><?php echo htmlspecialchars($row['category']); ?></td>
                              <td><?php echo htmlspecialchars($row['price']); ?></td>
                              <td>
                                  <img src="../products/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image">
                              </td>
                              <td>
                                  <a class="btn btn-success" href="update_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                              </td>
                              <td>
                                  <a class="btn btn-danger" href="view_product.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                              </td>
                          </tr>
                      <?php endwhile; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="7">No products found.</td>
                      </tr>
                  <?php endif; ?>
              </table>
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
