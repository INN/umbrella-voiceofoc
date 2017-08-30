<?php
/**
 * Functions as regards custom term meta
 *
 * @link https://themehybrid.com/weblog/introduction-to-wordpress-term-meta
 */

// make sure this is consistent
define( 'HEADER_WIDGET_AREA_META_NAME', 'header_widget_area_enabled' );

/**
 * Register the voice of oc theme's custom term meta:
 * - enabled-ness of the Widget Header Area
 *
 */
function voiceofoc_widget_header_area_meta_register() {
	register_meta( 'term', HEADER_WIDGET_AREA_META_NAME, 'voiceofoc_widget_header_area_meta_sanitize');
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
					echo get_term_meta( $term_id, HEADER_WIDGET_AREA_META_NAME, true ) ;
				?>

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
	?>
		<table class="form-table">
			<tr>
				<th>
					<label for="voiceofoc-widget-header-area-enabled"><?php _e( 'Enable Widget Header Area', 'voiceofoc' ); ?></label>
				</th>
				<td>
					<input type="checkbox" name="voiceofoc-widget-header-area-enabled" id="voiceofoc-widget-header-area-enabled"
						<?php
							checked( get_term_meta( $term_id, HEADER_WIDGET_AREA_META_NAME, true ) , 1, true );
						?>
					>
					<p class="description"><?php _e( 'Checking this enables the Widget Header Area on the frontend.', 'voiceofoc' ); ?></p>
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
	$old_whether = get_term_meta( $term_id, HEADER_WIDGET_AREA_META_NAME, true );
	$new_whether = voiceofoc_widget_header_area_meta_sanitize( $_POST['voiceofoc-widget-header-area-enabled'] );

	if ( $old_whether && '' === $new_whether ) {
		delete_term_meta( $term_id, HEADER_WIDGET_AREA_META_NAME );
	} else if ( $old_whether !== $new_whether ) {
		update_term_meta( $term_id, HEADER_WIDGET_AREA_META_NAME, $new_whether );
	}
}
add_action( 'edit_category', 'voiceofoc_widget_header_area_meta_form_save' );
add_action( 'add_category', 'voiceofoc_widget_header_area_meta_form_save' );
add_action( 'edit_post_tag', 'voiceofoc_widget_header_area_meta_form_save' );
add_action( 'edit_post_tag', 'voiceofoc_widget_header_area_meta_form_save' );
