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
					<a href="<?php echo esc_url( admin_url() . 'admin.php?page=accessibility-onetap-modules' ); ?>" class="button">
						<?php esc_html_e( 'Back To Modules', 'accessibility-onetap' ); ?>
					</a>
					<a href="<?php echo esc_url( admin_url() . 'admin.php?page=accessibility-onetap-settings' ); ?>" class="button">
						<?php esc_html_e( 'General Settings', 'accessibility-onetap' ); ?>
					</a>
			
				</div>
			</div>
			<div class="myrow myrow2">
				<h2><?php esc_html_e( 'Customize Module Labels', 'accessibility-onetap' ); ?></h2>
				<p class="desc"><?php esc_html_e( 'Set your own names for each accessibility feature. Customize how modules are labeled to match your site’s tone, language, or user needs. Personalization helps make access easier.', 'accessibility-onetap' ); ?>
				</p>
			</div>
		</div>
	</header>
	<section class="box-button-navigation" style="display: none;">
		<div class="separator"></div>
		<ul>
			<li>
				<a class="button" href="#anchorAccessibilityProfiles">
					<?php esc_html_e( 'Accessibility Profiles', 'accessibility-onetap' ); ?>
				</a>
			</li>
			<li>
				<a class="button" href="#anchorContentModules">
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