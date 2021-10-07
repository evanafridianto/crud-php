<?php
include '_loader.php';
if (isset($_GET['halaman'])) {
  $halaman = $_GET['halaman'];
} else {
  $halaman = 'mahasiswa';
}
ob_start();
$file = '_halaman/' . $halaman . '.php';
if (!file_exists($file)) {
  include '_halaman/error.php';
} else {
  include $file;
}
$content = ob_get_contents();
ob_end_clean();


?>

<!DOCTYPE html>
<html lang="en">
<?php include '_layouts/head.php' ?>


<body class="g-sidenav-show  bg-gray-100">

  <?php

  include '_layouts/sidebar.php';

  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <!-- Navbar -->


    <?php include '_layouts/header.php'; ?>
    <div class="container-fluid py-4">
      <?php
      echo $content;
      ?>
      <?php include '_layouts/footer.php'; ?>
    </div>
  </main>

  <?php include '_layouts/javascript.php' ?>
</body>

</html>