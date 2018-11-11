<?php
/**
 * Template Name: Login
 */
?>
<?php $secure = ( 'https' === parse_url( wp_login_url(), PHP_URL_SCHEME ) );
setcookie( TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN, $secure ); ?>

<?php get_header(); ?>

<main id="login">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div id="login-form-wrap">
					<div class="login-logo-wrap">
						<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo_cf_medium.png'; ?>" alt="">
					</div>

					<?php if(!isset($_GET['login']) OR $_GET['login'] !== 'forget-password' AND $_GET['login'] !== 'sent-password' AND !isset($_GET['key'])) { ?>
						<form name="loginform" action="<?php echo site_url( '/wp-login.php' ); ?>" method="post">
							<input id="login-username" type="text" size="30" value="" name="log" placeholder="E-mail adres">
							<label for="login-username">Vul hier je e-mail adres in</label>


							<input id="login-password" type="password" size="30" value="" name="pwd" placeholder="Wachtwoord">
							<label for="login-password">Vul hier je wachtwoord in</label>

							<input type="submit" class="fp-submit" value="LOGIN" name="wp-submit">

							<input type="hidden" value="<?php echo esc_attr( home_url() ); ?>" name="redirect_to">
							<input type="hidden" value="1" name="testcookie">
						</form>

						<?php if(isset($_GET['login']) AND $_GET['login'] === 'failed') { ?>
							<div class="login-failed">Helaas, dat was niet goed. Deze combinatie van e-mail en wachtwoord is bij ons niet bekend</div>
						<?php } ?>

						<?php if(isset($_GET['login']) AND $_GET['login'] === 'invalidkey') { ?>
                            <div class="login-failed">Invalid Key</div>
						<?php } ?>

                        <?php if(isset($_GET['login']) AND $_GET['login'] === 'expired_key') { ?>
                            <div class="login-failed">Key Expired</div>
						<?php } ?>

						<?php if(isset($_GET['password']) AND $_GET['password'] === 'changed') { ?>
                            <div class="login-success">Password changed</div>
						<?php } ?>

						<div class="login-form-footer">
							<a id="forget-password-url" href="<?php echo get_the_permalink(14) . '/?login=forget-password' ?>">Wachtwoord vergeten</a>
						</div>
					<?php } ?>

					<?php if(isset($_GET['login']) AND $_GET['login'] === 'forget-password') { ?>
						<div class="login-form-footer">
							<div class="fp-title">Wachtwoord vergeten?</div>

							<form style="margin-bottom: 15px" name="loginform" action="<?php echo site_url( '/wp-login.php?action=lostpassword' ); ?>" method="post">
								<input id="user_login" type="email" size="30" value="" name="user_login" placeholder="E-mail adres" >
								<label for="user_login">Vul hier je e-mail adres in</label>

								<button class="fp-submit" type="submit" value="Get New Password" name="wp-submit">VERSTUREN</button>

								<input type="hidden" value="<?php echo get_the_permalink(14) . '/?login=sent-password'; ?>" name="redirect_to">
							</form>

							<a id="login-url" href="<?php echo get_the_permalink(14); ?>">Terug naar inloggen</a>
						</div>
					<?php } ?>

					<?php if(isset($_GET['login']) AND $_GET['login'] === 'sent-password') { ?>
						<div class="login-form-footer">
							<div class="fp-title">Wachtwoord vergeten?</div>

							<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/fp_success.png'; ?>" alt="">
							<div class="fp-sent">Binnen enkele minuten ontvang je een e-mail met een link om je wachtwoord op te halen.</div>

							<a id="login-url" href="<?php echo get_the_permalink(14); ?>">Terug naar inloggen</a>
						</div>
					<?php } ?>

					<?php if(isset($_GET['login']) AND isset($_GET['key'])) { ?>
                        <div id="password-reset-form" class="widecolumn">
                            <form name="resetpassform" id="resetpassform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
                                <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $_REQUEST['login'] ); ?>" autocomplete="off" />
                                <input type="hidden" name="rp_key" value="<?php echo esc_attr( $_REQUEST['key'] ); ?>" />

                                <input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" />
                                <label for="pass1"><?php _e( 'New password', 'personalize-login' ) ?></label>

                                <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
                                <label for="pass2"><?php _e( 'Repeat new password', 'personalize-login' ) ?></label>

                                <p class="description"><?php echo wp_get_password_hint(); ?></p>

                                    <input type="submit" name="submit" id="resetpass-button"
                                           class="fp-submit" value="<?php _e( 'Reset Password', 'personalize-login' ); ?>" />
                            </form>

	                        <?php if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'password_reset_empty') { ?>
                                <div class="login-failed">Reset Password is empty</div>
	                        <?php } ?>

	                        <?php if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'password_reset_mismatch') { ?>
                                <div class="login-failed">Reset Password missmatch</div>
	                        <?php } ?>
                        </div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</main>

    <script>
        jQuery(document).ready(function($) {
            $.cookie("period", '', {path: '/'});
            $.cookie("year", '', {path: '/'});
            $.cookie("user-ids", '', {path: '/'});
            $.cookie("review-id", '', {path: '/'});
            $.cookie("project-id", '', {path: '/'});

            $.cookie("export-compare-type", '', {path: '/'});
            $.cookie("export-compare-user-id", '', {path: '/'});
            $.cookie("export-period-from", '', {path: '/'});
            $.cookie("export-period-to", '', {path: '/'});
            $.cookie("export-year-from", '', {path: '/'});
            $.cookie("export-year-to", '', {path: '/'});
            $.cookie("export-review-id", '', {path: '/'});
            $.cookie("export-user-id", '', {path: '/'});
        })
    </script>

<?php get_template_part('components/component', 'footer'); ?>

<div id="login-bgr"></div>

<?php get_footer(); ?>