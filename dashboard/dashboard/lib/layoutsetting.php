  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Layout setting</title>  
  
  

 <!-- Modal -->
 <?php if (isset($_REQUEST['col'])) {
  $col = (int) $_REQUEST['col'];
  $request_col =  $_REQUEST['col'];
  } else {
  $col = 0;
  $request_col=0;
  }
 $rs="";
// $url = preg_replace('/&task=submit/', '', $_SERVER['REQUEST_URI']);
 $url =  $_SERVER['REQUEST_URI'];

  
if (isset($_POST['save'])=='true') {

		savedata($col);
		$_POST['save']='';
		//header('Location: ' . $_SERVER["HTTP_REFERER"] );
		?>
		<script>
		window.location.replace('<?php echo $url;?>');
		</script> 
		<?php
}

if (!empty($_POST['cleardata']) && ($_POST['cleardata']=="true")) {
		cleardata($col);
		$_POST['cleardata']=''; 
		?>
		<script>
		window.location.replace('<?php echo $url;?>');
		</script> 
		<?php
}
 
 $type = "";
 $cols = array();
 $xaxis = array();
 $yaxis = array();
 $size = array();
 $text = array();
 $maptype = array();
 $tracename = array();
 $title = "";
 $name = "";
 $xaxistitle="";
 $yaxistitle="";
 $height="";
 $width="";
 $showgrid="";
 $showline="";
 $orientation="";
 
 $xmlDoc=simplexml_load_file($folder.'data/data.xml');
 dbc();

$query = array();
$lastSQL = array();
$noofquery = 1;

// Assign initial values //
if (isset($_POST['runquery'])=='true') {
	// Check $_POST data 
		if (isset($_POST['tabs'])){
			$tbdsp = $_POST['tabs'];
			$tb = $_POST['tabs'] -1; // taking tab count
		}
		
		if (!empty($_POST['query'])){
				$x=0;
					 foreach($_POST['query'] as $value){
					  $value = preg_replace('/\s+/S', " ", $value); 
					  $query[$x] = trim($value);
					  $x++;
					 }
				$noofquery = $x;
		}
		if (!empty($_POST['X'])){
			 $x=0;
			 foreach($_POST['X'] as $value){
				 if (!empty($value)){
					$xaxis[$x] = $value;
					$x++;
				 }
			 }
		}
		
		
		if (!empty($_POST['Y'])){
				$x=0;
				 foreach($_POST['Y'] as $value){
					 if (!empty($value)){
						$yaxis[$x] = $value;
						$x++;
					 }
				 }
		}
		
		if (!empty($_POST['size'])){
				$x=0;
				 foreach($_POST['size'] as $value){
					 if (!empty($value)){
						$size[$x] = $value;
						$x++;
					 }
				 }
		}
		
		if (!empty($_POST['text'])){
				$x=0;
				 foreach($_POST['text'] as $value){
					 if (!empty($value)){
						$text[$x] = $value;
						$x++;
					 }
				 }
		}
		
		if (!empty($_POST['query'])){
			$sql = trim($query[$tb]);
			if (!empty($sql)) {
			try{
					$rs = $conn->query($sql);
					$columncount = $rs->columnCount();
					for ($i = 0; $i < $rs->columnCount(); $i++) { 
					$colm = $rs->getColumnMeta($i);
					$cols[$i] = $colm['name'];
					}
						} catch(Exception $e){
							//echo $e;
							echo '<div class="alert alert-danger alert-dismissable">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Error! Invalid Query </strong> '.$sql .
									  '</div>';
							}
		} }						
		
		
		if (!empty($_POST['tracename'])){
				$x=0;
				 foreach($_POST['tracename'] as $value){
					 if (!empty($value)){
						$tracename[$x] = $value;
						$x++;
					 }
				 }
		}
		if (!empty($_POST['type'])){
			$type = $_POST['type'];
		}
		if (!empty($_POST['title'])){
			$title = $_POST['title'];
		}
		if (!empty($_POST['name'])){
			$name = $_POST['name'];
		}
		if (!empty($_POST['xaxistitle'])){
			$xaxistitle = $_POST['xaxistitle'];
		}
		if (!empty($_POST['yaxistitle'])){
			$yaxistitle = $_POST['yaxistitle'];
		}
		if (!empty($_POST['height'])){
			$height = $_POST['height'];
		}
		if (!empty($_POST['width'])){
			$width = $_POST['width'];
		}
		if (!empty($_POST['showgrid'])){
			$showgrid = $_POST['showgrid'];
		}
		if (!empty($_POST['showline'])){
			$showline = $_POST['showline'];
		}
		if (!empty($_POST['orientation'])){
			$orientation = $_POST['orientation'];
		}

		} // Check $_POST data end
		

		else { // Checking xml data
		$type = $xmlDoc->col[$col]->type;
		$title = $xmlDoc->col[$col]->title;
		$name =  $xmlDoc->col[$col]->name;
		
		foreach($xmlDoc->col[$col]->xaxis as $value){
			$xaxis[] = $value;
		}
		foreach($xmlDoc->col[$col]->yaxis as $value){
			$yaxis[] = $value;
		}
		foreach($xmlDoc->col[$col]->size as $value){
			$size[] = $value;
		}
		foreach($xmlDoc->col[$col]->text as $value){
			$text[] = $value;
		}
		foreach($xmlDoc->col[$col]->tracename as $value){
			$tracename[] = $value;
		}
	

		if (!empty($xmlDoc->col[$col]->sql)){
				$x=0;
					 foreach($xmlDoc->col[$col]->sql as $value){
					  $query[$x] = $value;
					  $x++;
					 }
				$noofquery = $x;
				$tb = $x;
		}


		$xaxistitle = $xmlDoc->col[$col]->xaxistitle;
		$yaxistitle = $xmlDoc->col[$col]->yaxistitle;
		$height = $xmlDoc->col[$col]->height;
		$width = $xmlDoc->col[$col]->width;
		$showgrid = $xmlDoc->col[$col]->showgrid;
		$showline = $xmlDoc->col[$col]->showline;
		$orientation = $xmlDoc->col[$col]->orientation;	
		$maptype = $xmlDoc->col[$col]->maptype;
		
} // Assigining initila values


												
if ($xmlDoc->col[$col]->source=="upload"){
	if (file_exists($xmlDoc->col[$col]->file)) {
			$filename = $xmlDoc->col[$col]->file;
			require('../assets/class/excel_reader2.php');
			require('../assets/class/SpreadsheetReader.php');
			$Reader = new SpreadsheetReader($filename);
			$i=0;
			
			$XLSCol = array();
			foreach ($Reader as $XLS)
				{
				 
					$j=0;
					foreach ($XLS as $HDS)
						{
						   $HDS = str_replace(array(","), '~', $HDS);  // newly added
							$XLSCol[$j][$i] = $HDS;
							$j++;
						}
					$i++;
				}
	}
}

if (!empty($sql)){
	$sql = str_replace("'", "^", $sql); 
}

?>

		    <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.replace('<?php echo $url;?>')">&times;</button>
				<a data-toggle="modal" id="#dbModal-0" style="float:right;margin:5px 10px 10px 10px;" onclick="$('#settingModal-0').modal('hide');" href="dbsetting.php?layout=1&col=<?php echo  $request_col;?>" data-target="#dbModal-0"><button class="btn-xs btn-danger" >Change Database</button></a>
                 <h4 class="modal-title">Chart Settings</h4>
            </div>			<!-- /modal-header -->
			 <div class="modal-body">
			 <div class="se-pre-modal"></div>
			 <form id="layoutsetting" class="form-horizontal" method="post" action="<?php echo $url;?>" onsubmit="return validateForm();">
			  <input type="hidden" name="node" value="<?php if (isset($_POST['node'])) { echo $_POST['node'];}?>"/>

				<!-- Navigation -->
				<div class="row" >
				<div class="col-md-3" style="background-color:#F7F7F7; padding-top:10px;">
				<!-- Left Navi -->
				
							<div class="form-group ">
							  <label for="sel1" class="col-sm-3  control-label">Type:</label>
							  <div class="col-sm-9">
							  <select class="form-control" id="type" name="type" value="<?php echo $type;?>" onchange="mySelection()">
							  	<option value="area" <?php if ($type=='area'){?> selected <?php }?>>Area</option>
							  	<option value="bar" <?php if ($type=='bar'){?> selected <?php }?>>Bar</option>
								<option value="bubble" <?php if ($type=='bubble'){?> selected <?php }?>>Bubble</option>
								<option value="map" <?php if ($type=='map'){?> selected <?php }?>>Choropleth Map</option>
								<option value="donut" <?php if ($type=='donut'){?> selected <?php }?>>Donut</option>
								<option value="heatmap" <?php if ($type=='heatmap'){?> selected <?php }?>>Heatmap</option>
								<option value="histogram" <?php if ($type=='histogram'){?> selected <?php }?>>Histogram</option>
								<option value="kpi" <?php if ($type=='kpi'){?> selected <?php }?>>KPI</option>
								<option value="line" <?php if ($type=='line'){?> selected <?php }?>>Line</option>
								<option value="pie" <?php if ($type=='pie'){?> selected <?php }?>>Pie</option>
								<option value="stack" <?php if ($type=='stack'){?> selected <?php }?>>Stack</option>
							  </select>
							  </div>
							</div>
						
				<!-- Menu -->
	<div class="side-menu2">
