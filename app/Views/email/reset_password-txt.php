<?php // See app/Views/email/reset_password-html.php -- not currently wired up. ?>
Hi<?php if (strlen($username ?? '') > 0) { ?> <?php echo $username; ?><?php } ?>,

You have changed your password.
Please, keep it in your records so you don't forget it.
<?php if (strlen($username ?? '') > 0) { ?>

Your username: <?php echo $username; ?>
<?php } ?>

Your email address: <?php echo $email; ?>

Thank you,
The <?php echo $site_name; ?> Team
