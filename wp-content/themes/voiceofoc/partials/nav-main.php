<?php

if ( is_front_page() || is_home() || is_archive() ): ?>
<nav id="main-nav" class="navbar clearfix">
  <div class="navbar-inner">
	<div class="container">

	  <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
	  <a class="btn btn-navbar toggle-nav-bar"  title="<?php esc_attr_e('More', 'largo'); ?>">
		<div class="bars">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</div>
	  </a>

	  <div class="nav-shelf">
		<ul class="nav">
			<?php
					$args = array(
						'theme_location' => 'main-nav',
						'depth'		 => 0,
						'container'	 => false,
						'items_wrap' => '%3$s',
						'menu_class' => 'nav',
						'walker'	 => new Bootstrap_Walker_Nav_Menu()
					);
					largo_cached_nav_menu($args);
				?>
				</ul>
				<ul class="nav visible-phone">
					<?php if (has_nav_menu('global-nav')) { ?>
					<li class="menu-item-has-childen dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle"><?php
								//try to get the menu name from global-nav
								$menus = get_nav_menu_locations();
								$menu_title = wp_get_nav_menu_object($menus['global-nav'])->name;
								echo ( $menu_title ) ? $menu_title : __('About', 'largo');
							?> <b class="caret"></b>
						</a>
						<?php
							$args = array(
								'theme_location' => 'global-nav',
								'depth'		 => 1,
								'container'	 => false,
								'menu_class' => 'dropdown-menu',
							);
							largo_cached_nav_menu($args);
						?>
					</li>
					<?php } ?>
				</ul>
			</div>

		<?php if ( is_home() || is_front_page() ) { ?>
		<div id="header-search">
			<form class="form-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="input-append">
					<input type="text" placeholder="<?php _e('Search', 'largo'); ?>" class="input-medium appendedInputButton search-query" value="" name="s" /><button type="submit" class="search-submit btn"><i class="icon-search"></i></button>
				</div>
			</form>
		</div>
		<?php } ?>
	</div>
  </div>
</nav>
<?php endif;
