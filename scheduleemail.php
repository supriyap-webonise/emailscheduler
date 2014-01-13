<?php
include("layout/header.phtml");
if($_SESSION['id']=='')
{
    header("Location:index.php");
}
include ("common.php");
$common = new DBConnection();
$connection = $common->dbconnection();
if(isset($_POST) && !empty($_POST))
{	
	$data = $_POST;
	$savedata = $common->save_schedule($connection,$data);
	if(array_key_exists($_POST['update-schedule']))
		$message = "Successfully Updated ...";
	else $message = "Successfully Saved ...";
	header('location:schedulelisting.php?message="Successfully Updated ..."');
}
if(isset($_GET['id']))
{	
	$getdata = $common->getscheduleemail($connection,$_GET['id']);
}
?>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="public/css/scheduler.css"  type="text/css"/>
<script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js"></script>
<div class="container">

    <form actio="" method="post" class="form-emailschedule" id="emailform" role="form">
    	<input type="hidden" name="e_id" id="e_id" value="<?php if(isset($getdata['id']) && $getdata['id']!='')echo $getdata['id'];?>">
    	<label>Name : </label>
        <input type="text" class="form-control form_input1" name="e_name" placeholder="Name" required autofocus value="<?php if(isset($getdata['e_name'])) echo $getdata['e_name']?>">
        <br/>
        <label>Description : </label>
        <input type="text" class="form-control form_input1" name="e_description" placeholder="Description" required autofocus value="<?php if(isset($getdata['e_description'])) echo $getdata['e_description']?>">
        <br/>
        <label>To : </label>
        <input type="text" class="form-control form_input1" name="e_to" onblur="validate_email(this.value);"  placeholder="Recipent" required email autofocus value="<?php if(isset($getdata['e_to'])) echo $getdata['e_to']?>">
        <div id="warning-message" class="text-danger"></div>
        <br/>
        <label>Subject : </label>
        <input type="text" class="form-control form_input1" name="e_subject" placeholder="Subject" required value="<?php if(isset($getdata['e_subject'])) echo $getdata['e_subject']?>">
        <label>Body : </label>
        <textarea class="form-control" name="e_body" placeholder="Body" rows="3"><?php if(isset($getdata['e_body'])) echo $getdata['e_body']?></textarea>
        <label>Scheduled Date : </label>
        <div id="datetimepicker" class="input-append date">
            <input type="text" name="e_date" id="e_date" class="form_input1" value="<?php if(isset($getdata['e_date'])) echo $getdata['e_date']?>" <?php if(isset($_GET['id']) && $getdata['e_date']!='0000-00-00 00:00:00') echo 'readonly';?>>
      <span class="add-on add-on1">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
            </input
        </div>
        <br/>
        <br/>
        <p class="pull-right">
       <?php if(isset($_GET['id'])) {?>
       <button class="btn btn-info btn-default" type="submit" name="update-schedule" id="update-schedule">Update Schedule</button>
       <?php  } else { ?>
        <button class="btn btn-info btn-default" type="submit" name="schedule" id="schedule">Schedule</button>
        <?php  } ?>
        <button class="btn btn-info btn-default" type="button" name="cancel" id="cancel" onclick="location.href='schedulelisting.php'" >Cancel</button>
        </p>
    </form>
</div> <!-- /container -->
<?php include("layout/footer.phtml");?>
<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
    });
</script>