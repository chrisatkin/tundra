<?php
$site_name = 'Tundra';
$verifyUrl = url_to('verify-magic-link') . '?token=' . $token;
?>
Hi <?php echo esc($user->username ?? ''); ?>,

Forgot your password, huh? No big deal.
This link will log you straight in -- no password needed:

<?php echo $verifyUrl; ?>


You received this email because it was requested by a <?php echo $site_name; ?> user, from IP address <?php echo esc($ipAddress); ?> using <?php echo esc($userAgent); ?> on <?php echo esc($date); ?>. If you DID NOT request this then please ignore this email.


Thank you,
The <?php echo $site_name; ?> Team
