<?php
function copanel_post_by_year_load_widget() {
    register_widget( 'copanel_post_by_year_widget' );
}
add_action( 'widgets_init', 'copanel_post_by_year_load_widget' );
 
// Creating the widget 
class copanel_post_by_year_widget extends WP_Widget {
 
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'copanel_post_by_year_widget', 
	 
	// Widget name will appear in UI
	__('Copanel Post by years', 'copanel_post_by_year_widget_domain'), 
	 
	// Widget description
	array( 'description' => __( 'Get post sorted by years for Copanel', 'copanel_post_by_year_widget_domain' ), ) 
	);
	}
	 
	// recent post
	 
	public function widget( $args, $instance ) {
		// The output
		global $post;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$cat = $instance['cat'];
		$list_type = $instance['list_type'];
		$this_query = array(
			'post_type' => 'post'
		);
	 	if($cat == 'same'){
	 		$cat_array = array();
	 		foreach( get_the_category() as $cate ){
				$cat_array[] = $cate->term_id;
			}
	 		$this_query['category__in'] = $cat_array;
	 	}
	 	elseif($cat != 'all'){
	 		$this_query['category__in'] = $cat;
	 	}

	 	$date_query = array();
	 	$date_query['after'] = '2019-01-01';
	 	$date_query['before'] = strtotime('first day of january next year');
	 	$date_query['inclusive'] = true;
	 	$this_query['date_query'] = array($date_query);
	 	$now_year = 0;
		$post_list = new WP_Query($this_query);
		$root_url = get_site_url();

		?><ul class = "post_list_ctner post_list_ctner_<?php echo $list_type; ?>"><?php
		if($list_type == 'block'){
			while ( $post_list->have_posts() ){
				$post_list->the_post();
				$this_id = get_the_ID();
				$cates = get_the_category($this_id);
				$link = get_the_permalink();
				$link_thumbnail = get_the_post_thumbnail_url( $this_id, 'large');
				$title = get_the_title();
				$this_year = get_the_date('Y');
				$this_date = get_the_date();
				var_dump($this_date);
				if($this_year != $now_year){
				?>
					<h3 id = 'post_list_<? echo $this_year; ?>' class = 'post_list_year post-anchor'><? echo $this_year; ?></h3>
				<?php
					$now_year = $this_year;
				}
				?><li>
				<a href="<?php echo $link; ?>">
					<div class = "post_list_image" style = "background-image: url('<?php echo $link_thumbnail; ?>')">
					</div>
					<h5><?php echo $title; ?></h5>
				</a>
				<div class = "post_list_categories">
				<?php
			    if(!empty($cates)){
			    	foreach($cates as $cate){
			    		if($cate->name != "Uncategorized"){
			    		?><a class = "post_list_cate" href = '<?php echo get_category_link($cate->term_id); ?> '><?php echo $cate->name; ?></a>
			    		<?php
			        	}
			    	}
			    }
		    ?></div><?php
		    if( !empty( get_the_excerpt()) ){
		    	?>
		    	<div class = "post_list_excerpt">
		    		<p><?php echo get_the_excerpt(); ?>
		    		<a class = "post_list_readMore" href = '<?php echo $link; ?>'>&thinsp;[&thinsp;...&thinsp;]</a></p>
		    	</div>
			<?php
			}
		    ?></li><?php
		}
		}elseif($list_type == 'row'){
			add_filter( 'excerpt_length', 'longer_excerpt_length', 200 );
			while ( $post_list->have_posts() ){
				$post_list->the_post();
				$this_id = get_the_ID();
				$cates = get_the_category($this_id);
				$link = get_the_permalink();
				$link_thumbnail = get_the_post_thumbnail_url( $this_id, 'large');
				$title = get_the_title();
    	?><li>
    		<a href="<?php echo $link; ?>">
    			<div class = "post_list_image" style = "background-image: url('<?php echo $link_thumbnail ?>')"></div>
    		</a>
			<div class = "post_list_text">
				<a href="<?php echo $link; ?>">
					<h5><?php echo $title; ?></h5>
				</a>
				<?php
				if( !empty( get_the_excerpt() )){
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
		        	<?php 
		        	}
		    	}
		    }
		    ?></div>
		</li><?php
		}}
		?></ul><?php
		wp_reset_postdata();
		wp_enqueue_script( 'copanel-anchor_offset', get_template_directory_uri() . '/js/anchor_offset.js', array(), '', true);
	}
	         
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) 
			$title = $instance[ 'title' ];
		else 
			$title = __( '', 'copanel_post_by_year_widget_domain' );
		

		if ( isset( $instance[ 'cat' ] ) ) 
			$cat = $instance[ 'cat' ];
		else 
			$cat = __( 'all', 'copanel_post_by_year_widget_domain' );
		

		if ( isset( $instance[ 'list_type' ] ) ) 
			$list_type = $instance[ 'list_type' ];
		else 
			$list_type = __( 'block', 'copanel_post_by_year_widget_domain' );

	// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />	
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Specify category:' ); ?></label> 
		<select id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" class="widefat" style="width:100%;">
				<optgroup>
					<option <?php selected( $instance['cat'], 'all')?> value = "all">all posts</option>
	             	<option <?php selected( $instance['cat'], 'same')?> value = "same">same categories</option>
             	</optgroup>
             	<optgroup label="----------">
                <?php 
                foreach(get_categories() as $term) { 
				?><option <?php selected( $instance['cat'], $term->term_id )?> value = "<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
             	<?php } ?>
             	</optgroup>
        </select>
        </p>
        <p>
		<label for="<?php echo $this->get_field_id( 'list_type' ); ?>"><?php _e( 'List type:' ); ?></label> 
		<select id="<?php echo $this->get_field_id('list_type'); ?>" name="<?php echo $this->get_field_name('list_type'); ?>" class="widefat" style="width:100%;">
			<option <?php selected( $instance['list_type'],'block' ) ;?> value = "block">blocks</option>
         	<option <?php selected( $instance['list_type'],'row' ); ?> value = "row">rows</option>
         </select>
        </p>
		<?php 
	}
	     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cat'] = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
		$instance['list_type'] = ( ! empty( $new_instance['list_type'] ) ) ? strip_tags( $new_instance['list_type'] ) : '';
		return $instance;
	}
} // Class nymap_widget ends here
