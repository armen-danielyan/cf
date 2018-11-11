<?php
/**
 * Prevent Direct Access
 */
defined( 'ABSPATH' ) or die( 'Direct Access to This File is Not Allowed.' );

/**
 * Define Theme Version
 */
define( 'CF_VERSION', '0.0.1' );

/**
 * Define Languages
 */
define('CF_LANG', array('nl', 'fr', 'de'));

/**
 * Run After Theme Activated
 */
add_action('after_switch_theme', 'afterThemeActivated');
function afterThemeActivated () {
	if( get_role('subscriber') ){
		remove_role( 'subscriber' );
	}

	if( get_role('contributor') ){
		remove_role( 'contributor' );
	}

	if( get_role('editor') ){
		remove_role( 'editor' );
	}

	if( get_role('author') ){
		remove_role( 'author' );
	}

	add_role( 'consultant', __('Consultant', 'cf'));
	add_role( 'candidate', __('Candidate', 'cf'));
	add_role( 'project-manager', __('Manager', 'cf'));
}

$loginPageId = 14;

/**
 * Set Options
 */
require_once 'libs/options/theme-options.php';
new cfOptions();

/**
 * Redirect non logged users to login page
 */
add_action( 'wp', 'redirectLoginPage' );
function redirectLoginPage() {
	wp_reset_query();
	if ( !is_user_logged_in() && !is_page(14) && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {
		wp_redirect( get_the_permalink(14) );
		exit;
	} elseif ( is_user_logged_in() && is_page(14) ) {
		wp_redirect( home_url() );
		exit;
	}
}

/**
 * Redirect from wp-login to login page
 */
add_action('init','redirectLoginPageFromWpLogin');
function redirectLoginPageFromWpLogin() {
	$pageViewed = basename($_SERVER['REQUEST_URI']);

	if( $pageViewed == 'wp-login.php' && $_SERVER['REQUEST_METHOD'] == 'GET') {
		wp_redirect(get_the_permalink(14));
		exit;
	}
}

/**
 * Redirect from logput to login page
 */
add_action('wp_logout','logoutRedirect');
function logoutRedirect() {
	wp_redirect(get_the_permalink(14));
	exit;
}

/**
 * Login failed
 */
add_action( 'wp_login_failed', 'loginFailed' );
function loginFailed() {
	$referrer = $_SERVER['HTTP_REFERER'];
	if ( !empty( $referrer ) && !strstr( $referrer, 'wp-login' ) && !strstr( $referrer, 'wp-admin' ) ) {
		wp_redirect( $referrer . '?login=failed' );
		exit;
	}
}

/**
 * Load Scripts and Styles
 */
add_action( 'wp_enqueue_scripts', 'loadScriptsStyles' );
function loadScriptsStyles() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'cf-jqueryui-js', get_stylesheet_directory_uri() . '/assets/js/jquery-ui.min.js', array( 'jquery' ), CF_VERSION, true );
	wp_enqueue_script( 'cf-cookie-js', get_stylesheet_directory_uri() . '/assets/js/jquery.cookie.js', array( 'jquery' ), CF_VERSION, true );
	wp_enqueue_script( 'cf-datatable-js', get_stylesheet_directory_uri() . '/assets/js/jquery.dataTables.min.js', array( 'jquery' ), CF_VERSION, true );
	wp_enqueue_script( 'cf-bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array( 'jquery' ), CF_VERSION, true );
	wp_enqueue_script( 'cf-main-js', get_stylesheet_directory_uri() . '/assets/js/main.js', array(
		'jquery',
		'cf-bootstrap-js',
		'cf-datatable-js'
	), CF_VERSION, true );
	wp_localize_script( 'cf-main-js', 'wp_vars', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	) );

	wp_enqueue_style( 'cf-jqueryui-css', get_stylesheet_directory_uri() . '/assets/css/jquery-ui.min.css', '', CF_VERSION, '' );
	wp_enqueue_style( 'cf-datatable-css', get_stylesheet_directory_uri() . '/assets/css/jquery.dataTables.min.css', '', CF_VERSION, '' );
	wp_enqueue_style( 'cf-bootstrap-css', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', '', CF_VERSION, '' );
	wp_enqueue_style( 'cf-main-fa', get_stylesheet_directory_uri() . '/assets/css/fa-all.min.css', array(), CF_VERSION, '' );
	wp_enqueue_style( 'cf-main-css', get_stylesheet_directory_uri() . '/assets/css/main.css', array( 'cf-bootstrap-css', 'cf-datatable-css' ), CF_VERSION, '' );
}

