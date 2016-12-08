<?php
	
include_once get_template_directory() . '/homepages/homepage-class.php';

class VoiceofOC extends Homepage {
	var $name = 'Voice of OC';
	var $type = 'voiceofoc';
	var $description = 'Homepage layout for Voice of OC, by Cornershop Creative';
	var $sidebars = array(
		'Homepage Left Rail (An optional widget area that, when enabled, appears to the left of the main content area on the homepage)'
	);
	var $rightRail = true;

	function __construct($options=array()) {
		$suffix = (LARGO_DEBUG)? '' : '.min';

		$defaults = array(
			'template' => get_stylesheet_directory() . '/homepages/templates/voiceofoc.php',
			'assets' => array(
				array('voiceofoc-home', get_stylesheet_directory_uri() . '/homepages/assets/css/voiceofoc' . $suffix . '.css', array()),
			)
		);
		$options = array_merge($defaults, $options);
		$this->init($options);
		$this->load($options);
	}

	public function init($options=array()) {
		$this->prominenceTerms = array(
			array(
				'name' => __('Top Story', 'largo'),
				'description' 	=> __('Add this label to a post to make it a Top Story on the homepage', 'largo'),
		    	'slug' 			=> 'top-story'
			),
			array(
				'name' => __('Homepage Featured', 'largo'),
				'description' => __('Add this label to posts to display them on the homepage.', 'largo'),
				'slug' => 'homepage-featured'
			),
			array(
				'name' => __('In Case You Missed It', 'largo'),
				'description' => __('Add this label to posts to display them in the In Case You Missed It section of the homepage. Story must also include a Featured Image.', 'largo'),
				'slug' => 'missed-it'
			),
		);
	}

	/**
	* Override base Homepage class setRightRail method
	* Disable the Largo right rail, as we will implement our own.
	*/
	public function setRightRail() {
		global $largo;
		unset($largo['home_rail']);
	}

	/**
	 * Create byline and date string, like largo_byline
	 *
	 * @param $post removed 2015-08-18 because it's not actually used in this function and was causing PHP warnings.
	 */
	private static function getBylineAndDate() {
		$time_difference = current_time('timestamp') - get_the_time('U');

		$output = largo_byline(FALSE, TRUE); // Do not echo & exclude date

		if ( $time_difference < 86400 ) {
			$output .= ' <time class="entry-date updated dtstamp pubdate recent" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . get_the_date( 'g:i A' ) . '</time>';
		} else {
			$output .= ' <time class="entry-date updated dtstamp pubdate" datetime="' . esc_attr( get_the_date( 'c' ) ) . '"></time>';
		}

		return $output;
	}

