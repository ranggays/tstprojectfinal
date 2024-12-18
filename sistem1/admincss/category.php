<?php
 include '../db_connection.php';

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category = $_POST['category'];
    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $stmt->close();
    header("Location: category.php"); // Refresh halaman
    exit();
}

// Ambil data kategori
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");

?>


<!DOCTYPE html>
<html>
  <head>
    <?php
      include('admin.css.php')
    ?>
    
    <style type="text/css">

        input[type='text']
        {
            width: 300px;
            height: 50px;
        }

        .div_deg
        {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px;
        }

        .table_deg
        {
          text-align: center;
          margin: auto;
          border: 2px solid yellowgreen;
          margin-top: 50px;
          width: 600px;
        }

        th
        {
          background-color: skyblue;
          padding: 15px;
          font-size: 20px;
          font-weight: bold;
          color: white;
        }

        td 
        {
          color: white;
          padding: 10px;
          border: 1px solid skyblue;
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
            <h1 style="color: white;">Add Category</h1>
          
            <div class="div_deg">
                <form method="post" action="">
                    <input type="text" name="category" placeholder="Enter category" required>
                    <input class="btn btn-primary" type="submit" name="add_category" value="Add Category">
                </form>
            </div>

            <table class="table_deg">
                <tr>
                    <th>Category Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><a class="btn btn-success" href="edit_category.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                    <td><a class="btn btn-danger" href="delete_category.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
                </tr>
                <?php endwhile; ?>
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
