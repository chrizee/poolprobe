<?php 
$GLOBALS['folder'] ="..".DIRECTORY_SEPARATOR;
if (isset($_POST['opentask'])) {
		if ($_POST["opentask"]=='open'){
		    if (!empty($_POST['filename'])) {
		    session_start();
		    openfile($_POST['filename']);
			header('Location: ' . $_SERVER["HTTP_REFERER"] );
		    }
		}
}
?>

 <!-- Modal -->
 
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
		 <h4 class="modal-title">File Open</h4>
	</div>			<!-- /modal-header -->

	
	<!-- Tab Panel Ends -->
	<form  id="savefil" class="form-horizontal" action="open.php" method="post">
	<br/>
	<label class="col-sm-3 control-label">File Name:</label> 

	
	<div class="col-sm-6">
	<select  name="filename" class="form-control col-sm-offset-2" size="5" required oninvalid="this.setCustomValidity('Please select a file to open')" oninput="setCustomValidity('')">
	   <?php
 		 $search = $folder. "store".DIRECTORY_SEPARATOR."*.data";
		 
		 $patterns = array();
		 $replacements =  array();
		 foreach (glob($search) as $filename) {
		 			$filenamevalue = $filename;
		 			//$filename=  preg_replace('/.data/','$5',$filename);
					$filename = substr ($filename, 0, -5);
					$patterns[0] = '/store/';
					$replacements[0] = '';
					$patterns[1] = '/\../';
					$replacements[1] = '';
					$patterns[2] = '/\\\/';
					$replacements[2] = '';

					$filename= preg_replace($patterns, $replacements, $filename);

					echo '<option value="'. $filenamevalue.'">'. $filename .'</option>';
				}

		?>    
		</select>
		<br/>
	</div><br/><br/><br/><br/><br/>

	
	<div class="modal-footer">
	<input type="hidden" id="opentask" name="opentask" value="open"/>
	<div class="col-md-12">
		<button type="button" class="btn btn-default" style="float:none;" data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;">Cancel</button>  
		<button type="submit" class="btn btn-primary"  style="float:right;">Open</button>  
	</div>
	</div>
</form>

<?php
function openfile($filename){

$folder ="..".DIRECTORY_SEPARATOR;

$newfile = $folder.'data'.DIRECTORY_SEPARATOR.'data.xml';
$file = $filename;

	if (!copy($file, $newfile)) {
		echo '<div class="alert alert-danger alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Error!</strong> failed to copy $file...
		</div>';
	}
	
	
$newfile = $folder.'data'.DIRECTORY_SEPARATOR.'layout.xml';

//$file= preg_replace('/.data/', '.lay', $filename);
$file = substr ($filename, 0, -5);
$_SESSION['filename']= $file;
$file = $file .'.lay';
	
	if (!copy($file, $newfile)) {
		echo '<div class="alert alert-danger alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Error!</strong> failed to copy $file...
		</div>';
	}
					$patterns[0] = '/store/';
					$replacements[0] = '';
					$patterns[1] = '/\../';
					$replacements[1] = '';
					$patterns[2] = '/\\\/';
					$replacements[2] = '';


$_SESSION['filename']= preg_replace($patterns, $replacements, $_SESSION['filename']);

}
?>
