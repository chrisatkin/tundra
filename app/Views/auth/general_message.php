<?php echo $message ?? session()->getFlashdata('message') ?? session()->getFlashdata('error') ?? ''; ?>
