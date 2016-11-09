<?php

function voc_register_sidebars() {
	$sidebars = array (
		array (
			'name'	=> __( 'Header Left', 'voc' ),
			'desc' 	=> __( 'An optional area to place one widget in the header to the left of the site logo.', 'voiceofoc' ),
			'id' 	=> 'voiceofoc-header-left'
		)
	);
	
	// register the active widget areas
	foreach ( $sidebars as $sidebar ) {
		register_sidebar( array(
			'name' => $sidebar['name'],
			'description' => $sidebar['desc'],
			'id' => $sidebar['id'],
			'before_widget' => '<div class="">',
			'after_widget' => '</div>',
			'before_title' => '<div class="">',
			'after_title' => '</div>'
		) );
	}
}
add_action( 'widgets_init', 'voc_register_sidebars' );