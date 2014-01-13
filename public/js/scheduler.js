function schdeduleaction(option,val)
{	
	$.ajax({
		url: "schedulelisting.php",
		data: "option="+option+"&id="+val,
		type: "post",
		}).done(function() {
			window.location.href = 'schedulelisting.php';
			$('#messagediv').html("Scheduled Email Has Been Cancelled");
		});
}
function validate_email(val){

    var email = val.split(/[;,]+/); // split element by , and ;
    valid = true;
    for (var i in email) {
        if(!validateEmail(email[i])){
            valid = false;
            $("#warning-message").html('Invalid email:'+email[i]);
            $("#schedule").attr('disabled', 'disabled');
        }
    }
    if(valid){
        $("#warning-message").html('');
        $("#schedule").removeAttr('disabled');
    }

}

function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( $email ) ) {
        return false;
    } else {
        return true;
    }
}