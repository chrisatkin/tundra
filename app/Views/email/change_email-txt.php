<?php // See app/Views/email/change_email-html.php -- not currently wired up. ?>
Hi<?php if (strlen($username ?? '') > 0) { ?> <?php echo $username; ?><?php } ?>,

You have changed your email address for <?php echo $site_name; ?>.

Your new email: <?php echo $new_email ?? $email; ?>


Thank you,
The <?php echo $site_name; ?> Team
