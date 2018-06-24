<!DOCTYPE html>
<html>

<head>
	
	<meta charset="utf-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Admin Control Panel	</title>

	<link href="../assets/css2/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css2/style.css" rel="stylesheet">



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
	
$setmode4 = shell_exec("gpio -g mode 4 out");
$setmode3 = shell_exec("gpio -g mode 3 out");
$setmode2 = shell_exec("gpio -g mode 2 out");
if(isset($_GET["r_tamuON"])){
$gpio_on = shell_exec("gpio -g write 4 1");
		}
else if(isset($_GET["r_tamuOFF"])){
$gpio_off = shell_exec("gpio -g write 4 0");
		}
else if(isset($_GET["r_makanON"])){
$gpio_off = shell_exec("gpio -g write 3 1");
		}
else if(isset($_GET["r_makanOFF"])){
$gpio_off = shell_exec("gpio -g write 3 0");
		}
else if(isset($_GET["r_kerjaON"])){
$gpio_off = shell_exec("gpio -g write 2 1");
		}
else if(isset($_GET["r_kerjaOFF"])){
$gpio_off = shell_exec("gpio -g write 2 0");
		}		
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


</body>
</html>
