<?php if( !defined('ABSPATH') )exit; ?>
<div id='pvl-ask-permision-modal' name='pvl-ask-permision-modal' class='pvl-ask-permision-modal-top-centered'>
	<div class='pvl-sub-modal-top-centered'>
        	<div class='pvl-text-main-container'>
	                <div class='pvl-text-icon-container'>
				<img src='<?php if( $pvltimagemodal > 0) echo wp_get_attachment_url( $pvltimagemodal ); else echo plugin_dir_url(__FILE__). "../../resources/default_logo.png"; ?>' alt=''/>
			</div>
	                <div>
				<div class='pvl-modal-title'><?= $pvltmodaltitle ?></div>
				<div class='pvl-modal-text'><?= $pvltmodaltext ?></div>
			</div>
	        </div>
	        <div class='pvl-button-container'>
	                <div id='pvl-cancel-button' name='pvl-cancel-button'><?=$pvltmodalcancel ?></div>
	                <div id='pvl-accept-button' name='pvl-accept-button'><?=$pvltmodalaccept ?></div>
	        </div>
		<?php pvlPoweredBy($poweredBy);?>
	</div>
</div>
<?php printPvlBigBlackDiv($pvlObscured); ?> 

<script type="text/javascript">
jQuery(function(){
		if(PushVault.isCompatible() && getPvltCookie() != 1){
			setTimeout(function(){
				<?php showPvlBigBlackDiv($pvlObscured);?>
				jQuery('#pvl-ask-permision-modal').animate({"top": "0px"}, "500");
			}, <?= $pvlTimer ?>);
		}else{
			console.log('pushvault: user not compatible or already subscribed')
		}
});
jQuery('#pvl-cancel-button').click(function() {
	<?php hidePvlBigBlackDiv($pvlObscured);?>
	setPvltCookie(<?= $pvlCookieInt ?>);
	jQuery('#pvl-ask-permision-modal').animate({"top": "-210px"}, "500");
});
jQuery('#pvl-accept-button').click(function() {
	jQuery('#pvl-ask-permision-modal').hide();
	PushVault.askPermission({
                uid: '<?=$uid_value?>',
                publicKey: '<?=$publicKey_value?>',
                gcmSenderId: '<?=$sender_id_value?>',
                serviceWorkerPath:'<?= plugin_dir_url(__FILE__)?>../../pushVaultServiceWorker.js',
                category:'mainstream',
                source:'web'
                }, function(response){
                       if(response.error){
                        // Error getting permission
                        console.log('pushvault:' + response.message)
                       }else{
                        // Success!!
                        console.log('pushvault: notification accepted')
                       }
		<?php hidePvlBigBlackDiv($pvlObscured);?>
        });	
});
function setPvltCookie(exdays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    document.cookie="pvlt_disabled=1; expires="+exdate.toUTCString()+"; path=/";
}
function getPvltCookie(){
    var c_value = document.cookie;
    var c_start = c_value.indexOf("pvlt_disabled=");
    if (c_start == -1){
        c_start = c_value.indexOf("pvlt_disabled=");
    }
    if (c_start == -1){
        c_value = null;
    }else{
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1){
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}
</script>
