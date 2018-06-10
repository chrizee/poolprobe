<link href="../assets/css/jquery-linedtextarea.css" type="text/css" rel="stylesheet" />
<?php

$code = genfile();

?>

<div class="col-lg-12">
<div class="panel panel-default">
	<div class="panel-heading">
	&nbsp;&nbsp;
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
	&nbsp;&nbsp;
	<button class="close" onClick="copypast('hiddencode')"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;</button>
	&nbsp;&nbsp;
	</div>
	<div class="panel-body">
	
			<form  id="savefil" class="form-horizontal"  method="post">
									<textarea  id="phpcode" class="lined" rows="20" hresize><?php echo $code;?></textarea>
									
			<div class="modal-footer">
				<button type="button" class="btn btn-default" style="float:none;" data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;">Cancel</button>  
				<button type="button" class="btn btn-primary" onClick="copypast('hiddencode')" style="float:right;">Copy&nbsp;<span class="fa fa-clipboard"></span></button>
			</div>
			</form>
	</div>
</div>
	

<?php 

function genfile(){

$xml=simplexml_load_file("../data/data.xml") or die("Error: Cannot create object");
$layout=simplexml_load_file("../data/layout.xml") or die("Error: Cannot create object");

// Code Generate Start 
$write = '
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
';

// Col data

$no_col = count($xml->col);

$reuslt = array();
$name = array();
$height = array();

for ($j=0;$j<$no_col;$j++){


$write.='

// for chart #'.($j+1).'
$data = new dashboardbuilder(); 
$data->type =  "'.$xml->col[$j]->type.'";'."\n";
// Check if source is Database
if ($xml->col[$j]->source=='ADatabase'){
if (empty($xml->col[$j]->ssl)){
	$servername =  $xml->col[$j]->servername;
	}
	else
	{
	$servername =  'https://'.$xml->col[$j]->servername;
}
$write.='
$data->source =  "Database"; 
$data->rdbms =  "'.$xml->col[$j]->rdbms.'"; 
$data->servername =  "'.$servername.'";
$data->username =  "'.$xml->col[$j]->username.'";
$data->password =  "'.$xml->col[$j]->password.'";
$data->dbname =  "'.$xml->col[$j]->dbname.'";
';
	$i=0;
	
	$xml->col[$j]->source = "Database";
	    if (substr($xml->col[$j]->xaxis,0,3) =="SQL"){
			
			$i=0;
			foreach($xml->col[$j]->xaxis as $value){
				preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
				preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->xaxis[$i], $match);
				$write.='$data->xaxisSQL['.$i.']=  "'.$sqlmatch[1].'";'."\n";
				$write.='$data->xaxisCol['.$i.']=  "'.$match[1].'";'."\n";
			    if ($xml->col[$j]->type=='heatmap') {break;}  // if heatmap just take the first data
				$i++;
			}

			$i=0;
			if(!($xml->col[$j]->type=='kpi')){
			foreach($xml->col[$j]->yaxis as $value){
				preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
				preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->yaxis[$i], $match);
				$write.='$data->yaxisSQL['.$i.']=  "'.$sqlmatch[1].'";'."\n";
				$write.='$data->yaxisCol['.$i.']=  "'.$match[1].'";'."\n";
				if ($xml->col[$j]->type=='heatmap') {break;}  // if heatmap just take the first data
				$i++;
				}
			}
	
			$i=0;
			if ($xml->col[$j]->type=='bubble'){
				foreach($xml->col[$j]->size as $value){
				    preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->size[$i], $match);
					$write.='$data->sizeSQL['.$i.']=  "'.$sqlmatch[1].'";'."\n";
					$write.='$data->sizeCol['.$i.']=  "'.$match[1].'";'."\n";
					$i++;
				}
			} // end if bubble
				
			if (($xml->col[$j]->type=='bubble') || ($xml->col[$j]->type=='map') || ($xml->col[$j]->type=='heatmap')){
				$i=0;
				foreach($xml->col[$j]->text as $value){
				    preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->text[$i], $match);
					$write.='$data->textSQL['.$i.']=  "'.$sqlmatch[1].'";'."\n";
					$write.='$data->textCol['.$i.']=  "'.$match[1].'";'."\n";
					$i++;
				}
			}	// end if bubble and map
		} //end if SQL
		  // $write.='$data->sql['.$i.']=  "'.$value.'";'."\n";
		  
	} //if Database End
	elseif (($xml->col[$j]->source =="upload")){
		$i=0;
		foreach($xml->col[$j]->xaxis as $value){
		 if ($value){
			  preg_match('~{data}([^{]*){/data}~i', $value, $match);
			  if (!empty($match[1])){
			  	$a = array_map('strval', explode(',', $match[1]));
				$write.='$data->xaxis['.$i.']= '.json_encode($a).';'."\n";
			  }
		  }
		  $i++;
		}

		$i=0;
		foreach($xml->col[$j]->yaxis as $value){
		 if ($value){
			  preg_match('~{data}([^{]*){/data}~i', $value, $match);
			  if (!empty($match[1])){
			    $a = array_map('strval', explode(',', $match[1]));
				$write.='$data->yaxis['.$i.']= '.json_encode($a).';'."\n";
			}
		  }
		  $i++;
		}	
		
		if ($xml->col[$j]->type == 'bubble'){
				$i=0;
				foreach($xml->col[$j]->size as $value){
				 if ($value){
					  preg_match('~{data}([^{]*){/data}~i', $value, $match);
					  if (!empty($match[1])){
						$a = array_map('strval', explode(',', $match[1]));
						$write.='$data->size['.$i.']= '.json_encode($a).';'."\n";
					}
				  }
				  $i++;
				}	
		 } // end if bubble
				
		 if (($xml->col[$j]->type=='bubble') || ($xml->col[$j]->type=='map') || ($xml->col[$j]->type=='heatmap')){
				$i=0;
				foreach($xml->col[$j]->text as $value){
				 if ($value){
					  preg_match('~{data}([^{]*){/data}~i', $value, $match);
					  if (!empty($match[1])){
						$a = array_map('strval', explode(',', $match[1]));
						$write.='$data->text['.$i.']= '.json_encode($a).';'."\n";
					}
				  }
				  $i++;
				}	
		}// end if bubble and map
	}
	else
	{
	$i=0;
	foreach($xml->col[$j]->xaxis as $value){
		if (!empty($value)){
		   $write.='$data->xaxis['.$i.']= array_map("strval", explode(",", "'.$value.'"));'."\n";
		   if ($xml->col[$j]->type=='heatmap') {break;}  // if heatmap just take the first data
		   $i++;
		  }
	}
	$i=0;
	foreach($xml->col[$j]->yaxis as $value){
		if (!empty($value)){
		  $write.='$data->yaxis['.$i.']= array_map("strval", explode(",", "'.$value.'"));'."\n";
		   if ($xml->col[$j]->type=='heatmap') {break;}  // if heatmap just take the first data
		   $i++;
		  }
	}
} // Else Database End
if (!empty($xml->col[$j]->height)) {
	$h= $xml->col[$j]->height;
} else {
	$h= $layout->height[$j]-70;
}

