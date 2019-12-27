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
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>T͉̓̉ͦ̔e͖̹͈̻͋ͭ̋ͨa͈͗̂̊ͪ̀ͬͤm͓͚ͬͦ̂ ͉̪ͤ̊̽͋P̖̼̠̐̊ͅé̙̮̯̊ͭn͎ͥͯ̔ͬ͌c̳͚͎̋̑ḁ̖̖̫̐̆r̹̱̲͋́̄ȉ̲̊ ̰͓ͩ̑P̞͎̮̐͗͊̇̍r̲̎̋̚o͖͎̅x̭̮̖͛̊̋ͮ̀y̗̱̏ͯ̓ © 2019</title>
    <link rel="icon" href="assets/images/icon/avatar.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="assets/js/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    
</head>
<body>
<div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="post">
                    <div class="login-form-head">
                        <h4>Dor Tsel V2 Web</h4>
                        <p>T͉̓̉ͦ̔e͖̹͈̻͋ͭ̋ͨa͈͗̂̊ͪ̀ͬͤm͓͚ͬͦ̂ ͉̪ͤ̊̽͋P̖̼̠̐̊ͅé̙̮̯̊ͭn͎ͥͯ̔ͬ͌c̳͚͎̋̑ḁ̖̖̫̐̆r̹̱̲͋́̄ȉ̲̊ ̰͓ͩ̑P̞͎̮̐͗͊̇̍r̲̎̋̚o͖͎̅x̭̮̖͛̊̋ͮ̀y̗̱̏ͯ̓<p>
                        <img src="TPP.png" alt="TPP">
                        <p>key : tppselaludihati<p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="nomor">Masukan No Hp</label>
                            <input type="number" id="nomor" name="msisdn" placeholder="628xxx">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="form-gp">
                            <label for="key">Masukan Key</label>
                            <input type="text" id="key" name="key" placeholder="">
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" name="do" value="GETOTP" type="submit">SEND OTP <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Menghargai Creator dengan Donate <a href="https://wa.me/6281393706485">Whatsapp</a></p>
                        </div>
                    </div>
                     
                </form>
            </div>
        </div>
    </div>
<!-- login area end -->

<!-- jquery latest version -->
<script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
<!-- bootstrap 4 js -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.slicknav.min.js"></script>

<!-- others plugins -->
<script src="assets/js/plugins.js"></script>
<script src="assets/js/scripts.js"></script>
<script type="text/javascript">
  var uid = '42762';
  var wid = '532778';
</script>
<script type="text/javascript" src="//cdn.popcash.net/pop.js"></script>
</body>

<!-- ################################ 2 ################################ -->

<?php }else if (isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['tipe']) and !isset($_SESSION['secret_token'])){ ?>
<body>
<div class="container-contact100">
<div class="wrap-contact100">
<form class="contact100-form validate-form" method="POST">
<span class="contact100-form-title">
Tembak Telkomsel OMG ©SeptianFerry
</span>
<marquee direction="left" onmouseover="this.stop()" onmouseout="this.start()" scrollamount="5"><i class="mdi mdi-chevron-double-right"></i> 
  MASUKIN OTPNYA JANGAN KELAMAAN YA BANGSAAAT gagal mendapatkan otp ? GET OTP V.2 <a href="https://vip-reseller.co.id/telkomsel/otpv2" target="_blank">KLIK DISINI</a></marquee><br><br>
    <center>
<p> OTP akan Expired dalam : <span id="countdowntimer">50 </span> Detik</p>

<script type="text/javascript">
    var timeleft = 50;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0)
        clearInterval(downloadTimer);
    },1000);
</script>
</label>
<label class="radio-container m-r-45">VMP
<input type="radio" checked="checked" name="tipe" value="vmp.telkomsel.com">
<span class="checkmark"></span>
</label>
        </center>
