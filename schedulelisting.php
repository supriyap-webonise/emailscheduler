<?php
include("layout/header.phtml");
if($_SESSION['id']=='')
{
    header("Location:index.php");
}
include ("common.php");
$common = new DBConnection();
$connection = $common->dbconnection();
if(isset($_REQUEST['option']) && isset($_REQUEST['id']))
{
	if($_REQUEST['option']=='cancel')
	{
		$result=$common->updatestatus($connection,$_REQUEST['id']);
	}
}
$records = $common->get_all($connection);

?>
<div class="container">
<?php if(isset($_GET['message']))
{?>
<h4><p class="text-danger text-center"><?php echo $_GET['message']?></p></h4>
<?php }
 if(empty($records))
        { ?>
       <h4><p class="text-danger text-center">No Emails Scheduled ...</p></h4>
    <?php }
    else { ?>
    <div id="messagediv" class="text-danger"></div>
   <table class="table table-striped table-bordered">
       <tr>
       	   <td width="15%" class="schedule-listing-header">Name</td>
       	   <td width="15%" class="schedule-listing-header">Description</td>
           <td width="20%" class="schedule-listing-header">To</td>
           <td width="20%" class="schedule-listing-header">Subject</td>           
           <td width="15%" class="schedule-listing-header">Scheduled Date</td>
           <td width="5%" class="schedule-listing-header">Status</td>
           <td width="5%" class="schedule-listing-header">Edit</td>
           <td width="5%" class="schedule-listing-header">Cancel</td>
       </tr>
       <?php
       foreach($records as $row){
           if($row['e_sent']==0) {$name="pending.png"; $title="Pending";}
           elseif($row['e_sent']==1) { $name="correct.png"; $title="Completed";}
           elseif($row['e_sent']==2) { $name="cross.png"; $title="Cancelled";}?>
       <tr class="success">
       	   <td><?php echo $row['e_name'];?></td>
       	   <td><?php echo $row['e_description'];?></td>
           <td><?php echo $row['e_to'];?></td>
           <td><?php echo $row['e_subject'];?></td>           
           <td><?php echo $row['e_date'];?></td>
           <td align="center"><img src="public/images/<?php echo $name;?>" alt="<?php echo $title;?>" width="16px" height="16px"/> </td>
           <td><input type="button" class="btn-default" name="edit" id="edit" value="Edit" onclick="location.href='scheduleemail.php?id=<?php echo  $row['id'];?>'"></td>
           <td><input type="button" class="btn-danger" name="cancel" id="cancel" value="Cancel" onclick="schdeduleaction(this.id,'<?php echo $row['id'];?>');" <?php if($row['e_sent']==1) echo "disabled=disabled";?> ></td>
       </tr>
       <?php } ?>
   </table>
    <?php } ?>
</div> <!-- /container -->
<?php include("layout/footer.phtml");?>