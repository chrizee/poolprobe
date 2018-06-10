<?php
$url =  $_SERVER['REQUEST_URI']; 
$folder ="..".DIRECTORY_SEPARATOR;
$col = (int) $_POST['col'];
if (isset($_GET['task'])) {
if ($_GET["task"]=='save'){
savedataDB($col);
header('Location: ' . $_SERVER["HTTP_REFERER"] );
}
}
	

?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Data Source setting</title> 
<script>
		document.getElementById('fileToUpload').required = false;
		$('#fileToUpload').get(0).setCustomValidity('');
</script>  


 <!-- Modal -->
 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
                 <h4 class="modal-title">Data Source Settings</h4>
            </div>			<!-- /modal-header -->
			<?php 
			

			
			$xmlDoc=simplexml_load_file($folder.'data/data.xml');
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
			
			$rdbms = $xmlDoc->col[$col]->rdbms;
			
			$title = $xmlDoc->col[$col]->title;			
			?>

			<form id="dbsetting" class="form-horizontal" enctype="multipart/form-data" action="dbsetting.php?task=save&layout=1&col=<?php echo $_POST['col'];?>" method="post" onsubmit="return validateForm();">
			<fieldset>
			 </br>
			
			<div class="modal-body">
			
			<!-- Tab Panel starts -->
			<ul class="nav nav-tabs">
			<?php
			$dbTabActive = "active";
			$xlTabActive = "";
			 if ($xmlDoc->col[$col]->dbconnected== '1'){
				  $dbTabActive = "active";
				  $xlTabActive = "";
				}
		
				if ($xmlDoc->col[$col]->source== 'upload'){
					if (file_exists($xmlDoc->col[$col]->file)) {
						$dbTabActive = "";
				  		$xlTabActive = "active";
					}
				}
			?>
			  <li class="<?php echo $dbTabActive;?>"><a data-toggle="tab" href="#home" onclick="tabvalue('ADatabase');">&nbsp;&nbsp;&nbsp;&nbsp; Database &nbsp;&nbsp;&nbsp;&nbsp;</a></li>
			  <li class="<?php echo $xlTabActive;?>"><a data-toggle="tab" id="xltabid" href="#menu1" onclick="tabvalue('upload');">   Upload</a></li>
			 <!-- <li><a data-toggle="tab" href="#menu2"  onclick="tabvalue('url')">   URL</a></li>-->
			  <input type="hidden" id="source" name="source" value="ADatabase" />
			</ul>

			<div class="tab-content">
			<!-- Tab for Data Source -->
			  <div id="home" class="tab-pane fade in <?php echo $dbTabActive;?>">

			  		<p>&nbsp;</p>
					<div id="Database" >
					<!-- Database connection -->
						<label  class="col-sm-3 control-label">Database:</label>
						  <div class="col-sm-8" >
						  <select class="form-control" id="rdbms" name="rdbms" value="<?php echo $rdbms;?>" onchange="DBSelection()">
							<option value="mysql" <?php if (($rdbms=='mysql') || ($rdbms=='')){?> selected <?php }?>>MySQL</option>
							<option value="sqlsrv" <?php if ($rdbms=='sqlsrv'){?> selected <?php }?>>MS SQL Server</option>
							<option value="dblib" <?php if ($rdbms=='dblib'){?> selected <?php }?>>Sybase</option>
							<option value="pgsql" <?php if ($rdbms=='pgsql'){?> selected <?php }?>>PostgreSQL</option>
							<option value="oci" <?php if ($rdbms=='oci'){?> selected <?php }?>>Oracle</option>
							<option value="cubrid" <?php if ($rdbms=='cubrid'){?> selected <?php }?>>Cubrid</option>
							<option value="sqlite" <?php if ($rdbms=='sqlite'){?> selected <?php }?>>SQLite</option>
						  </select>
						  </div>
						  
						
						<div id="hostID" <?php if ($rdbms=='sqlite'){?> style="display:none;"<?php }?>>  
						<br/><p>&nbsp;</p>
					  	<label class="col-sm-3 control-label">Host:</label> 
						<div class="col-sm-8">
						   <input type="text" class="form-control" id="host" name="host" value="<?php echo $xmlDoc->col[$col]->servername;?>" placeholder="localhost" size="50" <?php if (!($rdbms=='sqlite')){?> required oninvalid="this.setCustomValidity('Please enter Host name')" oninput="setCustomValidity('')" <?php }?>/>    
						</div>
						</div>
						
						
						<div id="userID" <?php if ($rdbms=='sqlite'){?> style="display:none;"<?php }?>>
						<br/><p>&nbsp;</p>
						<label class="col-sm-3 control-label">User:</label> 
						<div class="col-sm-8">
						   <input type="text" class="form-control" id="user" name="user" value="<?php echo $xmlDoc->col[$col]->username;?>" placeholder="root" size="50" <?php if (!($rdbms=='sqlite')){?> required oninvalid="this.setCustomValidity('Please enter user name')" oninput="setCustomValidity('')"  <?php }?>/>    
						</div>
						</div>
						
						<div id="passwordID" <?php if ($rdbms=='sqlite'){?> style="display:none;"<?php }?>>
						<br/><p>&nbsp;</p>
						<label class="col-sm-3 control-label">Password:</label> 
						<div class="col-sm-8">
						   <input type="password" class="form-control" id="password" name="password" value="<?php echo $xmlDoc->col[$col]->password;?>" size="50"/>    
						</div>
						</div>
						
						<br/><p>&nbsp;</p>
						
						<label class="col-sm-3 control-label">DB Name:</label> 
						<div class="col-sm-8">
						   <input type="text" id="dbname" class="form-control" name="dbname" value="<?php echo $xmlDoc->col[$col]->dbname;?>" placeholder="Type your database name" size="50" required oninvalid="this.setCustomValidity('Please enter DB name')" oninput="setCustomValidity('')" />    
						</div>
						<br/><p>&nbsp;</p>
						
						<label class="col-sm-3 control-label">SSL Enabled:</label> 
						<div class="col-sm-2">
						   <input type="checkbox" id="ssl" name="ssl" <?php if($xmlDoc->col[$col]->ssl=='on'){ echo 'checked';}?> />   
						</div>
						<br/><p>&nbsp;</p>

					</div>
					
			  </div>
			<!-- Tab Data Source end -->
	
			<!-- Tab for Properties -->  
			  <div id="menu1" class="tab-pane fade in <?php echo $xlTabActive;?>">
				<div class="col-md-12">
				<br/>         
							  <div class="form-group files">
							  <?php if($xlTabActive) {?>
								<div class="label label-success"><?php echo basename($xmlDoc->col[$col]->file);?></div>
							  <?php } ?>
								<label>Upload Your File (XLSX, XLS or CSV)</label>
								  
								<input type="file" name="fileToUpload" id="fileToUpload" class="form-control"  oninvalid="this.setCustomValidity('Please select an Excel or a CSV file')" oninput="setCustomValidity('')"/>
								
								  <br/>
								<label class="uploadfiles">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;or drag it here. </label>
							  </div>           
						    
				</div>
			  </div>
			  <!-- Tab Properties Ends -->
			  
			</div>
			<!-- Tab Panel Ends -->

			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;">Cancel</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
			</fieldset>
			</form>
			</div>			<!-- /modal-body -->


