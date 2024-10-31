<?php
if( !defined('ABSPATH') )exit;

if(isset($_POST['pvlt-modal-text'])){
	$pvltimagemodal	 = sanitize_text_field($_POST['pvlt_image_attachment_id']);
	$pvltmodaltitle  = sanitize_text_field($_POST['pvlt-modal-title']);
	$pvltmodaltext   = sanitize_text_field($_POST['pvlt-modal-text']);
	$pvltmodalaccept = sanitize_text_field($_POST['pvlt-modal-accept-button']);
	$pvltmodalcancel = sanitize_text_field($_POST['pvlt-modal-cancel-button']);
	update_option('pvlt-modal-title', 		   $pvltmodaltitle);
	update_option('pvlt-modal-text', 		   $pvltmodaltext);
	update_option('pvlt-modal-accept-button', 	   $pvltmodalaccept);
	update_option('pvlt-modal-cancel-button', 	   $pvltmodalcancel);
	update_option('pvlt_media_selector_attachment_id', $pvltimagemodal);
}
$pvltmodaltitle  = get_option('pvlt-modal-title', 'We want to inform you!');
$pvltmodaltext   = get_option('pvlt-modal-text', 'Accept our notifications and keep informed');
$pvltmodalaccept = get_option('pvlt-modal-accept-button', 'Accept');
$pvltmodalcancel = get_option('pvlt-modal-cancel-button', 'Please no');
$pvltimagemodal  = get_option('pvlt_media_selector_attachment_id',0);
$powered         = get_option('pvlt-powered','on');

wp_enqueue_media();
?>
<div style='display:inline-block; width:50%; min-width:300px; float:left'>
	<div>Side Image:</div>
	<div style='margin:10px; width:80%; border:dashed 2px #aaa; text-align:center; padding:20px; min-width:300px'>
					<input id="upload_image_button" type="button" class="button" value="<?php esc_attr(_e( 'Upload image' )); ?>" />
					<input type='hidden' name='pvlt_image_attachment_id' id='pvlt_image_attachment_id' value='<?= esc_attr($pvltimagemodal) ?>'>
	</div>
	<div>Modal Information Title:</div>
	<div style='padding:10px;'><textarea id='pvlt-modal-title' name='pvlt-modal-title' style='width:90%; height:40px' placeholder='Push Notification Service'><?= esc_attr($pvltmodaltitle) ?></textarea></div>
	<div>Modal Information Text:</div>
	<div style='padding:10px;'><textarea id='pvlt-modal-text' name='pvlt-modal-text' style='width:90%; height:40px' placeholder='Subscribe to our notification service!'><?= esc_attr($pvltmodaltext) ?></textarea></div>
	<div style='margin-top:10px'>
		Accept Button Text: <input id='pvlt-modal-accept-button' name='pvlt-modal-accept-button' type='text' placeholder='Accept' value='<?= esc_attr($pvltmodalaccept) ?>'/> &nbsp; &nbsp; Decline Button Text: <input id='pvlt-modal-cancel-button' name='pvlt-modal-cancel-button' type='text' placeholder='Dismiss' value='<?= esc_attr($pvltmodalcancel) ?>'/>
	</div>
</div>
<?php wp_enqueue_style( 'pvl-style', plugin_dir_url(__FILE__). '../../resources/pvl-style.css' ); ?>
<div style='display:inline-block; width:50%; min-width:400px; float:left'>
	<div id='pvl-ask-permision-modal' name='pvl-ask-permision-modal' style="z-index:299; margin-top:30px; position:relative; width:400px; height:160px; background-color:#fff; -webkit-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.79); -moz-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.79); box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.79); padding:30px 30px 20px; font-size:13px">
		<div class='pvl-text-main-container'>
                        <div class='pvl-text-icon-container'><img id='image-preview' src='<?php if( $pvltimagemodal > 0) echo wp_get_attachment_url( $pvltimagemodal ); else echo plugin_dir_url(__FILE__). "../../resources/default_logo.png";?>' alt='' width='75px' height='75px' /></div>
                        <div>
                                <div class='pvl-modal-title'><?= esc_attr($pvltmodaltitle) ?></div>
                                <div class='pvl-modal-text'><?= esc_attr($pvltmodaltext) ?></div>
                        </div>
                </div>
                <div class='pvl-button-container'>
                        <div id='pvl-cancel-button' name='pvl-cancel-button'><?= esc_attr($pvltmodalcancel) ?></div>
                        <div id='pvl-accept-button' name='pvl-accept-button'><?= esc_attr($pvltmodalaccept) ?></div>
                </div>
                <?php pvlPoweredBy($powered);?>
	</div>
</div>
<div style='clear:both; padding:10px'></div>