/**
 * Load Admin Scripts and Styles
 */
add_action( 'admin_enqueue_scripts', 'loadAdminScriptsStyles' );
function loadAdminScriptsStyles() {
	wp_enqueue_script( 'cf-admin-main-js', get_stylesheet_directory_uri() . '/assets/js/admin-main.js', array('jquery'), CF_VERSION, true );
}

/**
 * Register Menus
 */
add_action( 'init', 'registerMenus' );
function registerMenus() {
	register_nav_menus( array(
		'main-menu' => __('Main Menu', 'cf')
	) );
}

/**
 * Include Bootstrap NavWalker
 */
require_once 'libs/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php';

/**
 * Register Post Types
 */
require_once 'post_types/Sectors.php';
require_once 'post_types/Specialism.php';
require_once 'post_types/JobTitles.php';
require_once 'post_types/Experience.php';

require_once 'post_types/Project.php';
require_once 'post_types/Review.php';
require_once 'post_types/Question.php';
require_once 'post_types/Reviews_Done.php';

/**
 * Users Custom Fields
 */
require_once 'users/user-custom-fields.php';

/**
 * CF API
 */
require_once 'libs/API/CF.php';
$cfAPI = new CF_API();
$cfAPI->register_routes();

/**
 * Ajax
 */
require_once 'ajax/ajax.php';

/**
 * Set post per page for Projects and Reviews archive
 */
add_action( 'pre_get_posts', 'setPostsPerPageForProjects' );
function setPostsPerPageForProjects( $query ) {
	if ( !is_admin() && $query->is_main_query() && is_post_type_archive( array('projects', 'reviews') ) ) {
		$query->set( 'posts_per_page', '-1' );
	}
}

/**
 * Get Projects Review Count
 */
function getReviewsCount($postId) {
	$argsReview = array(
		'post_type' => 'reviews',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => '_cf_review_projectid',
				'value' => $postId,
			)
		)
	);
	$reviews = new WP_Query($argsReview);

	return $reviews->post_count;
}

/**
 * Update/Delete post meta
 */
function updatePostMeta($postId, $key, $data) {
	$value = implode(',', (array)$data);
	if(get_post_meta($postId, $key, FALSE)) {
		update_post_meta($postId, $key, $value);
	} else {
		add_post_meta($postId, $key, $value);
	}
	if(!$value) delete_post_meta($postId, $key);

	return;
}

/**
 * Reviews Done count by Review ID
 */
function reviewsDoneByReviewId($reviewId) {
	$currentUserId = get_current_user_id();

	$reviewsDone = new WP_Query(array(
		'post_type' => 'reviewsdone',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_cf_review_done_reviewid',
				'value' => $reviewId
			),
			array(
				'key' => '_cf_review_done_consultant',
				'value' => $currentUserId
			)
		)
	));

	return $reviewsDone->post_count;
}

/**
 * Reviews Done count by Project ID
 */
function reviewsDoneByprojectId($projectId) {
	$reviewsDone = new WP_Query(array(
		'post_type' => 'reviewsdone',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => '_cf_review_done_projectid',
				'value' => $projectId
			)
		)
	));

	return $reviewsDone->post_count;
}

/**
 * Project users count by Project ID
 */
function projectUsersByProjectId($projectId) {
	$projectUsersRaw = get_post_meta($projectId, '_cf_project_users', true);
	if(!$projectUsersRaw) return 0;

	$projectUsers = unserialize($projectUsersRaw);
	$usersCount = count($projectUsers);

	return $usersCount;
}

/**
 * Reviews Done count by Project ID
 */