<?php
function savedataDB($col) {
	// $xmlfile = 'data/layout'.$_GET['layout'].'.xml';
	 $xmlfile = '../data/data.xml';
	 $xmlDoc=simplexml_load_file($xmlfile);

	 $xmlDoc->col[$col]->source = $_POST['source'];
	 
	 if ($_POST['source']=='ADatabase'){
	 	$xmlDoc->col[$col]->rdbms = $_POST['rdbms'];
	 }
 
	 if (!empty($_POST['host'])){
	 	$xmlDoc->col[$col]->servername = $_POST['host'];
	 }
	 
	 $xmlDoc->col[$col]->ssl = '';
	 if (!empty($_POST['ssl'])){
	 	$xmlDoc->col[$col]->ssl = $_POST['ssl'];
	 }
		
	if (!empty($_POST['user'])){
	 	$xmlDoc->col[$col]->username = $_POST['user'];
		}
		

	 $xmlDoc->col[$col]->password = $_POST['password'];

		
	if (!empty($_POST['dbname'])){
	 	$xmlDoc->col[$col]->dbname = $_POST['dbname'];
		}

		
	 // DB connection start
			if ($_POST['source']=='ADatabase'){
			if (!$xmlDoc->col[$col]->dbname==''){

			$DB_TYPE = $xmlDoc->col[$col]->rdbms; //Type of database<br>
			if (isset($_POST['ssl'])){
				$DB_HOST = 'https://'.$xmlDoc->col[$col]->servername; //Host name<br>
				}
				else
				{
				$DB_HOST = $xmlDoc->col[$col]->servername; //Host name<br>
			}
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
				$xmlDoc->col[$col]->dbconnected = '1';
					if ($DB_TYPE=='sqlite'){
						if (file_exists($DB_NAME)){
								if (filesize($DB_NAME) > 0 ) {
										$conn = new PDO("$DB_TYPE:$DB_NAME");
									}
									else 
									{
										$xmlDoc->col[$col]->dbconnected = '0';
									}
							}
							else {
								$xmlDoc->col[$col]->dbconnected = '0';
							}
					}
					else {
						$conn = new PDO("$DB_TYPE:host=$DB_HOST; dbname=$DB_NAME;", $DB_USER, $DB_PASS);
					}
				} catch(PDOException $e){
					$xmlDoc->col[$col]->dbconnected = '0';
					} 
				}
			}

	 	  
	 if ($_POST['source']=='upload'){
		$target_file =  "../data/" . basename($_FILES["fileToUpload"]["name"]);
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
		$xmlDoc->col[$col]->file = $target_file;
	 }
	 $xmlDoc->asXML($xmlfile);

}
?> 

