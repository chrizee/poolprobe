<?php
/**
 * DashboardBuilder
 *
 * @author Diginix Technologies www.diginixtech.com
 * Support <support@dashboardbuider.net> - https://www.dashboardbuilder.net
 * @copyright (C) 2018 Dashboardbuilder.net
 * @version 2.1.5
 * @license: license.txt
 */

include("inc/dashboard_dist.php");  // copy this file to inc folder 


// for chart #1
$data = new dashboardbuilder(); 
$data->type =  "kpi";

$data->source =  "Database"; 
$data->rdbms =  "mysql"; 
$data->servername =  "localhost";
$data->username =  "root";
$data->password =  "christo16";
$data->dbname =  "poolprobe";
$data->xaxisSQL[0]=  "SELECT * FROM sensors order by timestamp desc limit 10;";
$data->xaxisCol[0]=  "atlas_temp";

$data->name = "0";
$data->title = "Wassertemperatur";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "58";
$data->width = "";
$data->col = "0";
$data->tracename[0]=  "Temperatur";

$result[0] = $data->result();

// for chart #2
$data = new dashboardbuilder(); 
$data->type =  "line";

$data->source =  "Database"; 
$data->rdbms =  "mysql"; 
$data->servername =  "localhost";
$data->username =  "root";
$data->password =  "christo16";
$data->dbname =  "poolprobe";
$data->xaxisSQL[0]=  "SELECT * FROM sensors order by timestamp desc limit 10;";
$data->xaxisCol[0]=  "timestamp";
$data->yaxisSQL[0]=  "SELECT * FROM sensors order by timestamp desc limit 10;";
$data->yaxisCol[0]=  "atlas_temp";

$data->name = "4";
$data->title = "Temperaturverlauf";
$data->orientation = "";
$data->xaxistitle = "Zeit";
$data->yaxistitle = "Temp";
$data->showgrid = "";
$data->showline = "";
$data->height = "180";
$data->width = "";
$data->col = "1";

$result[1] = $data->result();

// for chart #3
$data = new dashboardbuilder(); 
$data->type =  "kpi";

$data->source =  "Database"; 
$data->rdbms =  "mysql"; 
$data->servername =  "localhost";
$data->username =  "root";
$data->password =  "christo16";
$data->dbname =  "poolprobe";
$data->xaxisSQL[0]=  "SELECT * FROM sensors order by timestamp desc limit 10;";
$data->xaxisCol[0]=  "ph";

$data->name = "2";
$data->title = "PH Wert Wasser";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "58";
$data->width = "";
$data->col = "2";
$data->tracename[0]=  "PH Wert";

$result[2] = $data->result();

// for chart #4
$data = new dashboardbuilder(); 
$data->type =  "kpi";

$data->source =  "Database"; 
$data->rdbms =  "mysql"; 
$data->servername =  "localhost";
$data->username =  "root";
$data->password =  "christo16";
$data->dbname =  "poolprobe";
$data->xaxisSQL[0]=  "SELECT * FROM sensors LIMIT 10;";
$data->xaxisCol[0]=  "orp";

$data->name = "3";
$data->title = "ORP Wert Wasser";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "57";
$data->width = "";
$data->col = "3";
$data->tracename[0]=  "ORP Wert";

$result[3] = $data->result();

// for chart #5
$data = new dashboardbuilder();
$data->type =  "kpi";

$data->source =  "Database";
$data->rdbms =  "mysql";
$data->servername =  "localhost";
$data->username =  "root";
$data->password =  "christo16";
$data->dbname =  "poolprobe";
$data->xaxisSQL[0]=  "SELECT * FROM sensors order by timestamp desc limit 10;";
$data->xaxisCol[0]=  "timestamp";

$data->name = "4";
$data->title = "Update";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "141";
$data->width = "";
$data->col = "4";
$data->tracename[0]=  "letzte Aktualisierung";

$result[4] = $data->result();

// for chart #6
$data = new dashboardbuilder();
$data->type =  "kpi";

$data->source =  "Database";
$data->rdbms =  "mysql";
$data->servername =  "localhost";
$data->username =  "root";
$data->dbname =  "poolprobe";
$data->password =  "christo16";
$data->xaxisSQL[0]=  "SELECT * FROM temp_tb LIMIT 10;";
$data->xaxisCol[0]=  "wert";

$data->name = "5";
$data->title = "Aussentemperatur";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "64";
$data->width = "";
$data->col = "5";
$data->tracename[0]=  "Grad C";

$result[5] = $data->result();?>

<!DOCTYPE html>
<html>
<head>
	<script src="assets/js/dashboard.min.js"></script> <!-- copy this file to assets/js folder -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> <!-- Bootstrap CSS file, change the path accordingly -->
	
<style>
@media screen and (min-width: 960px) {
.id0 {position:absolute;margin-top:134px;}
.id1 {position:absolute;margin-top:747px;}
.id2 {position:absolute;margin-top:6px;}
.id3 {position:absolute;margin-top:266px;}
.id4 {position:absolute;margin-top:394px;}
.id5 {position:absolute;margin-top:610px;}

}
.panel-heading {line-height:0.7em;}
#kpi {font-size:34px; font-weight:bold;text-align:center;}
#kpi_legand {font-size:11px; color:#999;text-align:center;}
</style>
</head>
<body> 
<div class="container-fluid main-container">
<div class="col-md-12 col-lg-12 col-xs-12">
<div class="row">
<div class="col-md-2 col-lg-2 col-md-offset-0 col-lg-offset-0 col-xs-12 id0">
<div class="panel panel-default">
<div class="panel-heading">Wassertemperatur</div>
	<div class="panel-body">
		<?php echo $result[0];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-7 col-lg-7 col-md-offset-0 col-lg-offset-0 col-xs-12 id1">
<div class="panel panel-default">
<div class="panel-heading">Temperaturverlauf</div>
	<div class="panel-body">
		<?php echo $result[1];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-2 col-lg-2 col-md-offset-0 col-lg-offset-0 col-xs-12 id2">
<div class="panel panel-default">
<div class="panel-heading">PH Wert Wasser</div>
	<div class="panel-body">
		<?php echo $result[2];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-2 col-lg-2 col-md-offset-0 col-lg-offset-0 col-xs-12 id3">
<div class="panel panel-default">
<div class="panel-heading">ORP Wert Wasser</div>
	<div class="panel-body">
		<?php echo $result[3];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-2 col-lg-2 col-md-offset-0 col-lg-offset-0 col-xs-12 id4">
<div class="panel panel-default">
<div class="panel-heading">Update</div>
	<div class="panel-body">
		<?php echo $result[4];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-2 col-lg-2 col-md-offset-0 col-lg-offset-0 col-xs-12 id5">
<div class="panel panel-default">
<div class="panel-heading">Aussentemperatur</div>
	<div class="panel-body">
		<?php echo $result[5];?>
	</div>
</div>
</div>
</div>
</div>
</div>
</body>
<script>
	Plotly.relayout("col0", {height:58});
	
	Plotly.relayout("col1", {height:180});
	
	Plotly.relayout("col2", {height:58});
	
	Plotly.relayout("col3", {height:57});
	
	Plotly.relayout("col4", {height:141});
	
	Plotly.relayout("col5", {height:64});
	
</script>