function projectReviewsDoneByProjectId($projectId) {
	$reviewsDone = new WP_Query(array(
		'post_type' => 'reviewsdone',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => '_cf_review_done_projectid',
				'value' => $projectId
			)
		)
	));

	return $reviewsDone->post_count;
}

/**
 * Filter Projects archive by consultant
 */
add_action( 'pre_get_posts', 'filterProjectsByConsultant' );
function filterProjectsByConsultant( $query ) {
	if( ! is_admin() && $query->is_main_query() && is_post_type_archive('projects') && !userAdmin() ) {
		$query->set('meta_key', '_cf_project_consultant');
		$query->set('meta_value', get_current_user_id());
	}
}


/**
 * Remove admin bar for all rolles except administrator
 */
add_action('after_setup_theme', 'removeAdminBar');
function removeAdminBar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

/**
 * Redirect wp-login.php to login page
 */
add_action('init', 'possiblyRedirect');
function possiblyRedirect(){
	global $pagenow;
	if( 'wp-login.php' == $pagenow ) {
		if ( isset( $_POST['wp-submit'] ) ||
		     ( isset($_GET['action']) && $_GET['action'] == 'logout') ||
		     ( isset($_GET['action']) && $_GET['action'] == 'rp') ||
		     ( isset($_GET['action']) && $_GET['action'] == 'resetpass') ||
		     ( isset($_GET['checkemail']) && $_GET['checkemail'] == 'confirm') ||
		     ( isset($_GET['checkemail']) && $_GET['checkemail'] == 'registered') ) return;
		else wp_redirect( get_the_permalink(14) );
		exit();
	}
}

/**
 * Force to make active according menu item
 */
add_filter( 'nav_menu_css_class', 'selectMenuItem', 10, 3 );
function selectMenuItem( $classes, $item, $args ) {
	if( (is_page(80) && 'Users' == $item->title) ||
		(is_page(104) && 'Users' == $item->title) ||
		(is_page(161) && 'Users' == $item->title) ||
		(is_page(180) && 'Users' == $item->title) ||
		(is_page(78) && 'Projects' == $item->title) ||
		(is_page(33) && 'Projects' == $item->title) ||
	    (is_singular('projects') && 'Projects' == $item->title) ||
	    (is_page(84) && 'Reviews' == $item->title) ||
	    (is_singular('reviews') && 'Reviews' == $item->title) ||
		(is_page(135) && 'Dashboard' == $item->title) ) {
		$classes[] = 'current-menu-item';
	}

	return array_unique( $classes );
}

/**
 * Redirect to password reset page
 */
add_action( 'login_form_rp', 'redirectToCustomPasswordReset' );
add_action( 'login_form_resetpass', 'redirectToCustomPasswordReset' );
function redirectToCustomPasswordReset() {
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
		$redirect_url = get_the_permalink(14);

		$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
		if ( ! $user || is_wp_error( $user ) ) {
			if ( $user && $user->get_error_code() === 'expired_key' ) {
				$redirect_url = add_query_arg( 'login', 'expired_key', $redirect_url );
				wp_redirect( $redirect_url );
			} else {
				$redirect_url = add_query_arg( 'login', 'invalidkey', $redirect_url );
				wp_redirect( $redirect_url );
			}
			exit;
		}

		$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
		$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

		wp_redirect( $redirect_url );
		exit;
	}
}

/**
 * Handle password reset
 */
