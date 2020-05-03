<?php
function copanel_questionnaire_load_widget() {
    register_widget( 'copanel_questionnaire_widget' );
}
add_action( 'widgets_init', 'copanel_questionnaire_load_widget' );
 
$current_lang = get_bloginfo('language');
$filter_var_list = array("bedroom", "bathroom", "area", "housing-type", "price");

// Creating the widget 
class copanel_questionnaire_widget extends WP_Widget {
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'copanel_questionnaire_widget', 
	 
	// Widget name will appear in UI
	__('Copanel Questionnaire', 'copanel_questionnaire_widget_domain'), 
	 
	// Widget description
	array( 'description' => __( 'Display questionnaire on homepage' ), ) 
	);
	}
	public function widget( $args, $instance ) {
		// The output
		global $post;
		global $woocommerce;
		global $current_lang;
		
		$questions = array();
		$questions[] = $instance['q1'];
		$questions[] = $instance['q2'];
		$questions[] = $instance['q3'];
		$questions[] = $instance['q4'];
		$questions[] = $instance['q5'];
		$questions[] = $instance['q6'];
		$questions[] = $instance['q7'];

		$options = array();
		$options[] = explode('==========', $instance[ 'q1_options' ]);
		$options[] = explode('==========', $instance[ 'q2_options' ]);
		$options[] = explode('==========', $instance[ 'q3_options' ]);
		$options[] = explode('==========', $instance[ 'q4_options' ]);
		$options[] = explode('==========', $instance[ 'q5_options' ]);
		$options[] = explode('==========', $instance[ 'q6_options' ]);
		$options[] = explode('==========', $instance[ 'q7_options' ]);

		$lang_var['zh-TW']['submit'] = '查看推薦房源及文章';
		$lang_var['zh-CN']['submit'] = '查看推薦房源及文章';
		$lang_var['en-US']['submit'] = 'Recommended Houses and Posts';

		$lang_var['zh-TW']['q6_last_option'] = '同';
		$lang_var['zh-CN']['q6_last_option'] = '同';
		$lang_var['en-US']['q6_last_option'] = 'Same as ';

		$lang_var['zh-TW']['q6_last_option-school'] = '學校地點';
		$lang_var['zh-CN']['q6_last_option-school'] = '学校地点';
		$lang_var['en-US']['q6_last_option-school'] = 'school location';

		$lang_var['zh-TW']['q6_last_option-work'] = '工作地點';
		$lang_var['zh-CN']['q6_last_option-work'] = '工作地点';
		$lang_var['en-US']['q6_last_option-work'] = 'work location';

		?><div id = 'question_ctner' class = ''>
			<div id = 'saved_q_ctner' class = 'concentrated-box'>
				<div class = 'saved_q_holder'><div></div></div>
				<div class = 'saved_q_holder'><div></div></div>
				<div class = 'saved_q_holder'><div></div></div>
				<div class = 'saved_q_holder'><div></div></div>
				<div class = 'saved_q_holder'><div></div></div>
				<div class = 'saved_q_holder'><div></div></div>
				<div class = 'saved_q_holder'><div></div></div>
			</div>
		<?php
		foreach($questions as $key => $q){
			?>
			
			<div id = 'q<?php echo $key + 1; ?>' class = 'question_ctner concentrated-box <?php 
				echo ($key == 0) ? "isAsked" : ""; 
			?>' >
				
				<h3 class = 'question'><?php echo $q; ?></h3>
				<div class = 'option_ctner'>
					<?php
					foreach($options[$key] as $k => $option){
						?>
						<div class = 'option' onclick = 'next_q(<?php echo $key; ?>, <?php echo $k; ?>, "<?php echo $option; ?>");'><?php echo $option; ?></div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
		<div class = 'question_ctner concentrated-box'>
			<div id = 'submit_btn' onclick = 'submit_q_form();'><?php echo $lang_var[$current_lang]['submit']; ?></div>
		</div>
		</div>
		<form id = 'q_form' method = 'POST' action = ''>
			<input id = 'q_input_1' type = 'hidden' name = 'q1' value = 'false'>
			<input id = 'q_input_2' type = 'hidden' name = 'q2' value = 'false'>
			<input id = 'q_input_3' type = 'hidden' name = 'q3' value = 'false'>
			<input id = 'q_input_4' type = 'hidden' name = 'q4' value = 'false'>
			<input id = 'q_input_5' type = 'hidden' name = 'q5' value = 'false'>
			<input id = 'q_input_6' type = 'hidden' name = 'q6' value = 'false'>
			<input id = 'q_input_7' type = 'hidden' name = 'q7' value = 'false'>
		</form>
		<script>
			var sQuestion_ctner = document.getElementsByClassName('question_ctner');
			var sSaved_q_ctner = document.getElementById('saved_q_ctner');
			var q_counter = 1;
			var sQuestion = document.getElementsByClassName('question');
			sQuestion[0].innerHTML = 'Q'+q_counter+'. '+sQuestion[0].innerHTML;
			function submit_q_form(){
				var sQ_form = document.getElementById('q_form');
				var sQ_form_input = document.querySelectorAll('#q_form input');
				// sQ_form.submit();
			}
			function next_q(this_q, this_option, this_option_content){
				var this_q_order = this_q + 1;
				var this_option_order = this_option + 1;
				var this_input = document.getElementById("q_input_"+this_q_order);
				this_input.value = this_option_order;

				var this_question = sQuestion_ctner[this_q];

				q_counter++;

				if(this_q_order == 1){
					if(this_option_order == 1)
						next_question_order = 1;
					else if(this_option_order == 2)
						next_question_order = 5;
				}else if(this_q_order == 2){
					if(this_option_order == 1)
						next_question_order = 2;
					else if(this_option_order == 2)
						next_question_order = 4;
					else if(this_option_order == 3)
						next_question_order = 5;
				}else if(this_q_order == 3){
					if(this_option_order == 8)
						next_question_order = 3;
					else
						next_question_order = 5;
				}else if(this_q_order == 4){
						next_question_order = 5;
				}else if(this_q_order == 5){
						next_question_order = 5;
				}else if(this_q_order == 6){
						next_question_order = 6;
				}else if(this_q_order == 7){
						next_question_order = 7;
				}

				var temp = document.querySelector('#saved_q_ctner div:nth-of-type('+this_q_order+')');
				var temp_child = temp.children[0];
				temp_child.innerText = this_option_content;
				
				temp.classList.add('isSaved');
				var temp_child_h = temp_child.clientHeight;
				temp.style.height = temp_child_h+'px';
				

				var next_question = sQuestion_ctner[next_question_order];;

				this_question.style.display = 'none';
				next_question.classList.add('isAsked');
				if( next_question_order < sQuestion.length-1)
					sQuestion[next_question_order].innerHTML = 'Q'+q_counter+'. '+sQuestion[next_question_order].innerHTML;
				if( next_question_order == 5){
					var sQ2_input = document.getElementById('q_input_2');
					var q6_last_option = next_question.getElementsByClassName('option');
					q6_last_option = q6_last_option[q6_last_option.length-1];

					if(sQ2_input.value == '3'){
						q6_last_option.parentNode.removeChild(q6_last_option);
					}else if(sQ2_input.value == '2'){
						q6_last_option.innerText = "<?php echo $lang_var[$current_lang]['q6_last_option'].$lang_var[$current_lang]['q6_last_option-work']; ?>";
					}else{
						q6_last_option.innerText = "<?php echo $lang_var[$current_lang]['q6_last_option'].$lang_var[$current_lang]['q6_last_option-school']; ?>";
					}
				}
				
			}
		</script>
		<?php

   		// wp_enqueue_script( 'copanel-filter_offset', get_template_directory_uri() . '/js/filter_offset.js', array());
	}
	         
	// Widget Backend 
	public function form( $instance ) {
		$var_option = array();
		$var_option['q1']['option_num'] = 2;
		$var_option['q2']['option_num'] = 3;
		$var_option['q3']['option_num'] = 8;
		$var_option['q4']['option_num'] = 10;
		$var_option['q5']['option_num'] = 10;
		$var_option['q6']['option_num'] = 11;
		$var_option['q7']['option_num'] = 8;

		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q1' ] ) ) {
		$q1 = $instance[ 'q1' ];
		}
		else {
		$q1 = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q1_options' ] ) ) {
			$q1_options = explode('==========', $instance[ 'q1_options' ]);

		}
		else {
			$q1_options = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q2' ] ) ) {
		$q2 = $instance[ 'q2' ];
		}
		else {
		$q2 = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q2_options' ] ) ) {
			$q2_options = explode('==========', $instance[ 'q2_options' ]);

		}
		else {
			$q2_options = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q3' ] ) ) {
		$q3 = $instance[ 'q3' ];
		}
		else {
		$q3 = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q3_options' ] ) ) {
			$q3_options = explode('==========', $instance[ 'q3_options' ]);

		}
		else {
			$q3_options = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q4' ] ) ) {
		$q4 = $instance[ 'q4' ];
		}
		else {
		$q4 = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q4_options' ] ) ) {
			$q4_options = explode('==========', $instance[ 'q4_options' ]);

		}
		else {
			$q4_options = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q5' ] ) ) {
		$q5 = $instance[ 'q5' ];
		}
		else {
		$q5 = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q5_options' ] ) ) {
			$q5_options = explode('==========', $instance[ 'q5_options' ]);

		}
		else {
			$q5_options = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q6' ] ) ) {
		$q6 = $instance[ 'q6' ];
		}
		else {
		$q6 = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q6_options' ] ) ) {
			$q6_options = explode('==========', $instance[ 'q6_options' ]);

		}
		else {
			$q6_options = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q7' ] ) ) {
		$q7 = $instance[ 'q7' ];
		}
		else {
		$q7 = __( '', 'copanel_questionnaire_widget_domain' );
		}

		if ( isset( $instance[ 'q7_options' ] ) ) {
			$q7_options = explode('==========', $instance[ 'q7_options' ]);

		}
		else {
			$q7_options = __( '', 'copanel_questionnaire_widget_domain' );
		}


		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'q1' ); ?>">Q1</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'q1' ); ?>" name="<?php echo $this->get_field_name( 'q1' ); ?>" type="text" value="<?php echo esc_attr( $q1 ); ?>" />
		</p>
		<label>Q1 options</label> 
		<div id = 'q1_option_ctner' class = 'option_ctner'>
			<?php 
			$this_q = 'q1';
			$this_name = $this->get_field_name( $this_q.'_options' );
			$this_id = $this->get_field_id( $this_q.'_options' );
			$this_num = $var_option[$this_q]['option_num'];
			for($i = 0 ; $i < $this_num ; $i ++){
				?>
				<input class="widefat" id="<?php echo $this_id; ?>" name="<?php echo $this_name;  ?>[]" type="text" value="<?php echo esc_attr( $q1_options[$i] ); ?>" />
				<?php
			}
			?>
		</div>

		<label for="<?php echo $this->get_field_id( 'q2' ); ?>">Q2</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'q2' ); ?>" name="<?php echo $this->get_field_name( 'q2' ); ?>" type="text" value="<?php echo esc_attr( $q2 ); ?>" />
		</p>
		<label>Q2 options</label> 
		<div id = 'q2_option_ctner' class = 'option_ctner'>
			<?php 
			$this_q = 'q2';
			$this_name = $this->get_field_name( $this_q.'_options' );
			$this_id = $this->get_field_id( $this_q.'_options' );
			$this_num = $var_option[$this_q]['option_num'];
			for($i = 0 ; $i < $this_num ; $i ++){
				?>
				<input class="widefat" id="<?php echo $this_id; ?>" name="<?php echo $this_name;  ?>[]" type="text" value="<?php echo esc_attr( $q2_options[$i] ); ?>" />
				<?php
			}
			?>
		</div>

		<label for="<?php echo $this->get_field_id( 'q3' ); ?>">Q3</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'q3' ); ?>" name="<?php echo $this->get_field_name( 'q3' ); ?>" type="text" value="<?php echo esc_attr( $q3 ); ?>" />
		</p>
		<label>Q3 options</label> 
		<div id = 'q3_option_ctner' class = 'option_ctner'>
			<?php 
			$this_q = 'q3';
			$this_name = $this->get_field_name( $this_q.'_options' );
			$this_id = $this->get_field_id( $this_q.'_options' );
			$this_num = $var_option[$this_q]['option_num'];
			for($i = 0 ; $i < $this_num ; $i ++){
				?>
				<input class="widefat" id="<?php echo $this_id; ?>" name="<?php echo $this_name;  ?>[]" type="text" value="<?php echo esc_attr( $q3_options[$i] ); ?>" />
				<?php
			}
			?>
		</div>

		<label for="<?php echo $this->get_field_id( 'q4' ); ?>">Q4</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'q4' ); ?>" name="<?php echo $this->get_field_name( 'q4' ); ?>" type="text" value="<?php echo esc_attr( $q4 ); ?>" />
		</p>
		<label>Q4 options</label> 
		<div id = 'q4_option_ctner' class = 'option_ctner'>
			<?php 
			$this_q = 'q4';
			$this_name = $this->get_field_name( $this_q.'_options' );
			$this_id = $this->get_field_id( $this_q.'_options' );
			$this_num = $var_option[$this_q]['option_num'];
			for($i = 0 ; $i < $this_num ; $i ++){
				?>
				<input class="widefat" id="<?php echo $this_id; ?>" name="<?php echo $this_name;  ?>[]" type="text" value="<?php echo esc_attr( $q4_options[$i] ); ?>" />
				<?php
			}
			?>
		</div>

		<label for="<?php echo $this->get_field_id( 'q5' ); ?>">Q5</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'q5' ); ?>" name="<?php echo $this->get_field_name( 'q5' ); ?>" type="text" value="<?php echo esc_attr( $q5 ); ?>" />
		</p>
		<label>Q5 options</label> 
		<div id = 'q5_option_ctner' class = 'option_ctner'>
			<?php 
			$this_q = 'q5';
			$this_name = $this->get_field_name( $this_q.'_options' );
			$this_id = $this->get_field_id( $this_q.'_options' );
			$this_num = $var_option[$this_q]['option_num'];
			for($i = 0 ; $i < $this_num ; $i ++){
				?>
				<input class="widefat" id="<?php echo $this_id; ?>" name="<?php echo $this_name;  ?>[]" type="text" value="<?php echo esc_attr( $q5_options[$i] ); ?>" />
				<?php
			}
			?>
		</div>

		<label for="<?php echo $this->get_field_id( 'q6' ); ?>">Q6</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'q6' ); ?>" name="<?php echo $this->get_field_name( 'q6' ); ?>" type="text" value="<?php echo esc_attr( $q6 ); ?>" />
		</p>
		<label>Q6 options</label> 
		<div id = 'q6_option_ctner' class = 'option_ctner'>
			<?php 
			$this_q = 'q6';
			$this_name = $this->get_field_name( $this_q.'_options' );
			$this_id = $this->get_field_id( $this_q.'_options' );
			$this_num = $var_option[$this_q]['option_num'];
			for($i = 0 ; $i < $this_num ; $i ++){
				?>
				<input class="widefat" id="<?php echo $this_id; ?>" name="<?php echo $this_name;  ?>[]" type="text" value="<?php echo esc_attr( $q6_options[$i] ); ?>" />
				<?php
			}
			?>
		</div>

		<label for="<?php echo $this->get_field_id( 'q7' ); ?>">Q7</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'q7' ); ?>" name="<?php echo $this->get_field_name( 'q7' ); ?>" type="text" value="<?php echo esc_attr( $q7 ); ?>" />
		</p>
		<label>Q7 options</label> 
		<div id = 'q7_option_ctner' class = 'option_ctner'>
			<?php 
			$this_q = 'q7';
			$this_name = $this->get_field_name( $this_q.'_options' );
			$this_id = $this->get_field_id( $this_q.'_options' );
			$this_num = $var_option[$this_q]['option_num'];
			for($i = 0 ; $i < $this_num ; $i ++){
				?>
				<input class="widefat" id="<?php echo $this_id; ?>" name="<?php echo $this_name;  ?>[]" type="text" value="<?php echo esc_attr( $q7_options[$i] ); ?>" />
				<?php
			}
			?>
		</div>

		<?php 
	}  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['q1'] = ( ! empty( $new_instance['q1'] ) ) ? strip_tags( $new_instance['q1'] ) : '';
		if(! empty( $new_instance['q1_options'] )){
			foreach($new_instance['q1_options'] as $key => &$q1_option)
				$q1_option = strip_tags($q1_option);
			unset($q1_option);
			$instance['q1_options'] = implode('==========', $new_instance['q1_options']);
		}else{
			$instance['q1_options'] = '';
		}

		$instance['q2'] = ( ! empty( $new_instance['q2'] ) ) ? strip_tags( $new_instance['q2'] ) : '';
		if(! empty( $new_instance['q2_options'] )){
			foreach($new_instance['q2_options'] as $key => &$q2_option)
				$q2_option = strip_tags($q2_option);
			unset($q2_option);
			$instance['q2_options'] = implode('==========', $new_instance['q2_options']);
		}else{
			$instance['q2_options'] = '';
		}

		$instance['q3'] = ( ! empty( $new_instance['q3'] ) ) ? strip_tags( $new_instance['q3'] ) : '';
		if(! empty( $new_instance['q3_options'] )){
			foreach($new_instance['q3_options'] as $key => &$q3_option)
				$q3_option = strip_tags($q3_option);
			unset($q3_option);
			$instance['q3_options'] = implode('==========', $new_instance['q3_options']);
		}else{
			$instance['q3_options'] = '';
		}

		$instance['q4'] = ( ! empty( $new_instance['q4'] ) ) ? strip_tags( $new_instance['q4'] ) : '';
		if(! empty( $new_instance['q4_options'] )){
			foreach($new_instance['q4_options'] as $key => &$q4_option)
				$q4_option = strip_tags($q4_option);
			unset($q4_option);
			$instance['q4_options'] = implode('==========', $new_instance['q4_options']);
		}else{
			$instance['q4_options'] = '';
		}

		$instance['q5'] = ( ! empty( $new_instance['q5'] ) ) ? strip_tags( $new_instance['q5'] ) : '';
		if(! empty( $new_instance['q5_options'] )){
			foreach($new_instance['q5_options'] as $key => &$q5_option)
				$q5_option = strip_tags($q5_option);
			unset($q5_option);
			$instance['q5_options'] = implode('==========', $new_instance['q5_options']);
		}else{
			$instance['q5_options'] = '';
		}

		$instance['q6'] = ( ! empty( $new_instance['q6'] ) ) ? strip_tags( $new_instance['q6'] ) : '';
		if(! empty( $new_instance['q6_options'] )){
			foreach($new_instance['q6_options'] as $key => &$q6_option)
				$q6_option = strip_tags($q6_option);
			unset($q6_option);
			$instance['q6_options'] = implode('==========', $new_instance['q6_options']);
		}else{
			$instance['q6_options'] = '';
		}

		$instance['q7'] = ( ! empty( $new_instance['q7'] ) ) ? strip_tags( $new_instance['q7'] ) : '';
		if(! empty( $new_instance['q7_options'] )){
			foreach($new_instance['q7_options'] as $key => &$q7_option)
				$q7_option = strip_tags($q7_option);
			unset($q7_option);
			$instance['q7_options'] = implode('==========', $new_instance['q7_options']);
		}else{
			$instance['q7_options'] = '';
		}

		return $instance;
	}
} // Class nymap_widget ends here
