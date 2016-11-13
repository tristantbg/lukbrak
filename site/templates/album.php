<?php snippet('header') ?>

<div class="inner">

<?php $slides = $page->gallery()->toStructure() ?>
<?php $slideIndex = 0; ?>

<div class="slider<?php if ($slides->count() > 1) { echo ' slides'; } ?>">
	
	<?php foreach ($slides as $key => $slide): ?>
		<?php $image = $page->image($slide->content());
		$caption = $slide->caption();
		$height = $slide->height();
		$imagesize = $slide->imagesize();
		$imageposition = $slide->imageposition();
		$contain = $slide->contain()->bool();
		$width = $slide->width(); 
		$url = $slide->content();
		?>

		<?php if($slide->_fieldset() == 'image' && $image !== null): ?>
			<?php $slideIndex++ ?>
			<div class="cell" data-id="page-<?= $slideIndex ?>">
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
					alt="<?php if($caption->isEmpty()){ $page->title()->html() . ' — © '.$site->title(); } else { $caption->html() . ' — © '.$site->title(); } ?>" 
					width="auto" height="auto">

					<noscript>
						<img class="content" alt="<?php if($caption->isEmpty()){ $page->title()->html() . ' — © '.$site->title(); } else { $caption->html() . ' — © '.$site->title(); } ?>" src="<?= resizeOnDemand($image, 1500) ?>" height="auto" width="auto" />
					</noscript>	

					<?php if($caption->isNotEmpty()): ?>
						<div class="caption<?php if($slide->captionlight()->bool()){ echo ' light'; } ?>" style="left: <?= $slide->captionposition()->value() + 50 ?>%">
							<?= $caption->kt() ?>
						</div>
					<?php endif ?>

				</div>
				
			</div>
		<?php elseif($slide->_fieldset() == 'video' && $url !== null): ?>
			<?php $slideIndex++ ?>
			<div class="cell" data-id="page-<?= $slideIndex ?>">
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

			<?php if($caption->isNotEmpty()): ?>
				<div class="caption" style="left: <?= $slide->captionposition()->value() + 50 ?>%">
					<?= $caption->kt() ?>
				</div>
			<?php endif ?>

		</div>

	<?php endif ?>

<?php endforeach ?>


</div>

<?php if ($slides->count() > 1): ?>
	<?php $index = $pages->find('index'); ?>
	<div id="flatplan">

		<?php $slideIndex = 0 ?>
		<?php foreach ($slides as $key => $slide): ?>

			<?php if($slide->_fieldset() == 'image' && $page->image($slide->content()) !== null): ?>
				<?php $slideIndex++ ?>
				<?php $image = $page->image($slide->content())->focusCrop( 60,84,array('quality' => 90) )->url(); ?>
				<a class="thumbnail" href="#page-<?= $slideIndex ?>">
					<figure>
						<img class="lazyimg lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?= $image ?>" height="auto" width="60px">
						<figcaption><em><?= $slideIndex ?></em></figcaption>
					</figure>
				</a>
			<?php elseif($slide->_fieldset() == 'video'): ?>
				<?php $slideIndex++ ?>
				<?php if($page->image($slide->image()) !== null): ?>
				<?php $image = $page->image($slide->image())->focusCrop( 60,84,array('quality' => 90) )->url(); ?>
					<a class="thumbnail" href="#page-<?= $slideIndex ?>">
						<figure>
							<img class="lazyimg lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?= $image ?>" height="auto" width="60px">
							<figcaption><em><?= $slideIndex ?></em></figcaption>
						</figure>
					</a>
				<?php endif ?>
			<?php elseif($slide->_fieldset() == 'layout' && $slide->content()->isNotEmpty()): ?>
				<a class="thumbnail layout">
				<figure>
					<img class="lazyimg lazyload" src="data:image/svg+xml;base64,<?= $index->file($slide->content())->base64() ?>" height="84px" width="60px">
					<figcaption><em>X</em></figcaption>
				</figure>
				</a>
			<?php endif ?>

		<?php endforeach ?>
	</div>
<?php endif ?>

<?php if ($slides->count() > 1): ?>
<div id="flattoggle"></div>
<?php endif ?>
	
</div>

<?php snippet('footer') ?>