add_action( 'login_form_rp', 'doPasswordReset' );
add_action( 'login_form_resetpass', 'doPasswordReset' );
function doPasswordReset() {
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$redirect_url = get_the_permalink(14);

		$rp_key = $_REQUEST['rp_key'];
		$rp_login = $_REQUEST['rp_login'];

		$user = check_password_reset_key( $rp_key, $rp_login );

		if ( ! $user || is_wp_error( $user ) ) {
			if ( $user && $user->get_error_code() === 'expired_key' ) {
				$redirect_url = add_query_arg( 'login', 'expired_key', $redirect_url );
				wp_redirect( $redirect_url );
			} else {
				$redirect_url = add_query_arg( 'login', 'invalidkey', $redirect_url );
				wp_redirect( $redirect_url );
			}
			exit;
		}

		if ( isset( $_POST['pass1'] ) ) {
			if ( $_POST['pass1'] != $_POST['pass2'] ) {
				// Passwords don't match
				$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
				$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

			if ( empty( $_POST['pass1'] ) ) {
				// Password is empty

				$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
				$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
				$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

				wp_redirect( $redirect_url );
				exit;
			}

			// Parameter checks OK, reset password
			reset_password( $user, $_POST['pass1'] );

			$redirect_url = add_query_arg( 'password', 'changed', $redirect_url );
			wp_redirect( $redirect_url );
		} else {
			echo "Invalid request.";
		}

		exit;
	}
}

/**
 * Reset token after changing password
 */
add_action( 'after_password_reset', 'actionPasswordReset', 10, 2 );
function actionPasswordReset( $user, $new_pass ) {
    // do_action('jwt_auth_expire', time() + (DAY_IN_SECONDS * 30) );
}

/**
 * Get Custom Items
 */
function getCustomItems($postType) {
	$postsArray = get_posts( array(
		'post_type' => $postType,
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby'  => 'title',
		'order' => 'ASC',
	) );

	$output = [];

	foreach ( $postsArray as $post ) {
		$output[] = $post->post_title;
	}

	wp_reset_postdata();

	return $output;
}

/**
 * Filter query result by user role
 */
function filterByUserRole($key) {
	$user = wp_get_current_user();
	$role = ( array ) $user->roles;
	if($role[0] === 'consultant') {
		return array(
			'key' => $key,
			'value' => get_current_user_id(),
		);
	} else {
		return array();
	}
}

/**
 * Current user administrator
 */
function userAdmin() {
	$user = wp_get_current_user();
	$role = ( array ) $user->roles;
	if($role[0] === 'administrator') {
		return true;
	} else {
		return false;
	}
}

function getExportAverageData($numItemsArr, $reviewId) {
	$numItemsDataArr = [];

	$reviewDoneArgs = array(
		'post_type' => 'reviewsdone',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation'  => 'AND',
			array(
				'key' => '_cf_review_done_rated',
				'value' => '1',
			),
			array(
				'key' => '_cf_review_done_reviewid',
				'value' => $reviewId,
			)
		)
	);

	$reviewsDone = new WP_Query($reviewDoneArgs);
	if($reviewsDone->have_posts()): while($reviewsDone->have_posts()): $reviewsDone->the_post();
		$rDoneId = get_the_id();
		$period = get_post_meta($rDoneId, '_cf_select_review_period', true);
		$year = get_post_meta($rDoneId, '_cf_select_review_year', true);

		$periodYear = 'Q' . $period . ' ' . $year;
		if(in_array($periodYear, $numItemsArr)) {
			$qIdsRaw = get_post_meta($rDoneId, '_cf_reviews_done_questions', true);
			$qIds = unserialize($qIdsRaw);

			foreach($qIds as $qId) {
				$qr = $numItemsDataArr[(string)$qId['qid']][$periodYear];
				if($qr) {
					$numItemsDataArr[(string)$qId['qid']][$periodYear] = ($qr + (int)$qId['qr']) / 2;
				} else {
					$numItemsDataArr[(string)$qId['qid']][$periodYear] = (int)$qId['qr'];
				}

			}
		}
	endwhile; endif;

	return $numItemsDataArr;
}

