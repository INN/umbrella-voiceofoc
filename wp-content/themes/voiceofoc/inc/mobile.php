<?php
/**
 * Register post metabox to allow hiding posts on mobile
 * @since Largo 0.4
 * @see voiceofoc_hide_mobile_article_add_meta_box
 * @see voiceofoc_hide_mobile_article_meta_box
 */
if (function_exists('largo_add_meta_box')){
	largo_add_meta_box(
		'voiceofoc_hide_mobile_article',
		__( 'Hide Article On Mobile Site', 'voiceofoc' ),
		'voiceofoc_hide_mobile_article_meta_box',
		'post',
		'side',
		'low'
	);
} else{
	add_action( 'add_meta_boxes', 'voiceofoc_hide_mobile_article_add_meta_box' );
}

/**
 * If Largo's metabox API isn't working, register the hide-post-on-mobile metabox.
 * @since Largo 0.4
 */
function voiceofoc_hide_mobile_article_add_meta_box(){
	add_meta_box(
		'voiceofoc_hide_mobile_article',
		__( 'Hide Article On Mobile Site', 'voiceofoc' ),
		'voiceofoc_hide_mobile_article_meta_box',
		'post',
		'side',
		'low'
	);
}

/**
 * Output the metabox that provides the option to hide a post on mobile.
 * @since Largo 0.4
 * @see voiceofoc_hide_mobile_article_add_meta_box
 */
function voiceofoc_hide_mobile_article_meta_box(){
	global $post;
	$values = get_post_custom( $post->ID );
	$hide_mobile_value_true = (isset($values['_voiceofoc_hide_mobile'][0]) && $values['_voiceofoc_hide_mobile'][0] !== 'false')? 'checked': '';
	$hide_mobile_value_false = (!isset($values['_voiceofoc_hide_mobile'][0]) || $values['_voiceofoc_hide_mobile'][0] == 'false')? 'checked': '';
	wp_nonce_field( 'voiceofoc_hide_mobile_article_nonce', 'voiceofoc_hide_mobile_article_meta_box_nonce' );
	?>
	<p>

		<label for="voiceofoc_hide_mobile"><?php _e('Hide On Mobile (example: tablet, phone)?');?></label>
		<input type="radio" name="_voiceofoc_hide_mobile" id="voiceofoc_hide_mobile" value="true" <?php echo $hide_mobile_value_true;?>><?php _e('Yes');?>
		<input type="radio" name="_voiceofoc_hide_mobile" id="voiceofoc_hide_mobile" value="false" <?php echo $hide_mobile_value_false;?>><?php _e('No');?>
	</p>
	<?php
}
/**
 * Register the hide-mobile option
 */
add_action('init', function() {
	largo_register_meta_input( array('_voiceofoc_hide_mobile'), 'sanitize_text_field' );
} );
