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
                $tsel->login($msisdn, $otp, $tipe);
                
                
                if (strlen($login) > 0){
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
<?php
session_start();
if(isset($_SESSION["waktu_start"])){
	$lewat = time() - $_SESSION["waktu_start"];
	}else{
		$_SESSION["waktu_start"] = time();
		$lewat = 0;
	}
?>

Inwepo
Ad
Esti Pinarsih in Tutorial Pemrograman
Cara Membuat Visitor Counter Sederhana dengan PHP
HomepageTutorial Pemrograman



Salah satu widgets wajib yang biasa ditemukan pada sebuah website adalah visitor counter atau hit counter. Visitor counter atau hit counter berfungsi untuk menghitung pengunjung website. Dalam perkembangannya visitor counter atau hit counter dalam sebuah website tersedia dalam 2 jenis, yaitu visitor counter harian, dan visitor counter total. Visitor counter harian akan menghitung kunjungan perhari sedangkan visitor counter total akan menghitung keseluruhan kunjungan pada website.


Tak perlu berlama-lama lagi, langsung saja kita bahas bagaimana caranya membuat visitor counter atau hit counter sederhana.

1. Buka XAMPP Control Panel dan aktifkan Apache dan MySql.

2. Buka text editor, seperti Notepad++, atau Dreamweaver dan ketiklah script code berikut.

<html>
<head>
<title> Cara Membuat Visitor Counter Website di PHP</title>
</head>
<body>
<FONT FACE="Comic Sans MS" size='6' color='brown'>Cara Membuat Visitor Counter Website di PHP</font></br></br></br>
<?php
$filename = 'counter.txt';
 
function counter(){  
 global $filename; 
 
 if(file_exists($filename)){  
  $value = file_get_contents($filename); 
 }else{  
  $value = 0;  
 }
 
 file_put_contents($filename, ++$value);  
}
 
counter(); 
 
echo 'Total pengunjung: '.file_get_contents($filename); 
?></br></br>
<FONT FACE="Comic Sans MS" size='4' color='black'>Pengunjung Anda akan bertambah 1, ketika Anda me-refresh halaman.</font>
</body>
</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/jquery.plugin.min.js"></script>
<script src="js/jquery.countdown.js"></script>
<div id="timer_place">
	<span id="timer">00 : 00 : 00</span>
</div>
<script type="text/javascript">
	function waktuHabis(){
		alert('Waktu Anda telah habis, Terima kasih sudah berkunjung.');
		var frmSoal = document.getElementById("frmSoal"); 
		frmSoal.submit(); 
	}
	function hampirHabis(periods){
		if($.countdown.periodsToSeconds(periods) == 60){
			$(this).css({color:"red"});
		}
	}
	$(function(){
		var waktu = 180; 
		var sisa_waktu = waktu - <?php echo $lewat ?>;
		var longWayOff = sisa_waktu;
		$("#timer").countdown({
			until: longWayOff,
			compact:true,
			onExpiry:waktuHabis,
			onTick: hampirHabis
		});
	})
</script>
<style>
	#timer_place{
		margin:0 auto;
		text-align:center;
	}
	#timer{
		border-radius:7px;
		border:2px solid gray;
		padding:7px;
		font-size:2em;
		font-weight:bolder;
	}
</style>

<?php if (!isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['secret_token']) ){ ?>
<body>
</body>
<html>
<head>
<script type='text/javascript' src='http://code.jquery.com/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='detik-mundur.js'></script>
</head>
<body>
<div id='tampilkan'></div>
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
<body>
    <div id='timer'></div>
</body>
<body>
<p> The download will begin in <span id="countdowntimer">10 </span> Seconds</p>

<script type="text/javascript">
    var timeleft = 10;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0)
        clearInterval(downloadTimer);
    },1000);
</script>
</body>
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
var timeleft = 10;
var downloadTimer = setInterval(function(){
  document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
  timeleft -= 1;
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    document.getElementById("countdown").innerHTML = "Finished"
  }
}, 1000);
<div id="countdown"></div>
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
Login
</span></button>&nbsp;&nbsp;
<button class="contact100-form-btn" name="do" value="CHANGE" type="submit">
Change
</span></button>
<!-- <input type="submit" name="do" value="GETOTP"></input> -->
<?php if(!empty($err)) echo $err ?>
<!--     </pre> -->
</div>
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
