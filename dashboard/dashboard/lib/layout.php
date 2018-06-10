<?php 
$folder ="..".DIRECTORY_SEPARATOR;
echo '<script src="'.$folder.'assets/js/dashboard.min.js"></script>';
require_once($folder."inc/dashboard_dist.php"); 
$xml=simplexml_load_file($folder."data/data.xml") or die("Error: Cannot create object");
$layout=simplexml_load_file($folder."data/layout.xml") or die("Error: Cannot create object");

// Col data

$no_col = count($xml->col);


$col = array();
$reuslt = array();
$name = array();
$height = array();

for ($j=0;$j<$no_col;$j++){
	$data = new dashboardbuilder();
	$data->col = $j; 
	$data->type =  $xml->col[$j]->type; 
	$data->source =  $xml->col[$j]->source; 
	if (empty($xml->col[$j]->ssl)){
				$data->servername =  $xml->col[$j]->servername;
				}
				else
				{
				$data->servername =  'https://'.$xml->col[$j]->servername;
			}

	$data->username =  $xml->col[$j]->username;
	$data->password =  $xml->col[$j]->password;
	$data->dbname =  $xml->col[$j]->dbname;
	$data->rdbms =  $xml->col[$j]->rdbms;
	
	$data->name = $xml->col[$j]->name;
	$data->title = $xml->col[$j]->title;
	$data->orientation = $xml->col[$j]->orientation;
	$data->xaxistitle = $xml->col[$j]->xaxistitle;
	$data->yaxistitle = $xml->col[$j]->yaxistitle;
	//$data->height = $xml->col[$j]->height;
	$data->height = $layout->height[$j]-70;
	$data->width = $xml->col[$j]->width;
	$data->showgrid = $xml->col[$j]->showgrid;
	$data->showline = $xml->col[$j]->showline;

	
	$i=0;
	if ($xml->col[$j]->source =="Database"){
		foreach($xml->col[$j]->sql as $value){
		   $data->sql[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($xml->col[$j]->tracename) {
		foreach($xml->col[$j]->tracename as $value){
		   $data->tracename[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($data->type=='map'){
		foreach($xml->col[$j]->maptype as $value){
			$data->maptype[$i] = $value;
			$i++;
		}
	} // end if map
		
	
	if (($xml->col[$j]->source =="ADatabase")){
		$xml->col[$j]->source = "Database";
	    if (substr($xml->col[$j]->xaxis,0,3) =="SQL"){
			
			$i=0;
			foreach($xml->col[$j]->xaxis as $value){
				preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
				preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->xaxis[$i], $match);
				$data->xaxisSQL[$i] = $sqlmatch[1];
				$data->xaxisCol[$i] = $match[1];
				$i++;
			}

			$i=0;
			if(!($data->type=='kpi')){
				foreach($xml->col[$j]->yaxis as $value){
					preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->yaxis[$i], $match);
					$data->yaxisSQL[$i] = $sqlmatch[1];
					$data->yaxisCol[$i] = $match[1];
					$i++;
				}
			}

			$i=0;
			if ($data->type=='bubble'){
			if (substr($xml->col[$j]->size,0,3) =="SQL"){
				foreach($xml->col[$j]->size as $value){
				    preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->size[$i], $match);
					$data->sizeSQL[$i] = $sqlmatch[1];
					$data->sizeCol[$i] = $match[1];
					$i++;
				}
			} // end if SQL
			}// end if bubble
				
			$i=0;
			if (($data->type=='bubble') || ($data->type=='map') || ($data->type=='heatmap') ){
			if (substr($xml->col[$j]->text,0,3) =="SQL"){
				foreach($xml->col[$j]->text as $value){
				    preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->text[$i], $match);
					$data->textSQL[$i] = $sqlmatch[1];
					$data->textCol[$i] = $match[1];
					$i++;
				}
			} // end if SQL
			}// end if bubble and map
			
			
		}
	}
	
	
	if (($xml->col[$j]->source =="upload")){
		 if (substr($xml->col[$j]->xaxis,0,3) =="XLS"){
			$i=0;
			foreach($xml->col[$j]->xaxis as $value){
			 if ($value){
				  preg_match('~{data}([^{]*){/data}~i', $value, $match);
				  if (!empty($match[1])){
					$data->xaxis[$i] = array_map('strval', explode(',', $match[1]));
				  }
			  }
			  $i++;
			}
	
			$i=0;
			foreach($xml->col[$j]->yaxis as $value){
			 if (!empty($value)){
				  preg_match('~{data}([^{]*){/data}~i', $value, $match);
				  if (!empty($match[1])){
					$data->yaxis[$i] = array_map('strval', explode(',', $match[1]));
				}
			  }
			  $i++;
			}
			
			if ($xml->col[$j]->type=='bubble'){
			$i=0;
				foreach($xml->col[$j]->size as $value){
					 if (!empty($value)){
						  preg_match('~{data}([^{]*){/data}~i', $value, $match);
						  if (!empty($match[1])){
							$data->size[$i] = array_map('strval', explode(',', $match[1]));
						}
					  }
				  $i++;
				}
			} // end if bubble
			
			if (($xml->col[$j]->type=='bubble') || ($xml->col[$j]->type=='map') || ($xml->col[$j]->type=='heatmap')){
				$i=0;
				foreach($xml->col[$j]->text as $value){
					 if (!empty($value)){
						  preg_match('~{data}([^{]*){/data}~i', $value, $match);
						  if (!empty($match[1])){
							$data->text[$i] = array_map('strval', explode(',', $match[1]));
						}
					  }
				  $i++;
				}
			} // end if bubble and map

		}
	}

	$result[$j] = $data->result(); 
	$name[$j] = $data->name;
	$height[$j] = $data->height;
  
}// for end

function str_replace_first($from, $to, $subject)
{


    $from = '/'.preg_quote($from, '/').'/';

    //return preg_replace(strtoupper($from), $to, strtoupper($subject), 1);
	return preg_replace($from, $to, $subject, 1);
}
?>

<?php include ('col.php');?>
