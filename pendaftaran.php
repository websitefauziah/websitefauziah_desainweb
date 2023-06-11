<?php include("inc_header.php")?>
<?php
if(isset($_SESSION['members_email']) != ''){
    header("location:index.php");
    exit();
}
?>
<style>
    table {
        width: 600px;
    }

    @media screen and (max-width: 700px){
        table {
            width: 90%;
        }
    }
    table td{
        padding: 5px;
    }
    td.label {width: 40%;}
    .input{
        border: 1px solid #cccccc;
        background-color: #dfdfdf;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }
    input.tbl-biru {
        border: none;
        background-color: #3f72af;
        border-radius: 20px;
        margin-top: 20px;
        padding: 15px 20px 15px 20px;
        color: #ffffff;
        cursor: pointer;
        font-weight: bold;
    }
    input.tbl-biru:hover {
        background-color: #fc5185; 
        text-decoration: none;
    }
    .error {
        padding: 20px;
        background-color: #f44336;
        color: #ffffff;
        margin-bottom: 15px;
    }
    .sukses {
        padding: 20px;
        background-color: #2196F3;
        color: #ffffff;
        margin-bottom: 15px;
    }

    .error ul {margin-left: 10px;}
</style>
<h3>Pendaftaran</h3>
<?php
$email          = "";
$nama_lengkap   = "";
$err            = "";
$sukses         = "";

if(isset($_POST['simpan'])){
    $email                    = $_POST['email'];
    $nama_lengkap             = $_POST['nama_lengkap'];
    $password                 = $_POST['password'];
    $konfirmasi_password      = $_POST['konfirmasi_password'];

    if($email == '' or $nama_lengkap == '' or $password == '' or $konfirmasi_password == ''){
        $err .= "<li>Silahkan masukan semua isian.</li>";
    }

    if ($email != '') {
        $sql1   = "select email from membersi where email = '$email'";
        $q1     = mysqli_query($koneksi,$sql1);
        $n1     = mysqli_num_rows($q1);
        if($n1 > 0){
            $err.= "<li>Email yang kamu masukan sudah terdaftar.</li>";
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $err.= "<li>Email yang kamu masukan tidak valid.</li>";
        }
    }
    
    if($password != $konfirmasi_password){
        $err.= "<li>Password dan Konfirmasi Password tidak sesuai.</li>";
    }
    if(strlen($password) < 6){
        $err .= "<li>Panjang karaketr yang diizinkan untuk password tidak lebih dari 6 karakter. </li>";
    }

    if(empty($err)){
        $status             = md5(rand(0,1000));
        $judul_email        = "Halaman Konfirmasi Pendaftaran";
        $isi_email          = "Akun yang kamu miliki dengan email <b>$email</b> telah siap digunakan.<br/>";
        $isi_email         .= "Sebelumnya silahkan melakukan aktifasi email di link di bawah ini:<br/>";
        $isi_email        .= url_dasar()."/verifikasi.php?email=$email&kode=$status";
        
        kirim_email($email,$nama_lengkap,$judul_email,$isi_email);

        $sql1       = "insert into membersi(email,nama_lengkap,password,status) values ('$email','$nama_lengkap',md5($password),'$status')";
        $q1         = mysqli_query($koneksi,$sql1);
        if($q1){
            $sukses = "Proses Berhasil.Silahkan cek email kamu untuk verifikasi.";
        }
    }

}
?>
<?php if($err){echo "<div class='error'><ul>$err</ul></div>";}?>
<?php if($sukses){echo "<div class='sukses'>$sukses</div>";}?>
<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td >
                <input type="text" name="email" class="input" value="<?php echo $email?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td >
                <input type="text" name="nama_lengkap" class="input" value="<?php echo $nama_lengkap?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Password</td>
            <td >
                <input type="password" name="password" class="input"/>
            </td>
        </tr>
        <tr>
            <td class="label">Konfirmasi Password</td>
            <td >
                <input type="password" name="konfirmasi_password" class="input"/>
                <br/>
                Sudah punya akun? Silahkan <a href='<?php echo url_dasar()?>/login.php'>login</a>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="simpan" value="simpan" class="tbl-biru"/>
            </td>
        </tr>
    </table>
</form>
<?php include("inc_footer.php")?>