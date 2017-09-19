<?php 

if ( voiceofoc_widget_header_area_enabled() ) {
	echo '<div class="row" id="widget-header-area">';
		dynamic_sidebar( 'widget-header-area' );
	echo '</div>';
}
