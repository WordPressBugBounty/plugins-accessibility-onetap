<?php
/**
 * Content template for submenu page.
 *
 * @package    Accessibility_Onetap
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap">
	<!-- Header -->
	<header class="top">
		<div class="mycontainer">
			<div class="myrow myrow1">
				<div class="left">
					<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/logo.png' ); ?>" alt="<?php echo esc_attr__( 'logo', 'accessibility-onetap' ); ?>">
				</div>
				<div class="right">
					<a href="<?php echo esc_url( admin_url() . 'admin.php?page=onetap-module-labels' ); ?>" class="button">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.074 4.282a2.046 2.046 0 0 0-.5.154c-.262.122-.508.361-5.64 5.496-3.793 3.794-5.394 5.421-5.459 5.548-.201.39-.205.422-.224 1.917-.01.779-.007 1.53.008 1.669.031.291.135.471.341.592.135.079.198.082 1.74.082 1.717 0 1.798-.008 2.179-.213.26-.141 10.879-10.76 11.006-11.007.15-.292.196-.481.201-.82.004-.373-.073-.671-.244-.936-.168-.26-2.103-2.172-2.322-2.293-.303-.168-.688-.235-1.086-.189M17.33 6.67c.705.705.91.932.91 1.01 0 .077-.164.264-.7.8l-.7.699-1.01-1.009-1.009-1.01.699-.7c.533-.534.723-.7.799-.7.077 0 .309.208 1.011.91m-2.55 2.57 1 1-4 4-4 4H5.76v-2.02l3.99-3.99a571.73 571.73 0 0 1 4.01-3.99c.011 0 .47.45 1.02 1" fill-rule="evenodd"></path></svg>
						<?php esc_html_e( 'Edit Labels', 'accessibility-onetap' ); ?>
					</a>					
					<a target="_blank" href="<?php echo esc_url( 'https://wponetap.com/support/' ); ?>" class="button">
						<?php esc_html_e( 'Support', 'accessibility-onetap' ); ?>
					</a>
				</div>
			</div>
			<div class="myrow myrow2">
				<h2><?php esc_html_e( 'Accessibility Settings', 'accessibility-onetap' ); ?></h2>
				<p class="desc"><?php esc_html_e( 'Customize your browsing experience by enabling or disabling various accessibility modules.', 'accessibility-onetap' ); ?>
					<br>
					<?php esc_html_e( 'For the best results, we recommend keeping all features turned on to maximize ease of use and inclusivity.', 'accessibility-onetap' ); ?>
				</p>
				<div class="box-button-cta">
					<a target="_blank" href="<?php echo esc_url( 'https://wponetap.com/pricing/' ); ?>" class="button button-primary">
						<?php esc_html_e( 'Get Pro Version', 'accessibility-onetap' ); ?>
					</a>
					<a target="_blank" href="<?php echo esc_url( 'https://wponetap.com/' ); ?>" class="button">
						<?php esc_html_e( 'See Whats Include', 'accessibility-onetap' ); ?>
					</a>
				</div>
			</div>
		</div>
	</header>
	<section class="box-button-navigation">
		<div class="separator"></div>
		<ul>
			<li>
				<a class="button" href="#anchorAccessibilityProfiles">
					<?php esc_html_e( 'Accessibility Profiles', 'accessibility-onetap' ); ?>
				</a>
			</li>
			<li>
				<a class="button" href="#anchorContentlModules">
					<?php esc_html_e( 'Content Modules', 'accessibility-onetap' ); ?>
				</a>
			</li>
			<li>
				<a class="button" href="#anchorModulesColors">
					<?php esc_html_e( 'Colors', 'accessibility-onetap' ); ?>
				</a>
			</li>
			<li>
				<a class="button" href="#anchorOrientation">
					<?php esc_html_e( 'Orientation', 'accessibility-onetap' ); ?>
				</a>
			</li>
		</ul>
	</section>
	<?php $this->settings_api->show_forms(); ?>
</div>