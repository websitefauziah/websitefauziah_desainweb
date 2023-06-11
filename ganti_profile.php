<?php include("inc_header.php")?>
<?php
if(isset($_SESSION['members_email']) == ''){
    header("location:login.php");
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
<h3>Ganti Profile Akun</h3>
<?php
$email          = "";
$nama_lengkap   = "";
$err            = "";
$sukses         = "";

if(isset($_POST['simpan'])){
    $nama_lengkap             = $_POST['nama_lengkap'];
    $password_lama            = $_POST['password_lama'];
    $password                 = $_POST['password'];
    $konfirmasi_password      = $_POST['konfirmasi_password'];

    if($nama_lengkap == ''){
        $err    .= "<li>Silahkan masukan nama lengkap</li>";
    }

    if($password != ''){
        $sql1       = "select * from membersi where email = '".$_SESSION['members_email']."'";
        $q1         = mysqli_query($koneksi,$sql1);
        $r1         = mysqli_fetch_array($q1);
        if(md5($password_lama) != $r1['password']){
            $err .= "<li>Password yang kamu tuliskan tidak sesuai dengan password sebelumnya</li>";
        }

        if($password_lama == '' or $konfirmasi_password == '' or $password == ''){
            $err .= "<li>Silahkan masukan password lama, password baru serta konfirmasi password</li>";
        }

        if($password != $konfirmasi_password){
            $err .= "<li>Silahkan masukan password dan konfirmasi password yang sama</li>";
        }

        if(strlen($password) < 6){
            $err .= "<li>Panjang karakter yang diizinkan untuk password adalah 6 karakter,minimal</li>";
        }
    }

    if(empty($err)){
        $sql1   = "update membersi set nama_lengkap = '" .$nama_lengkap."' where email = '" .$_SESSION['members_email']."'";
        mysqli_query($koneksi,$sql1);
        $_SESSION['members_nama_lengkap'] = $nama_lengkap;

        if($password){
            $sql2   = "update membersi set password = md5($password) where email = '" .$_SESSION['members_email']."'";
            mysqli_query($koneksi,$sql2);
        }

        $sukses = "Data berhasil dibubah";
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
                <?php echo $_SESSION['members_email']?>
            </td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td >
                <input type="text" name="nama_lengkap" class="input" value="<?php echo $_SESSION['members_nama_lengkap']?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Password Lama</td>
            <td >
                <input type="password" name="password_lama" class="input"/>
            </td>
        </tr>
        <tr>
            <td class="label">Password Baru</td>
            <td >
                <input type="password" name="password" class="input"/>
            </td>
        </tr>
        <tr>
            <td class="label">Konfirmasi Password</td>
            <td >
                <input type="password" name="konfirmasi_password" class="input"/>
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