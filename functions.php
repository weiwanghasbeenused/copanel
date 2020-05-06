<?php
/**
 * copanel functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package copanel
 */
if ( ! function_exists( 'copanel_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function copanel_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on copanel, use a find and replace
		 * to change 'copanel' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'copanel', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'copanel' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'copanel_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// added by Wei
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 200, 170, true ); // Sets the Post Main Thumbnails 
		add_image_size( 'delicious-recent-thumbnails', 55, 55, true ); // Sets Recent Posts Thumbnails 

	}
endif;
add_action( 'after_setup_theme', 'copanel_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function copanel_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'copanel_content_width', 640 );
}
add_action( 'after_setup_theme', 'copanel_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function copanel_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'copanel' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'copanel' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'copanel_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function copanel_scripts() {
	wp_enqueue_style( 'copanel-style', get_stylesheet_uri() );

	wp_enqueue_script( 'copanel-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'copanel-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'copanel-recent_post', get_template_directory_uri() . '/js/recent_post.js', array());

	wp_enqueue_script( 'copanel-screen_setting', get_template_directory_uri() . '/js/screen_setting.js', array(), '', true);
	
	wp_enqueue_script( 'copanel-mobile', get_template_directory_uri() . '/js/mobile.js', array(),  '', true);


	$post_type = get_post_type();
	if($post_type == 'post'){
		wp_enqueue_script( 'copanel-title_control', get_template_directory_uri() . '/js/title_control.js', array(), '', true);
		wp_enqueue_script( 'copanel-anchor_offset', get_template_directory_uri() . '/js/anchor_offset.js', array(), '', true);
		wp_enqueue_script( 'copanel-post_styling', get_template_directory_uri() . '/js/post_styling.js', array(), '', true);
	}elseif($post_type == 'product'){
		wp_enqueue_script( 'copanel-product_gallery_control', get_template_directory_uri() . '/js/product_gallery_control.js', array(), '', true);
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'copanel_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/* ======================================================
                      my functions
====================================================== */

/* =================================
               filter
================================== */

// remove [...] at the and of excerpts
function new_excerpt_more( $more ) {
    return '';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

// remove "category", "tag", etc on archive page
add_filter( 'get_the_archive_title', function ($title) {    
    if ( is_category() ) {    
            $title = single_cat_title( '', false );    
        } elseif ( is_tag() ) {    
            $title = single_tag_title( '', false );    
        } elseif ( is_author() ) {    
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
        } elseif ( is_tax() ) { //for custom post types
            $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title( '', false );
        }
    return $title;    
});

function longer_excerpt_length( $length ) {
	return 200;
}
function shorter_excerpt_length( $length ) {
	return 100;
}

/* =================================
            simple msg
================================== */
function msg_archive_greeting($current_cato){
	$current_lang = get_bloginfo('language');
	if(!isset($current_cato))
		$current_cato = '';
	if( $current_lang == 'zh-TW')
		echo '<p class = "p-mid">您正在瀏覽所有「<span class = "cate-link">'.$current_cato.'」分類的文章。</span></p>';
	else if( $current_lang == 'zh-CN')
		echo '<p class = "p-mid">您正在浏览所有「<span class = "cate-link">'.$current_cato.'」分类的文章。</span></p>';
	else
		echo '<p class = "p-mid">You are viewing all the posts in catrgory &ldquo;<span class = "cate-link">'.$current_cato.'</span>&rdquo;</p>';
}


/* =================================
            post-fetching
================================== */

// print post as <li>
function print_post_items($this_id, $cates, $listed_post_type, $list_type = 'block', $displayExcerpts = true){
	$link = get_the_permalink();
	$link_thumbnail = get_the_post_thumbnail_url( $this_id, 'large');
	$title = get_the_title();
	if($list_type == 'block'){
		?><li>
			<a href="<?php the_permalink(); ?>">
				<div class = "post_list_image" style = "background-image: url('<?php echo $link_thumbnail; ?>')">
				</div>
				<h5><?php the_title(); ?></h5>
			</a>
			<div class = "post_list_categories">
			<?php
		    if(!empty($cates)){
		    	foreach($cates as $cate){
		    		if($cate->name != "Uncategorized"){
		    			$this_cate_name = $cate->name;
		    			$this_cate_href = $listed_post_type == 'post' ? 'href = "'.get_category_link($cate->term_id).'"' : '';
		    		?><a class = "post_list_cate" <?php echo $this_cate_href; ?> ><?php echo $cate->name; ?></a>
		    		<?php
		        	}
		    	}
		    }
	    ?></div><?php
	    if( !empty( get_the_excerpt() ) && ($listed_post_type != 'product') && $displayExcerpts){
	    	?>
	    	<div class = "post_list_excerpt">
	    		<p><?php echo get_the_excerpt(); ?>
	    		<a class = "post_list_readMore" href = '<?php echo $link; ?>'>&thinsp;[&thinsp;...&thinsp;]</a></p></div>
		<?php
		}
	    ?></li><?php

    }elseif($list_type == 'row'){
    	
	    add_filter( 'excerpt_length', 'longer_excerpt_length', 200 );

    	?><li>
    		<a href="<?php echo $link; ?>">
    			<div class = "post_list_image" style = "background-image: url('<?php echo $link_thumbnail ?>')"></div>
    		</a>
			<div class = "post_list_text">
				<a href="<?php echo $link; ?>">
					<h5><?php echo $title; ?></h5>
				</a>
				<?php
				if( !empty( get_the_excerpt() ) && ($listed_post_type != 'product') ){
			    	?>
			    	<div class = "post_list_excerpt">
			    		<p><?php echo get_the_excerpt(); ?><a class = "post_list_readMore" href = "<?php echo $link; ?>">&thinsp;[&thinsp;...&thinsp;]</a>
			    		</p>
			    	</div>
			    <?php }
		    ?></div>
		    <div class = "post_list_categories">
		    <?php if(!empty($cates)){
		    	foreach($cates as $cate){
		    		if($cate->name != "Uncategorized"){
		    		?><a class = "post_list_cate" href = "<?php echo get_category_link($cate->term_id); ?>" ><?php echo $cate->name; ?></a>
		        	<?php }
		    	}
		    }
		    ?></div>
		</li><?php
    }
}




function get_post_list($arr, $listed_post_type, $list_type = 'block', $displayExcerpts){

	global $post;
	global $current_lang;

	$post_list = new WP_Query($arr);
	$root_url = get_site_url();

	$lang_var['zh-TW']['post'] = '相關文章';
	$lang_var['zh-CN']['post'] = '相关文章';
	$lang_var['en-US']['post'] = 'Recommended Posts';

	$lang_var['zh-TW']['product'] = '推薦房源';
	$lang_var['zh-CN']['product'] = '推荐房源';
	$lang_var['en-US']['product'] = 'Recommended Listing';
	if($post_list->have_posts()){
		?>
		<h4 class = 'recommended_title'><?php echo $lang_var[$current_lang][$listed_post_type]; ?></h4>
		<?php
		printf('<ul class = "'.$listed_post_type.'_rec_list post_list_ctner post_list_ctner_'.$list_type.'">');
		// die();
		while ( $post_list->have_posts() ){
			$post_list->the_post();
			$this_id = get_the_ID();
			if($listed_post_type=='post')
				$cates = get_the_category($this_id);
			elseif($listed_post_type=='product')
				$cates = get_the_terms( $post->ID, 'product_cat' );
			print_post_items($this_id, $cates, $listed_post_type, $list_type, $displayExcerpts);
		}
		printf('</ul>');
		wp_reset_postdata();
	}
}

function recent_posts($post_per_page = 3, $displayExcerpts = true){
	global $post;
	$listed_post_type = 'post';
	$this_query = array(
	    'cat'            => get_queried_object()->term_id,
	    'post__not_in'   => array($post->ID),
	    'post_type'   => 'post',
	    'posts_per_page' => $post_per_page
	);
	get_post_list($this_query,$listed_post_type, 'block', $displayExcerpts);
}

function same_category_posts($post_per_page = 3, $displayExcerpts = true){
	global $post;
	$this_post_type = get_post_type();
	$listed_post_type = 'post';
	$cat_array = array();
	if($this_post_type == 'post'){
		$cate_object = get_the_category();
		foreach( $cate_object as $cate ){
			$cat_array[] = $cate->term_id;
		}
	}
	elseif($this_post_type == 'product'){
		$cate_object = get_the_terms( $post->ID, 'product_cat' );
		foreach( $cate_object as $cate ){
			$thisCatName = $cate->name;
			$thisCat = get_cat_ID($thisCatName);
			if($thisCat && $thisCat !== 0)
				$cat_array[] = $thisCat;
		}
	}
	if(!empty($cat_array)){
		$this_query = array(
			'post_type'   => 'post',
		    'category__in'   => $cat_array,
		    'post__not_in'   => array($post->ID),
		    'post_status' => 'publish',
		    'posts_per_page' => $post_per_page
		);
		get_post_list($this_query, $listed_post_type, 'block', $displayExcerpts);
	}
}
function same_category_products($post_per_page, $displayExcerpts = true){
	global $post;
	$this_post_type = get_post_type();
	$listed_post_type = 'product';
	$tax_array = array();
	if($this_post_type == 'post')
		$cate_object = get_the_category();
	elseif($this_post_type == 'product')
		$cate_object = get_the_terms( $post->ID, 'product_cat' );

	$tax_array = array();
	foreach( $cate_object as $cate ){
		$tax_array[] = $cate->name;
	}
	$this_query = array(
		'post_type'   => $listed_post_type,
	    'post__not_in'   => array($post->ID),
	    'posts_per_page' => $post_per_page,
	    'tax_query' => array(
	    	array(
	    		'taxonomy' => 'product_cat',
	            'field' => 'name',
	            'terms' => $tax_array
	    	),
	    )
	);
	get_post_list($this_query, $listed_post_type, 'block', $displayExcerpts);
}

function copanel_cato() {
	// original: template-parts/template-tags.php

	// printing our category for posts
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( '', 'copanel' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'copanel' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'copanel' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( '%1$s', 'copanel' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
}
function copanel_entry_footer() {
	// copanel_author()
	global $current_lang;
	$author_page = get_page_by_title( '-author-'.$current_lang, '', 'page' );
	if($author_page){
		$post_id = $author_page->ID;
		$post_content = get_post( $post_id )->post_content;
		$first_block = parse_blocks($post_content)[0];
	    echo render_block($first_block);
	}
}

function copanel_post_feature_img($size = 'thumbnail') {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ){
		printf('<div class="post-thumbnail size-'.$size.'">');
		the_post_thumbnail($size);
		printf('</div>');

	}else {

		printf('<a class="post-thumbnail" href="');
		the_permalink();
		printf('aria-hidden="true" tabindex="-1">');
		the_post_thumbnail( 'post-thumbnail', array(
			'alt' => the_title_attribute( array(
				'echo' => false,
			) ),
		) );
		printf('</a>');

	}; // End is_singular().
}


require_once('customized-widget/widget-nymap.php');
require_once('customized-widget/widget-copanel_recent_post.php');
require_once('customized-widget/widget-copanel_product_list.php');
require_once('customized-widget/widget-copanel_slideshow.php');
require_once('customized-widget/widget-copanel_questionnaire.php');

/* ==================================================
			woocommerce
=========================================== */

// unhook Woocommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// hook custom own wrappers to woo page
add_action('woocommerce_before_main_content', 'copanel_product_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'copanel_product_wrapper_end', 10);

function copanel_product_wrapper_start() {
    echo '<div id="mainCtner_product">';
}

function copanel_product_wrapper_end() {
    echo '</div>';
}

// adding support
function copanel_add_woocommerce_support() {
    add_theme_support( 'woocommerce' , array('single_image_width'    => 1400) );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'copanel_add_woocommerce_support' );
// disconnect original woocommerce style;
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