<!-- <input type="radio" name="tipe" value="vmp.telkomsel.com" checked> VMP Prepod&nbsp;&nbsp;<input type="radio" name="tipe" value="vmp-preprod.telkomsel.com"> VMP<br> -->
<div class="wrap-input100 validate-input" data-validate="Please enter your phone">
<input class="input100" type="text" value="<?= $_SESSION['msisdn']; ?>" name="phone" disabled>
<span class="focus-input100"></span>
</div>
<div class="wrap-input100 validate-input" data-validate="Please enter your key">
<input class="input100" type="number" name="otp">
<span class="focus-input100"></span>
</div>
<div class="container-contact100-form-btn">
<button class="btn btn-primary" name="do" value="LOGIN" type="submit">
    <i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
Login
</span></button>&nbsp;&nbsp;
<button class="btn btn-danger" name="do" value="CHANGE" type="submit">
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
<form method="POST">
<fieldset>
Key:&nbsp;<?= $_SESSION['key']."<br>" ?>
Msisdn:&nbsp;<?= $_SESSION['msisdn']."<br>" ?>
OTP:&nbsp;<?= $_SESSION['otp']."<br>" ?>
<hr>
    <center>
            <div class="table-responsive">
            <div class="container-contact100">
            <div class="wrap-contact100">
            <span class="contact100-form-title">BELI PAKET</span>
PILIH&nbsp;PAKET:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="pkgid" onchange="if (this.value=='1'){this.form['pkgidman'].style.visibility='visible'}else {this.form['pkgidman'].style.visibility='hidden'};" style="width: 50%;">
  <option value="0">--Pilih Paket--</option>
  <option value="00016038">OMG [VIU] 5gb Harga : Rp. 10.000 / 30 Hari</option>
  <option value="00016036">OMG [KlikFilm] 5gb Harga : Rp. 10.000 / 30 Hari</option>
  <option value="00009382">OMG 1GB Harga : Rp. 10 / 2 Hari</option>
  <option value="00010654">Maxtream 1GB Harga : Rp. 10 / 2 Hari</option>
  <option value="00021308">Maxtream 1GB Harga : Rp. 10 / 30 Hari</option>
  <option value="00016090">Maxstream 5gb Harga : Rp. 10.000 / 30 Hari</option>
  <option value="00016030">Maxtream 10gb Harga : Rp.  10.000 / 30 Hari</option>
  <option value="00007333">Maxtream 30gb Harga : Rp. 30.000 / 30 Hari</option>
  <option value="00016199">AddMax 30gb Harga : Rp.  30.000 / 30 Hari</option>
  <option value="00015185">Gigamax 6gb Harga : Rp. 25.000 / 30 Hari</option>
  <option value="00020943">Flash 50GB Harga : Rp. 50.000 / 7 Hari</option>
  <option value="00015893">Flash 17GB Harga : Rp. 80.000 / 30 Hari</option>
  <option value="1">Manual ID</option>
</select><br>
PKGID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pkgidman"  style="width: 50%; visibility:hidden;"></input><br>
TRANSACTIONID:<input type="text" name="transactionid" style="width: 50%;" value="A301180826192021277131740"></input><br>
    <button class="btn btn-primary" name="do" value="BUY_PKG" type="submit">Buy</button>
    <button class="btn btn-danger" type="submit" name="do" value="LOGOUT">Logout</button>
<?php if(!empty($ress)) echo $ress ?>
</div>
                        <div class="form-footer text-center mt-5">
                        <p class="text-muted">Donate <a href="https://wa.me/6281393706485">Whatsapp</a></p>
                        </div>
                       </div>
                        <textarea style="height: 100%; width: 100%;">  </textarea>
                       <hr>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

<!-- login area end -->
    
<!-- jquery latest version -->
<script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
<!-- bootstrap 4 js -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.slicknav.min.js"></script>

<!-- others plugins -->
<script src="assets/js/plugins.js"></script>
<script src="assets/js/scripts.js"></script>
<script type="text/javascript">
  var uid = '42762';
  var wid = '532778';
</script>
<script type="text/javascript" src="//cdn.popcash.net/pop.js"></script>


</body>
<?php } ?>
