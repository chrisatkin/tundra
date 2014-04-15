<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed"); ?>

<table class="TundraRssWidget">
	<?php
	$i = 0;
	foreach($feed as $item):
	if($i >= $this->input->get('display')) break;
	?>
	<tr>
		<td class="icon" style="width: 16px; padding-top: 2px"><?php echo get_image("arrow_right.png"); ?></td>
		<td class="item" style="text-align: left">
			<?php
					preg_match_all('/<img [^>]*src=["|\']([^"|\']+)/i', $item->getDescription(), $matches);	
					if(isset($matches[1][0]) && $i == 0 && $this->input->get('image') != 'no')
						echo "<div class='image'><img src='{$matches[1][0]}' /></div>";
						
					if($this->input->get('image') != 'no')
					{						
						//echo "<div class='image'><img src='". $item->thumbnail() . "' /></div>";
					}
			?>
			<a target="_blank" href="<?php echo $item->getLink(); ?>"><?php echo $item->getTitle(); ?></a>
			<?php if($i == 0 || (isset($_GET['preview']) && $_GET['preview'] = 'all')): ?>
				<div class="summary"><?php echo word_limiter(strip_tags($item->getContent() , '<script><a>'), 40); ?></div>
			<?php endif; ?>
		</td>
	</tr>
	<?php
	$i++;
	endforeach;?>
</table>