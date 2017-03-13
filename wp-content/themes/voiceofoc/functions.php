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
 * Because of a persistant Flash of Uninitialized Text on the part of Voice of OC staff, we're going to implement http://anantgarg.com/2016/06/22/typekit-fout-fix/
 * @since 2017-03-13
 */
function voiceofoc_typekit() {
		// normal Typekit script:
		// <script src="https://use.typekit.net/xyq0vny.js"></script>
		// <script>try{Typekit.load({ async: true });}catch(e){}</script>
	?>
		<script>
			(function(d) {
				loadFonts = 1;
				if(window.sessionStorage){
					if(sessionStorage.getItem('useTypekit')==='false'){
						loadFonts = 0;
					}
				}
				if (loadFonts == 1) {
						var config = {
							kitId: 'xyq0vny',
							scriptTimeout: 1000,
							async: true
						},
						h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";if(window.sessionStorage){sessionStorage.setItem("useTypekit","false")}},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+="wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s);
					}
				}
			)(document);
		</script>
		<style>
			.wf-loading p, .wf-loading h1, .wf-loading h2, .wf-loading h3, .wf-loading h4 {
				visibility: hidden;
			}
			.wf-active p, .wf-active h1, .wf-active h2, .wf-active h3, .wf-active h4 {
				visibility: visible;
			}
			.wf-inactive p, .wf-inactive h1, .wf-inactive h2, .wf-inactive h3, .wf-inactive h4 {
				visibility: visible;
			}
		</style>
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
