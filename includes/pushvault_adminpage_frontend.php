<?php
if( !defined('ABSPATH') )exit;

if( isset( $_GET['tab'] ) ) {
	$active_tab = sanitize_text_field($_GET['tab']);
}else{
	$active_tab = 'display';
}
if(isset($_POST['pvlt-uid'])){
	check_admin_referer( 'pvlt_plugin_form' );
	$value = sanitize_text_field($_POST['pvlt-uid']);
	$apiRequest = "https://pushvault.com/api/auth/getkeys/".$value;
	$json = wp_remote_get( $apiRequest);
	$json_ar = json_decode($json['body'], true);
	if(!isset($json_ar['error']) && sizeof($json_ar) > 0){
		update_option('pvlt-uid',       $value);
		update_option('pvlt-sender-id', $json_ar['gcm_sender_id']);
		update_option('pvlt-publicKey', $json_ar['public_key']);
		$fp = @fopen( plugin_dir_path(__FILE__) . '../manifest.json', 'wb+');
		@fwrite($fp, '{ "gcm_sender_id": "'.$json_ar['gcm_sender_id'].'" }');
		@fclose($fp);
	}else{
		$error = 1;
	}
}
$sender_id_value = get_option('pvlt-sender-id', '');
$uid_value 	 = get_option('pvlt-uid',       '');
$publicKey 	 = get_option('pvlt-publicKey', '');
?>
<div class="wrap">
	<div style='background-color:#333; padding:0px 25px;'><h1 style='color:#fff'><img src='//pushvault.com/panel/assets/imgs/logo.svg' style='padding-bottom:7px; vertical-align:middle; height:30px'> - Free Webpush Notifications Tool for Webmasters</h1></div>
	<p>You need an <b>uid</b> in order to use this tool. You can get one for free signing up in <a href='https://pushvault.com/panel/auth/register' alt='pushvault' target='_blank'>pushvault.com</a></p>
	<form method="POST">
	<?php wp_nonce_field( 'pvlt_plugin_form'); ?>
	<?php if(( $error == 1 && $uid_value != '' ) || $uid_value == ''){ 
		echo "<h2>Insert your uid here: &nbsp; <input type='text' name='pvlt-uid' id='pvlt-uid' value='".esc_attr($_POST['pvlt-uid'])."' placeholder='Your uid here...' style='width:265px'> <span style='color:red'>Invalid UID</span></h2>"; 
	}else{ 
		echo "<h2>Insert your uid here: &nbsp; <input type='text' name='pvlt-uid' id='pvlt-uid' value='".esc_attr($uid_value)."' placeholder='Your uid here...' style='width:265px;' readonly> <input type='button' id='pvlt-unlock-UID' value='Unlock UID' class='button button-primary button-small' onClick='enableUID()' style='float:right'> <span style='color:green'>OK</span></h2>";
	?>
	<hr>
	<div>
		<div style='margin-bottom:20px'>
		<h2 class="nav-tab-wrapper">
		    <a href="?page=pushvault-push-notifications%2Fincludes%2Fpushvault_adminpage_frontend.php&tab=display" class="nav-tab <?php echo $active_tab == 'display' ? 'nav-tab-active' : ''; ?>">Display options</a>
		    <a href="?page=pushvault-push-notifications%2Fincludes%2Fpushvault_adminpage_frontend.php&tab=customization" class="nav-tab <?php echo $active_tab == 'customization' ? 'nav-tab-active' : ''; ?>">Customization</a>
		    <a href="?page=pushvault-push-notifications%2Fincludes%2Fpushvault_adminpage_frontend.php&tab=legal" class="nav-tab <?php echo $active_tab == 'legal' ? 'nav-tab-active' : ''; ?>">Legal Functionalities</a>
		</h2>
		</div>
		<?php include_once(plugin_dir_path(__FILE__) . 'backend/'.$active_tab.'.php'); ?>
	</div>	
	<?php
	} ?> 
	<hr>
	<input type='submit' id='pvlt-submit' value='Save Settings' class="button button-primary button-large">
	</form>
</div>
<script>
function enableUID(){
	document.getElementById('pvlt-uid').removeAttribute('readonly');
}
</script>
