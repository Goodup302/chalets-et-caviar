<?php

foreach ((get_the_category()) as $cat) {
	if ($cat->slug == 'leasing') {
		$perMonth = ' par mois';
		break;
	}
}
?>
	<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix postsloop cover_post col-md-4'); ?> itemscope itemtype="http://schema.org/CreativeWork">
		<a href="<?php the_permalink(); ?>" style="display:block;width:100%;height:100%;"></a>
		<div class="content-first">
			<a href="<?php the_permalink(); ?>" class="hover_view_button">
				<div class="button_view">OUVRIR</div>
			</a>
			<div class="content-second">
				<h3 class="the-title" itemprop="headline"><a class="entry-title" rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" ><?php the_title(); ?></a></h3>
			</div>
			<div>
				<img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="<?php echo esc_html(the_post_thumbnail_caption(get_the_ID())); ?>">
			</div>
			<div class="info_post">
				<span><?php echo get_field('post_price'); ?> <i class="fa fa-eur"></i><?php echo $perMonth; ?></span>
				<span><i class="fa fa-area-chart" aria-hidden="true"></i> <?php echo get_field('post_area'); ?> m²</span>
				<span><?php echo get_field('post_user'); ?> <i class="fa fa-users" aria-hidden="true"></i></span>
			</div>
			<div class="desc_post">
				<p class="text_desc"><?php echo the_excerpt(); ?></p>
			</div>					
		</div>
	</div>

