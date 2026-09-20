<table class="TundraRssWidget">
	<?php
	$i = 0;
	foreach($feed->get_items() as $item):
	if($i >= request()->getGet('display')) break;
	?>
	<tr>
		<td class="icon" style="width: 16px; padding-top: 2px"><?php echo get_image("arrow_right.png"); ?></td>
		<td class="item" style="text-align: left">
			<?php
					preg_match_all('/<img [^>]*src=["|\']([^"|\']+)/i', $item->get_description(), $matches);
					if(isset($matches[1][0]) && $i == 0 && request()->getGet('image') != 'no')
						echo "<div class='image'><img src='{$matches[1][0]}' /></div>";

					if(request()->getGet('image') != 'no')
					{
						//echo "<div class='image'><img src='". $item->thumbnail() . "' /></div>";
					}
			?>
			<a target="_blank" href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a>
			<?php if($i == 0 || (request()->getGet('preview') !== null)): ?>
				<div class="summary"><?php echo word_limiter(strip_tags($item->get_content() , '<script><a>'), 40); ?></div>
			<?php endif; ?>
		</td>
	</tr>
	<?php
	$i++;
	endforeach;?>
</table>
