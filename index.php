<?php
session_start(); #list: key, msisdn, otp, secret_token
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tembak Telkomsel © 2020</title>
    <link rel="shortcut icon" href="https://resources.1337route.cf/favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/css/util.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/css/main.css">
</head>
<?php
    date_default_timezone_set('Asia/Jakarta');
    
    require_once('config.php');
    require('class.php');
    
    $err    = NULL;
    $ress   = NULL;
    
    if (isset($_POST) and isset($_POST['do'])){
        
        switch($_POST['do']){
            
            default: die(); exit(); break;

            case "CHANGE":{
                $msisdn = $_SESSION['msisdn'];
                $tipe   = $_SESSION['tipe'];
                
                unset($_SESSION['tipe']);
                unset($_SESSION['msisdn']);
                unset($_SESSION['otp']);
                unset($_SESSION['secret_token']);
                session_destroy();
            }
            break;
            
            case "LOGOUT":{
                
                $msisdn         = $_SESSION['msisdn'];
                $tipe           = $_SESSION['tipe'];
                $otp            = $_SESSION['otp'];
                $secret_token   = $_SESSION['secret_token'];
                
                
                $tsel = new MyTsel();
                $tsel->logout($secret_token, $tipe);
                
                unset($_SESSION['tipe']);
                unset($_SESSION['msisdn']);
                unset($_SESSION['otp']);
                unset($_SESSION['secret_token']);
                session_destroy();
            }
            break;
            
            
            case "GETOTP":{
                $msisdn = $_POST['msisdn'];
                
                

                $tsel = new MyTsel();
                if ($tsel->get_otp($msisdn) == "SUKSES"){
                    
                    session_regenerate_id();
                    $_SESSION['msisdn'] = $msisdn;                    
                    session_write_close();

                }
                else
                {
                    $err = "Error: msisdn salah";
                }
            }
            break;
            
            case "LOGIN":{
                $msisdn = $_SESSION['msisdn'];
                $tipe   = $_POST['tipe'];
                $otp    = $_POST['otp'];
                
                //if ($key != privatekey){die("Error: wrong key");}
                $tsel = new MyTsel();
                $login = $tsel->login($msisdn, $otp, $tipe);
                
                
                if (strlen($login) > 0){

                    $secret_token               = trim(preg_replace('/\s+/', ' ', $login));
                    $_SESSION['otp']            = $otp;
                    $_SESSION['secret_token']   = $secret_token;
                    $_SESSION['tipe']           = $tipe;
                    
                    
                } else {
                    //echo $login;
                    $err = $login;
                }

                
            }
            break;
            
            case "BUY_PKG":{
                $msisdn         = $_SESSION['msisdn'];
                $tipe           = $_SESSION['tipe'];
                $secret_token   = $_SESSION['secret_token'];
                $pkgid          = $_POST['pkgid'];
                $transactionid  = $_POST['transactionid'];
                
                switch($_POST['pkgid']){
                case '1':
                    $pkgidman = $_POST['pkgidman'];
                    $tsel = new MyTsel();
                    $ress = "PKGID: <b>".$pkgidman."</b><br>Result: ".$tsel->buy_pkg($secret_token, $pkgidman, $transactionid, $tipe);
                break;
                default:
                    $tsel = new MyTsel();
                    $ress = "PKGID: <b>".$pkgid."</b><br>Result: ".$tsel->buy_pkg($secret_token, $pkgid, $transactionid, $tipe);
                }
                
            }
            break;
            
        }
        
    }
?>

