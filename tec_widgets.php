<?php
defined ('ABSPATH') or die( 'You dont have permission to view this page' );

class tec_widgets extends WP_Widget{
	
	function __construct(){
		
		parent::__construct(
		
		'tec_widgets',
		__('The English College Widget' , 'tec_widget'),
		array('description' => __( 'The English College Widget' , 'tec_widget' ))
		);
		
	}
	
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		if( ! empty( $instance['selected_posts'] ) && is_array( $instance['selected_posts'] ) ){ 
			$selected_posts = get_posts( array( 'post__in' => $instance['selected_posts'] ) );
			?>
			<ul>
			<?php foreach ( $selected_posts as $post ) { ?>
				<li><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a></li>
			<?php } ?>
			</ul>
			<?php 
		
		}else{
			echo esc_html__( 'No posts selected!', 'text_domain' );	
		}
		echo $args['after_widget'];
	}
	
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Title', 'text_domain' );
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
		<p>
		<?php
		
		$posts = get_posts( array( 
				'post_type' =>'tec',
				'posts_per_page' => 20,
				'offset' => 0
			) );
		$selected_posts = ! empty( $instance['selected_posts'] ) ? $instance['selected_posts'] : array();
		?>
		<div style="max-height: 120px; overflow: auto;">
			<ul>
			<?php foreach ( $posts as $post ) { ?>
				<li><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'selected_posts' ) ); ?>[]" value="<?php echo $post->ID; ?>" <?php checked( ( in_array( $post->ID, $selected_posts ) ) ? $post->ID : '', $post->ID ); ?> /><?php echo get_the_title( $post->ID ); ?></li>
			<?php } ?>
			</ul>
		</div>
		<?php
		
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		$selected_posts = ( ! empty ( $new_instance['selected_posts'] ) ) ? (array) $new_instance['selected_posts'] : array();
		$instance['selected_posts'] = array_map( 'sanitize_text_field', $selected_posts );
		return $instance;
	}
}

add_action( 'widgets_init' , function(){
	
	register_widget( 'tec_widgets' );
	
});