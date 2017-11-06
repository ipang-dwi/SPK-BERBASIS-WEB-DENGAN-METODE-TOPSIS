<?php
	session_start();
	include('configdb.php');
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title><?php echo $_SESSION['judul']." - ".$_SESSION['by'];?></title>
	
    <!-- Bootstrap core CSS -->
    <link href="ui/css/bootstrap.css" rel="stylesheet">
	<link href="ui/css/united.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="ui/css/jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--script src="./index_files/ie-emulation-modes-warning.js"></script-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style>
	body {
	padding-top: 10px; /* 10px to make the container go all the way to the bottom of the topbar */
	background-image:url(img/bg_dotted.png);
  </style>
  
  <body>
	<div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo $_SESSION['judul'];?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="kriteria.php">Data Kriteria</a></li>
              <li><a href="alternatif.php">Data Alternatif</a></li>
			  <li class="active"><a href="#">Analisa</a></li>
              <li><a href="perhitungan.php">Perhitungan</a></li>
			</ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
		<ol class="breadcrumb">
		  <li><a href="index.php">Home</a></li>
		  <li class="active">Analisa</li>
		</ol>
      <!-- Main component for a primary marketing message or call to action -->
      <div class="panel panel-primary">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Analisa</div>
		  <div class="panel-body">
			<div>
				<canvas id="canvas"></canvas>
			</div>
			<br />
			<center>
				<?php
					//echo "<b>Matrix Alternatif - Kriteria</b></br>";
					
					$alt = get_alternatif();
					$alt_name = get_alt_name();
					$kep = get_kepentingan();
					$cb = get_costbenefit();
					$k = jml_kriteria();
					$a = jml_alternatif();
					
					//echo "<table class='table table-striped table-bordered table-hover'>";
					//echo "<thead><tr><th>Alternatif / Kriteria</th><th>K1</th><th>K2</th><th>K3</th><th>K4</th><th>K5</th><th>K6</th></tr></thead>";
					for($i=0;$i<$a;$i++){
						//echo "<tr><td><b>A".($i+1)."</b></td>";
						for($j=0;$j<$k;$j++){
							//echo "<td>".$alt[$i][$j]."</td>";
						}
						//echo "</tr>";
					}
					//echo "</table><hr>";
					// ======================================================================== //
					//echo "<b>Matrix Pembagi</b></br>";
					//echo "<table class='table table-striped table-bordered table-hover'>";
					//echo "<thead><tr><th></th><th>K1</th><th>K2</th><th>K3</th><th>K4</th><th>K5</th><th>K6</th></tr></thead>";
					//echo "<tr><td><b>Pembagi</b></td>";
						for($i=0;$i<$k;$i++){
							$pembagi[$i] = 0;
							for($j=0;$j<$a;$j++){
								$pembagi[$i] = $pembagi[$i] + pow($alt[$j][$i],2);
							}
							$pembagi[$i] = round(sqrt($pembagi[$i]),4);
							//echo "<td>".$pembagi[$i]."</td>";
						}
					//echo "</tr>";
					//echo "</table><hr>";
					// ======================================================================== //
					//echo "<b>Matrix Ternormalisasi</b></br>";
					//echo "<table class='table table-striped table-bordered table-hover'>";
					//echo "<thead><tr><th>Alternatif / Kriteria</th><th>K1</th><th>K2</th><th>K3</th><th>K4</th><th>K5</th><th>K6</th></tr></thead>";
					for($i=0;$i<$a;$i++){
						//echo "<tr><td><b>A".($i+1)."</b></td>";
						for($j=0;$j<$k;$j++){
							$nor[$i][$j] = round(($alt[$i][$j] / $pembagi[$j]),4);
							//echo "<td>".$nor[$i][$j]."</td>";
						}
						//echo "</tr>";
					}
					//echo "</table><hr>";
					// ======================================================================== //
					//echo "<b>Matrix Terbobot</b></br>";
					//echo "<table class='table table-striped table-bordered table-hover'>";
					//echo "<thead><tr><th>Alternatif / Kriteria</th><th>K1</th><th>K2</th><th>K3</th><th>K4</th><th>K5</th><th>K6</th></tr></thead>";
					for($i=0;$i<$a;$i++){
						//echo "<tr><td><b>A".($i+1)."</b></td>";
						for($j=0;$j<$k;$j++){
							$bob[$i][$j] = round(($nor[$i][$j] * $kep[$j]),4);
							//echo "<td>".$bob[$i][$j]."</td>";
						}
						//echo "</tr>";
					}
					//echo "</table><hr>";
					// ======================================================================== //
					//echo "<b>Min Max Berdasarkan Cost Benefit Kriteria</b></br>";
					//echo "<table class='table table-striped table-bordered table-hover'>";
					//echo "<thead><tr><th></th><th>K1</th><th>K2</th><th>K3</th><th>K4</th><th>K5</th><th>K6</th></tr></thead>";
					//echo "<tr><td><b>A+</b></td>";
						for($i=0;$i<$k;$i++){
							for($j=0;$j<$a;$j++){
								$temp[$j] = $bob[$j][$i];
							}
							if($cb[$i]=='benefit')
								$aplus[$i] = max($temp);
							if($cb[$i]=='cost')
								$aplus[$i] = min($temp);
							//echo "<td>".$aplus[$i]."</td>";
						}
					//echo "</tr>";
					//echo "<tr><td><b>A+</b></td>";
						for($i=0;$i<$k;$i++){
							for($j=0;$j<$a;$j++){
								$temp[$j] = $bob[$j][$i];
							}
							if($cb[$i]=='benefit')
								$amin[$i] = min($temp);
							if($cb[$i]=='cost')
								$amin[$i] = max($temp);
							//echo "<td>".$amin[$i]."</td>";
						}
					//echo "</tr>";
					//echo "</table><hr>";
					// ======================================================================== //
					//echo "<b>Nilai D+ dan D-</b></br>";
					//echo "<table class='table table-striped table-bordered table-hover'>";
					//echo "<thead><tr><th></th><th>D+</th><th>D-</th></tr></thead>";
					for($i=0;$i<$a;$i++){
						//echo "<tr><td><b>A".($i+1)."</b></td>";
						$dplus[$i] = 0;
						for($j=0;$j<$k;$j++){
							$dplus[$i] = $dplus[$i] + pow(($aplus[$j] - $bob[$i][$j]),2);
						}
						$dplus[$i] = round(sqrt($dplus[$i]),4);
						//echo "<td>".$dplus[$i]."</td>";
						$dmin[$i] = 0;
						for($j=0;$j<$k;$j++){
							$dmin[$i] = $dmin[$i] + pow(($amin[$j] - $bob[$i][$j]),2);
						}
						$dmin[$i] = round(sqrt($dmin[$i]),4);
						//echo "<td>".$dmin[$i]."</td>";echo "</tr>";
					}
					//echo "</table><hr>";
					// ======================================================================== //
					//echo "<b>Hasil Akhir</b></br>";
					//echo "<table class='table table-striped table-bordered table-hover'>";
					//echo "<thead><tr><th></th><th>V</th></tr></thead>";
					for($i=0;$i<$a;$i++){
						//echo "<tr><td><b>A".($i+1)."</b></td>";
						$v[$i][0] = round(($dmin[$i] / ($dplus[$i]+$dmin[$i])),4);
						$v[$i][1] = $alt_name[$i];
 						//echo "<td>".$v[$i][0]."</td>";
					}
					//echo "</table><hr>";
					usort($v, "cmp");
					$i = 0;
					while (list($key, $value) = each($v)) {
						$hsl[$i] = array($value[1],$value[0]); 
						$i++;
					}
					// ======================================================================== //
					echo "<b>Hasil Analisa</b></br>";
					echo "Berikut ini hasil analisa diurutkan berdasarkan hasil nilai tertinggi. </br>Jadi dapat disimpulkan bahwa Alternatif terbaik adalah <b>".ucwords(($hsl[0][0]))."</b> dengan nilai <b>".$hsl[0][1]."</b>.";
					echo "<table class='table table-striped table-bordered table-hover'>";
					echo "<thead><tr><th>No.</th><th>Alternatif</th><th>Hasil Akhir</th></tr></thead>";
					echo "<tbody>";
					for($i=0;$i<$a;$i++){
						echo "<tr><td>".($i+1).".</td><td>".ucwords(($hsl[$i][0]))."</td><td>".$hsl[$i][1]."</td></tr>";
					}
					echo "</tbody></table><hr>";
					
					
										function jml_kriteria(){	
											include 'configdb.php';
											$kriteria = $mysqli->query("select * from kriteria");
											return $kriteria->num_rows;
										}
										
										function jml_alternatif(){	
											include 'configdb.php';
											$alternatif = $mysqli->query("select * from alternatif");
											return $alternatif->num_rows;
										}
										
										function get_kepentingan(){
											include 'configdb.php';
											$kepentingan = $mysqli->query("select * from kriteria");
											if(!$kepentingan){
												echo $mysqli->connect_errno." - ".$mysqli->connect_error;
												exit();
											}
											$i=0;
											while ($row = $kepentingan->fetch_assoc()) {
												@$kep[$i] = $row["kepentingan"];
												$i++;
											}
											return $kep;
										}
										
										function get_costbenefit(){
											include 'configdb.php';
											$costbenefit = $mysqli->query("select * from kriteria");
											if(!$costbenefit){
												echo $mysqli->connect_errno." - ".$mysqli->connect_error;
												exit();
											}
											$i=0;
											while ($row = $costbenefit->fetch_assoc()) {
												@$cb[$i] = $row["cost_benefit"];
												$i++;
											}
											return $cb;
										}
										
										function get_alt_name(){
											include 'configdb.php';
											$alternatif = $mysqli->query("select * from alternatif");
											if(!$alternatif){
												echo $mysqli->connect_errno." - ".$mysqli->connect_error;
												exit();
											}
											$i=0;
											while ($row = $alternatif->fetch_assoc()) {
												@$alt[$i] = $row["alternatif"];
												$i++;
											}
											return $alt;
										}
										
										function get_alternatif(){
											include 'configdb.php';
											$alternatif = $mysqli->query("select * from alternatif");
											if(!$alternatif){
												echo $mysqli->connect_errno." - ".$mysqli->connect_error;
												exit();
											}
											$i=0;
											while ($row = $alternatif->fetch_assoc()) {
												@$alt[$i][0] = $row["k1"];
												@$alt[$i][1] = $row["k2"];
												@$alt[$i][2] = $row["k3"];
												@$alt[$i][3] = $row["k4"];
												@$alt[$i][4] = $row["k5"];
												@$alt[$i][5] = $row["k6"];
												$i++;
											}
											return $alt;
										}
										
										function cmp($a, $b){
											if ($a == $b) {
												return 0;
											}
											return ($a > $b) ? -1 : 1;
										}

										function print_ar(array $x){	//just for print array
											echo "<pre>";
											print_r($x);
											echo "</pre></br>";
										}
				?>
			</center>
		  </div>
		  <div class="panel-footer"><?php echo $_SESSION['by'];?><div class="pull-right"></div></div>
		</div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="ui/js/jquery-1.10.2.min.js"></script>
	<script src="ui/js/bootstrap.min.js"></script>
	<script src="ui/js/bootswatch.js"></script>
	<script src="ui/js/Chart.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="ui/js/ie10-viewport-bug-workaround.js"></script>
	<!-- chart -->
	<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : [
			<?php 
				for($i=0;$i<$a;$i++){
					echo '"'.ucwords(($v[$i][1])).'",';
				}
			?>
		],
		datasets : [
			{
				fillColor : "rgba(255,255,0,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(255,128,0,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [
					<?php 
						for($i=0;$i<$a;$i++){
							echo $v[$i][0].',';
						}
					?>
				]
			},
			/*{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
			}*/
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}

	</script>
</body></html>