<!-- ################################ 1 ################################ -->
<?php if (!isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['secret_token']) ){ ?>
<html>
<head>
  <!-- Kita membutuhkan jquery, disini saya menggunakan langsung dari jquery.com, jquery ini bisa didownload dan ditaruh dilocal -->
  <script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
 
  <!-- Script Timer -->
     <script type="text/javascript">
        $(document).ready(function() {
              /** Membuat Waktu Mulai Hitung Mundur Dengan 
                * var detik = 0,
                * var menit = 1,
                * var jam = 1
              */
              var detik = 30;
              var menit = 10;
              var jam   = 0;
              
             /**
               * Membuat function hitung() sebagai Penghitungan Waktu
             */
            function hitung() {
                /** setTimout(hitung, 1000) digunakan untuk 
                    * mengulang atau merefresh halaman selama 1000 (1 detik) 
                */
                setTimeout(hitung,1000);
  
               /** Jika waktu kurang dari 10 menit maka Timer akan berubah menjadi warna merah */
               if(menit < 10 && jam == 0){
                     var peringatan = 'style="color:red"';
               };
 
               /** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */
               $('#timer').html(
                      '<h1 align="center"'+peringatan+'>Sisa waktu anda <br />' + jam + ' jam : ' + menit + ' menit : ' + detik + ' detik</h1><hr>'
                );
  
                /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
                detik --;
 
                /** Jika var detik < 0
                    * var detik akan dikembalikan ke 59
                    * Menit akan Berkurang 1
                */
                if(detik < 0) {
                    detik = 59;
                    menit --;
 
                    /** Jika menit < 0
                        * Maka menit akan dikembali ke 59
                        * Jam akan Berkurang 1
                    */
                    if(menit < 0) {
                        menit = 59;
                        jam --;
 
                        /** Jika var jam < 0
                            * clearInterval() Memberhentikan Interval dan submit secara otomatis
                        */
                        if(jam < 0) {                                                                 
                            clearInterval();  
                        } 
                    } 
                } 
            }           
            /** Menjalankan Function Hitung Waktu Mundur */
            hitung();
      }); 
      // ]]>
    </script>
</head>
</body>

</html>
<style>
			body{
				background-color:rgb(81, 11, 245);
			}
		</style>
<div class="container-contact100">
<div class="wrap-contact100">
<form class="contact100-form validate-form" method="POST">
<span class="contact100-form-title">
Tembak Telkomsel OMG VMP Prepod Methode
</span>
<!--     <form method="POST">
    <pre> -->
<div class="wrap-input100 validate-input" data-validate="Please enter your msisdn">
<input class="input100" type="text" name="msisdn" placeholder="Nomer Hp 628x">
<span class="focus-input100"></span>
</div>
<button class="contact100-form-btn" name="do" value="GETOTP" type="submit">
    <span>
<i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
GET OTP
</span></button>
<!-- <input type="submit" name="do" value="GETOTP"></input> -->
<?php if(!empty($err)) echo $err ?> 
<!--     </pre> -->
<br>
<br>
<br>
   <center>
    <div class="container">
            Jumlah pengguna hari ini
            <?php 
            include ("counter.php");
            echo "<p style='color:red; font-weight: bold;'> $kunjungan[0] </p>";
            ?>
            USER
</form>
</div>
</div>
</body>

<!-- ################################ 2 ################################ -->
<?php }else if (isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['tipe']) and !isset($_SESSION['secret_token'])){ ?>
<body>
<div class="container-contact100">
<div class="wrap-contact100">
<form class="contact100-form validate-form" method="POST">
<span class="contact100-form-title">
Tembak Telkomsel OMG VMP Methode
</span>
    <center>
</label>
<label class="radio-container m-r-45">VMP Prepod
<input type="radio" checked="checked" name="tipe" value="vmp-preprod-cms.telkomsel.com">
<span class="checkmark"></span>
</label>
        </center>
<!-- <input type="radio" name="tipe" value="vmp-preprod-cms.telkomsel.com" checked> VMP Prepod&nbsp;&nbsp;<input type="radio" name="tipe" value="vmp.telkomsel.com"> VMP<br> -->
<div class="wrap-input100 validate-input" data-validate="Please enter your phone">
<input class="input100" type="text" value="<?= $_SESSION['msisdn']; ?>" name="phone" disabled>
<span class="focus-input100"></span>
</div>
<div class="wrap-input100 validate-input" data-validate="Please enter your key">
<input class="input100" type="number" name="otp">
<span class="focus-input100"></span>
</div>
<div class="container-contact100-form-btn">
<button class="contact100-form-btn" name="do" value="LOGIN" type="submit">
    <i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
Login
</span></button>&nbsp;&nbsp;
<button class="contact100-form-btn" name="do" value="CHANGE" type="submit">
    <i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
Change
</span></button>
</div>
<!-- <input type="submit" name="do" value="LOGIN"></input> -->
<?php if(!empty($err)) echo $err ?>
<!--     </pre> -->
    </form>
</div>
</div>
</body>


<!-- ################################ 3 ################################ -->
<?php }else if (isset($_SESSION['msisdn']) and isset($_SESSION['otp']) and isset($_SESSION['tipe']) and isset($_SESSION['secret_token'])){ ?>
<body>
<style>
			body{
				background-color:rgb(81, 11, 245);
			}
		</style>
<form method="POST">
<fieldset>
Key:&nbsp;<?= $_SESSION['key']."<br>" ?>
Msisdn:&nbsp;<?= $_SESSION['msisdn']."<br>" ?>
OTP:&nbsp;<?= $_SESSION['otp']."<br>" ?>
<hr>
<h3><u>Buy Package</u></h3>
PILIH&nbsp;PAKET:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="pkgid" onchange="if (this.value=='1'){this.form['pkgidman'].style.visibility='visible'}else {this.form['pkgidman'].style.visibility='hidden'};" style="width: 50%;">
  <option value="00016030">Maxtream 10gb 10k</option>
  <option value="00009382">OMG! 1GB 2hari Rp 10</option>
  <option value="00010654">Maxtream 1GB - Rp10 2hr</option>
  <option value="00007333">OMG! 30gb 30k</option>
  <option value="00016038">OMG! 5gb 10k</option>
  <option value="00016199">AddMax 30gb 30k 30hr</option>
  <option value="00015185">Gigamax 6gb 25k 30hr</option>
  <option value="00016030">Maxtream 10gb 10k</option>
  <option value="00016036">MaxKlik Film 5gb 10k</option>
  <option value="00020943">Flash 4G 50GB - Rp50k 7hr</option>
  <option value="00015893">Flash 17GB - Rp80K</option>
  <option value="1">Manual ID</option>
</select><br>
PKGID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pkgidman"  style="width: 50%; visibility:hidden;"></input><br>
TRANSACTIONID:<input type="text" name="transactionid" style="width: 50%;" value="A301180826192021277131740"></input><br>
    <button class="btn btn-primary" name="do" value="BUY_PKG" type="submit">Buy</button>
    <button class="btn btn-danger" type="submit" name="do" value="LOGOUT">Logout</button>
<?php if(!empty($ress)) echo $ress ?>
<hr>
</fieldset>
</form>
</body>
<?php } ?>
