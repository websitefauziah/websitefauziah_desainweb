<?php include("inc_header.php")?>
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
<?php
$email      = "";
$password   = "";
$err        = "";

if(isset($_POST['login'])){
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    if($email =='' or $password == ''){
        $err .= "<li>Silakan masukan semua isian</li>";
    }else{
        $sql1   = "select * from membersi where email = '$email'";
        $q1     = mysqli_query($koneksi,$sql1);
        $r1     = mysqli_fetch_array($q1);
        $n1     = mysqli_num_rows($q1);

        if($r1['status'] != '1'&& $n1 > 0){
            $err .= "<li>Akun yang kamu miliki belum aktif</li>";
        }

        if($r1['password'] != md5($password) && $n1 >0 && $r1['status'] == '1'){
            $err .= "<li>Password tidak sesuai</li>";
        }

        if($n1 < 1){
            $err .= "<li>Akun tidak ditemukan</li>";
        }

        if(empty($err)){
            $_SESSION['members_email'] = $email;
            $_SESSION['members_nama_lengkap'] = $r1['nama_lengkap'];
            
            header("location:rahasia.php");
            exit();
        }
    }
}
?>
<?php if ($err){ echo "<div class='error><ul class='pesan'>$err</ul></div>";}?>
<h3>Login Ke Halaman Members</h3>
<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td><input type="text" name="email" class="input" value="<?php echo $email?>"/></td>
        </tr>
        <tr>
            <td class="label">Password</td>
            <td><input type="password" name="password" class="input"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="login" value="login" class="tbl-biru"/></td>
        </tr>
    </table>
</form>
<?php include("inc_footer.php")?>