<?php
function nymap_load_widget() {
    register_widget( 'nymap_widget' );
}
add_action( 'widgets_init', 'nymap_load_widget' );
 
// Creating the widget 
class nymap_widget extends WP_Widget {
 
function __construct() {
parent::__construct(
 
// Base ID of your widget
'nymap_widget', 
 
// Widget name will appear in UI
__('New York interactive map', 'nymap_widget_domain'), 
 
// Widget description
array( 'description' => __( 'Sample widget based on nymap Tutorial', 'nymap_widget_domain' ), ) 
);
}
 
// Creating widget front-end
 
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$body = apply_filters( 'widget_body', $instance['body'] );
// before and after widget arguments are defined by themes
// echo $args['before_widget'];
// if ( ! empty( $title ) )
// echo $args['before_title'] . $title . $args['after_title'];
 
$map_base = file_get_contents(__DIR__."/../images/map/nymap-0-base.svg");
$map_hover = file_get_contents(__DIR__."/../images/map/nymap_hover.svg");
$map_border = file_get_contents(__DIR__."/../images/map/nymap-border.svg");
$map_green = file_get_contents(__DIR__."/../images/map/nymap-green.svg");
echo "<div id = 'nymap_container' class = 'concentrated-bo'>";
echo "<div id = 'nymap'>".$map_base.$map_hover.$map_border.$map_green."</div>";
echo "</div>";
}
         
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'nymap_widget_domain' );
}

if ( isset( $instance[ 'body' ] ) ) {
$title = $instance[ 'body' ];
}
else {
$title = __( 'Body text', 'nymap_widget_domain' );
}

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
<label for="<?php echo $this->get_field_id( 'body' ); ?>"><?php _e( 'Body text:' ); ?></label> 
<textarea class="widefat" id="<?php echo $this->get_field_id( 'body' ); ?>" name="<?php echo $this->get_field_name( 'body' ); ?>" type="text" value="<?php echo esc_attr( $body ); ?>" /></textarea>
</p>
<?php 
}
     
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['body'] = ( ! empty( $new_instance['body'] ) ) ? strip_tags( $new_instance['body'] ) : '';
return $instance;
}
} // Class nymap_widget ends here