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
							
							<!-- RUANG TAMU -->
							<tr>
								<td>
								<form method="get">
								<button name="r_tamuON" value="ON" class="buttonHidup">HIDUP</button>
								<button name ="r_tamuOFF" value="OFF" class="buttonMati" onclick="document.getElementById('r_tamu').src='../assets/img/lamp_mati.png'">MATI</button>
								<img src="../assets/img/lamp_mati.png" id="r_tamu" class="img-fluid">
<?php
$setmode4 = shell_exec("gpio -g mode 4 out");
if(isset($_GET['r_tamuON'])){
$gpio_on = shell_exec("gpio -g write 4 1");
echo "<script type=\"text/javascript\">
document.getElementById('r_tamu').src='../assets/img/lamp_hidup.png';
</script>";
}
else if(isset($_GET['r_tamuOFF'])){
$gpio_off = shell_exec("gpio -g write 4 0");
}
?>
								</form>
								</td>
								
								<td class="huruf">MATI</td>
								<td class="huruf">LAMPU RUANG TAMU</td>
								</td>
							</tr>

							<!-- RUANG MAKAN -->
							<tr>
								<td>
								<form method="get">
								<button name="r_makanON" value="ON" class="buttonHidup" onclick="document.getElementById('r_makan').src='../assets/img/lamp_hidup.png'">HIDUP</button>
								<button name="r_makanOFF" value="OFF" class="buttonMati" onclick="document.getElementById('r_makan').src='../assets/img/lamp_mati.png'">MATI</button>
								<img src="../assets/img/lamp_mati.png" id="r_makan" class="img-fluid">
<?php
$setmode3 = shell_exec("gpio -g mode 3 out");
if(isset($_GET['r_makanON'])){
$gpio_on = shell_exec("gpio -g write 3 1");
echo "<script type=\"text/javascript\">
document.getElementById('r_makan').src='../assets/img/lamp_hidup.png';
</script>";
}
else if(isset($_GET['r_makanOFF'])){
$gpio_off = shell_exec("gpio -g write 3 0");
}
?>
								</form>
								</td>
								<td class="huruf">MATI</td>
								<td class="huruf">LAMPU RUANG MAKAN</td>
							</tr>

							<!-- RUANG KERJA -->
							<tr>
								<td>
								<form method="get">
								<button name="r_kerjaON" value="ON" class="buttonHidup" onclick="document.getElementById('r_kerja').src='../assets/img/lamp_hidup.png'">HIDUP</button>
								<button name="r_kerjaOFF" value="OFF" class="buttonMati" onclick="document.getElementById('r_kerja').src='../assets/img/lamp_mati.png'">MATI</button>
								<img src="../assets/img/lamp_mati.png" id="r_kerja" class="img-fluid">
<?php
$setmode2 = shell_exec("gpio -g mode 2 out");
if(isset($_GET['r_kerjaON'])){
$gpio_on = shell_exec("gpio -g write 2 1");
echo "<script type=\"text/javascript\">
document.getElementById('r_kerja').src='../assets/img/lamp_hidup.png';
</script>";
}
else if(isset($_GET['r_kerjaOFF'])){
$gpio_off = shell_exec("gpio -g write 2 0");
}
?>

								</form>
								</td>
								<td class="huruf">MATI</td>
								<td class="huruf">LAMPU RUANG KERJA</td>
							</tr>

							<!-- PINTU -->
							<tr>
								<td><img src="../assets/img/close.png" class="img-fluid"></td>
								<td class="huruf">TERTUTUP</td>
								<td class="huruf">PINTU</td>
							</tr>

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
