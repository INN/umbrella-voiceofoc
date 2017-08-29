<?php 

if ( voiceofoc_widget_header_area_enabled() ) {
	echo '<div class="row">';
		dynamic_sidebar( 'widget-header-area' );
	echo '</div>';
}
