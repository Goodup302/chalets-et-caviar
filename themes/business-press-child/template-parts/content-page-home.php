<?php
// $fontImages = get_field('content_home_1');
// $logoImages = get_field_object('site_logo'); $logoImages['value']['title'];
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> itemscope itemtype="http://schema.org/CreativeWork">
	<div class="content-first">
		<?php if( get_post_meta( get_the_id(), 'business_press_hide_title', true ) != 1 ) { ?>
			<div class="content-second">
				<h1 class="the-title entry-title" itemprop="headline"><?php the_title(); ?></h1>
			</div>
		<?php } ?>
	</div>

	<div class="entry-content">
		
		<div class="home_slider">
			<?php echo do_shortcode('[smartslider3 slider=1]'); ?>
		</div>

		<div class="col-md-12">
			<div class="home-boxe">
				<?php the_content(); ?>
			</div>
		</div>

		<div class="second_content">
			<div class="col-md-6">
				<div class="home-boxe">
					<?php echo get_field('content_home_1'); ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="home-boxe">
					<?php echo get_field('content_home_2'); ?>		
				</div>
			</div>
		</div>

	</div>
</div>
