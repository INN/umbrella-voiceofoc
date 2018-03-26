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
	'/inc/term-meta.php',
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




// Register Sidebar
function voiceofoc_sponsorhome_sidebar() {

	$args = array(
		'id'            => 'voiceofoc_sponsorhome_sidebar',
		'class'         => 'sponsorhome-sidebar',
		'name'          => __( 'Home After Featured Post', 'voiceofoc' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'voiceofoc_sponsorhome_sidebar' );

// Add display for registered Sidebar
function voiceofoc_sponsorhome_sidebar_display($post, $query) {
	if ( is_active_sidebar( 'voiceofoc_sponsorhome_sidebar' ) && $query->current_post == 1 ) :
		echo '<div id="sponsorhome-sidebar" class="clearfix sponsorship-widget-area">';
				dynamic_sidebar( 'voiceofoc_sponsorhome_sidebar' );
		echo '</div>';
	endif;
}
add_action( 'largo_before_home_list_post', 'voiceofoc_sponsorhome_sidebar_display', 10, 2);


// Register Sidebar
function voiceofoc_sponsorheader_sidebar() {

	$args = array(
		'id'            => 'voiceofoc_sponsorheader_sidebar',
		'class'         => 'sponsorheader-sidebar',
		'name'          => __( 'Category Header', 'voiceofoc' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'voiceofoc_sponsorheader_sidebar' );

// Add display for registered Sidebar
function voiceofoc_sponsorheader_sidebar_display() {
	if ( is_active_sidebar( 'voiceofoc_sponsorheader_sidebar' ) && is_tag() || is_category() ) :
		echo '<div id="sponsorheader-sidebar" class="sponsorship-widget-area">';
			dynamic_sidebar( 'voiceofoc_sponsorheader_sidebar' );
		echo '</div>';
	endif;
}
add_action( 'largo_after_nav', 'voiceofoc_sponsorheader_sidebar_display');




// Register Sidebar
function voiceofoc_sponsorpost_sidebar() {

	$args = array(
		'id'            => 'voiceofoc_sponsorpost_sidebar',
		'class'         => 'sponsorpost-sidebar',
		'name'          => __( 'Post Header', 'voiceofoc' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'voiceofoc_sponsorpost_sidebar' );

// Add display for registered Sidebar
function voiceofoc_sponsorpost_sidebar_display() {
	if ( is_active_sidebar( 'voiceofoc_sponsorpost_sidebar' ) && is_single() ) :
		echo '<div id="sponsorpost-sidebar" class="sponsorship-widget-area">';
			dynamic_sidebar( 'voiceofoc_sponsorpost_sidebar' );
		echo '</div>';
	endif;
}
add_action( 'largo_after_nav', 'voiceofoc_sponsorpost_sidebar_display');


// Register Sidebar
function voiceofoc_sponsorrightbar_sidebar() {

	$args = array(
		'id'            => 'voiceofoc_sponsorrightbar_sidebar',
		'class'         => 'sponsorrightbar-sidebar',
		'name'          => __( 'Category Sidebar 2', 'voiceofoc' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'voiceofoc_sponsorrightbar_sidebar' );

// Add display for registered Sidebar
function voiceofoc_sponsorrightbar_sidebar_display() {
	if ( is_active_sidebar( 'voiceofoc_sponsorrightbar_sidebar' ) && !is_home() ) :
		echo '<div id="sponsorrightbar-sidebar" class="sponsorship-widget-area">';
			dynamic_sidebar( 'voiceofoc_sponsorrightbar_sidebar' );
		echo '</div>';
	endif;
}
add_action( 'largo_after_sidebar_widgets', 'voiceofoc_sponsorrightbar_sidebar_display');



// Add tronc DFP ad tags
function voiceofoc_tronc_DFP_ads() {

	if ( is_front_page() ) {
		?>
		<!-- Start Section Front (Homepage) GPT Async Tag -->
		<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
		<script>
		  var gptadslots = [];
		  var googletag = googletag || {cmd:[]};
		</script>
		<script>
		  googletag.cmd.push(function() {
		    //Adslot 1 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[728,90]], 'div-gpt-ad-2723726-1')
					     .setTargeting('pos', ['1'])
					     .addService(googletag.pubads()));
		    //Adslot 2 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[728,90]], 'div-gpt-ad-2723726-2')
					     .setTargeting('pos', ['2'])
					     .addService(googletag.pubads()));
		    //Adslot 3 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[728,90]], 'div-gpt-ad-2723726-3')
					     .setTargeting('pos', ['3'])
					     .addService(googletag.pubads()));
		    //Adslot 4 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[320,50]], 'div-gpt-ad-2723726-4')
					     .setTargeting('pos', ['1'])
					     .addService(googletag.pubads()));
		    //Adslot 5 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[300,250]], 'div-gpt-ad-2723726-5')
					     .setTargeting('pos', ['1'])
					     .addService(googletag.pubads()));
		    //Adslot 6 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc/sf', [[300,250]], 'div-gpt-ad-2723726-6')
					     .setTargeting('pos', ['2'])
					     .addService(googletag.pubads()));

		    googletag.pubads().setTargeting('ptype', ['sf']);
		    googletag.enableServices();
		  });
		</script>
		<!-- End GPT Async Tag -->
		<?php
}

else {
		?>

		<!-- Start GPT Async Tag -->
		<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
		<script>
		  var gptadslots = [];
		  var googletag = googletag || {cmd:[]};
		</script>
		<script>
		  googletag.cmd.push(function() {
		    //Adslot 1 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[728,90]], 'div-gpt-ad-5190402-1')
					     .setTargeting('pos', ['1'])
					     .addService(googletag.pubads()));
		    //Adslot 2 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[728,90]], 'div-gpt-ad-5190402-2')
					     .setTargeting('pos', ['2'])
					     .addService(googletag.pubads()));
		    //Adslot 3 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[728,90]], 'div-gpt-ad-5190402-3')
					     .setTargeting('pos', ['3'])
					     .addService(googletag.pubads()));
		    //Adslot 4 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[320,50]], 'div-gpt-ad-5190402-4')
					     .setTargeting('pos', ['1'])
					     .addService(googletag.pubads()));
		    //Adslot 5 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[300,250]], 'div-gpt-ad-5190402-5')
					     .setTargeting('pos', ['1'])
					     .addService(googletag.pubads()));
		    //Adslot 6 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[300,250]], 'div-gpt-ad-5190402-6')
					     .setTargeting('pos', ['2'])
					     .addService(googletag.pubads()));
		    //Adslot 7 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[320,50]], 'div-gpt-ad-5190402-7')
					     .setTargeting('pos', ['2'])
					     .addService(googletag.pubads()));
		    //Adslot 8 declaration
		    gptadslots.push(googletag.defineSlot('/4011/trb.latimes/voiceoc', [[320,50]], 'div-gpt-ad-5190402-8')
					     .setTargeting('pos', ['3'])
					     .addService(googletag.pubads()));

		    googletag.pubads().setTargeting('ptype', ['s']);
		    googletag.enableServices();
		  });
		</script>
		<!-- End GPT Async Tag -->
		<?php
	}
}
add_action( 'wp_head', 'voiceofoc_tronc_DFP_ads' );

function voiceofoc_facebook_pixel() {
	?>
		<!-- Facebook Pixel Code -->
		<script>
			!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			document,'script','https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '1873216659661772'); // Insert your pixel ID here.
			fbq('track', 'PageView');
		</script>
		<noscript>
			<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1873216659661772&ev=PageView&noscript=1"/>
		</noscript>
		<!-- DO NOT MODIFY -->
		<!-- End Facebook Pixel Code -->
	<?php
}
add_action('wp_head', 'voiceofoc_facebook_pixel');
