<?php
/**
 * Ported verbatim from application/views/email/activate-html.php.
 * Not currently wired up -- app/Config/Auth.php's $actions['register'] is
 * null (auto-activate), matching Tank Auth's own email_activation = FALSE
 * default. Kept for reference/parity should activation-on-register ever
 * be turned on (Shield's EmailActivator action would need its own view
 * override pointed at this pair instead).
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Welcome to <?php echo $site_name; ?>!</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Welcome to <?php echo $site_name; ?>!</h2>
Thanks for joining <?php echo $site_name; ?>. We listed your sign in details below, make sure you keep them safe.<br />
To verify your email address, please follow this link:<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('auth/login'); ?>" style="color: #3366cc;">Finish your registration...</a></b></big><br />
<br />
<?php if (isset($activation_period)) { ?>Please verify your email within <?php echo $activation_period; ?> hours, otherwise your registration will become invalid and you will have to register again.<br /><?php } ?>
<br />
<br />
<?php if (strlen($username ?? '') > 0) { ?>Your username: <?php echo $username; ?><br /><?php } ?>
Your email address: <?php echo $email; ?><br />
<br />
<br />
Have fun!<br />
The <?php echo $site_name; ?> Team
</td>
</tr>
</table>
</div>
</body>
</html>
