<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package copanel
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		$post_type = get_post_type();
		if($post_type == 'post'){
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );
				// the_post_navigation();
				same_category_posts(3, false);
				same_category_products(3);
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();

				endif;
			endwhile; // End of the loop.
		}elseif($post_type == 'product'){
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );
				// the_post_navigation();
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;
		}
		?>
		</main><!-- #main -->

	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
