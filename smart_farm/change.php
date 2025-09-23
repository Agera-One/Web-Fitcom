<?php
include 'connection.php';
if (isset($_GET['change'])) {
    $no = $_GET['change'];

    // Ambil data produk dari database berdasarkan 'no'
    $query = "SELECT * FROM produk WHERE no = '$no';";
    $sql = mysqli_query($connection, $query);
    $result = mysqli_fetch_assoc($sql);

    $code = $result['kode'];
    $name = $result['nama'];
    $unit = $result['satuan'];
    $price = $result['harga'];
    $image = $result['gambar'];

    if (!$result) {
        echo "Product not found.";
        exit;
    }
} else {
    echo "No product specified for changing.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="process.php" enctype="multipart/form-data">
        <input type="hidden" name="no" value="<?= $no; ?>">
        <input type="hidden" name="action" value="change">
        <h5 class="modal-title text-white">Change Your Product</h5>
        <div class="mb-3">
            <label for="code" class="form-label">Product code</label>
            <input type="text" class="form-control" id="code" name="code" placeholder="Enter product code : max 5 char" value="<?= $code; ?>" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name : max 225 char" value="<?= $name; ?>" required>
        </div>
        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <select class="form-select" aria-label="Default select example" name="unit" id="unit" value="<?= $unit; ?>" required>
                <option <?php if ($unit == 'pcs') {
                            echo "selected";
                        } ?> value="pcs">pcs
                </option>
                <option <?php if ($unit == 'set') {
                            echo "selected";
                        } ?> value="set">set
                </option>
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Enter product price : max 12 char" value="<?= $price; ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <!-- Untuk gambar lama -->
            <!-- <?php if ($image): ?>
                <img src="Assets/Images/<?= htmlspecialchars($image) ?>" alt="Current Image" style="max-width:100px;">
            <?php endif; ?> -->
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" onclick="window.location.href='index.php'">Cancel</button>
            <button type="submit" class="btn btn-success">Save change</button>
        </div>
    </form>
</body>

</html>