<header>
	<nav id="main-menu" class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top" role="navigation">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-main-menu" aria-controls="bs-navbar-main-menu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="<?php echo home_url(); ?>">
				<img height="50" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo_cf_medium.png'; ?>" alt="">
			</a>

			<?php wp_nav_menu( array(
				'theme_location'    => 'main-menu',
				'depth'             => 2,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'bs-navbar-main-menu',
				'menu_class'        => 'nav navbar-nav mr-auto',
				'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
				'walker'            => new WP_Bootstrap_Navwalker(),
			) ); ?>

			<?php global $current_user;
			wp_get_current_user(); ?>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <strong><?php echo $current_user->user_login; ?></strong>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarUserDropdown">
                            <a class="dropdown-item" href="<?php echo wp_logout_url( get_the_permalink(14) ); ?>">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
		</div>
	</nav>
</header>