<nav class="navbar navbar-default2" role="navigation">
			<!-- Main Menu -->
			<!-- filed_wrapper -->
			<div class="field_wrapper">
			<div class="side-menu-container " >
				<ul class="nav navbar-nav">

					<!-- Dropdown-->
					<li class="active panel panel-default" id="dropdown">
					
						<!--<div class="setting-menu" style="background-color:#E5E5E5;width:100%; height:2em; padding:5px;" >-->
						
						<div class="setting-menu">
							<a data-toggle="collapse" href="#dropdown-chs1" >
								<span class="fa fa-random"></span>&nbsp;Trace 1<span class="caret"></span>
							</a>
							
							<a href="javascript:void(0);" id="add_trace" class="add_button col-sm-offset-12" title="Add Trace" style="color:#000000; float:right;margin-top:-15px;"> <span class="fa fa-plus-square-o" ></span></a>
						</div>
						<!-- Dropdown level 1 -->
						<div id="dropdown-chs1" class="panel-collapse">
							<div class="panel-body" style="padding: 0; padding-top:15px;">
								
									<div id="XGroup" class="form-group" >
									  <label for="sel2" class="col-sm-3  control-label" id="x">X: </label>
									  <div class="col-sm-8">
									  <select class="form-control" id="X" name="X[]" style="height:25px; width:100%; padding:0;">
										 <?php  
										    if ($xmlDoc->col[$col]->source=="ADatabase"){
												if (!empty($xaxis[0])){
														preg_match('~{col}([^{]*){/col}~i', $xaxis[0], $match);
														echo '<option value ="'.$xaxis[0].'">'.substr($xaxis[0],0,5).$match[1].'(1)</option>';
												}
												if (isset($_POST['query'])){				
												for ($x = 0; $x < $i ; $x++) { ?>
													<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
													echo '{data}';
													echo $sql;
													echo '{/data}';
													?>">
													<?php 
													echo "SQL".$tbdsp.':'.$cols[$x]; ?>
													</option>
												<?php
												}
												} 
											}?>
											
											<?php  
										    if ($xmlDoc->col[$col]->source=="upload"){
											if (file_exists($xmlDoc->col[$col]->file)) {
													if (!empty($xaxis[0])){
															preg_match('~{col}([^{]*){/col}~i', $xaxis[0], $match);
															echo '<option value ="'.$xaxis[0].'" selected="selected">'.$match[1].'</option>';
													}
													$i=0;
													for ($i=0; $i<count($XLSCol); $i++)
													{
													?>
													 <option value="XLS:<?php 
																	echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																	echo implode (',',array_slice($XLSCol[$i], 1));
																	echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
													<?php 
													} 
											   }
											}?>
									  </select>
									 
									  </div>
									</div>
									
									<div  id="YGroup" class="form-group" >
									  <label for="sel2" class="col-sm-3  control-label" id="y" >Y: </label>
									  <div class="col-sm-8" >
									  <select class="form-control" id="Y" name="Y[]" style="height:25px; width:100%; padding:0;">
										 <?php  
										 if ($xmlDoc->col[$col]->source=="ADatabase"){
												if (!empty($yaxis[0])){
														preg_match('~{col}([^{]*){/col}~i', $yaxis[0], $match);
														echo '<option value ="'.$yaxis[0].'">'.substr($yaxis[0],0,5).$match[1].'(1)</option>';
												}
												if (isset($_POST['query'])){										
												for ($x = 0; $x < $i ; $x++) { ?>
													<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
													echo '{data}';
													echo $sql;
													echo '{/data}';?>"><?php echo "SQL".$tbdsp.':'.$cols[$x]; ?></option>
												<?php
												}
												} 
											}?>
											
											<?php  
										    if ($xmlDoc->col[$col]->source=="upload"){
											if (file_exists($xmlDoc->col[$col]->file)) {
												if (!empty($yaxis[0])){
														preg_match('~{col}([^{]*){/col}~i', $yaxis[0], $match);
														echo '<option value ="'.$yaxis[0].'" selected="selected">'.$match[1].'</option>';
												}
													$i=0;
													for ($i=0; $i<count($XLSCol); $i++)
													{
													
													?>
													 <option value="XLS:<?php 
																	echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																	echo implode (',',array_slice($XLSCol[$i], 1));
																	echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
													<?php 
													} 
											   }
											}?>
									  </select>
									  </div>
									</div>
										
									<!-- Bubble size and text -->
									<div id="IDbubble">
									
									<div class="form-group" id="IDsize" style="display:none;">
									  <label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; ">Size:&nbsp; </label>
									  <div class="col-sm-8">
											   <!-- <input class="form-control input-sm" style="width:100%; margin-left:10px;" type="text" id="size" name="size[]" value="<?php //if(!empty($size[0])){echo $size[0];}?>" placeholder="20,30,40,50"  />  -->
									  			<select class="form-control" id="size" name="size[]"  style="height:25px; width:100%; padding:0;">
										 <?php  
										 if ($xmlDoc->col[$col]->source=="ADatabase"){
												if (!empty($size[0])){
														preg_match('~{col}([^{]*){/col}~i', $size[0], $match);
														echo '<option value ="'.$size[0].'">'.substr($size[0],0,5).$match[1].'</option>';
												}
												if (isset($_POST['query'])){										
												for ($x = 0; $x < $i ; $x++) { ?>
													<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
													echo '{data}';
													echo $sql;
													echo '{/data}';?>"><?php echo "SQL".$tbdsp.':'.$cols[$x]; ?></option>
												<?php
												}
												} 
											}?>
											
											<?php  
										    if ($xmlDoc->col[$col]->source=="upload"){
											if (file_exists($xmlDoc->col[$col]->file)) {
												if (!empty($size[0])){
														preg_match('~{col}([^{]*){/col}~i', $size[0], $match);
														echo '<option value ="'.$size[0].'" selected="selected">'.$match[1].'</option>';
												}
													$i=0;
													for ($i=0; $i<count($XLSCol); $i++)
													{
													
													?>
													 <option value="XLS:<?php 
																	echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																	echo implode (',',array_slice($XLSCol[$i], 1));
																	echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
													<?php 
													} 
											   }
											}?>
									  </select>
									  </div>
									</div>
									
									<div class="form-group" id="IDtext" style="display:none;">
									  <label id="TextLabel" class="col-sm-3 control-label" style="margin:0 -15px 0 15px; ">Text:&nbsp; </label>
									  <div class="col-sm-8">
											   <!-- <input class="form-control input-sm" style="width:100%; margin-left:10px;" type="text" id="text" name="text[]" value="<?php //if(!empty($text[0])){echo $text[0];}?>" placeholder="'Pizza 30%', 'Burger 44%', 'Orange 8%', 'Banana 12%'" />  -->
									 		<select class="form-control" id="text" name="text[]"  style="height:25px; width:100%; padding:0;">
											 <?php  
											 if ($xmlDoc->col[$col]->source=="ADatabase"){
													if (!empty($text[0])){
															preg_match('~{col}([^{]*){/col}~i', $text[0], $match);
															echo '<option value ="'.$text[0].'">'.substr($text[0],0,5).$match[1].'</option>';
													}
													if (isset($_POST['query'])){										
													for ($x = 0; $x < $i ; $x++) { ?>
														<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
														echo '{data}';
														echo $sql;
														echo '{/data}';?>"><?php echo "SQL".$tbdsp.':'.$cols[$x]; ?></option>
													<?php
													}
													} 
												}?>
												
												<?php  
												if ($xmlDoc->col[$col]->source=="upload"){
												if (file_exists($xmlDoc->col[$col]->file)) {
													if (!empty($text[0])){
															preg_match('~{col}([^{]*){/col}~i', $text[0], $match);
															echo '<option value ="'.$text[0].'" selected="selected">'.$match[1].'</option>';
													}
														$i=0;
														for ($i=0; $i<count($XLSCol); $i++)
														{
														
														?>
														 <option value="XLS:<?php 
																		echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																		echo implode (',',array_slice($XLSCol[$i], 1));																		
																		echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
														<?php 
														} 
												   }
												}?>
										  </select>
									  </div>
									</div>
									
									</div>
									<!-- Bubble size and text -->
									
									<!-- Map Type Starts -->
									
									<div class="form-group" id="IDmaptype" style="display:none; ">
									  <label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; ">Map:&nbsp; </label>
									  <div class="col-sm-8">
									  			<select class="form-control" id="maptype" name="maptype[]"  style="height:25px; width:100%; padding:0;">
													<option value="world" <?php if ($maptype=='world') {echo "selected";}?>>World</option>
													<option value="usa" <?php if ($maptype=='usa') {echo "selected";}?>>USA</option>
													<option value="africa" <?php if ($maptype=='africa') {echo "selected";}?>>Africa</option>
													<option value="asia" <?php if ($maptype=='asia') {echo "selected";}?>>Asia</option>
													<option value="europe" <?php if ($maptype=='europe') {echo "selected";}?>>Europe</option>
													<option value="north america" <?php if ($maptype=='north america') {echo "selected";}?>>North America</option>
													<option value="south america" <?php if ($maptype=='south america') {echo "selected";}?>>South America</option>
									  			</select>
									  </div>
									</div>
									
									<!-- Map Type Ends -->
									
									<div class="form-group" style="padding:0 15px; ">
									  <label class="col-sm-3 control-label">Legend:&nbsp; </label>
									  <div class="col-sm-8">
											   <input class="form-control input-sm" style="width:100%; margin-left:10px;" type="text" id="tracename" name="tracename[]" value="<?php if(!empty($tracename[0])) {echo $tracename[0];}?>" placeholder="Sales" /> 
									  </div>
									</div>

								 	<input type="hidden" id="sql" name="sql[]" value="<?php // echo $sqlvalue;?>" placeholder="<?php //echo $sqlvalue;?>"/> 
								
							</div> <!-- Drop level 1 -->
						</div>
					</li>
					
				</ul>
			</div><!-- /.navbar-collapse -->
			
			<!-- Dynamic Dropdown Tracing -->
			<?php 
			
			//if (!empty($_POST['X'])){			
			if (!empty($xaxis[1])){			
			$w=0;  // bypass 1st one
			 foreach($xaxis as $value){ 
			
			if (!empty($value) && ($w > 0)) { 
			
			?>
						<!-- Main Menu -->
			<div id="div-remove" class="side-menu-container">
				<ul class="nav navbar-nav">

					<!-- Dropdown-->
					<li class="active panel panel-default" id="dropdown">
					
						<!--<div class="setting-menu" style="background-color:#E5E5E5; width:100%; height:2em; padding:5px;" >-->
						<div class="setting-menu">
							<a data-toggle="collapse" href="#dropdown-chs<?php echo $w+1;?>" >
								<span class="fa fa-random"></span> Trace <?php echo $w+1;?> <span class="caret"></span>
							</a>
							
							<a href="javascript:void(0);" class="remove_button col-sm-offset-12" title="Remove field" style="color:#000000; float:right;margin-top:-15px;"> <span class="fa fa-minus-square-o" ></span></a>
							
						</div>
						<!-- Dropdown level 1 -->
						<div id="dropdown-chs<?php echo $w+1;?>" class="panel-collapse collapse">
							<div class="panel-body" style="padding: 0; padding-top:15px;">
								
									<div class="form-group XGroup2" >
									  <label for="sel2" class="col-sm-3  control-label x2">X: </label>
									  <div class="col-sm-8">
									  <select class="form-control" id="X" name="X[]"  style="height:25px; width:100%; padding:0;">
										<?php 
											if ($xmlDoc->col[$col]->source=="ADatabase"){
												if (!empty($xaxis)){
														preg_match('~{col}([^{]*){/col}~i', $xaxis[$w], $match);
														echo '<option value ="'.$xaxis[$w].'">'.substr($xaxis[$w],0,5).$match[1].'(1)</option>';
												}
												if (isset($_POST['query'])){				
												for ($x = 0; $x < $i ; $x++) { ?>
													<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
														echo '{data}';
														echo $sql;
														echo '{/data}';
														?>">
														<?php 
														echo "SQL".$tbdsp.':'.$cols[$x]; ?>
													</option>
												<?php
												}
												} 
											}?>
											
											<?php
											if ($xmlDoc->col[$col]->source=="upload"){
											if (file_exists($xmlDoc->col[$col]->file)) {
													if (!empty($xaxis[$w])){
															preg_match('~{col}([^{]*){/col}~i', $xaxis[$w], $match);
															echo '<option value ="'.$xaxis[$w].'" selected="selected">'.$match[1].'</option>';
													}
													$i=0;
													for ($i=0; $i<count($XLSCol); $i++)
													{
													
													?>
													 <option value="XLS:<?php 
																	echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																	echo implode (',',array_slice($XLSCol[$i], 1));
																	echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
													<?php 
													} 
											   }
											}?>
									  </select>
									 
									  </div>
									</div>
									
									<div  class="form-group YGroup2" >
									  <label for="sel2" class="col-sm-3  control-label y2" >Y: </label>
									  <div class="col-sm-8" >
									  <select class="form-control" id="Y" name="Y[]"   style="height:25px; width:100%; padding:0;">
										<?php  
										if ($xmlDoc->col[$col]->source=="ADatabase"){
												if (!empty($yaxis)){
														preg_match('~{col}([^{]*){/col}~i', $yaxis[$w], $match);
														echo '<option value ="'.$yaxis[$w].'">'.substr($yaxis[$w],0,5).$match[1].'(1)</option>';
												}
												if (isset($_POST['query'])){										
												for ($x = 0; $x < $i ; $x++) { ?>
													<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
														echo '{data}';
														echo $sql;
														echo '{/data}';
														?>">
														<?php 
														echo "SQL".$tbdsp.':'.$cols[$x]; ?>
													</option>
												<?php
												}
												}
											} ?>
											
											<?php
											if ($xmlDoc->col[$col]->source=="upload"){
											if (file_exists($xmlDoc->col[$col]->file)) {
													if (!empty($yaxis[$w])){
															preg_match('~{col}([^{]*){/col}~i', $yaxis[$w], $match);
															echo '<option value ="'.$yaxis[$w].'" selected="selected">'.$match[1].'</option>';
													}

													$i=0;
													for ($i=0; $i<count($XLSCol); $i++)
													{
													
													?>
													 <option value="XLS:<?php 
																	echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																	echo implode (',',array_slice($XLSCol[$i], 1));
																	echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
													<?php 
													} 
											   }
											}?>

									  </select>
									  </div>
									</div>
										
									<!-- Bubble size and text -->
									<div class="IDbubble2">
									
									<div class="form-group IDsize2" >
									  <label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; ">Size:&nbsp; </label>
									  <div class="col-sm-8">
											   <!-- <input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="size" name="size[]" value="<?php //if (!empty($size[$w])) {echo $size[$w];}?>" placeholder="20,30,40,50"  />  -->
											 <select class="form-control" id="size" name="size[]"  style="height:25px; width:100%; padding:0;">
												<?php 
													if ($xmlDoc->col[$col]->source=="ADatabase"){
														if (!empty($size)){
																preg_match('~{col}([^{]*){/col}~i', $size[$w], $match);
																echo '<option value ="'.$size[$w].'">'.substr($size[$w],0,5).$match[1].'</option>';
														}
														if (isset($_POST['query'])){				
														for ($x = 0; $x < $i ; $x++) { ?>
															<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
																echo '{data}';
																echo $sql;
																echo '{/data}';
																?>">
																<?php 
																echo "SQL".$tbdsp.':'.$cols[$x]; ?>
															</option>
														<?php
														}
														} 
													}?>
													
													<?php
													if ($xmlDoc->col[$col]->source=="upload"){
													if (file_exists($xmlDoc->col[$col]->file)) {
															if (!empty($size[$w])){
																	preg_match('~{col}([^{]*){/col}~i', $size[$w], $match);
																	echo '<option value ="'.$size[$w].'" selected="selected">'.$match[1].'</option>';
															}
															$i=0;
															for ($i=0; $i<count($XLSCol); $i++)
															{
															
															?>
															 <option value="XLS:<?php 
																			echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																			echo implode (',',array_slice($XLSCol[$i], 1));
																			echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
															<?php 
															} 
													   }
													}?>
											  </select>
									 
									  </div>
									</div>
									
									<div class="form-group IDtext2" >
									  <label class="col-sm-3 control-label TextLabel2" style="margin:0 -15px 0 15px; ">Text:&nbsp; </label>
									  <div class="col-sm-8">
											   <!-- <input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="text" name="text[]" value="<?php// if (!empty($text[$w])) {echo $text[$w];}?>" placeholder="'Pizza 30%', 'Burger 44%', 'Orange 8%', 'Banana 12%'" /> --> 
									 		<select class="form-control" id="text" name="text[]"  style="height:25px; width:100%; padding:0;">
												<?php 
													if ($xmlDoc->col[$col]->source=="ADatabase"){
														if (!empty($text)){
																preg_match('~{col}([^{]*){/col}~i', $text[$w], $match);
																echo '<option value ="'.$text[$w].'">'.substr($text[$w],0,5).$match[1].'</option>';
														}
														if (isset($_POST['query'])){				
														for ($x = 0; $x < $i ; $x++) { ?>
															<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
																echo '{data}';
																echo $sql;
																echo '{/data}';
																?>">
																<?php 
																echo "SQL".$tbdsp.':'.$cols[$x]; ?>
															</option>
														<?php
														}
														} 
													}?>
													
													<?php
													if ($xmlDoc->col[$col]->source=="upload"){
													if (file_exists($xmlDoc->col[$col]->file)) {
															if (!empty($text[$w])){
																	preg_match('~{col}([^{]*){/col}~i', $text[$w], $match);
																	echo '<option value ="'.$text[$w].'" selected="selected">'.$match[1].'</option>';
															}
															$i=0;
															for ($i=0; $i<count($XLSCol); $i++)
															{
															
															?>
															 <option value="XLS:<?php 
																			echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																			echo implode (',',array_slice($XLSCol[$i], 1));
																			echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
															<?php 
															} 
													   }
													}?>
											  </select>
									 
									 
									  </div>
									</div>
									
									</div>
									<!-- Bubble size and text -->
									
									<!-- Map Type Starts -->
									
									<div class="form-group IDmaptype2" style="display:none; ">
									  <label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; ">Map:&nbsp; </label>
									  <div class="col-sm-8">
									  			<select class="form-control" id="maptype" name="maptype[]"  style="height:25px; width:100%; padding:0;">
													<option value="world" selected>World</option>
													<option value="usa">USA</option>
													<option value="africa">Africa</option>
													<option value="asia">Asia</option>
													<option value="europe">Europe</option>
													<option value="north america">North America</option>
													<option value="south america">South America</option>
									  			</select>
									  </div>
									</div>
									
									<!-- Map Type Ends -->
									
									<div class="form-group" style="padding:0 15px; ">
									  <label class="col-sm-3 control-label">Legend:&nbsp; </label>
									  <div class="col-sm-8">
											   <input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="tracename" name="tracename[]" value="<?php if (!empty($tracename[$w])) {echo $tracename[$w];};?>" placeholder="Sales" /> 
									  </div>
									</div>

								 	<input type="hidden" id="sql" name="sql[]" value="<?php // echo $sqlvalue;?>" placeholder="<?php //echo $sqlvalue;?>"/> 						
								
							</div> <!-- Drop level 1 -->
						</div>
					</li>
					
				</ul>
			</div><!-- /.navbar-collapse -->
						<script>
						var t = document.getElementById("type").value;

							if ((t == 'bubble') || (t == 'map') || (t == 'heatmap')) { //Check if bubble is selected
							// don't do anything
							}
							else
							{
								var y = document.getElementsByClassName("IDbubble2");
								var i;
								for (i = 0; i < y.length; i++) {
									y[i].style.display = "none";
								}
							}

						</script>
					<?php
					
					}
					$w++;
				}
			}
			?>
			</div> <!-- End filed_wrapper -->								
			<!-- Dynamic Dropdown Tracking End -->

			<!-- Properties -->

			<div class="side-menu-container" >
				<ul class="nav navbar-nav" >
					
					<li class="active panel panel-default" id="dropdown">
					
						<!--<div class="setting-menu" style="background-color:#E5E5E5; width:100%; height:2em; padding:5px;" >-->
						<div class="setting-menu">
							<a data-toggle="collapse" href="#dropdown-properties">
								<span class="fa fa-sliders"></span> Properties <span class="caret"></span>
							</a>
								<div class="col-sm-offset-12" >
								   &nbsp;   
								</div>
						</div>
					
						<div id="dropdown-properties" class="panel-collapse collapse" style="padding:0 15px; ">
						<br/>
						<!-- Dropdown level 1 -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Caption:;</label> 
								<div class="col-sm-9" >
								   <input class="form-control input-sm"  type="text" id="title" name="title" value="<?php echo $title;?>" placeholder="Chart Title"/>    
								</div>
							</div>
				
							<div class="form-group">
								<label class="col-sm-3 control-label">Name:</label> 
								<div class="col-sm-9">
								   <input class="form-control input-sm" type="text" id="name" name="name" value="<?php echo $name;?>" placeholder="Pie1" size="10" />    
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">X-Title:</label> 
								<div class="col-sm-9">
								   <input class="form-control input-sm" type="text" id="xaxistitle" name="xaxistitle" value="<?php echo $xaxistitle;?>" placeholder="Sales"  />    
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Y-Title:</label> 
								<div class="col-sm-9">
								   <input class="form-control input-sm" type="text" id="yaxistitle" name="yaxistitle" value="<?php echo $yaxistitle;?>" placeholder="Products"  />    
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Height:</label> 
								<div class="col-sm-9">
								   
								
								<select class="form-control" id="height" name="height" value="<?php echo $height;?>" style="height:25px; width:100%; padding:0;" >
									<option value="" <?php if ($height==''){?> selected <?php }?>>Default</option>
									<option value="200" <?php if ($height=='200'){?> selected <?php }?>>200</option>
									<option value="250" <?php if ($height=='250'){?> selected <?php }?>>250</option>
									<option value="300" <?php if ($height=='300'){?> selected <?php }?>>300</option>
									<option value="350" <?php if ($height=='350'){?> selected <?php }?>>350</option>
									<option value="400" <?php if ($height=='400'){?> selected <?php }?>>400</option>
									<option value="450" <?php if ($height=='450'){?> selected <?php }?>>450</option>
									<option value="500" <?php if ($height=='500'){?> selected <?php }?>>500</option>
									<option value="550" <?php if ($height=='550'){?> selected <?php }?>>550</option>
									<option value="600" <?php if ($height=='600'){?> selected <?php }?>>600</option>
									<option value="650" <?php if ($height=='650'){?> selected <?php }?>>650</option>
									<option value="700" <?php if ($height=='700'){?> selected <?php }?>>700</option>
								</select>
								      
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Width:</label> 
								<div class="col-sm-9">
								   
								
								<select class="form-control" id="width" name="width" value="<?php echo $width;?>" style="height:25px; width:100%; padding:0;" >
									<option value="" <?php if ($width==''){?> selected <?php }?>>Default</option>
									<option value="200" <?php if ($width=='200'){?> selected <?php }?>>200</option>
									<option value="250" <?php if ($width=='250'){?> selected <?php }?>>250</option>
									<option value="300" <?php if ($width=='300'){?> selected <?php }?>>300</option>
									<option value="350" <?php if ($width=='350'){?> selected <?php }?>>350</option>
									<option value="400" <?php if ($width=='400'){?> selected <?php }?>>400</option>
									<option value="450" <?php if ($width=='450'){?> selected <?php }?>>450</option>
									<option value="500" <?php if ($width=='500'){?> selected <?php }?>>500</option>
									<option value="550" <?php if ($width=='550'){?> selected <?php }?>>550</option>
									<option value="600" <?php if ($width=='600'){?> selected <?php }?>>600</option>
									<option value="650" <?php if ($width=='650'){?> selected <?php }?>>650</option>
									<option value="700" <?php if ($width=='700'){?> selected <?php }?>>700</option>
								</select>
								      
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Grid:</label> 
								<div class="col-sm-offset-4">
									<div class="switch-field">
									  <input type="radio" id="showgrid_show" name="showgrid" value="true" <?php if ($showgrid=="true"){ echo 'checked';}?> />
									  <label for="showgrid_show">Show</label>
									  <input type="radio" id="showgrid_hide" name="showgrid" value="false" <?php if($showgrid=="false"){ echo 'checked';}?>  />
									  <label for="showgrid_hide">Hide</label>
									</div> 
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Lines:</label> 
								<div class="col-sm-offset-4">
									<div class="switch-field">
									  <input type="radio" id="showline_show" name="showline" value="true" <?php if($showline=="true"){ echo 'checked';}?> />
									  <label for="showline_show">Show</label>
									  <input type="radio" id="showline_hide" name="showline" value="false" <?php if($showline=="false"){ echo 'checked';}?>  />
									  <label for="showline_hide">Hide</label>
									</div> 
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Position:</label> 
								<div class="col-sm-offset-4">
									<div class="switch-field" >
									  <input type="radio" id="orientation_h" name="orientation" value="h" <?php if($orientation=="h"){ echo 'checked';}?> />
									  <label for="orientation_h">Horiz</label>
									  <input type="radio" id="orientation_v" name="orientation" value="v" <?php if($orientation=="v"){ echo 'checked';}?>  />
									  <label for="orientation_v">Vert</label>
									</div> 
								</div>
							</div>
							
							
						</div><!-- padding -->
						
						<!-- Drop Level 1 -->
						
					</li>
					
					<!-- Propoerties End -->
			</ul>
			
			</div>
			
			
			
		</nav>
		</div>
				
				<!-- Left Navi End -->
				
				
				</div>
				<div class="col-md-9">
					<?php 
					 if ($xmlDoc->col[$col]->source=='ADatabase'){ ?>
						<div class="panel panel-default">
							<div class="panel-body panel-resizable" style="height:200px; ">

								<ul class="nav nav-tabs">
										  <li <?php if (empty($tb)) {echo 'class="active"';}?> >
											  <div class="mtab">
												  <a data-toggle="tab" href="#tab1" id="myclick" onclick="tabvalue(1)"> &nbsp;&nbsp;  SQL 1    </a>      
												  &nbsp;&nbsp;<a href="javascript:void(0);" class="add-tab" title="Add SQL" > <span class="fa fa-plus-square-o" ></span></a>
											  </div>
										  </li>
										  <?php
										  
											if ($noofquery>1){									
											for ($x = 1; $x < $noofquery ; $x++) { ?>
											<li <?php if ($x==($tbdsp-1)) {echo 'class="active"';}?>  id="div-tabs-remove<?php echo $x+1;?>">
											  <div class="mtab">
												  <a data-toggle="tab" href="#tab<?php echo $x+1;?>" onclick="tabvalue(<?php echo $x+1;?>)"> &nbsp;&nbsp;  SQL <?php echo $x+1;?>    </a>      
												  &nbsp;&nbsp;<a href="javascript:void(0);" class="remove-tab" title="Remove field" > <span class="fa fa-minus-square-o" ></span></a>
											  </div>
										  	</li>
										  
											<?php }}
											?>
								  
								  <input type="hidden" id="tabs" name="tabs" value="<?php if(empty($tbdsp)) {echo '1';}else {echo $tbdsp;}?>" />
								  
								</ul>
				 
								<div class="col-md-8 tab-content">
										<div id="tab1" class="tab-pane fade in <?php if (empty($tb)) {echo 'active';}?> ">
											 <div class="form-group">											
											  <textarea class="form-control" rows="3" id="query1" name="query[]"  ><?php if (!empty($query[0])) { echo $query[0]; }?> </textarea>
											</div> 
											<!--<input id="submitForm" type="submit" class="btn btn-primary" value="Run Query"/>-->
											<button id="btnrunquery" type="submit" class="btn btn-primary" name="runquery" value="true">Run Query</button>
										</div>	
										
										
										<?php
										
											if ($noofquery>1) {
											
											for ($x = 1; $x < $noofquery ; $x++) { ?>
											
											<div id="tab<?php echo $x+1;?>" class="tab-pane fade in <?php if ($x==$tb) {echo 'active';}?> ">
											 <div class="form-group">											
											  <textarea class="form-control" rows="3" id="query<?php echo $x+1;?>" name="query[]"  ><?php  echo $query[$x];?> </textarea>
											</div> 
											<!--<input id="submitForm" type="submit" class="btn btn-primary" value="Run Query"/>-->
											<button type="submit" class="btn btn-primary" name="runquery" value="true">Run Query</button>
											</div>
										  
											<?php }}
											?>
								</div>
							
								
								<div class="col-md-4">
								<label for="table" style="font-size:9px;margin-top:-25px;">Tables from: <?php echo $xmlDoc->col[$col]->dbname;?></label>
								<?php 
	
	
										
								if ($xmlDoc->col[$col]->rdbms == 'sqlite'){
									$sql = "SELECT name  FROM sqlite_master WHERE type='table';";
								    }
									else if ($xmlDoc->col[$col]->rdbms == 'pgsql') {
										$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema='public'";
									}
									else {
										$sql = "SHOW TABLES FROM $DB_NAME";
								}
									
								?>
										<select class="form-control panel-body panel-resizable" id="table"  name="table" size="4" onchange="tableSelection()" style="font-size:0.8em; ">
										<?php
										if ($xmlDoc->col[$col]->dbconnected==1){ 
										foreach ($conn->query($sql) as $row) {
											echo '<option>'.$row[0].'</option>';
										}
										}?>
										</select>
								</div>
							</div>
						</div>
					<?php } // ADatabase Ends?>
					
						<div class="panel panel-default">
							<div class="panel-body panel-resizable" >
							<div class="table-responsive">
							
								<table id="tabledata" class="table table-bordered" style="font-size:0.8em; ">
								<thead style="background-color:#E5E5E5; font-weight:bold; ">
								  <tr>
								  <?php  
								  if ($xmlDoc->col[$col]->source=='ADatabase'){ 
										if (isset($_POST['query'])){
										//$sql = $_POST['query'] ;
										 $sql = $query[trim($_POST['tabs']) -1];
										if (!empty(trim($sql))) {?>
										<label for="table" style="font-size:9px;margin-top:-25px;">Showing SQL <?php echo $tb+1;?>: Result</label>
										<?php
										//$rs = $conn->query($sql);
										try{
											$rs = $conn->query($sql);
											for ($x = 0; $x < $rs->columnCount() ; $x++) {
												echo '<td style="line-height:0.5em;">'.$cols[$x].'</td>';
												}
											} catch(Exception $e){
													//echo $e;
													echo '<div class="alert alert-danger alert-dismissable">
													<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
													<strong>Error! Invalid Query </strong> '.$sql .
												  '</div>';
													
													}
										}}
								
								 }?>
								 
								  <?php  
								  if ($xmlDoc->col[$col]->source=='upload'){ 
									if (file_exists($xmlDoc->col[$col]->file)) {
										/*$filename = $xmlDoc->col[$col]->file;
										require('assets/class/excel_reader2.php');
										require('assets/class/SpreadsheetReader.php');
										$Reader = new SpreadsheetReader($filename);*/
										
										foreach ($Reader as $XLS)
										{
											foreach ($XLS as $HDS)
												{
													echo '<td style="line-height:0.5em;">'.$HDS.'</td>';
												}
											break;
										}
								   }
								 }
								 
								 ?>
								 
								 
								  </tr>
								</thead>
								<tbody>
								
								  
								  <?php 
								  if ($xmlDoc->col[$col]->source=='ADatabase'){ 
										  if (isset($_POST['query'])){
										  $lastSQL = $query[trim($_POST['tabs']) -1];
										  if (!empty(trim($lastSQL))) {
										        if (!empty($rs)) {
												  foreach ($rs as $row) {
												   echo '<tr>'; 
													for ($i =0; $i < $rs->columnCount(); $i++) {
														echo '<td style="line-height:0.5em;">'.$row[$i].'</td>';
													}
												   echo '</tr>';
												   }
												  }
											 }
										   }
								  }?>
								  
								  <?php
								  if ($xmlDoc->col[$col]->source=='upload'){ 
									if (file_exists($xmlDoc->col[$col]->file)) {
										/*$filename = $xmlDoc->col[$col]->file;
										require('assets/class/excel_reader2.php');
										require('assets/class/SpreadsheetReader.php');
										$Reader = new SpreadsheetReader($filename);*/
										$i=0;
										foreach ($Reader as $XLS)
										{
											if ($i>0){
											 echo '<tr>'; 
												foreach ($XLS as $HDS)
													{
														echo '<td style="line-height:0.5em;">'.$HDS.'</td>';
													}
											echo '</tr>';
											}
										$i++;
									   }
								   }
								 }?>
								  
								 </tbody>
								</table>
							</div>
							</div>
						</div>
				</div>
				</div>
				<!-- Navi End -->
			 </div>
			 
			 <div class="modal-footer">
			    <input type="hidden" name="col" value="<?php echo $request_col;?>" />
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:window.location.replace('<?php echo $url;?>')">Cancel</button>
				<input type="hidden" name="cleardata" id="cleardata" value="">
				<button type="submit" class="btn btn-success" name="clear" value="true" onclick="javascript:document.getElementById('cleardata').value='true';">Clear Data</button>
               	<button type="submit" class="btn btn-primary" name="save" value="true">Save changes</button>
            </div>
			
	  		</form>
			
			

