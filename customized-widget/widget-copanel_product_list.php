<?php
function copanel_product_list_load_widget() {
    register_widget( 'copanel_product_list_widget' );
}
add_action( 'widgets_init', 'copanel_product_list_load_widget' );
 
$current_lang = get_bloginfo('language');
$filter_var_list = array("bedroom", "bathroom", "area", "housing-type", "price");

// Creating the widget 
class copanel_product_list_widget extends WP_Widget {
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'copanel_product_list_widget', 
	 
	// Widget name will appear in UI
	__('Copanel Product List', 'copanel_product_list_widget_domain'), 
	 
	// Widget description
	array( 'description' => __( 'Display product list with subfunctions for Copanel', 'copanel_product_list_widget_domain' ), ) 
	);
	}
	public function widget( $args, $instance ) {
		// The output
		global $post;
		global $woocommerce;
		global $current_lang;
		global $filter_var_list;

		// $max_price = get_variation_price('max');
		$house_list_url = get_permalink();
		
		$wc_attributes_raw = wc_get_attribute_taxonomies();
		$attr_list = array();
		
		$filter_var = array();
		$filter_var["bedroom"]["input-type"] = "select";
		$filter_var["bathroom"]["input-type"] = "select";
		$filter_var["area"]["input-type"] = "checkbox";
		$filter_var["housing-type"]["input-type"] = "checkbox";
		$filter_var["price"]["input-type"] = "select";

		// setting up options in filters;
		foreach($filter_var_list as $fvl){
			$thisAttr = $fvl;
			$attr_list[] = $thisAttr;
			if($fvl == 'price'){
				// using wpdb to get all values of a certain meta key
				global $wpdb;

			    $priceOption = $wpdb->get_col( $wpdb->prepare( "
			        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
			        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			        WHERE pm.meta_key = %s 
			        AND p.post_status = %s 
			        AND p.post_type = %s
			    ", '_price', 'publish', 'product' ) );
			    foreach ($priceOption as &$po)
			    	$po = intval($po); 

			    $interval = 100000;
			    $max_price = max($priceOption);
			    $min_price = min($priceOption);
			    if($max_price % $interval != 0)
					$max_price = ( intval($max_price / $interval)+1 ) * $interval;
				if($min_price % $interval != 0)
					$min_price = intval($min_price / $interval) * $interval;
				$loop_length = ($max_price - $min_price) / $interval;
				$price_range = array();
				for($i = 0; $i <= $loop_length; $i++)
					$price_range[] = $min_price + $i * $interval;
				$filter_var[$thisAttr]["options"][0] = $price_range;
				$filter_var[$thisAttr]["options"][1] = $price_range;
				array_pop($filter_var[$thisAttr]["options"][0]);
				array_shift($filter_var[$thisAttr]["options"][1]);
				array_unshift($filter_var[$thisAttr]["options"][0], 'no minimum');
				array_unshift($filter_var[$thisAttr]["options"][1], 'no maximum');

			}else{
				$thisAttrOptions = get_terms('pa_'.$thisAttr);

				if($filter_var[$thisAttr]["input-type"] == "select"){
					// key '0' for min, key '1' for max;
					foreach($thisAttrOptions as $thisAttrOption)
						$filter_var[$thisAttr]["options"][0][] = intval($thisAttrOption->name);
					$max_val = max($filter_var[$thisAttr]["options"][0]);
					$min_val = min($filter_var[$thisAttr]["options"][0]);
					$filter_var[$thisAttr]["options"][0] = range($min_val, $max_val);
					$filter_var[$thisAttr]["options"][1] = $filter_var[$thisAttr]["options"][0];
					
					array_pop($filter_var[$thisAttr]["options"][0]);
					array_shift($filter_var[$thisAttr]["options"][1]);
					array_unshift($filter_var[$thisAttr]["options"][0], 'no minimum');
					array_unshift($filter_var[$thisAttr]["options"][1], 'no maximum');
					
				}
				else{
					foreach($thisAttrOptions as $thisAttrOption){
						$filter_var[$thisAttr]["options"][] = $thisAttrOption->name;
					}
				}


			}
			
			
		}

		// translating attributes

		$lang_var = array();
		$lang_var['zh-TW']['bedroom'] = '臥';
		$lang_var['zh-TW']['bathroom'] = '衛';
		$lang_var['zh-TW']['filter-area'] = '地區';
		$lang_var['zh-TW']['filter-price'] = '價格';
		$lang_var['zh-TW']['filter-bedroom'] = '臥室數';
		$lang_var['zh-TW']['filter-bathroom'] = '衛浴數';
		$lang_var['zh-TW']['filter-housing-type'] = '房型';
		$lang_var['zh-CN']['bedroom'] = '臥';
		$lang_var['zh-CN']['bathroom'] = '卫';
		$lang_var['zh-CN']['filter-area'] = '地区';
		$lang_var['zh-CN']['filter-price'] = '价格';
		$lang_var['zh-CN']['filter-bedroom'] = '臥室数';
		$lang_var['zh-CN']['filter-bathroom'] = '卫浴数';
		$lang_var['zh-CN']['filter-housing-type'] = '房型';
		$lang_var['en-US']['bedroom'] = ' bedroom(s)';
		$lang_var['en-US']['bathroom'] = ' bathroom(s)';
		$lang_var['en-US']['filter-area'] = 'Area';
		$lang_var['en-US']['filter-price'] = 'Price range';
		$lang_var['en-US']['filter-bedroom'] = 'Bedroom(s)';
		$lang_var['en-US']['filter-bathroom'] = 'Bathrooms(s)';
		$lang_var['en-US']['filter-housing-type'] = 'Housing type';

		$lang_var['zh-TW']['toggle-filter'] = '篩選房源';
		$lang_var['zh-CN']['toggle-filter'] = '筛选房源';
		$lang_var['en-US']['toggle-filter'] = 'Filter';
		$lang_var['zh-TW']['submit'] = '套用';
		$lang_var['zh-CN']['submit'] = '套用';
		$lang_var['en-US']['submit'] = 'Apply';
		$lang_var['zh-TW']['reset'] = '清除';
		$lang_var['zh-CN']['reset'] = '清除';
		$lang_var['en-US']['reset'] = 'Reset filter';

		$lang_var['zh-TW']['Brooklyn'] = '布魯克林';
		$lang_var['zh-CN']['Brooklyn'] = '布鲁克林';
		$lang_var['en-US']['Brooklyn'] = 'Brooklyn';
		$lang_var['zh-TW']['Queens'] = '皇后區';
		$lang_var['zh-CN']['Queens'] = '皇后区';
		$lang_var['en-US']['Queens'] = 'Queens';
		$lang_var['zh-TW']['Manhattan'] = '曼哈頓';
		$lang_var['zh-CN']['Manhattan'] = '曼哈顿';
		$lang_var['en-US']['Manhattan'] = 'Manhattan';

		$lang_var['zh-TW']['apartment'] = '公寓';
		$lang_var['zh-CN']['apartment'] = '公寓';
		$lang_var['en-US']['apartment'] = 'apartment';
		$lang_var['zh-TW']['studio'] = '工作室';
		$lang_var['zh-CN']['studio'] = '工作室';
		$lang_var['en-US']['studio'] = 'studio';
		$lang_var['zh-TW']['condo'] = '獨立產權公寓';
		$lang_var['zh-CN']['condo'] = '独立产权公寓';
		$lang_var['en-US']['condo'] = 'condo';
		$lang_var['zh-TW']['coop'] = '合作公寓';
		$lang_var['zh-CN']['coop'] = '合作公寓';
		$lang_var['en-US']['coop'] = 'coop';
		$lang_var['zh-TW']['house'] = '獨棟別墅';
		$lang_var['zh-CN']['house'] = '独栋别墅';
		$lang_var['en-US']['house'] = 'house';
		$lang_var['zh-TW']['multifamily'] = '多單元房';
		$lang_var['zh-CN']['multifamily'] = '多单元房';
		$lang_var['en-US']['multifamily'] = 'multifamily';

		$lang_var['zh-TW']['no maximum'] = '無上限';
		$lang_var['zh-CN']['no maximum'] = '无上限';
		$lang_var['en-US']['no maximum'] = 'no maximum';
		$lang_var['zh-TW']['no minimum'] = '無下限';
		$lang_var['zh-CN']['no minimum'] = '无下限';
		$lang_var['en-US']['no minimum'] = 'no minimum';

		$lang_var['zh-TW']['noresult'] = '抱歉！目前沒有符合條件的房源！';
		$lang_var['zh-CN']['noresult'] = '抱歉！目前没有符合条件的房源！';
		$lang_var['en-US']['noresult'] = 'Sorry! There are no items fitting the filter.';
		
		$url_query_value = array();
		$tax_filter = array();
		$tax_filter['relation'] = 'AND';
		$meta_query = array();
		// getting query from url
		foreach ($filter_var_list as $fvl) {
			if(!empty($_GET[$fvl]))
				$url_query_value[$fvl] = $_GET[$fvl];
			else
				$url_query_value[$fvl] = false;
		}
		foreach($url_query_value as $key => $val){
		  	if($val){
		  		if($key == 'price'){
		  			$this_meta_query = array(
			  			'key' => '_'.$key,
			  			'type' => 'numeric'
			  		);
			  		// [ -1, -1]  is filtered out in query_control.js
			  		$min = intval($val[0]);
		  			$max = intval($val[1]);
		  			if($max!=$min){	
		  				if($max == -1){
	  						// $max = $maximum_number;
	  						$this_meta_query['value'] = $min;
  							$this_meta_query['compare'] = '>=';

		  				}else{
		  					$this_meta_query['value'] = array($min, $max); 
		  					$this_meta_query['compare'] = 'BETWEEN';
		  				}
		  			}else{
		  				$this_meta_query['value'] = $min;
		  			}
		  			$meta_query[] = $this_meta_query;
		  		}else{
		  			$this_tax_filter = array(
			  			'taxonomy' => 'pa_'.$key,
			  			'field'    => 'slug',
			  		);
			  		if(is_array($val)){
			  			if(is_numeric($val[0])){
			  				$min = $val[0];
				  			$max = $val[1];
				  			if($max!=$min){		
				  				if($max == -1 || $max == '')
			  						$max = 100;
		  						if($key == 'bathroom' || $key == 'bedroom')
		  							$this_tax_filter['terms'] = range($min, $max, 0.5);
		  						else
		  							$this_tax_filter['terms'] = range($min, $max);
		  					}else
				  				$this_tax_filter['terms'] = $min;
			  			}else{
			  				$this_tax_filter['terms'] = $val;
			  			}
			  		}else{
			  			$this_tax_filter['terms'] =  $val;
			  		}
			  		$tax_filter[] = $this_tax_filter;
		  		}
		  	}else{
		  		$url_query_value[$key] = array();
		  	}
		}


		function loadItems( $post_type, $posts_per_page, $paged, $meta_query, $tax_query){
			$this_query = array(
				'fields' => 'ids',
				'post_type' => $post_type,
				'posts_per_page' => $posts_per_page,
				'paged' => $paged,
				'meta_query' => $meta_query,
				'tax_query' => $tax_query
			);
			return new WP_Query($this_query);
		}
		function displayList ($post_list, $root_url, $lang_var){
			global $current_lang;
			?><ul class = "product_list_ctner">
			<?php
			if($post_list->have_posts()){
			while ( $post_list->have_posts() ){
				$post_list->the_post();
				$this_id = get_the_ID();
				$cates = get_the_terms($this_id, 'product_cat');
				$price = number_format(get_post_meta( $this_id, '_price', true ));
				$bedroom = get_the_terms($this_id, 'pa_bedroom')[0]->name;
				$bathroom = get_the_terms($this_id, 'pa_bathroom')[0]->name;
				$housing_type = get_the_terms($this_id, 'pa_housing-type')[0]->name;
				$thumbnail_size = 'large';
			?><li>
				<a href = " <?php the_permalink(); ?>">
					<div class = "post_list_image" style = 'background-image: url("<?php echo get_the_post_thumbnail_url( $this_id, $thumbnail_size); ?> ")' ></div>
				</a>
				<a class = 'product_list_title' href = " <?php the_permalink(); ?>" >
					<h5><?php echo get_the_title(); ?></h5>
					<h5>$<?php echo $price; ?></h5>
				</a><div class = "product_list_info">
						<div class = "product_list_categories">
						<?php
			        	if(!empty($cates)){
				        	foreach($cates as $cate){
				        		if($cate->name != "Uncategorized"){
		        		?>
		        		<a class = "post_list_cate" ><?php echo $cate->name ?></a>
		        		<?php
				            	}
				        	}
			        	} ?>
			        </div>
	        		<p><?php echo $bedroom.$lang_var[$current_lang]['bedroom']; ?> | <?php echo $bathroom.$lang_var[$current_lang]['bathroom']; ?> | <?php echo $lang_var[$current_lang][$housing_type]; ?></p>
        		</div>
        		</li><?php 
			}
			?></ul><?php 
			wp_reset_postdata();
			}else{
				// no posts
				?>
				<div id = 'noresult'>
					<? echo $lang_var[$current_lang]['noresult']; ?>
				</div>
				<?php
			}
		}
		
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$post_list = loadItems('product', 4, $paged,$meta_query, $tax_filter);
		$root_url = get_site_url();
		?>
		<div id = "filter_ctner">
			<div id = 'filter_toggle_btn'>
				<?php echo $lang_var[$current_lang]['toggle-filter']; ?>
			</div>
			<div id = "filter_expand_btn">
				<div class = "filter_btn_bar"></div>
				<div class = "filter_btn_bar"></div>
				<div class = "filter_btn_bar"></div>
			</div>
			<div id = filter_form_ctner>
		        <form id = "house_list_form" action = "<?php echo $house_list_url; ?>" method = "GET">
		        	<input type = "hidden" name = "page_id" value = "<?php echo $post->ID; ?>">
		        	<?php 
		        	foreach($filter_var_list as $field){ 
		        		$field_lang = 'filter-'.$field;
						if($filter_var[$field]['input-type'] == 'input'){ ?>
			    			<div class = "filter_field <?php echo $field; ?>_field">
			        			<label class = 'filter_label single_label'><?php echo $lang_var[$current_lang][$field_lang]; ?></label>
			 					<?php 
			 					foreach( $filter_var[$field]["options"] as $key => $fo ){ ?>
		 						<input id = "" class = "house_list_filter" name = "<?php echo $field; ?>[]" value = "<?php echo ($url_query_value[$field][$key] != -1) ? $url_query_value[$field][$key] : '' ?>" >
			        			<?php
			    				}
			    				?></div><?php
		        		}elseif($filter_var[$field]['input-type'] == 'checkbox'){?>
		        			<div class = "filter_field <?php echo $field; ?>_field checkbox_ctner">
		        			<p class = 'filter_label group_label'><?php echo $lang_var[$current_lang][$field_lang]; ?></p>
		        			
		        			<?php 
		        				foreach( $filter_var[$field]["options"] as $fo ){ ?>
		        				<label for = "<?php echo $field.'_'.$fo; ?>">
		        					<?php echo $lang_var[$current_lang][$fo]; ?>
		 							<input id = "<?php echo $field.'_'.$fo; ?>" class = "house_list_filter" type="checkbox"  name="<?php echo $field; ?>[]" value="<?php echo $fo; ?>" <?php echo ( in_array($fo, $url_query_value[$field]) ) ? "checked" : "" ?> >
		 							<span class = 'psuedo-checkbox'></span>
		 						</label>
		        			<?php
		        			}
		        			?></div><?php
		        		}elseif($filter_var[$field]['input-type'] == 'select'){
		        			if(empty($url_query_value[$field])){
		        				$active = false;
		        				// some impossible value
		        				// note that php values ( 'non-numeral string' == 0 ) as true
		        				// they are probably both false
		        				$thisValue = -100;
		        			}
		        			else{
		        				$active = true;
		        				$thisValue = $url_query_value[$field][$key];
		        			}			
							?>

							<div class = "filter_field <?php echo $field; ?>_field">
		        			<label class = 'filter_label single_label'><?php echo $lang_var[$current_lang][$field_lang]; ?></label>
		        			
		 					<?php foreach( $filter_var[$field]["options"] as $key => $fo ){
		 						if($key != 0){
		 							?><span class = 'filter_dash'>&mdash;</span><?php
		 						}
								?>
		 						<select id = "" class = "house_list_filter select_ctner <?php echo ($active) ? 'active' : ''  ?>" name = "<?php echo $field; ?>[]">
		 							<?php foreach( $fo as $key => $f ){ 
		 								if($field == 'price' && is_numeric($f)){
		 									$f_display = number_format($f);
		 								}elseif(!is_numeric($f)){
		 									$f_display = $lang_var[$current_lang][$f];
		 								}else{
		 									$f_display = $f;
		 								}
		 								$selected = ( $f == $thisValue ) ? 'selected' : '';
		 								if(is_numeric($f)){
		 								?>
		 									<option value="<?php echo $f; ?>" <?php echo $selected ?> ><?php echo $f_display; ?></option>
		 							<?php 
		 								}else{
										?>
											<option value= "-1" ><?php echo $f_display; ?></option>
										<?php
		 								}
		 						} ?>
		 						</select>
		        			<?php
		    				}
		    				?></div><?php
		        		}
		        	}
		        ?>
		    	<button id = "filter-submit"onclick = "submitFilter(event);"><?php echo $lang_var[$current_lang]['submit']; ?></button>
				</form>
				<form id = "house_list_form_reset" action = "<?php echo $house_list_url;  ?>" method = "GET">
					<input type = "hidden" name = "page_id" value = "<?php echo $post->ID; ?>">
					<button type = "submit"><?php echo $lang_var[$current_lang]['reset']; ?></button>
				</form>
				<div id = "filter_leave_btn">
					<div class = 'cross_bar'></div>
					<div class = 'cross_bar'></div>
				</div>
			</div>
		</div>
		<?php

		displayList($post_list, $root_url, $lang_var);

		$total_pages = $post_list->max_num_pages;
	    if ($total_pages > 1){
	        $current_page = max(1, get_query_var('paged'));
	        $big = 99999999;
	        echo '<div class = "page_num_container">';
	        echo paginate_links(array(
	            'base' => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
	            'format' => '?paged=%#%',
	            'current' => $current_page,
	            'total' => $total_pages,
	            'prev_text'    => __('&larr;'),
	            'next_text'    => __('&rarr;'),
	        ));
	        echo '</div>';
	    }
        wp_reset_postdata();
   		remove_filter( 'posts_where', 'filter_where' ); 
   		wp_enqueue_script( 'copanel-query_control', get_template_directory_uri() . '/js/query_control.js', array());
   		wp_enqueue_script( 'copanel-filter_offset', get_template_directory_uri() . '/js/filter_offset.js', array());
		

	}
	         
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( '', 'copanel_product_list_widget_domain' );
		}

	// Widget admin form
		?>
		<p style = 'color:red;'>!!! nothing to change here !!!</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />	
		</p>
		<?php 
	}  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class nymap_widget ends here
