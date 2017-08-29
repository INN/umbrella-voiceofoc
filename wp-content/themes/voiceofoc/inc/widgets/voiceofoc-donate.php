<?php
/*
 * Voice of OC donate widget
 * Forked from Largo donate widget
 */
class voiceofoc_donate_widget extends WP_Widget {

	function __construct() {
		$widget_opts = array(
			'classname' => 'voiceofoc-donate',
			'description'=> __('Call-to-action for donations', 'largo')
		);
		parent::__construct( 'voiceofoc-donate-widget', __('Voice of OC Donate Widget', 'largo'), $widget_opts);
	}
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Support ' . get_bloginfo('name'), 'largo') : $instance['title'], $instance, $this->id_base);
		$show_title = $instance['show_title'] ? TRUE : FALSE;

		// Use theme option donation link if no widget donation link provided
		$donate_link = esc_url( $instance['donate_url'] );
		if ( !$donate_link && of_get_option( 'donate_link' ) ) {
			$donate_link = esc_url( of_get_option( 'donate_link' ) );
		}

		echo $before_widget;
		echo '<aside class="voiceofoc-donate-widget"><div>';
		if ( $title && $show_title ) {
			echo $before_title . $title . $after_title;
		}
		echo '<p class="voiceofoc-donate-cta">' . esc_html( $instance['cta_text'] ) . '</p>';

		if ( $instance['button_image_url'] ) {
			printf(
				'<div class="voiceofoc-button"><a class="voiceofoc-donate-link" href="%s"><img src="%s" alt="%s" ></a><div>',
				$donate_link,
				esc_url( $instance['button_image_url'] ),
				esc_html( $instance['button_text'] )
			);
		} else {
			printf(
				'<div class="voiceofoc-button"><a class="btn btn-primary" href="%s">%s</a><div>',
				$donate_link,
				esc_html( $instance['button_text'] )
			);
		}
		echo '</div></aside>';
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['show_title'] = sanitize_text_field( $new_instance['show_title'] );
		$instance['cta_text'] = sanitize_text_field( $new_instance['cta_text'] );
		$instance['button_text'] = sanitize_text_field( $new_instance['button_text'] );
		$instance['donate_url'] = esc_url_raw( $new_instance['donate_url'] );
		$instance['button_image_url'] = esc_url_raw( $new_instance['button_image_url'] );
		return $instance;
	}
	function form( $instance ) {
		$donate_link = '';
		if ( of_get_option( 'donate_link' ) ) {
			$donate_link = esc_url( of_get_option( 'donate_link' ) );
		}
		$donate_btn_text = __('Donate Now', 'largo');
		if ( of_get_option( 'donate_button_text' ) ) {
			$donate_btn_text = esc_attr( of_get_option( 'donate_button_text' ) );
		}
		$defaults = array(
			'title' 			=> __('Support ' . get_bloginfo('name'), 'largo'),
			'show_title' 		=> 'on',
			'cta_text' 			=> __('We depend on your support. A generous gift in any amount helps us continue to bring you this service.', 'largo'),
			'button_text' 		=> $donate_btn_text,
			'donate_url' 		=> $donate_link,
			'button_image_url' 	=> '',

		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e('Show Title (uncheck to hide title when displaying the widget):', 'largo'); ?></label>
    		<input class="checkbox" type="checkbox" <?php checked($instance['show_title'], 'on'); ?> id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cta_text' ); ?>"><?php _e('Call-to-Action Text:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'cta_text' ); ?>" name="<?php echo $this->get_field_name( 'cta_text' ); ?>" value="<?php echo esc_attr( $instance['cta_text'] ); ?>" style="width:90%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e('Button Text:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $instance['button_text'] ); ?>" style="width:90%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_image_url' ); ?>"><?php _e('Donate Image URL (button text used as image alt text if present):', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_image_url' ); ?>" name="<?php echo $this->get_field_name( 'button_image_url' ); ?>" value="<?php echo esc_attr( $instance['button_image_url'] ); ?>" style="width:90%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'donate_url' ); ?>"><?php _e('Donate URL (for custom campaigns, theme option donation link used if blank):', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'donate_url' ); ?>" name="<?php echo $this->get_field_name( 'donate_url' ); ?>" value="<?php echo esc_attr( $instance['donate_url'] ); ?>" style="width:90%;" />
		</p>

		<?php
	}
}
