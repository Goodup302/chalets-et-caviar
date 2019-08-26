<?php
get_header();

$single_layout = esc_attr( get_theme_mod( 'business_press_blog_single_layout', 'rights' ) );
while( have_posts() ) : the_post();

foreach ((get_the_category()) as $cat) {
	if ($cat->slug == 'leasing') {
		$buyType = 'Louer';
		$perMonth = ' par mois';
		break;
	} else if ($cat->slug == 'sale'){
		$buyType = 'Acheter';
		break;
	}
}
?>

<div class="single_post">
		<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> itemscope itemtype="http://schema.org/CreativeWork">
			<div class="content-first">
					
				<?php
				if( get_post_meta( get_the_id(), 'business_press_hide_title', true ) != 1 )
				{
				?>
					<div class="content-second">
						<h1 class="the-title entry-title" itemprop="headline"><?php the_title(); ?></h1>
					</div>
				<?php
				}
				?>
						
				<div class="main_content" itemprop="text">
					<div class="content_head">
						<div class="col-md-9">
							<img class="main_img img-responsive" src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="<?php echo esc_html(the_post_thumbnail_caption(get_the_ID())); ?>">
						</div>
						<div class="col-md-3 info_post">
							<h3>Caractéristiques</h3>
							<span><?php echo get_field('post_price'); ?> <i class="fa fa-eur"></i><?php echo $perMonth; ?></span>
							<span><i class="fa fa-area-chart" aria-hidden="true"></i> <?php echo get_field('post_area'); ?> m²</span>
							<span><?php echo get_field('post_user'); ?> <i class="fa fa-users" aria-hidden="true"></i></span>
							<br>
							<h3><?php echo $buyType; ?></h3>
							<p>Ce chalet vous plaît, nous sommes à votre disposition pour toute information complémentaire.</p>
							<a href="<?php echo get_site_url(); ?>/nous-contacter" class="btn btn-warning">Nous Contacter</a>
						</div>
					</div>
					<span class=" spacer"></span>
					<div class="col-md-12 entry-content">
						<h3>Déscription</h3>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
</div>

<?php
// comments_template();

business_press_post_pagination();
		
endwhile;
?>
<?php if( $single_layout == 'rights' || $single_layout == 'lefts' ) { get_sidebar(); } ?>
<?php get_footer(); ?>