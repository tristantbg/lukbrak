<!-- Website developed by Tristan Bagot -->

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>

	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="dns-prefetch" href="//www.google-analytics.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="canonical" href="<?php echo html($page->url()) ?>" />
	<?php if($page->isHomepage()): ?>
		<title><?= $site->title()->html() ?></title>
	<?php else: ?>
		<title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>
	<?php endif ?>
	<?php if($page->isHomepage()): ?>
		<meta name="description" content="<?= $site->description()->html() ?>">
	<?php else: ?>
		<meta name="DC.Title" content="<?= $page->title()->html() ?>" />
		<?php if(!$page->text()->empty()): ?>
			<meta name="description" content="<?= $page->text()->excerpt(250) ?>">
			<meta name="DC.Description" content="<?= $page->text()->excerpt(250) ?>"/ >
			<meta property="og:description" content="<?= $page->text()->excerpt(250) ?>" />
		<?php else: ?>
			<meta name="description" content="">
			<meta name="DC.Description" content=""/ >
			<meta property="og:description" content="" />
		<?php endif ?>
	<?php endif ?>
	<meta name="robots" content="index,follow" />
	<meta name="keywords" content="<?= $site->keywords()->html() ?>">
	<?php if($page->isHomepage()): ?>
		<meta itemprop="name" content="<?= $site->title()->html() ?>">
		<meta property="og:title" content="<?= $site->title()->html() ?>" />
	<?php else: ?>
		<meta itemprop="name" content="<?= $page->title()->html() ?> | <?= $site->title()->html() ?>">
		<meta property="og:title" content="<?= $page->title()->html() ?> | <?= $site->title()->html() ?>" />
	<?php endif ?>
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?= html($page->url()) ?>" />
	<?php if($page->content()->name() == "album"): ?>
		<?php if (!$page->featured()->empty()): ?>
			<meta property="og:image" content="<?= resizeOnDemand($page->image($page->featured()), 1200) ?>"/>
		<?php endif ?>
	<?php else: ?>
		<?php if(!$site->ogimage()->empty()): ?>
			<meta property="og:image" content="<?= $site->ogimage()->toFile()->width(1200)->url() ?>"/>
		<?php endif ?>
	<?php endif ?>

	<meta itemprop="description" content="<?= $site->description()->html() ?>">
	<link rel="shortcut icon" href="<?= url('assets/images/favicon.ico') ?>">
	<link rel="icon" href="<?= url('assets/images/favicon.ico') ?>" type="image/x-icon">

<!-- 	<script>
	    // function loadJS(u){var r=document.getElementsByTagName("script")[0],s=document.createElement("script");s.src=u;r.parentNode.insertBefore(s,r);}

	    // if(!window.HTMLPictureElement || !('sizes' in document.createElement('img'))){
	    //     loadJS("/assets/js/vendor/ls.respimg.min.js");
	    // }
	</script> -->

	<?php 
	echo css('assets/css/build/build.min.css');
	echo js('assets/js/vendor/modernizr.min.js');
	?>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= url('assets/js/vendor/jquery.min.js') ?>">\x3C/script>')</script>

	<?php if(!$site->customcss()->empty()): ?>
		<style type="text/css">
			<?php echo $site->customcss()->html() ?>
		</style>
	<?php endif ?>

</head>
<?php $pname = $page->content()->name(); ?>
<body <?php if($pname == 'album'){ echo ' class="album"'; } elseif($page->isHomepage()) { } else { echo ' class="page"'; } ?>>

<div class="loader"></div>

<header>
	<div id="site-title" class="uppercase">
	<?php if($site->logopng()->isNotEmpty() && $site->logosvg()->isNotEmpty()): ?>
		<a href="<?= $site->url() ?>" data-title="<?= $site->title()->html() ?>" data-target="index">
			<img src="<?= $site->logosvg()->toFile()->url() ?>" onerror="this.src='<?= $site->image($site->logopng())->url() ?>'; this.onerror=null;" alt="<?= $site->title()->html() ?>" width="<?= $site->logowidth() ?>%">
		</a>
	<?php else: ?>
		<a href="<?= $site->url() ?>" data-title="<?= $site->title()->html() ?>" data-target="index"><?= $site->title()->html() ?></a>
	<?php endif ?>
	</div>
	<div id="menu">
		<div id="index" class="italic">
			<?php $index = $pages->find('index'); ?>
			<?= $index->title()->html() ?>
		</div>
		<div id="contact" class="italic">
			<?php $contact = $pages->find('contact'); ?>
			<a href="<?= $contact->url() ?>" data-title="<?= $contact->title()->html() ?>" data-target="page"><?= $contact->title()->html() ?></a>
		</div>
	</div>
</header>

<div id="navigation">
	<?php $albums = $index->children()->visible() ?>
	<nav>
		<ul>
			<?php foreach($albums as $album): ?>
			<?php $titleformat = $album->titleformatting()->split() ?>
				<li class="uppercase<?php e(in_array('clear', $titleformat), ' clear') ?><?php e(in_array('italic', $titleformat), ' italic') ?><?php e($album->isOpen(), ' active') ?>">
				<?php if($album->externallink()->isEmpty()): ?>
					<a class="album-title" href="<?php echo $album->url() ?>" data-title="<?= $album->title()->html() ?>" data-target="album">
				<?php else: ?>
					<a href="<?= $album->externallink() ?>" target="_blank">
				<?php endif ?>
				<?php if(in_array('comma', $titleformat)){ echo $album->title()->html().', '; } else { echo $album->title()->html(); } ?>
				</a>
				</li>
			<?php endforeach ?>
		</ul>
	</nav>
</div>

<div id="container">