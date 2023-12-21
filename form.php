<?php
require_once 'dbkoneksi.php';
require_once 'class_produk.php';

// Fungsi untuk menambahkan produk
function tambahProduk($data) {
  global $dbh;

  $nama = $data["nama"];
  $qty = $data["qty"];
  $harga = $data["harga"];
  $idjenis = $data["idjenis"];

  try {

      $kode = bin2hex(random_bytes(8));
      

      $query = "INSERT INTO produk (kode, nama, stok, harga, idjenis) VALUES ('$kode', '$nama', '$qty', '$harga', '$idjenis')";
      $stmt = $dbh->prepare($query);
      $stmt->execute();

      return $stmt->rowCount();  
  } catch (PDOException $e) {

      echo "Error: " . $e->getMessage();
      return 0; 
  }
}


$objproduk = new Produk($dbh);


$formSubmitted = false;
$result = 0;

if (isset($_POST['submit'])) {
    $result = tambahProduk($_POST);
    $formSubmitted = true; 
}

$rsproduk = $objproduk->getAllProduk();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Form Produk</title>
</head>
<body>

<div class="container mt-4">
    <h3>Form Produk</h3>

    <form method="post" action="form.php">
        <div class="form-group row">
            <label for="nama" class="col-4 col-form-label">Nama Produk</label> 
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-at"></i>
                        </div>
                    </div> 
                    <input id="nama" name="nama" type="text" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="Qty" class="col-4 col-form-label">Qty</label> 
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-apple"></i>
                        </div>
                    </div> 
                    <input id="Qty" name="qty" type="text" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="Harga" class="col-4 col-form-label">Harga</label> 
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-anchor"></i>
                        </div>
                    </div> 
                    <input id="Harga" name="harga" type="text" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="idjenis" class="col-4 col-form-label">Jenis Produk</label> 
            <div class="col-8">
                <select id="idjenis" name="idjenis" class="custom-select" required>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Barang">Barang</option>
                </select>
            </div>
        </div> 
        <div class="form-group row">
            <div class="offset-4 col-8">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>


    <?php if ($formSubmitted): ?>
        <h3 class="mt-4">Daftar Produk</h3>
        <table class="table">
            <thead>
            <tr><th>No</th><th>Nama Produk</th><th>Qty</th>
                <th>Harga</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php
            $nomor = 1;
            foreach ($rsproduk as $row) {
                echo '<tr>
                            <td>' . $nomor . '</td>
                            <td>' . $row->nama . '</td>
                            <td>' . $row->stok . '</td>
                            <td>' . $row->harga . '</td>
                            <td align="center">
                                <a href="edit.php?id=' . $row->id . '">Edit</a> |
                                <a href="delete.php?id=' . $row->id . '">Del</a>
                            </td>
                        </tr>';
                $nomor++;
            }
            ?>
            </tbody>
        </table>


        <?php
        if ($result > 0) {
            echo '<p class="text-success">Produk berhasil ditambahkan!</p>';
        } else {
            echo '<p class="text-danger">Gagal menambahkan produk.</p>';
        }
        ?>
    <?php endif; ?>
</div>

</body>
</html>
