<?php
/**
 * Functions as regards custom term meta
 *
 * @link https://themehybrid.com/weblog/introduction-to-wordpress-term-meta
 */

// make sure these meta names are consistent
define( 'HEADER_WIDGET_AREA_ENABLED', 'header_widget_area_enabled' );
define( 'HEADER_WIDGET_AREA_CLASS', 'header_widget_area_class' );

/**
 * Register the voice of oc theme's custom term meta:
 * - enabled-ness of the Widget Header Area
 *
 */
function voiceofoc_widget_header_area_meta_register() {
	register_meta( 'term', HEADER_WIDGET_AREA_ENABLED, 'voiceofoc_widget_header_area_meta_sanitize');
}
add_action( 'init', 'voiceofoc_widget_header_area_meta_register' );

/**
 * make sure that this checkbox value is checked or not-checked
 *
 * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 */
function voiceofoc_widget_header_area_meta_sanitize( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * form!
 */
function voiceofoc_widget_header_area_meta_form_add() {
	wp_nonce_field( 'voiceofoc_widget_header_area_meta_nonce', 'voiceofoc_widget_header_area_meta_nonce' );
	?>
		<div class="form-field">
			<label for="voiceofoc-widget-header-area-enabled"><?php _e( 'Enable Widget Header Area for this term?', 'voiceofoc' ); ?></label>
			<input type="checkbox" name="voiceofoc-widget-header-area-enabled" id="voiceofoc-widget-header-area-enabled">
				<?php
					echo get_term_meta( $term_id, HEADER_WIDGET_AREA_ENABLED, true ) ;
				?>


		</div>
		<div class="form-field">
			<label for="voiceofoc-widget-header-area-class"><?php _e( 'How many columns should the Header Widget Area have?', 'voiceofoc' ); ?></label>
			<select name="voiceofoc-widget-header-area-class" id="voiceofoc-widget-header-area-class">
				<option value="span3"><?php _e( 'Four Columns', 'voiceofoc' ); ?></option>
				<option value="span4"><?php _e( 'Three Columns', 'voiceofoc' ); ?></option>
				<option value="span6" selected><?php _e( 'Two Columns', 'voiceofoc' ); ?></option>
				<option value="span12"><?php _e( 'One Column', 'voiceofoc' ); ?></option>
			</select>
		</div>
	<?php
}
add_action( 'category_add_form_fields', 'voiceofoc_widget_header_area_meta_form_add' );
add_action( 'post_tag_add_form_fields', 'voiceofoc_widget_header_area_meta_form_add' );
/**
 * Edit form!
 */
function voiceofoc_widget_header_area_meta_form_edit( $term ) {
	$default = 0;
	$term_id = $term->term_id;
	wp_nonce_field( 'voiceofoc_widget_header_area_meta_nonce', 'voiceofoc_widget_header_area_meta_nonce' );
	$enabled = get_term_meta( $term_id, HEADER_WIDGET_AREA_ENABLED, true );
	$class = get_term_meta( $term_id, HEADER_WIDGET_AREA_CLASS, true );
	?>
		<table class="form-table">
			<tr>
				<th>
					<label for="voiceofoc-widget-header-area-enabled"><?php _e( 'Enable Widget Header Area', 'voiceofoc' ); ?></label>
				</th>
				<td>
					<input type="checkbox" name="voiceofoc-widget-header-area-enabled" id="voiceofoc-widget-header-area-enabled"
						<?php
							checked( $enabled, 1, true );
						?>
					>
					<p class="description"><?php _e( 'Checking this enables the Widget Header Area on the frontend.', 'voiceofoc' ); ?></p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="voiceofoc-widget-header-area-class"><?php _e( 'How many columns should the Header Widget Area have?', 'voiceofoc' ); ?></label>
				</th>
				<td>
					<select name="voiceofoc-widget-header-area-class" id="voiceofoc-widget-header-area-class">
						<option value=""><?php _e( 'Choose number of columns' ); ?></option>
						<option value="span3" <?php selected( $class, 'span3' ); ?>><?php _e( 'Four Columns', 'voiceofoc' ); ?></option>
						<option value="span4" <?php selected( $class, 'span4' ); ?>><?php _e( 'Three Columns', 'voiceofoc' ); ?></option>
						<option value="span6" <?php selected( $class, 'span6' ); ?>><?php _e( 'Two Columns', 'voiceofoc' ); ?></option>
						<option value="span12" <?php selected( $class, 'span12' ); ?>><?php _e( 'One Column', 'voiceofoc' ); ?></option>
					</select>
				</td>
			</tr>

		</table>
	<?php
}
add_action( 'category_edit_form_fields', 'voiceofoc_widget_header_area_meta_form_edit' );
add_action( 'post_tag_edit_form_fields', 'voiceofoc_widget_header_area_meta_form_edit' );

/**
 * Save the submitted form data
 */
function voiceofoc_widget_header_area_meta_form_save( $term_id ) {
	if ( ! isset( $_POST['voiceofoc_widget_header_area_meta_nonce'] ) || ! wp_verify_nonce( $_POST['voiceofoc_widget_header_area_meta_nonce'], 'voiceofoc_widget_header_area_meta_nonce' ) ) {
		return;
	}
	$old_whether = get_term_meta( $term_id, HEADER_WIDGET_AREA_ENABLED, true );
	$new_whether = voiceofoc_widget_header_area_meta_sanitize( $_POST['voiceofoc-widget-header-area-enabled'] );

	if ( $old_whether && '' === $new_whether ) {
		delete_term_meta( $term_id, HEADER_WIDGET_AREA_ENABLED );
	} else if ( $old_whether !== $new_whether ) {
		update_term_meta( $term_id, HEADER_WIDGET_AREA_ENABLED, $new_whether );
	}

	$old_class = get_term_meta( $term_id, HEADER_WIDGET_AREA_ENABLED, true );
	$new_class = esc_attr( $_POST['voiceofoc-widget-header-area-class'] );

	if ( $old_class && '' === $new_class ) {
		delete_term_meta( $term_id, HEADER_WIDGET_AREA_CLASS );
	} else if ( $old_class !== $new_class ) {
		update_term_meta( $term_id, HEADER_WIDGET_AREA_CLASS, $new_class );
	}
}
add_action( 'edit_category', 'voiceofoc_widget_header_area_meta_form_save' );
add_action( 'add_category', 'voiceofoc_widget_header_area_meta_form_save' );
add_action( 'edit_post_tag', 'voiceofoc_widget_header_area_meta_form_save' );
add_action( 'edit_post_tag', 'voiceofoc_widget_header_area_meta_form_save' );
