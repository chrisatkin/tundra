<?php
/**
 * Rendered by Shield's MagicLinkController::loginAction() as the
 * 'magic-link-email' view (see app/Config/Auth.php), which passes
 * $token, $user, $ipAddress, $userAgent, $date -- not the $site_name/
 * $user_id/$new_pass_key the old application/views/email/forgot_password-html.php
 * expected. Adapted accordingly: Tank Auth's forgot-password flow asked the
 * user to set a new password on the link; Shield's magic link logs them in
 * directly instead (there's no separate "create a new password" step), so
 * the copy below describes that instead of copying the old wording verbatim.
 */
$site_name = 'Tundra';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Log in to <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Log in to <?php echo $site_name; ?></h2>
Forgot your password, huh? No big deal.<br />
This link will log you straight in -- no password needed:<br />
<br />
<?php $verifyUrl = url_to('verify-magic-link') . '?token=' . $token; ?>
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo $verifyUrl; ?>" style="color: #3366cc;">Log in to <?php echo $site_name; ?></a></b></big><br />
<br />
Link doesn't work? Copy the following link to your browser address bar:<br />
<nobr><a href="<?php echo $verifyUrl; ?>" style="color: #3366cc;"><?php echo $verifyUrl; ?></a></nobr><br />
<br />
<br />
You received this email because it was requested by a <?php echo $site_name; ?> user, from IP address <?php echo esc($ipAddress); ?> using <?php echo esc($userAgent); ?> on <?php echo esc($date); ?>. If you DID NOT request this then please ignore this email.<br />
<br />
<br />
Thank you,<br />
The <?php echo $site_name; ?> Team
</td>
</tr>
</table>
</div>
</body>
</html>
