<?php
/**
 * Home Template: Voice of OC
 * Description: Homepage layout for Voice of OC, by Cornershop Creative
 * Sidebars:
 *   Homepage Right Rail
 *   Homepage Missed It
 */

global $largo, $shown_ids, $tags;
?>
<main id="homepage-voiceofoc" class="row-fluid clearfix">
	<section class="span8">
		<div class="row-fluid hidden-phone">
			<section class="homepage-top-stories span7">
				<?php
					/*
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
					echo $voiceofocTopStories;
				?>
			</section>
			<aside class="homepage-featured span5">
				<?php
					/*
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
					echo $voiceofocFeaturedStories;
				?>
			</aside>
		</div>
		<div class="row-fluid show-mobile">
			<section class="homepage-top-stories span12">
				<?php
					/*
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
					echo $voiceofocMobileStories;
				?>
			</section>
		</div>
		<div class="row-fluid hidden-phone">
			<header class="span12 color-box color-box-missed-it">
				<h1>In Case You Missed It</h1>
			</header>
		</div>
		<div class="row-fluid hidden-phone">
			<div class="span12">
				<aside id="missed-it" class="row-fluid missed-it row-wrap">
					<?php
						/*
						*	article.span4 (x9)
						*		figure
						*			img
						*		h1
						*
						*/
						echo $voiceofocMissedIt;
					?>
				</aside>
			</div>
		</div>
	</section>
	<aside class="span4 voiceofoc-right-rail">
		<?php
		/*
		* Widget Area: Homepage Right Rail
		*/
		if ( is_active_sidebar( 'voiceofoc-homepage-right-rail' ) ) {
			ob_start();
			dynamic_sidebar( 'voiceofoc-homepage-right-rail' );
			$sidebar = ob_get_clean();
			echo apply_filters( 'sidebar_output', $sidebar );
		} // is_active_sidebar( 'voiceofoc-homepage-right-rail' )
		else { ?>
			<article class="no-right-rail"><h1>Content not set</h1><p>Homepage right rail content not set. Please contact the editor and web team.</p></article>
		<?php } // else is_active_sidebar( 'voiceofoc-homepage-right-rail' ) ?>
	</aside>
</main>