</body>
</html>

<?php
function cleardata($col) {
	 // $xmlfile = 'data/layout'.$_GET['layout'].'.xml';
	 $xmlfile = '../data/data.xml';
	 $xmlDoc=simplexml_load_file($xmlfile);
	 $xmlDoc->col[$col]->type = "";
 
 	//initializing yaxis
	 unset($xmlDoc->col[$col]->xaxis);
	 $xmlDoc->col[$col]->addChild('xaxis', '');
	 
	 //initializing yaxis
     unset($xmlDoc->col[$col]->yaxis);
	 $xmlDoc->col[$col]->addChild('yaxis', '');


	 //initializing query.
	 unset($xmlDoc->col[$col]->sql);
	 $xmlDoc->col[$col]->addChild('sql', '');
	 
	  //initializing size..
	 unset($xmlDoc->col[$col]->size);
	 $xmlDoc->col[$col]->addChild('size', '');

	 //initializing text
	 unset($xmlDoc->col[$col]->text);
	 $xmlDoc->col[$col]->addChild('text', '');
	 
	  //initializing maptype
	 unset($xmlDoc->col[$col]->maptype);
	 $xmlDoc->col[$col]->addChild('maptype', '');
	 
	 //initializing text
	 unset($xmlDoc->col[$col]->text);
	 $xmlDoc->col[$col]->addChild('text', '');
	
	  //initializing tracename
	 unset($xmlDoc->col[$col]->tracename);
	 $xmlDoc->col[$col]->addChild('tracename', '');
	 

	 $xmlDoc->col[$col]->title = "";
	 $xmlDoc->col[$col]->name = "";
	 if (empty($xmlDoc->col[$col]->name)){
	 	$xmlDoc->col[$col]->name = "";
	}
	
	 $xmlDoc->col[$col]->xaxistitle = "";
	 $xmlDoc->col[$col]->yaxistitle = "";
	 $xmlDoc->col[$col]->height ="";
	 $xmlDoc->col[$col]->width = "";
	 $xmlDoc->col[$col]->showgrid = "";
	 $xmlDoc->col[$col]->showline = "";
	 
	 $xmlDoc->col[$col]->orientation = "";
	 
	 $xmlDoc->col[$col]->source = "";
	 $xmlDoc->col[$col]->servername = "";
	 $xmlDoc->col[$col]->username = "";
	 $xmlDoc->col[$col]->dbname = ""; 
	 $xmlDoc->col[$col]->password = "";
	 $xmlDoc->col[$col]->rdbms = "";
	 $xmlDoc->col[$col]->file = "";
	 $xmlDoc->col[$col]->source = "";
	 $xmlDoc->col[$col]->dbconnected = "";

	 $xmlDoc->asXML($xmlfile);

}