function getExportUserData($numItemsArr, $reviewId, $compareUserId) {
	$numItemsDataArr = [];

	$reviewDoneArgs = array(
		'post_type' => 'reviewsdone',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation'  => 'AND',
			array(
				'key' => '_cf_review_done_rated',
				'value' => '1',
			),
			array(
				'key' => '_cf_review_done_reviewid',
				'value' => $reviewId,
			),
			array(
				'key' => '_cf_review_done_target_userid',
				'value' => $compareUserId,
			)
		)
	);

	$reviewsDone = new WP_Query($reviewDoneArgs);
	if($reviewsDone->have_posts()): while($reviewsDone->have_posts()): $reviewsDone->the_post();
		$rDoneId = get_the_id();
		$period = get_post_meta($rDoneId, '_cf_select_review_period', true);
		$year = get_post_meta($rDoneId, '_cf_select_review_year', true);

		$periodYear = 'Q' . $period . ' ' . $year;
		if(in_array($periodYear, $numItemsArr)) {
			$qIdsRaw = get_post_meta($rDoneId, '_cf_reviews_done_questions', true);
			$qIds = unserialize($qIdsRaw);

			foreach($qIds as $qId) {
				$numItemsDataArr[(string)$qId['qid']][$periodYear] = (int)$qId['qr'];
			}
		}
	endwhile; endif;

	return $numItemsDataArr;
}

function getExportReviewDoneUsers($reviewId) {
	$numItemsDataArr = [];

	$reviewDoneArgs = array(
		'post_type' => 'reviewsdone',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation'  => 'AND',
			array(
				'key' => '_cf_review_done_rated',
				'value' => '1',
			),
			array(
				'key' => '_cf_review_done_reviewid',
				'value' => $reviewId,
			),
			filterByUserRole('_cf_review_done_consultant')
		)
	);

	$reviewsDone = new WP_Query($reviewDoneArgs);
	if($reviewsDone->have_posts()): while($reviewsDone->have_posts()): $reviewsDone->the_post();
		$rDoneId = get_the_id();
		$user = get_post_meta($rDoneId, '_cf_review_done_target_userid', true);
		$numItemsDataArr[] = (int)$user;
	endwhile; endif;

	return array_unique($numItemsDataArr);
}

function getExportReviewDoneReviews() {
	$numItemsDataArr = [];

	$reviewDoneArgs = array(
		'post_type' => 'reviewsdone',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation'  => 'AND',
			array(
				'key' => '_cf_review_done_rated',
				'value' => '1',
			),
			filterByUserRole('_cf_review_done_consultant')
		)
	);

	$reviewsDone = new WP_Query($reviewDoneArgs);
	if($reviewsDone->have_posts()): while($reviewsDone->have_posts()): $reviewsDone->the_post();
		$rDoneId = get_the_id();
		$review = get_post_meta($rDoneId, '_cf_review_done_reviewid', true);
		$numItemsDataArr[] = (int)$review;
	endwhile; endif;

	return array_unique($numItemsDataArr);
}

function getConsultantProjects() {
    $projectArgs = array(
        'post_type' => 'projects',
        'posts_per_page' => -1,
        'meta_query' => array(
            filterByUserRole('_cf_project_consultant')
        )
    );

    $projectsQuery = new WP_Query($projectArgs);
    $projectData = [];
    foreach($projectsQuery->posts as $project) {
        $projectData[$project->ID] = $project->post_title;
    }

    return $projectData;
}

add_filter( 'wp_mail_content_type', 'setContentType' );
function setContentType() {
    return "text/html";
}

add_filter('wp_mail', 'addWatermark', 10,1);
function addWatermark($args){
    $msg = $args['message'];
    $msg = str_replace('<','', $msg);
    $msg = str_replace('>','', $msg);
    $msg = str_replace("\n",'<br>', $msg);

    ob_start(); ?>
    <!DOCTYPE html>
    <html>
        <body>
            <div style="width: 80%;margin: 0 auto;border: 1px solid #999999;">
                <div class="cf-email-header">
                    <img width="100%" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/email_header.jpg'; ?>">
                </div>
                <div style="padding: 30px;font-size: 16px">
                    <?php echo $msg; ?>
                </div>
            </div>
        </body>
    </html>
    <?php $newMsg = ob_get_contents();
    ob_end_clean();

    $args['message'] = $newMsg;
    return $args;
}

add_filter( 'wp_mail_from_name', 'cfMailName' );
function cfMailName( $email ){
    return 'Computer Futures';
}

add_filter( 'wp_mail_from', 'cfMailFrom' );
function cfMailFrom ($email ){
    return get_bloginfo( 'admin_email' );
}



