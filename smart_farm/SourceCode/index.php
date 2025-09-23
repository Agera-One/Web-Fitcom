<!-- http://localhost:81/smart_farm/index.php -->

<?php
require_once 'connection.php';
$query = "SELECT * FROM produk";
$sql = mysqli_query($connection, $query);
$nomer = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial`-scale=1.0">
  <!-- bootstrap -->
  <link href="../Assets/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../Assets/Bootstrap/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../Assets/Bootstrap/icons/bootstrap-icons.min.css">
  <title>Smart Farm</title>
</head>

<body>
  <!-- TITEL -->
  <div class="container my-5">
    <h1>Data Produk</h1>
    <figure>
      <blockquote class="blockquote">
        <p>A well-known quote, contained in a blockquote element.</p>
      </blockquote>
      <figcaption class="blockquote-footer">
        CRUD <cite title="Source Title">Create Read Update Delete</cite>
      </figcaption>
    </figure>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
      Add New Products
    </button>
    <div class="modal fade" id="addProductModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-cente=red modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-success" data-bs-theme="dark">
            <h5 class="modal-title text-white">Add New Products</h5>
            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="process.php" enctype="multipart/form-data">
            <div class="modal-body">
              <input required type="hidden" name="action" value="add">
              <div class="mb-3">
                <label for="code" class="form-label">Product code</label>
                <input required type="text" class="form-control" id="code" name="code" placeholder="Enter product code">
                <small id="warningCode" style="color: red; display: none;">⚠️ Maximum 5 characters only</small>
                <script>
                  const inputCode = document.getElementById('code');
                  const warningCode = document.getElementById('warningCode');
                  inputCode.addEventListener('input', function() {
                    if (inputCode.value.length > 5) {
                      warningCode.style.display = 'inline';
                      inputCode.value = inputCode.value.slice(0, 5);
                    } else {
                      warningCode.style.display = 'none';
                    }
                  });
                </script>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input required type="text" class="form-control" id="name" name="name" placeholder="Enter product name">
                <small id="warningName" style="color: red; display: none;">⚠️ Maximum 20 characters only</small>
                <script>
                  const inputName = document.getElementById('name');
                  const warningName = document.getElementById('warningName');
                  inputName.addEventListener('input', function() {
                    if (inputName.value.length > 20) {
                      warningName.style.display = 'inline';
                      inputName.value = inputName.value.slice(0, 20);
                    } else {
                      warningName.style.display = 'none';
                    }
                  });
                </script>
              </div>
              <div class="mb-3">
                <label for="unit" class="form-label">Unit</label>
                <select class="form-select" aria-label="Default select example" name="unit" id="unit">
                  <option value="pcs">pcs</option>
                  <option value="set">set</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input required type="number" class="form-control" id="price" name="price" placeholder="Enter product price">
                <small id="warningPrice" style="color: red; display: none;">⚠️ Maximum 12 characters only</small>
                <script>
                  const inputPrice = document.getElementById('price');
                  const warningPrice = document.getElementById('warningPrice');
                  inputPrice.addEventListener('input', function() {
                    if (inputPrice.value.length > 12) {
                      warningPrice.style.display = 'inline';
                      inputPrice.value = inputPrice.value.slice(0, 12);
                    } else {
                      warningPrice.style.display = 'none';
                    }
                  });
                </script>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input required type="file" class="form-control" id="image" name="image" accept="image/*">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success">Add</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- TABLE -->
  <div class="container p-0 pb-3 shadow rounded-4 mb-5">
    <div class="header bg-success text-white px-3 py-4 rounded-top-4">
      <h4>
        <i class="bi bi-list-check me-2"></i>
        Current Stock Products
      </h4>
    </div>
    <div class="mx-4 body mt-3">
      <table class="table table-responsive align-middle table-striped">
        <thead>
          <tr>
            <th scope="col">Action</th>
            <th scope="col">No</th>
            <th scope="col">Product Image</th>
            <th scope="col">Product Code</th>
            <th scope="col">Product Name</th>
            <th scope="col">Unit</th>
            <th scope="col">Price</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($result = mysqli_fetch_assoc($sql)) : ?>
            <tr>
              <td>
                <a href="change.php?change=<?= $result['no'] ?>" type="button" class="btn btn-success">
                  <i class="bi bi-pencil-fill"></i>
                </a>
                <a href="process.php?remove=<?= $result['no'] ?>" type="button" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this item?')">
                  <i class="bi bi-trash3-fill"></i>
                </a>
              </td>
              <td><?= ++$nomer ?>.</td>
              <td>
                <img src="../Assets/Images/<?= htmlspecialchars($result['gambar']) ?>" alt="Product Image" style="max-width:150px;">
              </td>
              <td><?= $result['kode'] ?></td>
              <td><?= $result['nama'] ?></td>
              <td><?= $result['satuan'] ?></td>
              <td><?= $result['harga'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>