<!DOCTYPE html>
<html>

<head>
	
	<meta charset="utf-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Admin Control Panel	</title>

	<link href="../assets/css2/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css2/style.css" rel="stylesheet">
	<script src="../assets/js/push.min.js"></script>

<h1 id="keadaan">
<?php
$keadaan = shell_exec("gpio -g read 17");
if ($keadaan == 1) {
	echo "Ada Maling";
	echo shell_exec("sudo python /var/www/html/on-admin/alarm.py 2>&1");
}
else {
	echo "Kondisi Aman";
}
?>

</h1>

<h1 id="statusPintu">
<?php
$pintu = shell_exec("gpio -g read 27");

if ($pintu == 0) {
	echo "Pintu Tertutup";
}

else {
	echo "Pintu Terbuka";
}
?>

</h1>

</head>

<body>
<div class="wrap-container">
    	<div class="container">
			
    		<nav class="navbar navbar-expand-sm navbar-light">
    			<a href="#" class="navbar-brand"><img class="logo-atas" src="../assets/img/admin.png">ADMIN</a>

    			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#menu">
    				<span class="navbar-toggler-icon"></span>	
    			</button>

    			<div class="collapse navbar-collapse" id="menu">
    				<ul class="nav navbar-nav ml-auto">
    					<li><a class="nav-link" href="#">HOME</a></li>
    					<li><a class="nav-link" href="#">LOG</a></li>
    					<li><a class="nav-link" href="#">USER</a></li>
    					<li><a class="nav-link" href="#">LOGOUT</a></li>
    					<li><a class="nav-link" href="#">TAMBAH USER</a></li>
    				</ul>
    			</div>
    		</nav>

    		<!-- START SESSION -->
<?php
session_start();
/**
* Jika Tidak login atau sudah login tapi bukan sebagai admin
* maka akan dibawa kembali ke halaman login atau menuju halaman yang seharusnya.
*/
if ( !isset($_SESSION['user_login']) || ( isset($_SESSION['user_login']) && $_SESSION['user_login'] != 'admin' ) ){

header('location:./../login.php');
exit();
}

?>

<h2>Hallo Admin <?=$_SESSION['nama'];?> Apa kabar ?</h2>
<a href="./../logout.php">Logout</a>




<div class="row">
				<div class="col-md-12">
					<table class="table table-striped" border="1">
							<thead>	
									<tr>
										<th class="huruf">Komponen</th>
										<th class="huruf">Status</th>
										<th class="huruf">Keterangan</th>
									</tr>
							</thead>

							<tbody>

							<!-- TABEL RUANGAN -->
<?php
$jumlah = array(0,0,0);
$ruangan = array("LAMPU RUANG TAMU", "LAMPU RUANG MAKAN", "LAMPU RUANG KERJA");
$ruanganON = array("r_tamuON", "r_makanON", "r_kerjaON");
$ruanganOFF = array("r_tamuOFF", "r_makanOFF", "r_kerjaOFF");
$status = array("MATI","HIDUP");
$arrlength = count($jumlah);


for($i = 0; $i < $arrlength; $i++) {
echo "<tr>
		<td>
			<form method='GET'>
			<button name= '$ruanganON[$i]' value='ON' class='buttonHidup' onclick='hidupkan (".$i.")'>HIDUP</button>
			<button name='$ruanganOFF[$i]' value='OFF' class='buttonMati' onclick='matikan (".$i.")'>MATI</button>
			<img id='lampu_".$i."' class='img-fluid' src='../assets/img/lamp_mati_".$i.".png'>
			</form>
		</td>

		<td id='status".$i."' class='huruf'>$status[0]</td><td class='huruf'>$ruangan[$i]</td>
	</tr>";

	
			//memberi nilai pada pin
}
require '../config.php';

$nama = $_SESSION['user_login'];
	
$setmode4 = shell_exec("gpio -g mode 4 out");
$setmode3 = shell_exec("gpio -g mode 3 out");
$setmode2 = shell_exec("gpio -g mode 2 out");

if(isset($_GET["r_tamuON"])){
$gpio_on = shell_exec("gpio -g write 4 1");
$sql_check = "insert into log (nama,aktifitas) values('$nama', 'Menyalakan Lampu Ruang Tamu')"; 
$check_log = $dbconnect->query($sql_check);
		}

