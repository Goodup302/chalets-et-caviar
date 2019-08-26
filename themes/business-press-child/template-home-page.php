<?php
/**
 * Template Name: Home Page
 *
 */
get_header('home');
?>

<style type="text/css">
	.font-home {
		background-image:url(<?php echo get_field('font_image'); ?>);
	}
</style>

<!-- <div class="col-md-12">
	<div class="left-content" > -->
	<?php
	while( have_posts() ) : the_post();
		
		get_template_part( 'template-parts/content-page', 'home' );

		comments_template();
		
	endwhile;
	?>
	
<!-- 	</div>
</div> -->
<?php get_footer(); ?>