function savedata($col) {
	// $xmlfile = 'data/layout'.$_GET['layout'].'.xml';
	 $xmlfile = '../data/data.xml';
	 $xmlDoc=simplexml_load_file($xmlfile);
	 $xmlDoc->col[$col]->type = $_POST['type'];
 

	 //initializing yaxis
	 unset($xmlDoc->col[$col]->xaxis);
	 $xmlDoc->col[$col]->addChild('xaxis', '');
	 
	 //initializing yaxis
     unset($xmlDoc->col[$col]->yaxis);
	 $xmlDoc->col[$col]->addChild('yaxis', '');


	 //initializing query.
	 unset($xmlDoc->col[$col]->sql);
	 $xmlDoc->col[$col]->addChild('sql', '');
	 
	  //initializing size..
	 unset($xmlDoc->col[$col]->size);
	 $xmlDoc->col[$col]->addChild('size', '');

	 //initializing text
	 unset($xmlDoc->col[$col]->text);
	 $xmlDoc->col[$col]->addChild('text', '');
	 
	  //initializing maptype
	 unset($xmlDoc->col[$col]->maptype);
	 $xmlDoc->col[$col]->addChild('maptype', '');
	 
	 //initializing text
	 unset($xmlDoc->col[$col]->text);
	 $xmlDoc->col[$col]->addChild('text', '');
	
	  //initializing tracename
	 unset($xmlDoc->col[$col]->tracename);
	 $xmlDoc->col[$col]->addChild('tracename', '');
	
	 
	 $i=0;
	 if (!empty($_POST['X'])){
	 foreach($_POST['X'] as $value){
	 $xmlDoc->col[$col]->xaxis[$i] = $value;
	  $i++;
	 }
	 }

	 
	$i=0;
	if (!empty($_POST['Y'])){
	 foreach($_POST['Y'] as $value){
	 $xmlDoc->col[$col]->yaxis[$i] = $value;
	  $i++;
	 }
	 }
	 
	 
	 if (!empty($_POST['query'])){
	 $i=0;
	 foreach($_POST['query'] as $value){
      $xmlDoc->col[$col]->sql[$i] = $value;
	  $i++;
	 }
	 }
	 

	 if ($_POST['type']=='bubble'){
		 $i=0;
		 foreach($_POST['size'] as $value){
		  $xmlDoc->col[$col]->size[$i] = $value;
		  $i++;
		 }
	 }
	 

	
	if (($_POST['type']=='bubble') ||  ($_POST['type']=='heatmap')){
		 $i=0;
		 foreach($_POST['text'] as $value){
		  $xmlDoc->col[$col]->text[$i] = $value;
		  $i++;
		 }
	 }
	 
	 if ($_POST['type']=='map'){
		 $i=0;
		 foreach($_POST['text'] as $value){
		  $xmlDoc->col[$col]->text[$i] = $value;
		  $i++;
		 }
		 $i=0;
		 foreach($_POST['maptype'] as $value){
		  $xmlDoc->col[$col]->maptype[$i] = $value;
		  $i++;
		 }
	 }
	 
	 if (!empty($_POST['tracename'])){
	  $i=0;
	 foreach($_POST['tracename'] as $value){
      $xmlDoc->col[$col]->tracename[$i] = $value;
	  $i++;
	 }}
	 
	 $xmlDoc->col[$col]->title = $_POST['title'];
	 $xmlDoc->col[$col]->name = $_POST['name'];
	 if (empty($xmlDoc->col[$col]->name)){
	 	$xmlDoc->col[$col]->name = $col;
	}
	 $xmlDoc->col[$col]->xaxistitle = $_POST['xaxistitle'];
	 $xmlDoc->col[$col]->yaxistitle = $_POST['yaxistitle'];
	 $xmlDoc->col[$col]->height = $_POST['height'];
	 $xmlDoc->col[$col]->width = $_POST['width'];
	 $xmlDoc->col[$col]->showgrid = $_POST['showgrid'];
	 $xmlDoc->col[$col]->showline = $_POST['showline'];
	 
	 $xmlDoc->col[$col]->orientation = $_POST['orientation'];
	  
	 $xmlDoc->asXML($xmlfile);
}