<script>
function DBSelection() {

	var x = document.getElementById("rdbms").value;

	if(x === 'sqlite'){ //Check if SQLite is selected
            document.getElementById('hostID').style.display="none";
			document.getElementById('host').required = false;
			document.getElementById('userID').style.display="none";
			document.getElementById('user').required = false;
			document.getElementById('passwordID').style.display="none";
			$('#host').get(0).setCustomValidity('');
			$('#user').get(0).setCustomValidity('');
			}
			else {
			document.getElementById('hostID').style.display="block";
			document.getElementById('host').required = true;
			document.getElementById('userID').style.display="block";
			document.getElementById('user').required = true;   
			document.getElementById('passwordID').style.display="block"; 
			 }
}
</script>

<script type="text/javascript">
function tabvalue(tabvalue) {

	document.getElementById("source").value = tabvalue;
	
	if (tabvalue=='upload'){
		document.getElementById('host').required = false;
		document.getElementById('user').required = false;
		document.getElementById('dbname').required = false;
		$('#host').get(0).setCustomValidity('');
		$('#user').get(0).setCustomValidity('');
		$('#dbname').get(0).setCustomValidity('');
		document.getElementById('fileToUpload').required = true; 
	}
	
	if (tabvalue=='ADatabase'){
		document.getElementById('host').required = true;
		document.getElementById('user').required = true;
		document.getElementById('dbname').required = true;
		document.getElementById('fileToUpload').required = false;
		$('#fileToUpload').get(0).setCustomValidity('');
		DBSelection();
	}
}

$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="col-sm-offset-3"><input type="text" name="xaxis[]" value="" size="50"/><a href="javascript:void(0);" class="remove_button" title="Remove field"> <span class="fa fa-minus-square" style="font-size:26px;"></span></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button2'); //Add button selector
    var wrapper = $('.field_wrapper2'); //Input field wrapper
    var fieldHTML = '<div class="col-sm-offset-3"><input type="text" name="yaxis[]" value="" size="50"/><a href="javascript:void(0);" class="remove_button2" title="Remove field"> <span class="fa fa-minus-square" style="font-size:26px;"></span></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button2', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button3'); //Add button selector
    var wrapper = $('.field_wrapper3'); //Input field wrapper
    var fieldHTML = '<div class="col-sm-offset-3"><input type="text" name="size[]" value="" size="50"/><a href="javascript:void(0);" class="remove_button3" title="Remove field"> <span class="fa fa-minus-square" style="font-size:26px;"></span></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button3', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button4'); //Add button selector
    var wrapper = $('.field_wrapper4'); //Input field wrapper
    var fieldHTML = '<div class="col-sm-offset-3"><input type="text" name="text[]" value="" size="50"/><a href="javascript:void(0);" class="remove_button4" title="Remove field"> <span class="fa fa-minus-square" style="font-size:26px;"></span></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html

        }
    });
    $(wrapper).on('click', '.remove_button4', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button5'); //Add button selector
    var wrapper = $('.field_wrapper5'); //Input field wrapper
    var fieldHTML = '<div class="col-sm-offset-3"><input type="text" name="tracename[]" value="" size="50"/><a href="javascript:void(0);" class="remove_button5" title="Remove field"> <span class="fa fa-minus-square" style="font-size:26px;"></span></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html

        }
    });
    $(wrapper).on('click', '.remove_button5', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});




$(document).ready(function () {
$('input[type=file]').change(function () {
var val = $(this).val().toLowerCase();
var regex = new RegExp("(.*?)\.(csv|xlsx|xls)$");
 if(!(regex.test(val))) {
$(this).val('');

document.getElementById("fileToUpload").setCustomValidity("Please select an Excel or a CSV file");

} }); });



</script>