	/**
	* Homepage Top Stories section
	* Above the fold, center section. All stories include feature images
	*
	*
	*	article.sticky
	*		figure
	*			img
	*			figcaption.photo-credit
	*		header
	*			h1
	*			h5.byline
	*				time
	*		p.excerpt
	*
	*	article (x2)
	*		header
	*			h1
	*			h5.byline
	*				time
	*		main
	*			p.excerpt
	*			figure
	*				img
	*/
	public function voiceofocTopStories() {
		global $shown_ids;
		$content = '';
		//
		// Sticky Top Story post
		//
		$sticky_topstory = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy'	=> 'prominence',
					'field'		=> 'slug',
					'terms'		=> 'top-story'
				)
			),
			'post__in'				=> get_option( 'sticky_posts' ),
			'ignore_sticky_posts'	=> FALSE,
			'meta_key'				=> '_thumbnail_id',
			'showposts'				=> 1
		) );
		if ( $sticky_topstory->have_posts() ) {
			while ( $sticky_topstory->have_posts() ) {
				$sticky_topstory->the_post();
				$shown_ids[] = get_the_ID();
				// Hide article on mobile
				$hide_mobile = get_post_meta(get_the_ID(), '_voiceofoc_hide_mobile', true);
				if ($hide_mobile === 'true'){
					$hide_mobile = 'hidden-phone';
				} else{
					$hide_mobile = '';
				}
				$sticky_ts_content = array();
				// Photo
				$sticky_ts_content['photo-creditor'] = navis_get_media_credit( get_post_thumbnail_id() );
				if ( $sticky_ts_content['photo-creditor']->to_string() ) {
					$sticky_ts_content['photo-credit'] = sprintf('<figcaption class="photo-credit">%s</figcaption>', $sticky_ts_content['photo-creditor']->to_string());
				}
				// Photo
				$sticky_ts_content['photo'] = sprintf(
					'<figure class="desktop-photo %s"><a href="%s">%s</a>%s</figure>',
					largo_hero_class( get_the_ID(), false ), // VO-7, adding .is-video for the homepage image if it has a video.
					get_permalink(),
					get_the_post_thumbnail( get_the_ID(), 'large' ),
					isset( $sticky_ts_content['photo-credit'] ) ? $sticky_ts_content['photo-credit'] : ''
				);
				// Mobile photo
				$sticky_ts_content['mobile_photo'] = sprintf(
					'<figure class="mobile-photo"><a href="%s">%s</a>%s</figure>',
					get_permalink(),
					get_the_post_thumbnail( get_the_ID(), 'med-rect' ),
					isset( $sticky_ts_content['photo-credit'] ) ? $sticky_ts_content['photo-credit'] : ''
				);
				// Header
				$sticky_ts_content['header'] = sprintf(
					'<header><h1><a href="%s">%s</a></h1>%s<h5 class="byline">%s</h5></header>',
					get_permalink(),
					get_the_title(),
					$sticky_ts_content['mobile_photo'],
					static::getBylineAndDate()
				);
                // Date
                if (date('Y-m-d') === get_the_date('Y-m-d')) {
                	$date = sprintf('<span class="today">%s</span>', get_the_date('h:i A'));
                } else{
                	$date = get_the_date('h:i A');
                }
                $sticky_ts_content['date'] = sprintf(
                	'<span class="date-published"><time datetime="%1$s">%2$s</time></span>',
                	 get_the_date('Y-m-d H:i:s'),
                	 $date
                );
				// Excerpt
				$sticky_ts_content['excerpt'] = largo_excerpt( get_post(), 4, FALSE, '', FALSE );

				// Top term
				// http://jira.inn.org/browse/VO-12
				$sticky_ts_content['top-term'] = largo_top_term(array(
					'echo' => FALSE
				));

				$sticky_ts_content['classes'] = get_post_class($hide_mobile);

				// Append story to content
				$content .= sprintf(
					'<article id="story-%d" class="voiceofoc-sticky clearfix %s">%s%s%s%s</article>',
					get_the_ID(),
					implode( ' ', $sticky_ts_content['classes']),
					$sticky_ts_content['top-term'],
					$sticky_ts_content['photo'],
					$sticky_ts_content['header'],
					$sticky_ts_content['excerpt']
				);
			} // while ( $sticky_topstory->have_posts() )
		} // if ( $sticky_topstory->have_posts() )
		else {
			$content .= '<article class="voiceofoc-sticky"><header><h1>No Sticky Top Story</h1></header><p class="excerpt">No sticky top story found. Please contact the editor and web team.</p></article>';
		} // else ( $sticky_topstory->have_posts() )
		//
		// Additional Top Story posts
		//
		$addl_topstories = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy'	=> 'prominence',
					'field'		=> 'slug',
					'terms'		=> 'top-story'
				)
			),
			'ignore_sticky_posts'	=> FALSE,
			'meta_key'				=> '_thumbnail_id',
			'showposts'				=> 2,
			'post__not_in'			=> $shown_ids,
		) );
		if ( $addl_topstories->have_posts() ) {
			while ( $addl_topstories->have_posts() ) {
				$addl_topstories->the_post();

				// Hide article on mobile
				$hide_mobile = get_post_meta(get_the_ID(), '_voiceofoc_hide_mobile', true);
				if ($hide_mobile === 'true'){
					$hide_mobile = 'hidden-phone';
				} else{
					$hide_mobile = '';
				}
				$shown_ids[] = get_the_ID();
				$addl_ts_content = array();

				// Photo
				$addl_ts_content['photo'] = sprintf(
					'<figure><a href="%s">%s</a></figure>',
					get_permalink(),
					get_the_post_thumbnail( get_the_ID(), 'med-rect' )
				);

				// Header
				$addl_ts_content['header'] = sprintf(
					'<header><h1><a href="%s">%s</a></h1>%s<h5 class="byline">%s</h5></header>',
					get_permalink(),
					get_the_title(),
					$addl_ts_content['photo'],
					static::getBylineAndDate()
				);

				// Date
				if (date('Y-m-d') === get_the_date('Y-m-d')) {
					$date = sprintf('<span class="today">%s</span>', get_the_date('h:i A'));
				} else{
					$date = get_the_date('h:i A');
				}
				$addl_ts_content['date'] = sprintf(
					'<span class="date-published"><time datetime="%1$s">%2$s</time></span>',
					get_the_date('Y-m-d H:i:s'),
					$date
				);

				// Excerpt
				$addl_ts_content['excerpt'] = largo_excerpt( get_post(), 4, FALSE, '', FALSE );
				// Main (Excerpt)
				$addl_ts_content['main'] = sprintf(
					'<main>%s</main>',
					$addl_ts_content['excerpt']
				);

				// Top term
				// http://jira.inn.org/browse/VO-12
				$addl_ts_content['top-term'] = largo_top_term(array(
					'echo' => FALSE
				));

				$addl_ts_content['classes'] = get_post_class($hide_mobile);

				// Append story to content
				$content .= sprintf(
					'<article id="story-%d" class="top-middle clearfix %s">%s%s%s</article>',
					get_the_ID(),
					implode( ' ', $addl_ts_content['classes']),
					$addl_ts_content['top-term'],
					$addl_ts_content['header'],
					$addl_ts_content['main']
				);
			} // while ( $addl_topstories->have_posts() )
		} // if ( $addl_topstories->have_posts() )
		else {
			$content .= '<article class="sticky"><header><h1>No Top Stories</h1></header><p class="excerpt">No top stories found. Please contact the editor and web team.</p></article>';
		} // else ( $addl_topstories->have_posts() )
		return $content;
	}

	public function voiceofocMobileStories() {
		global $shown_ids;
		$content = '';

		$all_posts = largo_get_featured_posts( array(
			'ignore_sticky_posts'	=> TRUE,
			'showposts'				=> 15,
			'orderby'				=> 'post_date',
			'order'					=> 'DESC',
			'tax_query' => ''
		) );

		if ( $all_posts->have_posts() ) {
			while ( $all_posts->have_posts() ) {
				$all_posts->the_post();
				$has_featured_image = '';

				// Hide article on mobile
				$hide_mobile = get_post_meta(get_the_ID(), '_voiceofoc_hide_mobile', true);
				if ($hide_mobile === 'true'){
					$hide_mobile = 'hidden-phone';
				} else{
					$hide_mobile = '';
				}
				$sticky_ts_content = array();
				// Photo
				$sticky_ts_content['photo-creditor'] = navis_get_media_credit( get_post_thumbnail_id() );
				if ( $sticky_ts_content['photo-creditor']->to_string() ) {
					$sticky_ts_content['photo-credit'] = sprintf('<figcaption class="photo-credit">%s</figcaption>', $sticky_ts_content['photo-creditor']->to_string());
				}

				if ( has_post_thumbnail(get_the_ID()) ) {
					// Mobile photo
					$sticky_ts_content['mobile_photo'] = sprintf(
						'<figure class="mobile-photo"><a href="%s">%s</a>%s</figure>',
						get_permalink(),
						get_the_post_thumbnail( get_the_ID(), 'med-rect' ),
						isset( $sticky_ts_content['photo-credit'] ) ? $sticky_ts_content['photo-credit'] : ''
					);
				} else {
					$has_featured_image = ' no-image';
				}

				// Header
				$sticky_ts_content['header'] = sprintf(
					'<header><h1><a href="%s">%s</a></h1><h5 class="byline">%s</h5></header>',
					get_permalink(),
					get_the_title(),
					largo_byline(FALSE, TRUE)
				);

                // Date
                if (date('Y-m-d') === get_the_date('Y-m-d')) {
                	$date = sprintf('<span class="today">%s</span>', get_the_date('h:i A'));
                } else{
                	$date = sprintf(get_the_date('h:i A'));
                }

                $post_date = new DateTime(get_the_date('Y-m-d H:i:s'));
                $current_date = new DateTime();
                $date_difference = $post_date->diff($current_date);
                $totals_hours_diff = $date_difference->format('%h');
                $days_diff = $date_difference->format('%a');

                if ($days_diff > 0) {
                	$totals_hours_diff = ($totals_hours_diff * 24) + $totals_hours_diff;
                }
                
                if ($totals_hours_diff <= 24) {
	                $sticky_ts_content['date'] = sprintf(
	                	'<span class="date-published"><time data-post-time="%1$s" datetime="%2$s">%3$s</time></span>',
	                	strtotime(get_gmt_from_date(get_the_date())),
						get_the_date('H:i:s'),
						$date
	                );
	            } else{
	            	$sticky_ts_content['date'] = '';
	            }

				// Excerpt
				$sticky_ts_content['excerpt'] = largo_excerpt( get_post(), 4, FALSE, '', FALSE );
				// Append story to content
				$content .= sprintf(
					'<article id="story-%d" class="voiceofoc-sticky clearfix %s"><div class="mobile-story %s">%s%s%s</div>%s</article>',
					get_the_ID(),
					$hide_mobile,
					$has_featured_image,
					$sticky_ts_content['header'],
					$sticky_ts_content['date'],
					$sticky_ts_content['excerpt'],
					$sticky_ts_content['mobile_photo']
				);
			} // while ( $sticky_topstory->have_posts() )
		} // if ( $sticky_topstory->have_posts() )
		else {
			$content .= '<article class="voiceofoc-sticky"><header><h1>No Sticky Top Story</h1></header><p class="excerpt">No sticky top story found. Please contact the editor and web team.</p></article>';
		}

		return $content;
	}

	/**
	* Homepage Featured section
	* Above the fold, left section. No stories include feature images
	*
	*	article.sticky
	*		header
	*			h1
	*			h5.byline
	*				time
	*		main
	*			p.excerpt
	*
	*	article (x3)
	*		header
	*			h1
	*			h5.byline
	*				time
	*		main
	*			p.excerpt
	*/
	public function voiceofocFeaturedStories() {
		global $shown_ids;
		$content = '';
		//
		// Sticky Featured Story post
		//
		$sticky_featstory = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'prominence',
					'field' 	=> 'slug',
					'terms' 	=> 'homepage-featured'
				)
			),
			'ignore_sticky_posts'	=> FALSE,
			'showposts'				=> 4,
			'post__not_in'			=> $shown_ids,
		) );
		if ( $sticky_featstory->have_posts() ) {
			while ( $sticky_featstory->have_posts() ) {
				$sticky_featstory->the_post();
				// Hide article on mobile
				$hide_mobile = get_post_meta(get_the_ID(), '_voiceofoc_hide_mobile', true);
				if ($hide_mobile === 'true'){
					$hide_mobile = 'hidden-phone';
				} else{
					$hide_mobile = '';
				}
				$shown_ids[] = get_the_ID();
				$sticky_fs_content = array();
				// Photo
				$sticky_fs_content['photo'] = sprintf(
					'<figure class="desktop-photo"><a href="%s">%s</a></figure>',
					get_permalink(),
					get_the_post_thumbnail( get_the_ID(), 'med-rect' )
				);
				// Mobile photo
				$sticky_fs_content['mobile_photo'] = sprintf(
					'<figure class="mobile-photo"><a href="%s">%s</a></figure>',
					get_permalink(),
					get_the_post_thumbnail( get_the_ID(), 'med-rect' )
				);

				// Top term
				// http://jira.inn.org/browse/VO-12
				$sticky_fs_content['top-term'] = largo_top_term(array(
					'echo' => FALSE
				));

				// Header
				$sticky_fs_content['header'] = sprintf(
					'<header><h1><a href="%s">%s</a></h1>%s<h5 class="byline">%s</h5></header>',
					get_permalink(),
					get_the_title(),
					$sticky_fs_content['mobile_photo'],
					static::getBylineAndDate()
				);

				// Date
				if (date('Y-m-d') === get_the_date('Y-m-d')) {
					$date = sprintf('<span class="today">%s</span>', get_the_date('h:i A'));
				} else{
					$date = sprintf('%s at %s', get_the_date('F d, Y'), get_the_date('h:i A'));
				}
				$sticky_fs_content['date'] = sprintf(
					'<span class="date-published"><time datetime="%1$s">%2$s</time></span>',
					get_the_date('Y-m-d H:i:s'),
					$date
				);

				// Excerpt
				$sticky_fs_content['excerpt'] = largo_excerpt( get_post(), 4, FALSE, '', FALSE );

				$sticky_fs_content['classes'] = get_post_class($hide_mobile);

				// Append story to content
				$content .= sprintf(
					'<article id="story-%d" class="voiceofoc-sticky clearfix %s">%s%s%s</article>',
					get_the_ID(),
					implode( ' ', $sticky_fs_content['classes'] ),
					$sticky_fs_content['top-term'],
					$sticky_fs_content['header'],
					$sticky_fs_content['excerpt']
				);
			} // while ( $sticky_featstory->have_posts() )
		} // if ( $sticky_featstory->have_posts() )
		else {
			$content .= '<article class="voiceofoc-sticky"><header><h1>No Sticky Featured Story</h1></header><p class="excerpt">No sticky featured story found. Please contact the editor and web team.</p></article>';
		} // else ( $sticky_featstory->have_posts() )

		return $content;
	}
	/*
	* Homepage In Case You Missed It section
	* Below the fold, left section. All include feature images
	*
	*	article.span4 (x9)
	*		figure
	*			img
	*		h1
	*
	*/
	public function voiceofocMissedIt() {
		global $shown_ids;
		$content = '';
		//
		// Additional Top Story posts
		//
		$missedit_stories = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy'	=> 'prominence',
					'field'		=> 'slug',
					'terms'		=> 'missed-it'
				)
			),
			'ignore_sticky_posts'	=> FALSE,
			'meta_key'				=> '_thumbnail_id',
			'showposts'				=> 9,
			'post__not_in'			=> $shown_ids,
		) );
		// var_dump(count($missedit_stories['posts']));
		if ( $missedit_stories->have_posts() ) {
			$counter = 1;
			while ( $missedit_stories->have_posts() ) {
				$missedit_stories->the_post();
				// Hide article on mobile
				$hide_mobile = get_post_meta(get_the_ID(), '_voiceofoc_hide_mobile', true);
				if ($hide_mobile === 'true'){
					$hide_mobile = 'hidden-phone';
				} else{
					$hide_mobile = '';
				}
				$shown_ids[] = get_the_ID();
				$missedit_content = array();
				// Handle row-breaks every 3 items
				// Needed for IE8
				if ( 3 === $counter ) {
					$counter = 1;
					$missedit_content['class'] = 'row-last';
				} else {
					$missedit_content['class']  = '';
				}
				// Photo
				$missedit_content['photo'] = sprintf(
					'<figure><a href="%s">%s</a></figure>',
					get_permalink(),
					get_the_post_thumbnail( get_the_ID(), 'missed-it' )
				);
				// Header
				$missedit_content['header'] = sprintf(
					'<header><h1><a href="%s">%s</a></h1></header>',
					get_permalink(),
					get_the_title()
				);
				// Append story to content
				$content .= sprintf(
					'<div class="span4 %s %s"><article id="story-%d">%s%s</article></div>',
					$hide_mobile,
					$missedit_content['class'] ,
					get_the_ID(),
					$missedit_content['photo'],
					$missedit_content['header']
				);
			} // while ( $missedit_stories->have_posts() )
		} // if ( $missedit_stories->have_posts() )
		else {
			$content .= '<section class="row-fluid missed-it"><div class="span12"><header><h1>No &quot;In Case You Missed It&quot; Stories</h1></header><p class="excerpt">No &quot;In Case You Missed It&quot; stories found. Please contact the editor and web team.</p></div></section>';
		} // else ( $missedit_stories->have_posts() )

		return $content;
	}
}


function voiceofoc_add_homepage_widget_areas() {
	$sidebars = array (
		array (
			'name'	=> __( 'Homepage Right Rail', 'voiceofoc' ),
			'desc' 	=> __( 'The right rail on the homepage.', 'voiceofoc' ),
			'id' 	=> 'voiceofoc-homepage-right-rail'
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
add_action( 'widgets_init', 'voiceofoc_add_homepage_widget_areas' );


function voiceofoc_custom_homepage_layouts() {
	$unregister = array(
		'HomepageBlog',
		'HomepageSingle',
		'HomepageSingleWithFeatured',
		'HomepageSingleWithSeriesStories',
		'TopStories',
		'LegacyThreeColumn'
	);

	foreach ( $unregister as $layout )
		unregister_homepage_layout( $layout );

	register_homepage_layout( 'VoiceofOC' );
}
add_action( 'init', 'voiceofoc_custom_homepage_layouts', 10 );