else if(isset($_GET["r_tamuOFF"])){
$gpio_off = shell_exec("gpio -g write 4 0");
$sql_check = "insert into log (nama,aktifitas) values('$nama', 'Mematikan Lampu Ruang Tamu')"; 
$check_log = $dbconnect->query($sql_check);
		}

else if(isset($_GET["r_makanON"])){
$gpio_off = shell_exec("gpio -g write 3 1");
$sql_check = "insert into log (nama,aktifitas) values('$nama', 'Menyalakan Lampu Ruang Makan')"; 
$check_log = $dbconnect->query($sql_check);
		}

else if(isset($_GET["r_makanOFF"])){
$gpio_off = shell_exec("gpio -g write 3 0");
$sql_check = "insert into log (nama,aktifitas) values('$nama', 'Mematikan Lampu Ruang Makan')"; 
$check_log = $dbconnect->query($sql_check);
		}

else if(isset($_GET["r_kerjaON"])){
$gpio_off = shell_exec("gpio -g write 2 1");
$sql_check = "insert into log (nama,aktifitas) values('$nama', 'Menyalakan Lampu Ruang Kerja')"; 
$check_log = $dbconnect->query($sql_check);
		}

else if(isset($_GET["r_kerjaOFF"])){
$gpio_off = shell_exec("gpio -g write 2 0");
$sql_check = "insert into log (nama,aktifitas) values('$nama', 'Mematikan Lampu Ruang Kerja')"; 
$check_log = $dbconnect->query($sql_check);
		}		
	

			//memberi indikasi pada web apakah led mati atau hidup

$gpio_check4 = shell_exec("gpio -g read 4");
if($gpio_check4==1){
	echo "<script type=\"text/javascript\">
	document.getElementById('lampu_0').src='../assets/img/lamp_hidup_0.png';
	</script>";
	echo "<script type=\"text/javascript\">
	document.getElementById('status0').textContent='HIDUP';</script>";
}
else {
	echo "<script type=\"text/javascript\">
	document.getElementById('lampu_0').src='../assets/img/lamp_mati_0.png';
	</script>";
	echo "<script type=\"text/javascript\">
	document.getElementById('status0').textContent='MATI';</script>";
}

$gpio_check3 = shell_exec("gpio -g read 3");
if($gpio_check3==1){
	echo "<script type=\"text/javascript\">
	document.getElementById('lampu_1').src='../assets/img/lamp_hidup_1.png';
	</script>";
	echo "<script type=\"text/javascript\">
	document.getElementById('status1').textContent='HIDUP';</script>";
}
else {
	echo "<script type=\"text/javascript\">
	document.getElementById('lampu_1').src='../assets/img/lamp_mati_1.png';
	</script>";
	echo "<script type=\"text/javascript\">
	document.getElementById('status1').textContent='MATI';</script>";
}

$gpio_check2 = shell_exec("gpio -g read 2");
if($gpio_check2==1){
	echo "<script type=\"text/javascript\">
	document.getElementById('lampu_2').src='../assets/img/lamp_hidup_2.png';
	</script>";
	echo "<script type=\"text/javascript\">
	document.getElementById('status2').textContent='HIDUP';</script>";
}
else {
	echo "<script type=\"text/javascript\">
	document.getElementById('lampu_2').src='../assets/img/lamp_mati_2.png';
	</script>";
	echo "<script type=\"text/javascript\">
	document.getElementById('status2').textContent='MATI';</script>";
	}

$gpio_check17 = shell_exec("gpio -g read 17");
if($gpio_check17==1){
	echo "<script type=\"text/javascript\">
	Push.create('ADA MALING', {
		body: 'BURUAN KEJARRR',
		icon: '../assets/img/siangga.png',
		timeout: 10000,
		onClick: function () {
			window.focus();
				this.close();
			}
		});
		</script>";
	}
else {
echo "<script type=\"text/javascript\">

</script>";
}

?>

						</tbody>
					</table>
				</div>
			</div>
	</div>
</div>

<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/popper.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>

<script type='text/javascript'>

$( document ).ready(function() {


var myVar = setInterval(notif, 1000);

    function notif() {
    	$.get( "notifikasi.php", function( data ) {
		  $( ".result" ).html( data );
		  if(data !== '') {
		  	Push.create('Selamat datang admin !' , {
    	body: data,
    	icon: '../assets/img/welcome.png',
    	timeout: 10000,
    	onClick: function () {
       	 window.focus();
        	this.close();
        }
	});
		  }
		});
    }
});

</script>


</body>
</html>
