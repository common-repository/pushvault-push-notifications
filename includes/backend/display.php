<?php
if( !defined('ABSPATH') )exit;

if(isset($_POST['pvlt-display-option'])){
	$pvltdisplayoption = sanitize_text_field($_POST['pvlt-display-option']);
	$pvlttimeinterval  = sanitize_text_field($_POST['pvlt-time-interval']);
	$pvltcookieinterval= sanitize_text_field($_POST['pvlt-cookie-interval']);
	$pvltshowoptions   = sanitize_text_field($_POST['pvlt-show-options']);
	$pvltobscured 	   = sanitize_text_field($_POST['pvlt-obscured']);
	$pvltpowered 	   = sanitize_text_field($_POST['pvlt-powered']);
	$pvltdisablejquery = sanitize_text_field($_POST['pvlt-disable-jquery']);
	$pvltpaused 	   = sanitize_text_field($_POST['pvlt-paused']);
	update_option('pvlt-display-option', $pvltdisplayoption);
	update_option('pvlt-time-interval',  $pvlttimeinterval);
	update_option('pvlt-cookie-interval',$pvltcookieinterval);
	update_option('pvlt-show-options',   $pvltshowoptions);
	update_option('pvlt-obscured',       $pvltobscured);
	update_option('pvlt-powered',        $pvltpowered);
	update_option('pvlt-disable-jquery', $pvltdisablejquery);
	update_option('pvlt-paused', $pvltpaused);
}
$displayoption   = get_option('pvlt-display-option', '');
$timeinterval    = get_option('pvlt-time-interval','');
$showoptions     = get_option('pvlt-show-options','');
$obscured        = get_option('pvlt-obscured','');
$powered         = get_option('pvlt-powered','on');
$jquery		 = get_option('pvlt-disable-jquery','');
$paused		 = get_option('pvlt-paused','');
$pvlCookieInt    = get_option('pvlt-cookie-interval','30');
?>
<div>
	<div style='display:inline-block; witdth:300px; text-align:center; line-height:30px; margin-left:10px'>
		<div><input type='radio' id='pvlt-display-option' name='pvlt-display-option' value='1' checked></div>
		<div><img src='<?= plugin_dir_url(__FILE__) ?>../../resources/only-prompt.jpg' alt='only-prompt'></div>
		<div>Only Prompt Message</div>
	</div>
	<div style='display:inline-block; witdth:300px; text-align:center; line-height:30px; margin-left:10px'>
		<div><input type='radio' id='pvlt-display-option' name='pvlt-display-option' value='2' <?php if( $displayoption == 2) echo "checked" ?>></div>
		<div><img src='<?= plugin_dir_url(__FILE__) ?>../../resources/top-centered.jpg' alt='only-prompt'></div>
		<div>Top-Centered Modal Message</div>
	</div>
	<div style='display:inline-block; witdth:300px; text-align:center; line-height:30px; margin-left:10px'>
		<div><input type='radio' id='pvlt-display-option' name='pvlt-display-option' value='3' <?php if( $displayoption == 3) echo "checked" ?>></div>
		<div><img src='<?= plugin_dir_url(__FILE__) ?>../../resources/right-bottom.jpg' alt='only-prompt'></div>
		<div>Right-Bottom Modal Message</div>
	</div>
	<div style='display:inline-block; witdth:300px; text-align:center; line-height:30px; margin-left:10px'>
		<div><input type='radio' id='pvlt-display-option' name='pvlt-display-option' value='4' <?php if( $displayoption == 4) echo "checked" ?>></div>
		<div><img src='<?= plugin_dir_url(__FILE__) ?>../../resources/central-modal.jpg' alt='only-prompt'></div>
		<div>Central Modal Message</div>
	</div>
</div>
<div style='margin-top:40px'>
	<div style='display:inline-block; padding:5px'>Time Interval (secs): <select id='pvlt-time-interval' name='pvlt-time-interval'>
					<option value='0' selected>Instant</option>
					<option value='1' <?php if( $timeinterval == 1) echo "selected" ?>>1</option>
					<option value='2' <?php if( $timeinterval == 2) echo "selected" ?>>2</option>
					<option value='5' <?php if( $timeinterval == 5) echo "selected" ?>>5</option>
					<option value='10' <?php if( $timeinterval == 10) echo "selected" ?>>10</option>
				</select>
	</div>
	<div style='display:inline-block; padding:5px'> | </div>
	<div style='display:inline-block; padding:5px'>Show Options: <select id='pvlt-show-options' name='pvlt-show-options'>
					<option value='0' selected>Complete Site</option>
					<option value='1' <?php if( $showoptions == 1) echo "selected" ?>>Exclude Home Page</option>
					<option value='2' <?php if( $showoptions == 2) echo "selected" ?>>ONLY in Home Page</option>
				</select>
	</div>
	<div style='display:inline-block; padding:5px'> | </div>
	<div style='display:inline-block; padding:5px'>Cookie Duration (days): <select id='pvlt-cookie-interval' name='pvlt-cookie-interval'>
					<option value='1' <?php if(  $pvlCookieInt == 1) echo "selected" ?>>1</option>
					<option value='30' <?php if( $pvlCookieInt == 30) echo "selected" ?>>30</option>
					<option value='60' <?php if( $pvlCookieInt == 60) echo "selected" ?>>60</option>
					<option value='90' <?php if( $pvlCookieInt == 90) echo "selected" ?>>90</option>
					<option value='9999' <?php if( $pvlCookieInt == 9999) echo "selected" ?>>Ever</option>
				</select>
	</div>
	<div style='display:inline-block; padding:5px'> | </div>
	<div style='display:inline-block; padding:5px'><input type='checkbox' id='pvlt-obscured' name='pvlt-obscured' <?php if($obscured == 'on') echo 'checked';?>> Obscure content along the process</div>
</div>
<div style='margin-top:10px'>
	<div style='display:inline-block; padding:5px'><input type='checkbox' id='pvlt-disable-jquery' name='pvlt-disable-jquery' <?php if($jquery == 'on') echo 'checked';?>> Remove jQuery include (you must have jquery in your site previously)</div>
</div>
<div style='margin-top:10px'>
	<div style='display:inline-block; padding:5px'><input type='checkbox' id='pvlt-powered' name='pvlt-powered' <?php if($powered == 'on') echo 'checked';?>> "Powered by Pushvault" kind reference (without links)</div>
</div>
<div style='margin-top:10px'>
	<div style='display:inline-block; padding:5px'><input type='checkbox' id='pvlt-paused' name='pvlt-paused' <?php if($paused == 'on') echo 'checked';?>> Temporarily disable captation</div>
</div>
<br>
