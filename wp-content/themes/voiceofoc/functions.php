<?php

// This site is an INN Member
if ( ! defined( 'INN_MEMBER' ) ) {
	define( 'INN_MEMBER', true );
}
// This site is hosted by INN
if ( ! defined( 'INN_HOSTED' ) ) {
	define( 'INN_HOSTED', true );
}

/**
 * Includes
 */
$includes = array(
	'/inc/homepage.php',
	'/inc/widgets.php',
	'/inc/misc.php',
);
// Perform load
foreach ( $includes as $include ) {
	require_once( get_stylesheet_directory() . $include );
}


/**
* Register Voice of OC custom image sizes
*/
function voiceofoc_image_sizes() {
	// Small Rectangular Thumbnail
	// Used recent posts widget
	// 120 pixels wide by 80 pixels tall, hard crop mode
	add_image_size( 'small-rect', 120, 80, true );
}
add_action('init', 'voiceofoc_image_sizes', 20);

/**
 * Enqueue the stylesheet
 * @since Largo 0.4
 */
function voiceofoc_stylesheet() {
	$suffix = (LARGO_DEBUG)? '' : '.min';

	wp_dequeue_style( 'largo-child-styles' );
	wp_enqueue_style( 'voiceofoc', get_stylesheet_directory_uri().'/css/style' . $suffix . '.css' );
}
add_action( 'wp_enqueue_scripts', 'voiceofoc_stylesheet', 20 );

/**
 * Typekit fonts
 * @since 2017-03-13
 */
function voiceofoc_typekit() {
		// normal Typekit script:
	?>
		<script src="https://use.typekit.net/xyq0vny.js"></script>
		<script>try{Typekit.load({ async: false });}catch(e){}</script>
	<?php
}
add_action( 'wp_head', 'voiceofoc_typekit' );

/**
 * Added by request
 * @since Largo 0.5.5.3
 * @since February 20, 2017
 */
function voiceofoc_adsbygoogle() {
	?>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-1576598093855162",
		enable_page_level_ads: true
		});
		</script>
	<?php
}
add_action( 'wp_head', 'voiceofoc_adsbygoogle' );

/**
 * Added by request
 * @since April 27, 2017
 */
define( 'SHOW_GLOBAL_NAV', false );

// Register Sidebar
function voiceofoc_donate_sidebar() {

	$args = array(
		'id'            => 'voiceofoc_donate_sidebar',
		'class'         => 'header-donate-sidebar',
		'name'          => __( 'Header Donate Area', 'voiceofoc' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'voiceofoc_donate_sidebar' );

// Add display for registered Sidebar
function voiceofoc_donate_sidebar_display() {
	if ( is_active_sidebar( 'voiceofoc_donate_sidebar' ) ) :
		echo '<div id="header-donate-sidebar">';
			dynamic_sidebar( 'voiceofoc_donate_sidebar' );
		echo '</div>';
	endif;
}
add_action( 'largo_header_after_largo_header', 'voiceofoc_donate_sidebar_display' );

// Add tronc DFP ad tags
function voiceofoc_tronc_DFP_ads() {
	?>
	<!-- Start Section (Homepage) GPT Async Tag -->
	<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
	<script>
		var gptadslots = [];
		var googletag = googletag || {cmd:[]};
	</script>
	<script>
		googletag.cmd.push(function() {
		    //Adslot 1 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[728,90]], 'div-gpt-ad-7882103-1')
		                             .setTargeting('pos', ['1'])
		                             .setTargeting('ptype', ['sf'])
		                             .addService(googletag.pubads()));
		    //Adslot 2 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[300,250]], 'div-gpt-ad-7882103-2')
		                             .setTargeting('pos', ['1'])
		                             .setTargeting('ptype', ['sf'])
		                             .addService(googletag.pubads()));
		    //Adslot 3 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[320,50]], 'div-gpt-ad-7882103-3')
		                             .setTargeting('pos', ['1'])
		                             .setTargeting('ptype', ['sf'])
		                             .addService(googletag.pubads()));

		    googletag.enableServices();
		});
	</script>
	<!-- End GPT Async Tag -->

	<!-- Start Story (Article) GPT Async Tag -->
	<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
	<script>
	  var gptadslots = [];
	  var googletag = googletag || {cmd:[]};
	</script>
	<script>
	  googletag.cmd.push(function() {
	    //Adslot 1 declaration
	    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[728,90]], 'div-gpt-ad-6344897-1')
	                             .setTargeting('pos', ['1'])
	                             .setTargeting('ptype', ['s'])
	                             .addService(googletag.pubads()));
	    //Adslot 2 declaration
	    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[300,250]], 'div-gpt-ad-6344897-2')
	                             .setTargeting('pos', ['1'])
	                             .setTargeting('ptype', ['s'])
	                             .addService(googletag.pubads()));
	    //Adslot 3 declaration
	    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[320,50]], 'div-gpt-ad-6344897-3')
	                             .setTargeting('pos', ['1'])
	                             .setTargeting('ptype', ['s'])
	                             .addService(googletag.pubads()));

	    googletag.enableServices();
	  });
	</script>
	<!-- End GPT Async Tag -->
	<?php
}
#add_action( 'wp_head', 'voiceofoc_tronc_DFP_ads' );