function dbc (){
			global $xmlDoc,  $col, $conn, $DB_NAME, $folder;

			if (!isset ($xmlDoc->col[$col]->rdbms)) {
				$xmlDoc->col[$col]->source = $xmlDoc->col[0]->source;
				$xmlDoc->col[$col]->rdbms = $xmlDoc->col[0]->rdbms;
	 			$xmlDoc->col[$col]->servername  = $xmlDoc->col[0]->servername ;
	 			$xmlDoc->col[$col]->ssl = $xmlDoc->col[0]->ssl;
	 			$xmlDoc->col[$col]->username = $xmlDoc->col[0]->username ;
	 			$xmlDoc->col[$col]->password = $xmlDoc->col[0]->password;
	 			$xmlDoc->col[$col]->dbname = $xmlDoc->col[0]->dbname;
				$xmlDoc->col[$col]->dbconnected = $xmlDoc->col[0]->dbconnected ;
				$xmlDoc->col[$col]->file = $xmlDoc->col[0]->file;
			    $xmlDoc->asXML($folder.'data/data.xml');
			}
			
						if ($xmlDoc->col[$col]->dbconnected=='1'){
			$DB_TYPE = $xmlDoc->col[$col]->rdbms; //Type of database<br>
			$DB_HOST = $xmlDoc->col[$col]->servername; //Host name<br>
			$DB_USER = $xmlDoc->col[$col]->username; //Host Username<br>
			$DB_PASS = $xmlDoc->col[$col]->password; //Host Password<br>
			$DB_NAME = $xmlDoc->col[$col]->dbname; //Database name<br><br>


			$SERVER='host=';
			$DATABASE='dbname=';
			
			if ($DB_TYPE=='sqlsrv') {
				$SERVER='Server=';
				$DATABASE='Database=';
			}

			try{
					if ($DB_TYPE=='sqlite'){
						$conn = new PDO("$DB_TYPE:$DB_NAME");
					}
					else {
						$conn = new PDO("$DB_TYPE:host=$DB_HOST; dbname=$DB_NAME;", $DB_USER, $DB_PASS);
					}
				} catch(Exception $e){
					//echo $e;
					echo '<div class="alert alert-danger alert-dismissable">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Error! Invalid Database Connection </strong> '.$DB_TYPE .
									  '</div>';
					return;
					
					}

				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} // end if (!$xmlDoc->col[$col]->db=='')
			
			
}

