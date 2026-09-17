<?php
/**
 * Ported verbatim from application/views/email/change_email-html.php.
 * Not currently wired up -- app/Controllers/Account::changeEmail() changes
 * the email immediately after password verification rather than through a
 * confirmation-link step (Shield doesn't provide the underlying token
 * mechanism this relied on, and re-implementing it was out of scope for a
 * personal single-user app). Kept for reference/parity should that change.
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Your new email address on <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Your new email address on <?php echo $site_name; ?></h2>
You have changed your email address for <?php echo $site_name; ?>.<br />
Your email address: <?php echo $new_email ?? $email; ?><br />
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
