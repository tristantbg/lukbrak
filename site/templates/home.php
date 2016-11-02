<?php snippet('header') ?>

<div class="inner">

<?php $slides = $page->gallery()->toStructure() ?>

<div class="slider<?php if ($slides->count() > 1) { echo ' slides'; } ?>">
	
	<?php foreach ($slides as $index => $slide): ?>
		<div class="cell">
			<?php if($slide->_fieldset() == 'image' && $slide->layout()->isEmpty()): ?>
			
			<?php $image = $page->image($slide->content());
				  $caption = $slide->caption();
			      $height = $slide->height();
			?>
			<?php $srcset = '';
				  for ($i = 500; $i <= 5000; $i += 500) $srcset .= resizeOnDemand($image, $i) . ' ' . $i . 'w,';
			?>
			
			<div class="content lazyload<?php if($height->isEmpty()){ echo ' fullscreen'; } ?>" 
			<?php if($height->isEmpty()): ?>
			data-bgset="<?= $srcset ?>" data-sizes="auto"
			style="margin-left: <?= $slide->imageposition() ?>%"
			<?php else: ?>
			style="height: <?= $height ?>%; margin-left: <?= $slide->imageposition() ?>%"
			<?php endif ?>>
						<img 
						src="<?= resizeOnDemand($image, 100) ?>" 
						srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
						data-src="<?= resizeOnDemand($image, 1500) ?>" 
						data-srcset="<?= $srcset ?>" 
						data-sizes="auto" 
						data-optimumx="1.5" 
						class="lazyimg lazyload" 
						alt="<?php if($caption->isEmpty()){ $page->title()->html() . ' — © '.$site->title(); } else { $caption->html() . ' — © '.$site->title(); } ?>" 
						width="auto" height="auto">

				<noscript>
					<img class="content" alt="<?php if($caption->isEmpty()){ $page->title()->html() . ' — © '.$site->title(); } else { $caption->html() . ' — © '.$site->title(); } ?>" src="<?= resizeOnDemand($image, 1500) ?>" height="auto" width="auto" />
				</noscript>	
			</div>
			<?php elseif($slide->_fieldset() == 'video'): ?>

			<?php $caption = $slide->caption();
			      $width = $slide->width(); 
			      $url = $slide->content();

			      ?>

			<div class="content video" 
			<?php if($width->isEmpty()): ?>
			style="margin-left: <?= $slide->imageposition() ?>%"
			<?php else: ?>
			style="width: <?= $width ?>%; margin-left: <?= $slide->imageposition() ?>%"
			<?php endif ?>>
			
			<?php 

			$headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $url);
			if(is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$headers[0]) : false) {
        // is youtube
				$videoID = $url;
				echo '<div class="js-player" data-type="youtube" data-video-id="' . $videoID  . '"></div>';
			} else {
        // should be vimeo
				$videoID = $url;
				echo '<div class="js-player" data-type="vimeo" data-video-id="' . $videoID  . '"></div>';
			}

			?>

			</div>

			<?php endif ?>

			<?php if($caption->isNotEmpty()): ?>
				<div class="caption" style="left: <?= $slide->captionposition()->value() + 50 ?>%">
					<?= $caption->kt() ?>
				</div>
			<?php endif ?>

		</div>

	<?php endforeach ?>


</div>

</div>

<?php snippet('footer') ?>