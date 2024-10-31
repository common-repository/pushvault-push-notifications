<?php if( !defined('ABSPATH') )exit; ?>
<?php printPvlBigBlackDiv($pvlObscured); ?> 
<script type="text/javascript">
jQuery(function(){
		if(PushVault.isCompatible()){
			setTimeout(function(){
				<?php showPvlBigBlackDiv($pvlObscured);?>
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
			}, <?= $pvlTimer ?>);
		}else{
	                console.log('pushvault: user not compatible or already subscribed')
	        }
});
</script>
