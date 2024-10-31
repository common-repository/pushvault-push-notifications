<?php
if( !defined('ABSPATH') )exit;

$paused = get_option('pvlt-paused','');

add_action( 'wp_head', 	    'pvlt_initializator');
if($paused != 'on') add_action( 'wp_footer',    'pvlt_base_code');
add_action( 'admin_menu',   'pvlt_administration_menu' );
add_action( 'admin_footer', 'pvl_media_selector_print_scripts' );
add_shortcode( 'pvlt_disallow_button', 'disallowbutton_shortcode');

function pvlt_initializator(){
	echo '<link rel="manifest" href="'.plugin_dir_url(__FILE__).'../manifest.json"/>'; 
	wp_enqueue_script( 'pushVaultSDK', 'https://cdn.pushvault.com/scripts/pushVaultSDK.js', array(), null, true);
}
function pvlt_base_code(){

$pvlshowoptions  = get_option('pvlt-show-options','');
if($pvlshowoptions == 1 && is_front_page()) return;
if($pvlshowoptions == 2 && !is_front_page()) return;

$sender_id_value = get_option('pvlt-sender-id', '');
$uid_value 	 = get_option('pvlt-uid', '');	
$publicKey_value = get_option('pvlt-publicKey', '');
$pvlformat 	 = get_option('pvlt-display-option', '');
$pvlTimer 	 = get_option('pvlt-time-interval', '0');
$pvlObscured 	 = get_option('pvlt-obscured', '');
$poweredBy       = get_option('pvlt-powered','');
$pvlDisableJquery= get_option('pvlt-disable-jquery','');

$pvltmodaltitle  = get_option('pvlt-modal-title', 'We want to inform you!');
$pvltmodaltext   = get_option('pvlt-modal-text', 'Accept our notifications and keep informed');
$pvltmodalaccept = get_option('pvlt-modal-accept-button', 'Accept');
$pvltmodalcancel = get_option('pvlt-modal-cancel-button', 'Please no');
$pvltimagemodal  = get_option('pvlt_media_selector_attachment_id',0);
$pvlCookieInt    = get_option('pvlt-cookie-interval','30');

$pvlTimer = $pvlTimer * 1000;
if($pvlDisableJquery != 'on'){
	if ( ! wp_script_is( 'jquery', 'done' )){
		wp_enqueue_script('jquery');
	}
}
	if($sender_id_value == '' || $uid_value == '' || $publicKey_value == ''){
		wp_add_inline_script('pvltKeyWarning', 'console.log("pushvault:set your unique keys in the wp-admin area");');
	}else{
		wp_enqueue_style( 'pvl-style', plugin_dir_url(__FILE__). '../resources/pvl-style.css' );
		switch ($pvlformat){
			case '2':// 'top-centered':
				include ( plugin_dir_path(__FILE__) . "formats/top-centered.php");
				break;
			case '3':// 'right-bottom':
				include ( plugin_dir_path(__FILE__) . "formats/right-bottom.php");
				break;
			case '4':// 'central-modal':
				include ( plugin_dir_path(__FILE__) . "formats/central-modal.php");
				break;
			default:
				include ( plugin_dir_path(__FILE__) . "formats/only-prompt.php");
		}
	}
}
//Adds the pushvault new menu to the Admin Control Panel
function pvlt_administration_menu(){
	add_options_page(
	 'Pushvault Control Panel', // Title of the page
	 'Webpush Notifications', // Text to show on the menu link
	 'manage_options', // Capability requirement to see the link
	 plugin_dir_path(__FILE__) . '/pushvault_adminpage_frontend.php' // The 'slug' - file to display when clicking the link
 	);
}
function printPvlBigBlackDiv($pvlObscured){
	if($pvlObscured == 'on'){
		echo "<div id='pvl-fade-black-div' name='pvl-fade-black-div' style='display:none; position:absolute; top:0px; left:0px; width:100%; height:100%; background-color:#000; z-index:2998'></div>";
	}
}
function showPvlBigBlackDiv($pvlObscured){
	if($pvlObscured == 'on'){
		echo "jQuery('#pvl-fade-black-div').fadeTo('fast', 0.7);";
		echo "jQuery('#pvl-fade-black-div').show();";
		echo "jQuery('html, body').css({ 'overflow': 'hidden', 'height': '100%'});";
	}
}
function hidePvlBigBlackDiv($pvlObscured){
	if($pvlObscured == 'on'){
		echo "jQuery('#pvl-fade-black-div').fadeTo('fast', 0);";
        	echo "jQuery('#pvl-fade-black-div').hide();";
	        echo "jQuery('html, body').css({ 'overflow': 'auto', 'height': 'auto'});";
	}
}
function pvlPoweredBy($poweredBy){
	if($poweredBy == 'on'){
        	echo "<div style='font-size:8px; text-align:right; margin-top:5px; line-height:25px;'>kindly powered by <img src='".plugin_dir_url(__FILE__)."../resources/pushvault_thumb.png' alt='Pushvault' style='vertical-align:middle; opacity: 0.60; filter: alpha(opacity=60);'/></div>";
	}
}
function pvl_media_selector_print_scripts() {

	$my_saved_attachment_post_id = get_option( 'pvlt_media_selector_attachment_id', 0 );

	?><script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
			jQuery('#upload_image_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					// Do something with attachment.id and/or attachment.url here
					$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', '75px' );
					$( '#pvlt_image_attachment_id' ).val( attachment.id );
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});
	</script><?php
}
?>
<?php
function disallowbutton_shortcode( $atts ){
	
	wp_enqueue_style( 'userManagerStyle', plugin_dir_url(__FILE__). '../resources/pushVaultUserManagerStyle.css' );
	wp_enqueue_script( 'pushVaultUserManager', plugin_dir_url(__FILE__).'../resources/pushVaultUserManagerScripts.js', array(), null, true);
	return '<div class="local-block"><label class="pvlt-switch"><input type="checkbox" id="pushes-checkbox" onclick="pauseResume()"> <span class="pvlt-slider round"></span></label><span style="margin-left:10px"> Status: </span><span id="pvlt-status">&nbsp;Disallowed</span></div>';
}
?>
