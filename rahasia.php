<?php include("inc_header.php")?>
<?php
if($_SESSION['members_email'] == ''){
    header("location:login.php");
    exit();
}
?>
<div style="border: none;background-color: #3f72af;border-radius: 20px;margin-top: 20px;padding: 15px 20px 15px 20px;color: #ffffff;cursor: pointer;font-weight: bold;">
Selamat Datang <?php echo $_SESSION['members_nama_lengkap']?> di Halaman Rahasia Hanya Admin yang Sudah Login Yang Bisa Akses Halaman Ini
</div>
<?php include ("inc_footer.php")?>