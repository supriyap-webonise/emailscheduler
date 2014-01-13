<?php
include("layout/header.phtml");
require("common.php");
$i=0;
if(isset($_POST) && !empty($_POST))
{
    if($_POST['username']=='' && $_POST['password']=='')
        $i=1;
    elseif($_POST['username']=='')
        $i=2;
    elseif($_POST['password']=='')
        $i=3;
    $common = new DBConnection();
    $connection = $common->dbconnection();
    $data = $_POST;
    $signin = $common->signin($connection,$data);
    if($signin!='')
    {
        header("Location:schedulelisting.php");
    }
}
?>
<div class="container signinbody center-block">
<?php
    $error='';
     if($i!='' && $i==1)
           $error="Please Enter Username And Password ...";
      elseif($i!='' && $i==2)
           $error="Please Enter Username ...";
      elseif($i!='' && $i==3)
           $error="Please Enter Password ...";
    ?>
    <form class="form-signin" role="form" method="post" action="">
        <h2 class="form-signin-heading">Sign in</h2>
        <p class="text-danger"><?php echo $error;?></p>
        <input type="text" name="username" id="username" class="form-control" placeholder="Email address" required autofocus>
        <br/>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-success btn-block btn-default" type="submit" name="signin" id="signin">Sign in</button>
    </form>

</div> <!-- /container -->
<?php include("layout/footer.phtml");?>