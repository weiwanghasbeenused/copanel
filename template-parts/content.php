<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package copanel
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php

		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		?>
	</header><!-- .entry-header -->

	<?php copanel_post_feature_img('full'); ?>

	<div class="entry-content">
		<?php
		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta post-meta">
				<?php
				copanel_cato();
				?>
				<div class = 'header-date-author'><?php
				copanel_posted_on();
				// copanel_posted_by();
				?>
				</div>
			</div><!-- .entry-meta -->
		<?php endif; 

		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'copanel' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'copanel' ),
			'after'  => '</div>',
		) );
		if ( 'post' === get_post_type() ) :
			?>
			<div class="footer-meta post-meta">
				<?php
				copanel_cato();
				?>
				<div class = 'header-date-author'><?php
				copanel_posted_on();
				// copanel_posted_by();
				?>
				</div>
			</div><!-- .entry-meta -->
		<?php endif; 
		?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php copanel_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
