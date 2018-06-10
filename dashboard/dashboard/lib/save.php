<?php
$GLOBALS['folder'] ="..".DIRECTORY_SEPARATOR;
if (isset($_POST['savetask'])) {
if ($_POST["savetask"]=='save'){
session_start();
savefile();
header('Location: '.$_SERVER["HTTP_REFERER"] );

exit();
}
}?>	

 <!-- Modal -->
 
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
		 <h4 class="modal-title">File Save</h4>
	</div>			<!-- /modal-header -->

	
	<!-- Tab Panel Ends -->
	<form  id="savefil" class="form-horizontal" action="save.php" method="post">
	<br/>
	<label class="col-sm-3 control-label">File Name:</label> 
		<div class="col-sm-offset-3">
	   <input type="text" id="filename" name="filename" value="" placeholder="salesq1"size="50" required oninvalid="this.setCustomValidity('Please enter a file name')" oninput="setCustomValidity('')" />    
	</div><br/>
	
	<div class="col-sm-6">
	<select size="5" class="form-control col-sm-offset-6" id="fileselect" onchange="fileSelection()" >
	   <?php
	   	$patterns = array();
		 $replacements =  array();
 		 $search = $folder. "store".DIRECTORY_SEPARATOR."*.data";
		 foreach (glob($search) as $filename) {
		 			$filenamevalue = $filename;
		 			//$filename=  preg_replace('/.data/','',$filename);
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
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;">Cancel</button>
		<input type="hidden" name="savetask" value="save"/>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
</form>

<script>
function fileSelection() {
var x = document.getElementById("fileselect").value;
document.getElementById("filename").value = x.slice(0, -5);
}
</script>
<?php
function savefile(){
$folder ="..".DIRECTORY_SEPARATOR;
$file = $folder.'data'.DIRECTORY_SEPARATOR.'data.xml';
$newfile = $folder.'store'.DIRECTORY_SEPARATOR.$_POST['filename'].'.data';
if (!copy($file, $newfile)) {
?><script>alert ('Fail to copy');</script><?php
}
$file = $folder.'data'.DIRECTORY_SEPARATOR.'layout.xml';
$newfile = $folder.'store'.DIRECTORY_SEPARATOR.$_POST['filename'].'.lay';
if (!copy($file, $newfile)) {
?><script>alert ('Fail to copy');</script><?php
}
$patterns[0] = '/store/';
$replacements[0] = '';
$patterns[1] = '/\../';
$replacements[1] = '';
$patterns[2] = '/\\\/';
$replacements[2] = '';
$_SESSION['filename']= preg_replace($patterns, $replacements, $_POST['filename']);
}
?>