?>

<script>
function mySelection() {
    var x = document.getElementById("type").value;
	
	document.getElementById('XGroup').style.display="block";
	document.getElementById('YGroup').style.display="block";
	document.getElementById("TextLabel").innerHTML = "Text : ";
	document.getElementById('IDbubble').style.display="block";
	
	
	var y = document.getElementsByClassName("XGroup2");
	var y2 = document.getElementsByClassName("YGroup2");
	var y3 = document.getElementsByClassName("TextLabel2");
	var y4 = document.getElementsByClassName("IDsize2");
	var y5 = document.getElementsByClassName("IDtext2");
		var i;
		for (i = 0; i < y3.length; i++) {
			y[i].style.display = "block";
			y2[i].style.display = "block";
			y3[i].innerText = "Text : ";
			y4[i].style.display = "block";
			y5[i].style.display = "block";
	} 
	
	if(x == 'bubble'){ //Check if bubble is selected
	 		document.getElementById('IDbubble').style.display="block";
			document.getElementById('IDsize').style.display="block";
			document.getElementById('IDtext').style.display="block";

			var y = document.getElementsByClassName("IDsize2");
			var y2 = document.getElementsByClassName("IDtext2");
					var i;
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "block";
						y2[i].style.display = "block";
					} 
	}
			
	 if (x =='heatmap') { //Check if country map or heatmap is selected
			document.getElementById('IDtext').style.display="block";
			document.getElementById('IDsize').style.display="none";
			
			var y = document.getElementsByClassName("IDtext2");
			var y2 = document.getElementsByClassName("IDsize2");
			
					var i;
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "block";
						y2[i].style.display = "none";
					} 
	}
	
	if (x == 'map' ) {
		document.getElementById('IDtext').style.display="block";
		document.getElementById('IDsize').style.display="none";
		document.getElementById("x").innerHTML = "Loc : ";
		document.getElementById("y").innerHTML = "Z : ";
		document.getElementById('IDmaptype').style.display="block";
		
			var y1 = document.getElementsByClassName("x2");
			var y2 = document.getElementsByClassName("y2");
			var y3 = document.getElementsByClassName("IDtext2");
			var y4 = document.getElementsByClassName("IDsize2");
			var y5 = document.getElementsByClassName("IDmaptype2");
			
					var i;
					for (i = 0; i < y1.length; i++) {
						y1[i].innerHTML = "Loc: ";
						y2[i].innerHTML = "Z : ";
						y3[i].style.display = "block";
						y4[i].style.display = "none";
						y5[i].style.display = "block";
					} 
		}
		else 
		{
		document.getElementById("x").innerHTML = "X : ";
		document.getElementById("y").innerHTML = "Y : ";
		document.getElementById('IDmaptype').style.display="none";
			var y = document.getElementsByClassName("x2");
			var y2 = document.getElementsByClassName("y2");
			var y3 = document.getElementsByClassName("IDmaptype2");
			
					var i;
					for (i = 0; i < y.length; i++) {
						y[i].innerHTML = "X : ";
						y2[i].innerHTML = "Y : ";
						y3[i].style.display = "none";
					} 
	}
			
	if (x == 'heatmap') {
	
					//document.getElementById('XGroup').style.display="none";
					//document.getElementById('YGroup').style.display="none";
					document.getElementById("TextLabel").innerHTML = "Z : ";
					
					var y = document.getElementsByClassName("XGroup2");
					var y2 = document.getElementsByClassName('YGroup2');
					var y3 = document.getElementsByClassName("TextLabel2");
							//document.getElementsByClassName("TextLabel2").innerText = "Z : ";
						var i;
						for (i = 0; i < y3.length; i++) {
							y[i].style.display = "none";
							y2[i].style.display = "none";
							y3[i].innerText = "Z : ";
					} 

	}
			//
		
     if (!((x == 'bubble') || (x == 'map') || (x =='heatmap'))) {
			document.getElementById('IDbubble').style.display="none";
			
			var y = document.getElementsByClassName("IDsize2");
			var y2 = document.getElementsByClassName("IDtext2");
					var i;
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "none";
						y2[i].style.display = "none";
					};
			
			document.getElementById('XGroup').style.display="block";
			document.getElementById('YGroup').style.display="block";
			document.getElementById("TextLabel").innerHTML = "Text : ";
			

     }
	 
	 
	 //KPI
	 if (x == 'kpi') {
	
					document.getElementById('x').innerHTML="KPI";
					document.getElementById('YGroup').style.display="none";			
					document.getElementById("add_trace").style.display="none";
	   } else {
		   document.getElementById("add_trace").style.display="block";
	   }
		
}
</script>

