<?php snippet('header') ?>

<div class="inner">

<?php $slides = $page->gallery()->toStructure() ?>

<div class="slider<?php if ($slides->count() > 1) { echo ' slides'; } ?>">
	
	<?php foreach ($slides as $index => $slide): ?>
		<?php $image = $page->image($slide->content());
		$caption = $slide->caption();
		$height = $slide->height();
		$imagesize = $slide->imagesize();
		$imageposition = $slide->imageposition();
		$contain = $slide->contain()->bool();
		$width = $slide->width(); 
		$url = $slide->content();
		?>

		<?php if($slide->_fieldset() == 'image' && $slide->layout()->isEmpty() && $image !== null): ?>
			<div class="cell" data-id="page-<?= $index+1 ?>">
				<?php $srcset = '';
				for ($i = 500; $i <= 5000; $i += 500) $srcset .= resizeOnDemand($image, $i) . ' ' . $i . 'w,';
					?>
				
				<div class="content lazyimg<?php if ($slides->count() <= 1){ echo ' lazyload'; } ?><?php if($imagesize == 'full' && !$contain){ echo ' fullscreen'; } elseif($imagesize == 'full' && $contain){ echo ' contain'; } ?>" 
					<?php if($imagesize == 'full'): ?>
						data-bgset="<?= $srcset ?>" data-sizes="auto"
					<?php else: ?>
						style="height: <?= $height ?>%; <?php if($imageposition == '100'){ echo 'margin-left: auto'; } elseif($imageposition == '-100'){ echo 'margin-right: auto'; } else { echo 'margin-left:'.$imageposition . '%'; } ?>"
					<?php endif ?>>
					<img 
					srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
					data-src="<?= resizeOnDemand($image, 1500) ?>" 
					data-srcset="<?= $srcset ?>" 
					data-sizes="auto" 
					data-optimumx="1.5" 
					class="lazyimg<?php if ($slides->count() <= 1){ echo ' lazyload'; } ?>" 
					alt="<?php if($caption->isEmpty()){ echo $page->title()->html() . ' — © '.$site->title(); } else { echo str_replace('*', '', $caption->html()) . ' — © '.$site->title(); } ?>" 
					width="auto" height="auto">

					<?php if($caption->isNotEmpty()): ?>
						<div class="caption" style="left: <?= $slide->captionposition()->value() + 50 ?>%">
							<?= $caption->kt() ?>
						</div>
					<?php endif ?>

					<noscript>
						<img class="content" alt="<?php if($caption->isEmpty()){ echo $page->title()->html() . ' — © '.$site->title(); } else { echo str_replace('*', '', $caption->html()) . ' — © '.$site->title(); } ?>" src="<?= resizeOnDemand($image, 1500) ?>" height="auto" width="auto" />
					</noscript>	

				</div>
				
			</div>
		<?php elseif($slide->_fieldset() == 'video' && $url !== null): ?>
			<div class="cell" data-id="page-<?= $index+1 ?>">
				<div class="content video" 
				<?php if($width->isEmpty()): ?>
					style="margin-left: <?= $slide->imageposition() ?>%"
				<?php else: ?>
					style="width: <?= $width ?>%; margin-left: <?= $slide->imageposition() ?>%"
				<?php endif ?>>
				
				<?php 

				// $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $url);
				// if(is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$headers[0]) : false) {
    //     // is youtube
				// 	$videoID = $url;
				// 	echo '<div class="js-player" data-type="youtube" data-video-id="' . $videoID  . '"></div>';
				// } else {
    //     // should be vimeo
				// 	$videoID = $url;
				// 	echo '<div class="js-player" data-type="vimeo" data-video-id="' . $videoID  . '"></div>';
				// }
				if ($slide->vendor() == "youtube") {
					echo '<div class="js-player" data-type="youtube" data-video-id="' . $url  . '"></div>';
				} else {
					echo '<div class="js-player" data-type="vimeo" data-video-id="' . $url  . '"></div>';
				}

				?>

			</div>

			<?php if($caption->isNotEmpty()): ?>
				<div class="caption" style="left: <?= $slide->captionposition()->value() + 50 ?>%">
					<?= $caption->kt() ?>
				</div>
			<?php endif ?>

		</div>

	<?php endif ?>

<?php endforeach ?>


</div>

</div>

<?php snippet('footer') ?>