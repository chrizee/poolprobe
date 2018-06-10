<?php session_start();
$folder ="..".DIRECTORY_SEPARATOR;
include('top.php');?>
<?php 
$param = '';
$able = 'class="disabled"'. '  style="color:#CCCCCC;"';
if (isset($_REQUEST['col'])){
if (!empty($_REQUEST['col'])){
		 $param = 'col='.$_REQUEST['col'].'&p=1';
		 $able = '';
	}
}
if (isset($_POST['loadsampledata'])) {
	$file = $folder.'store'.DIRECTORY_SEPARATOR.'sampledata.data';
			$newfile = $folder.'data'.DIRECTORY_SEPARATOR.'data.xml';
			
			if (!copy($file, $newfile)) {
				echo "failed to copy $file...\n";
			}
			
			$file = $folder.'store'.DIRECTORY_SEPARATOR.'sampledata.lay';
			$newfile = $folder.'data'.DIRECTORY_SEPARATOR.'layout.xml';
			
			if (!copy($file, $newfile)) {
				echo "failed to copy $file...\n";
			}
			
			//header('Location: layout.php?col=4&p=0' );
}
?>
<style>
.disabled {
   pointer-events: none;
   cursor: default;
}
</style>
									
<div class="container-fluid main-container">

 <div class="col-md-12 content" >
  <div>

<div >
		
		<div class="row">

<!-- Modal -->
<div class="modal fade" id="youtube" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      
        <iframe id="iframeYoutube" width="560" height="315"  frameborder="0" allowfullscreen></iframe> 
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<ol class="breadcrumb">
	
		<a href="javascript:void(0);" class="btn btn-warning" id="file-new" onclick="submitAll('n');">
			New <i class="fa fa-file-o"></i>;
		</a>
	
		<a href="javascript:void(0);" class="btn btn-warning" id="file-open" onclick="submitAll('o');" >
			Open <i class="fa fa-folder-open-o"></i>
		</a>
		<a href="javascript:void(0);" class="btn btn-warning" id="file-save" onclick="submitAll('3');" >
			Save <i class="fa fa-save"></i>
		</a>
		
		

	
		<a href="javascript:void(0);" class="btn btn-warning addpanel" id="addpanelid" >
			Add Panel <i class="fa fa-square-o"><sup><i class="fa fa-plus"></i></sup></i>
		</a>

		<a href="javascript:void(0);" class="btn btn-warning" id="file-generate" onclick="submitAll('g');">
			Generate <i class="fa fa-code"></i>
		</a>
		

	<li>
		<i class="fa fa-th" > </i> <span id="savefilename">File: <?php if(isset($_SESSION['filename'])) {echo $_SESSION['filename']; } else {echo 'Untitled';}?></span>
	</li>
	
	<li id="panelno">Panel 1</li>
	<li id="resize">Size:</li> 
	<li id="reposition">Position:</li>
	
	
	
						<span style="float:right;">
						&nbsp;&nbsp;
						<a href="#" onclick="changeVideo('YHOoEsQ4ob8')"><button class="btn btn-danger" >Take a Tour</button></a>
						</span>
						
						<span style="float:right;">
						<form action="" method="post"  ><input type="hidden" name="loadsampledata" value="loadsampledata"><button class="btn btn-success" >Sample Data</button></form>

						</span>
						
	
	
</ol>









<?php 
for ($x = 1; $x <= 12; $x++) { ?>
<div class="col-md-1 col-xs-1 col-lg-1" style="padding:0;"><div id="grids" style="text-align:center;"><mylabel>col-<?php echo $x;?></mylabel></div></div>
<?php } ?>

<?php include ('layout.php');?>
<!-- Moodal -->


	</div>	
		
	

<?php include ('bottom.php');?>
<script>
$(document).ready(function(){
  $("#youtube").on("hidden.bs.modal",function(){
    $("#iframeYoutube").attr("src","#");
  }) 
})

function changeVideo(vId){
  var iframe=document.getElementById("iframeYoutube");
  iframe.src="https://www.youtube.com/embed/"+vId;

  $("#youtube").modal("show");
}


</script>