<script>
function tabvalue(tabvalue) {
	document.getElementById("tabs").value = tabvalue;
}

function tableSelection() {
var x = document.getElementById("table").value;
var queryid = 'query'+ document.getElementById("tabs").value;

document.getElementById(queryid).value = "SELECT * FROM  " + x + " LIMIT 10;";	

}
</script>

<script>

$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
   // var x = 1; //Initial field counter is 1
    var x = <?php if (!empty($w)){echo $w;}else {echo '1' ;}?>;
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
	
	$(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
			var fieldHTML = '<div id="div-remove" class="side-menu-container" ><ul class="nav navbar-nav"><li class="active panel panel-default" id="dropdown">';		
				fieldHTML = fieldHTML + '<div class="setting-menu">';
				fieldHTML = fieldHTML + '<a data-toggle="collapse" href="#dropdown-chs'+x+'" > ';
				fieldHTML = fieldHTML + '<span class="fa fa-random"></span> Trace <span id="trno">' + x +'</span> <span class="caret"></span>';
				fieldHTML = fieldHTML + '</a>';
				fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button col-sm-offset-12" title="Del field" style="color:#000000; float:right;margin-top:-15px;"> <span class="fa fa-minus-square-o" ></span></a>';
				fieldHTML = fieldHTML + '<span class="col-lg-12"></span>';
				fieldHTML = fieldHTML + '</div>';
				fieldHTML = fieldHTML + '<div id="dropdown-chs'+x+'" class="panel-collapse collapse">';
				fieldHTML = fieldHTML + '<div class="panel-body" style="padding: 0; padding-top:15px;">';
				
				fieldHTML = fieldHTML + '<div class="form-group XGroup2" >';
				fieldHTML = fieldHTML + '<label for="sel2" class="col-sm-3  control-label x2">X: </label>';
				fieldHTML = fieldHTML + '<div class="col-sm-8">';
				fieldHTML = fieldHTML + '<select class="form-control" id="X" name="X[]" style="height:25px; width:100%; padding:0;">';
				
						<?php 
						if ($xmlDoc->col[$col]->source=="ADatabase"){
						if (!empty($xaxis[0])){ 
								 preg_match('~{col}([^{]*){/col}~i', $xaxis[0], $match);
								?>
								 fieldHTML = fieldHTML +  '<option value="<?php echo $xaxis[0];?>"><?php echo substr($xaxis[0],0,5).$match[1];?></option>';
								<?php 
						}
				
						if (isset($_POST['query'])){
							for ($x = 0; $x < $i ; $x++) { ?>
								 fieldHTML = fieldHTML +  '<option value="SQL<?php echo $tbdsp;?>:{col}<?php echo $cols[$x];?>';
								 fieldHTML = fieldHTML + '{/col}{data}';
								 fieldHTML = fieldHTML + "<?php echo $sql;?>";
								 fieldHTML = fieldHTML + '{/data}';
								 fieldHTML = fieldHTML + '">';
								 fieldHTML = fieldHTML + '<?php echo "SQL".$tbdsp.':'.$cols[$x]; ?>';
								 fieldHTML = fieldHTML +  '</option>';
						<?php } }};?>
						
						<?php 
						if ($xmlDoc->col[$col]->source=="upload"){
							if (file_exists($xmlDoc->col[$col]->file)) {
									$i=0;
									for ($i=0; $i<count($XLSCol); $i++)
									{
									?>
									 fieldHTML = fieldHTML + '<option value="XLS:';
									 fieldHTML = fieldHTML + '{col}<?php echo $XLSCol[$i][0];?>{/col}{data}';
									 fieldHTML = fieldHTML + '<?php echo implode (",",array_slice($XLSCol[$i], 1));?>';
									 fieldHTML = fieldHTML + '{/data}"><?php echo $XLSCol[$i][0];?></option>';
									<?php 
									} 
							   }
						};?>

				fieldHTML = fieldHTML + '</select>';
				fieldHTML = fieldHTML + '</div></div>';
				fieldHTML = fieldHTML + '<div class="form-group YGroup2" >';
				fieldHTML = fieldHTML + '<label for="sel2" class="col-sm-3  control-label y2" >Y: </label>';
				fieldHTML = fieldHTML + '<div class="col-sm-8" >';
				fieldHTML = fieldHTML + '<select class="form-control" id="Y" name="Y[]" style="height:25px; width:100%; padding:0;">';
				
						<?php 
						if ($xmlDoc->col[$col]->source=="ADatabase"){
						if (!empty($yaxis[0])){
								 preg_match('~{col}([^{]*){/col}~i', $yaxis[0], $match);
								?>
								 fieldHTML = fieldHTML +  '<option value="<?php echo $yaxis[0];?>"><?php echo substr($yaxis[0],0,5).$match[1];?></option>';
								<?php 
						}
				
						if (isset($_POST['query'])){
							for ($x = 0; $x < $i ; $x++) { ?>
								 fieldHTML = fieldHTML +  '<option value="SQL<?php echo $tbdsp;?>:{col}<?php echo $cols[$x];?>';
								 fieldHTML = fieldHTML + '{/col}{data}';
								 fieldHTML = fieldHTML + "<?php echo $sql;?>";
								 fieldHTML = fieldHTML + '{/data}';
								 fieldHTML = fieldHTML + '">';
								 fieldHTML = fieldHTML + '<?php echo "SQL".$tbdsp.':'.$cols[$x]; ?>';
								 fieldHTML = fieldHTML +  '</option>';
						<?php }} };?>
						
						<?php 
						if ($xmlDoc->col[$col]->source=="upload"){
							if (file_exists($xmlDoc->col[$col]->file)) {
									$i=0;
									for ($i=0; $i<count($XLSCol); $i++)
									{
									?>
									 fieldHTML = fieldHTML + '<option value="XLS:';
									 fieldHTML = fieldHTML + '{col}<?php echo $XLSCol[$i][0];?>{/col}{data}';
									 fieldHTML = fieldHTML + '<?php echo implode (",",array_slice($XLSCol[$i], 1));?>';
									 fieldHTML = fieldHTML + '{/data}"><?php echo $XLSCol[$i][0];?></option>';
									<?php 
									} 
							   }
						};?>
						
				fieldHTML = fieldHTML + '</select>';
				fieldHTML = fieldHTML + '</div></div>';
				
				<!-- Bubble size and text -->
				
					fieldHTML = fieldHTML +  '<div class="IDbubble2">';
									
					fieldHTML = fieldHTML +  '<div class="form-group IDsize2" >';
					fieldHTML = fieldHTML +  '<label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; ">Size:&nbsp; </label>';
					fieldHTML = fieldHTML +  '<div class="col-sm-8">';
					//fieldHTML = fieldHTML +  '<input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="size" name="size[]" value="" placeholder="20,30,40,50"  /> ';
					fieldHTML = fieldHTML + '<select class="form-control" id="size" name="size[]"  style="height:25px; width:100%; padding:0;">';
				
						<?php 
						if ($xmlDoc->col[$col]->source=="ADatabase"){
						if (!empty($size[0])){ 
								 preg_match('~{col}([^{]*){/col}~i', $size[0], $match);
								?>
								 fieldHTML = fieldHTML +  '<option value="<?php echo $size[0];?>"><?php echo substr($size[0],0,5).$match[1];?></option>';
								<?php 
						}
				
						if (isset($_POST['query'])){
							for ($x = 0; $x < $i ; $x++) { ?>
								 fieldHTML = fieldHTML +  '<option value="SQL<?php echo $tbdsp;?>:{col}<?php echo $cols[$x];?>';
								 fieldHTML = fieldHTML + '{/col}{data}';
								 fieldHTML = fieldHTML + "<?php echo $sql;?>";
								 fieldHTML = fieldHTML + '{/data}';
								 fieldHTML = fieldHTML + '">';
								 fieldHTML = fieldHTML + '<?php echo "SQL".$tbdsp.':'.$cols[$x]; ?>';
								 fieldHTML = fieldHTML +  '</option>';
						<?php } }};?>
						
						<?php 
						if ($xmlDoc->col[$col]->source=="upload"){
							if (file_exists($xmlDoc->col[$col]->file)) {
									$i=0;
									for ($i=0; $i<count($XLSCol); $i++)
									{
									?>
									 fieldHTML = fieldHTML + '<option value="XLS:';
									 fieldHTML = fieldHTML + '{col}<?php echo $XLSCol[$i][0];?>{/col}{data}';
									 fieldHTML = fieldHTML + '<?php echo implode (",",array_slice($XLSCol[$i], 1));?>';
									 fieldHTML = fieldHTML + '{/data}"><?php echo $XLSCol[$i][0];?></option>';
									<?php 
									} 
							   }
						};?>

					fieldHTML = fieldHTML + '</select>';
			
					fieldHTML = fieldHTML +  '</div></div>';
										
					fieldHTML = fieldHTML +  '<div class="form-group IDtext2" >';
					fieldHTML = fieldHTML +  '<label class="col-sm-3 control-label TextLabel2" style="margin:0 -15px 0 15px; ">Text:&nbsp; </label>'
					fieldHTML = fieldHTML +  '<div class="col-sm-8">'
					//fieldHTML = fieldHTML +  '<input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="text" name="text[]" value="" placeholder="Pizza 30%, Burger 44%, Orange 8%, Banana 12%" /> ';
					fieldHTML = fieldHTML + '<select class="form-control" id="text" name="text[]"  style="height:25px; width:100%; padding:0;">';
				
						<?php 
						if ($xmlDoc->col[$col]->source=="ADatabase"){
						if (!empty($text[0])){ 
								 preg_match('~{col}([^{]*){/col}~i', $text[0], $match);
								?>
								 fieldHTML = fieldHTML +  '<option value="<?php echo $text[0];?>"><?php echo substr($text[0],0,5).$match[1];?></option>';
								<?php 
						}
				
						if (isset($_POST['query'])){
							for ($x = 0; $x < $i ; $x++) { ?>
								 fieldHTML = fieldHTML +  '<option value="SQL<?php echo $tbdsp;?>:{col}<?php echo $cols[$x];?>';
								 fieldHTML = fieldHTML + '{/col}{data}';
								 fieldHTML = fieldHTML + "<?php echo $sql;?>";
								 fieldHTML = fieldHTML + '{/data}';
								 fieldHTML = fieldHTML + '">';
								 fieldHTML = fieldHTML + '<?php echo "SQL".$tbdsp.':'.$cols[$x]; ?>';
								 fieldHTML = fieldHTML +  '</option>';
						<?php } }};?>
						
						<?php 
						if ($xmlDoc->col[$col]->source=="upload"){
							if (file_exists($xmlDoc->col[$col]->file)) {
									$i=0;
									for ($i=0; $i<count($XLSCol); $i++)
									{
									?>
									 fieldHTML = fieldHTML + '<option value="XLS:';
									 fieldHTML = fieldHTML + '{col}<?php echo $XLSCol[$i][0];?>{/col}{data}';
									 fieldHTML = fieldHTML + '<?php echo implode (",",array_slice($XLSCol[$i], 1));?>';
									 fieldHTML = fieldHTML + '{/data}"><?php echo $XLSCol[$i][0];?></option>';
									<?php 
									} 
							   }
						};?>

					fieldHTML = fieldHTML + '</select>';
					
					
					
					fieldHTML = fieldHTML +  '</div></div>';
					fieldHTML = fieldHTML +  '</div>';
				
									<!-- Bubble size and text -->
									
									<!-- Map Type Starts -->
									
					fieldHTML = fieldHTML +  '<div class="form-group IDmaptype2" style="display:none; ">';
					  fieldHTML = fieldHTML +  '<label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; ">Map:&nbsp; </label>';
					  fieldHTML = fieldHTML +  '<div class="col-sm-8">';
								fieldHTML = fieldHTML +  '<select class="form-control" id="maptype" name="maptype[]"  style="height:25px; width:100%; padding:0;">';
									fieldHTML = fieldHTML +  '<option value="world" selected>World</option>';
									fieldHTML = fieldHTML +  '<option value="usa">USA</option>';
									fieldHTML = fieldHTML +  '<option value="africa">Africa</option>';
									fieldHTML = fieldHTML +  '<option value="asia">Asia</option>';
									fieldHTML = fieldHTML +  '<option value="europe">Europe</option>';
									fieldHTML = fieldHTML +  '<option value="north america">North America</option>';
									fieldHTML = fieldHTML +  '<option value="south america">South America</option>';
								fieldHTML = fieldHTML +  '</select>';
					  fieldHTML = fieldHTML +  '</div>';
					fieldHTML = fieldHTML +  '</div>';
									
									<!-- Map Type Ends -->
				
				fieldHTML = fieldHTML + '<div class="form-group" style="padding:0 15px; ">';
				fieldHTML = fieldHTML + '<label class="col-sm-3 control-label">Legend:&nbsp; </label>';
				fieldHTML = fieldHTML + '<div class="col-sm-7">';
				fieldHTML = fieldHTML + '<input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="tracename" name="tracename[]" value="" placeholder="Sales" /> ';
				fieldHTML = fieldHTML + '</div>';
				fieldHTML = fieldHTML + '</div>';
				
				fieldHTML = fieldHTML + '</div></div></li></ul></div>';
				
  
            $(wrapper).append(fieldHTML); // Add field html
			
			mySelection();
	
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();	
		document.getElementById("div-remove").remove();
        x--; //Decrement field counter
		document.getElementById("trno").innerHTML = x;
    });
	
	 $('#div-remove').on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();	
		document.getElementById("div-remove").remove();
        x--; //Decrement field counter
		document.getElementById("trno").innerHTML = x;
    });

	/* SQL Buttons */
	var maxSQL = 10; //Input fields increment limitation
    var s = <?php echo $noofquery;?> ; //Initial field counter is 1
    var addSQLButton = $('.add-tab'); //Add button selector
    var sqlwrapper = $('.tab-content'); //Input field wrapper
	var tabsinput = $('.nav-tabs');
	
	$(addSQLButton).click(function(){ //Once add button is clicked
	
        if(s < maxSQL){ //Check maximum number of input fields
            s++; //Increment field counter
			   var SQLfieldHTML = '<li id="div-tabs-remove'+s+'">';
				   SQLfieldHTML = SQLfieldHTML + '<div class="mtab">';
				   SQLfieldHTML = SQLfieldHTML + '<a data-toggle="tab" href="#tab'+s+'" onclick="tabvalue('+s+')"> &nbsp;&nbsp;  SQL '+s+'    </a>  ';    
				   SQLfieldHTML = SQLfieldHTML + '&nbsp;&nbsp;<a href="javascript:void(0);" class="remove-tab" title="Remove field" > <span class="fa fa-minus-square-o" ></span></a>';
				   SQLfieldHTML = SQLfieldHTML + '</div>';
				   SQLfieldHTML = SQLfieldHTML + '</li>';
			       $(tabsinput).append(SQLfieldHTML); // Add field html
				   
				   
				   SQLfieldHTML = '<div id="tab'+s+'" class="tab-pane fade in">';
				   SQLfieldHTML = SQLfieldHTML +  '<div class="form-group">';
				   SQLfieldHTML = SQLfieldHTML +  '<textarea class="form-control" rows="3" id="query'+s+'" name="query[]"  > </textarea>';
				   SQLfieldHTML = SQLfieldHTML +  '</div>';
				   SQLfieldHTML = SQLfieldHTML +  '<button type="submit" class="btn btn-primary" name="runquery" value="true">Run Query</button>';
				   SQLfieldHTML = SQLfieldHTML +  '</div>';	
			       $(sqlwrapper).append(SQLfieldHTML); // Add field html
			   
			
			  }
    });
		     
			$(tabsinput).on('click', '.remove-tab', function(e){ //Once remove button is clicked
				e.preventDefault();	
				var tabsremove = 'div-tabs-remove'+s;
				document.getElementById(tabsremove).remove();
				var tabno = 'tab'+s;
				document.getElementById(tabno).remove();
				document.getElementById("query1").focus();
				var l = document.getElementById('myclick');
  				l.click();
				s--; //Decrement field counter			
			});
			
		
});

</script>

<script>

$('#layoutsetting').submit(function() {
    $('.se-pre-modal').show();
});
</script>


<?php 
if (($type=='bubble') || ($type=='map') || ($type=='heatmap') || ($type=='kpi') ){ //Check if bubble is selected 
?> 
		<script>
			mySelection();
		</script>
<?php 
}

if (empty($_POST['query'])){
	if(!empty($query[0])) {?>
	<script>
			document.getElementById("query1").focus();
			var l = document.getElementById('myclick');
  			l.click();
			var l = document.getElementById('btnrunquery');
  			l.click();
	</script>
	<?php	
	}
}
?>