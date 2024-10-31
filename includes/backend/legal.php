<?php
if( !defined('ABSPATH') )exit;
?>
<div>Remmember you need to explain your visitors how to manage their subscription and how you will manage the notification database. You can copy this example legal terms to your cookies-terms page or legal-terms page:</div>
<div style="margin:30px 0;">
<?php $content = "<h3>WebPush Notifications</h3>
<p>The webpush notification is a service related to your browser that allow us to send messages directly to your device. We dont collect any information about your identity so we can not revoque the authorization of sending messages from our side.</p>
<p>When you accept our page to send notifications, you are accepting we will send comercial comunications and/or promotional messages of your interest.</p>
<p>You can see the status of notifications in your browser and manage them <a href='https://support.google.com/chrome/answer/3220216?co=GENIE.Platform%3DDesktop&hl=en' rel='nofollow'>following this instructions</a> (provided by Google).</p>
<p>If your prefer, you can disallow notifications by clicking this switch in case you have it active:</p>
<p>[pvlt_disallow_button]</p>";?>
<?php wp_editor( $content, 'pvlt_legal_example' ); ?> 
</div>
<div>You can use the tag <strong>[pvlt_disallow_button]</strong> in any page/article to create a switch button and give user the option to unsubscribe (deactivating in our database) just clicking it</div>
