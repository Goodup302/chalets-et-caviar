<?php
get_header();
$archive_layout = esc_attr( get_theme_mod( 'business_press_blog_archive_layout', 'rights' ) );
?>
<div class="left-content" >

		<?php
		if( have_posts() )
		{
			$col = 0;
			while( have_posts() ) : the_post();
				if (true) {
					if ($col == 0) { echo '<div class="row">'; }
					get_template_part( 'template-parts/content', 'loop' );
					$col++;
					if ($col == 3) { echo '</div>'; $col = 0; }
				}
			endwhile;

			// business_press_posts_pagination();

		}
		else
		{
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
</div>
<?php if( $archive_layout == 'rights' || $archive_layout == 'lefts' ) { get_sidebar(); } ?>
<?php get_footer(); ?>