$write.='
$data->name = "'.$xml->col[$j]->name.'";
$data->title = "'.$xml->col[$j]->title.'";
$data->orientation = "'.$xml->col[$j]->orientation.'";
$data->xaxistitle = "'.$xml->col[$j]->xaxistitle.'";
$data->yaxistitle = "'.$xml->col[$j]->yaxistitle.'";
$data->showgrid = "'.$xml->col[$j]->showgrid.'";
$data->showline = "'.$xml->col[$j]->showline.'";
$data->height = "'.$h.'";
$data->width = "'.$xml->col[$j]->width.'";
$data->col = "'.$j.'";
';

$i=0;
	foreach($xml->col[$j]->tracename as $value){
		if (!empty($value)){
		   $write.='$data->tracename['.$i.']=  "'.$value.'";'."\n";
		   $i++;
	   }
	}
	
$i=0;
	if ($xml->col[$j]->type=='map'){
		foreach($xml->col[$j]->maptype as $value){
			$write.='$data->maptype['.$i.']=  "'.$value.'";'."\n";
			$i++;
		}
	} // end if map
	
$i=0;

$write.='
$result['.$j.'] = $data->result();';

$name[$j]=$xml->col[$j]->name;
//$height[$j]=$xml->col[$j]->height;
} // End For Loop

$write.='?>

<!DOCTYPE html>
<html>
<head>
	<script src="assets/js/dashboard.min.js"></script> <!-- copy this file to assets/js folder -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> <!-- Bootstrap CSS file, change the path accordingly -->
	';


$write.='
<style>
@media screen and (min-width: 960px) {
';

for ($j=0;$j<$no_col;$j++){
$write.= '.id'.$j.' {position:absolute;margin-top:'.$layout->top[$j].'px;}
';
}

$write.='
}
.panel-heading {line-height:0.7em;}
#kpi {font-size:34px; font-weight:bold;text-align:center;}
#kpi_legand {font-size:11px; color:#999;text-align:center;}
</style>
</head>
<body> 
<div class="container-fluid main-container">
<div class="col-md-12 col-lg-12 col-xs-12">';

for ($j=0;$j<$no_col;$j++){

//$coloffset=$layout->left[$j] / $_POST['col'];
$coloffset=$layout->left[$j];
 
$defaultcharttitle = ucwords($xml->col[$j]->type) . " Chart";
if ($xml->col[$j]->title==''){ $xml->col[$j]->title = $defaultcharttitle ;}
		
$write.='
<div class="row">
<div class="col-md-'.((int) $layout->width[$j]).' col-lg-'.((int)$layout->width[$j]).' col-md-offset-'.((int) $coloffset).' col-lg-offset-'.((int) $coloffset).' col-xs-12 id'.$j.'">
<div class="panel panel-default">
<div class="panel-heading">'.$xml->col[$j]->title.'</div>
	<div class="panel-body">
		<?php echo $result['.$j.'];?>
	</div>
</div>
</div>
</div>';
} // end_for

$write.='
</div>
</div>
</body>
<script>';
for ($j=0;$j<$no_col;$j++){
	$write.='
	Plotly.relayout("col'.$j.'", {height:'.($layout->height[$j] - 70).'});
	';
}

$write.='
</script>';

return $write;
}// End Function


?>
<script src="../assets/js/jquery-linedtextarea.js"></script>
<script>
$(function() {
	$(".lined").linedtextarea(
		{selectedLine: 1}
	);
});

function copypast(id){
	document.getElementById('phpcode').select();
    document.execCommand('copy');
};

</script>

