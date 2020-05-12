<?php
function copanel_slideshow_load_widget() {
    register_widget( 'copanel_slideshow_widget' );
}
add_action( 'widgets_init', 'copanel_slideshow_load_widget' );
 
// Creating the widget 
class copanel_slideshow_widget extends WP_Widget {
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'copanel_slideshow_widget', 
	 
	// Widget name will appear in UI
	__('Copanel Frontpage Slideshow', 'copanel_slideshow_widget_domain'), 
	 
	// Widget description
	array( 'description' => __( 'Display lastest products and a custom page for Copanel', 'copanel_slideshow_widget_domain' ), ) 
	);
	}
	
	public function widget( $args, $instance ) {
		// The output
		global $post;
		global $woocommerce;
		
		$first_slide_title = apply_filters( 'widget_title', $instance['title'] );
		$first_slide_description = $instance['description'];
		$product_slide_num = $instance['product_slide_num'];
		$slide_interval = $instance['slide_interval'];
		$first_slide_background_url = isset($instance['background_url']) ? $instance['background_url'] : '';
		$lang_var = array();
		$lang_var['zh-TW']['bedroom'] = '臥';
		$lang_var['zh-CN']['bedroom'] = '臥';
		$lang_var['en-US']['bedroom'] = ' bedroom(s)';

		$current_lang = get_bloginfo('language');
		// setting up options of filters;
		function loadItems( $post_type, $posts_per_page, $paged, $tax_query){
			$this_query = array(
				'fields' => 'ids',
				'post_type' => $post_type,
				'posts_per_page' => $posts_per_page,
				'paged' => $paged,
				'tax_query' => $tax_query
			);
			return new WP_Query($this_query);
		}
		function displaySlideshow ($post_list, $root_url = null, $lang_var = null, $num, $title = '', $des = '', $background_url = ''){
			global $current_lang;
			?><div id = "slideshow_ctner">
				<div id = "slideshow_viewport">
					<ul>
			<li class = 'slide'>
				<a style = 'background-image: url("<?php echo $background_url; ?>")'>
					<div class = 'slide_info_ctner'>
						<h3 class = 'slideshow_title'><?php echo $title; ?></h3>
						<p class = 'p-mid'><?php echo $des; ?></p>
					</div>
				</a>
			<?php
			while ( $post_list->have_posts() ){
				$post_list->the_post();
				$this_id = get_the_ID();
				$this_title = get_the_title();
				$this_short_description = get_the_excerpt();
				$price = number_format(get_post_meta( $this_id, '_price', true ));
				$bedroom = get_the_terms($this_id, 'pa_bedroom')[0]->name;
				// $cates = get_the_terms($this_id, 'product_cat');
				// $price = number_format(get_post_meta( $this_id, '_price', true ));
				$thumbnail_size = 'large';
			?></li><li class = 'slide'>
				<a href = " <?php the_permalink(); ?>" style = 'background-image: url("<?php echo get_the_post_thumbnail_url( $this_id, $thumbnail_size); ?> ")'>
					<div class = 'slide_info_ctner'>
						<h3 class = 'slideshow_title'><?php echo $this_title; ?></h3>
						<h3 class = 'slideshow_info'><?php echo $bedroom.$lang_var[$current_lang]['bedroom'].'&thinsp;–&thinsp;'.'$'.$price; ?></h3>
						<p class = 'p-mid'><?php echo $this_short_description; ?></p>
					</div>
				</a>
        		<?php 
			}
			?></li></ul>
			<div id = 'slideshow_next' class = "slideshow_control">
				<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39 67.6"><defs><style>.cls-1{fill:#fff;}</style></defs><polygon class="cls-1" points="0 7.94 29.84 33.8 0 59.66 0 67.6 39 33.8 0 0 0 7.94"/></svg>
			</div>
			<div id = 'slideshow_pre' class = "slideshow_control">
				<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39 67.6"><defs><style>.cls-1{fill:#fff;}</style></defs><polygon class="cls-1" points="39 59.66 9.16 33.8 39 7.94 39 0 0 33.8 39 67.6 39 59.66"/></svg>
			</div>
			<div id = 'slideshow_nod_ctner'>
			<?php for($i = 0 ; $i <= $num ; $i++ ) {?>
				<div class = 'slideshow_nod <?php echo ($i == 0) ? "active" : "" ?>'></div>
			<?php } ?>
			</div>
			</div></div><?php 
			wp_reset_postdata();
		}

		$post_list = loadItems('product',$product_slide_num, 1, array());
		displaySlideshow($post_list, null, $lang_var, $product_slide_num, $first_slide_title, $first_slide_description, $first_slide_background_url);

        wp_reset_postdata();
   		remove_filter( 'posts_where', 'filter_where' ); 
  
   		?>
   		<script>
   			var current_slide = 0;
   			var sSlideshow_ctner = document.getElementById('slideshow_ctner');
   			var sSlide = document.getElementsByClassName('slide');
   			var slide_num = sSlide.length;
   			var isPaused = false;

   			var sUl = document.querySelector('#slideshow_viewport > ul');
   			sUl.style.transform = 'translate(-'+current_slide+'00%, 0)';


   			// pre and next
   			var sNext = document.getElementById('slideshow_next');
   			var sPre = document.getElementById('slideshow_pre');
   			var sSlideshow_control = document.getElementsByClassName('slideshow_control');

   			Array.prototype.forEach.call(sSlideshow_control, function(el, i){
   				var thisId = el.id;
   				el.addEventListener('click', function(){
   					if(thisId == 'slideshow_next'){
   						current_slide++;
   						if(current_slide == slide_num)
   							current_slide = 0;
   					}else if(thisId == 'slideshow_pre'){
   						current_slide--;
   						if(current_slide == -1)
   							current_slide = slide_num-1;
   					}
   					updateSlide(current_slide);
   				});

   			});

   			// nods
   			var sNod = document.getElementsByClassName('slideshow_nod');
   			Array.prototype.forEach.call(sNod, function(el, i){
   				el.addEventListener('click', function(){
   					current_slide = i;
   					updateSlide(current_slide);
   				});

   			});
   
 			// auto-sliding
 			setInterval(function(){
 				if(!isPaused){
 					current_slide++;
 					if(current_slide == slide_num)
						current_slide = 0;
					updateSlide(current_slide);
 				}
 			}, <?php echo $slide_interval; ?>);
 			
 			function updateSlide(index){
 				var sNodActive = document.querySelector('.slideshow_nod.active');
 				sNodActive.classList.remove('active');
 				sNod[index].classList.add('active');
 				sUl.style.transform = 'translate(-'+index+'00%, 0)';

 			}

 			// hover on slideshow -> pause slideshow
 			sSlideshow_ctner.addEventListener('mouseenter', function(){
 				if(!isPaused)
 					isPaused = true;
 			});
 			sSlideshow_ctner.addEventListener('mouseleave', function(){
 				if(isPaused)
 					isPaused = false;
 			});
   		</script>
   		<?php
		

	}
	         
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( '', 'copanel_slideshow_widget_domain' );
		}

		if ( isset( $instance[ 'background_url' ] ) )
			$background_url = $instance[ 'background_url' ];
		else
			$background_url = '';

		if ( isset( $instance[ 'description' ] ) )
			$description = $instance[ 'description' ];
		else
			$description = '';

		if ( isset( $instance[ 'product_slide_num' ] ) )
			$product_slide_num = $instance[ 'product_slide_num' ];
		else
			$product_slide_num = 5;

		if ( isset( $instance[ 'slide_interval' ] ) )
			$slide_interval = $instance[ 'slide_interval' ];
		else
			$slide_interval = 5000;

	// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />	
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'background_url' ); ?>">Background image url</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'background_url' ); ?>" name="<?php echo $this->get_field_name( 'background_url' ); ?>" type="text" value="<?php echo esc_attr( $background_url ); ?>" />	
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'description' ); ?>">Text for first slide</label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo stripslashes( $description ); ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'product_slide_num' ); ?>">Number of product slides</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'product_slide_num' ); ?>" name="<?php echo $this->get_field_name( 'product_slide_num' ); ?>" type="number" value="<?php echo esc_attr( $product_slide_num ); ?>" />	
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'slide_interval' ); ?>">Time interval (ms, 1000 = 1 second)</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'slide_interval' ); ?>" name="<?php echo $this->get_field_name( 'slide_interval' ); ?>" type="number" value="<?php echo esc_attr( $slide_interval ); ?>" />	
		</p>
		<?php 
	}  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['background_url'] = ( ! empty( $new_instance['background_url'] ) ) ? strip_tags( $new_instance['background_url'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['product_slide_num'] = ( ! empty( $new_instance['product_slide_num'] ) ) ? strip_tags( $new_instance['product_slide_num'] ) : '';
		$instance['slide_interval'] = ( ! empty( $new_instance['slide_interval'] ) ) ? strip_tags( $new_instance['slide_interval'] ) : 5000;

		return $instance;
	}
} // Class nymap_widget ends here
