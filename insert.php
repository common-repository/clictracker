<?php
	require_once( '../../../wp-load.php' );
	if(!isset($_POST['email'])){
		echo 'No data submited.';
	}else{
		$email_address = $_POST['email'];
		$full_name = $_POST['full_name'];
		global $wpdb;
		if(!is_email($email_address)){
			echo 'Invalid email address.';
		}else{
		
		}
	}
?>

<script type="text/javascript">
	function closeWindow(){
		self.close();
	}
	setTimeout(closeWindow, 1000);
</script>