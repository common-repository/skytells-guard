<?php
/**
 * Admin: Premium License
 *
 * @package Skytells-AV Security Scanner
 * @author  Skytells, Inc
 */

/**
 * Do not execute this file directly.
 */
if (!defined('ABSPATH')) {
	exit;
}

use \skytells\wp\skyav\admin;
use \skytells\wp\skyav\ajax;
use \skytells\wp\skyav\license;
use \skytells\wp\skyav\options;
use \skytells\wp\skyav\vendor\common;

$data = array(
	'forms'=>array(
		'pro'=>array(
			'action'=>'skyav_ajax_pro',
			'n'=>ajax::get_nonce(),
			'license'=>options::get('license'),
			'errors'=>array(),
			'saved'=>false,
			'loading'=>false,
		),
	),
	'freeload'=>license::FREELOAD,
);
$license = license::get($data['forms']['pro']['license']);
$data['license'] = $license->get_license();

// JSON doesn't appreciate broken UTF.
common\ref\sanitize::utf8($data);
?>
<? oxygen_import('Layouts.Header', array("title" => 'Pro License', 'page' => 'pro')); ?>
        <div class="content">
<script>var skyavData=<?php echo json_encode($data, JSON_HEX_AMP); ?>;</script>
<div class="wrap" id="vue-pro" v-cloak>
	<h1><?php echo esc_html__('Premium License', SKYELLSAV_L10N); ?></h1>

	<?php
	// Warn about OpenSSL.
	if (!function_exists('openssl_get_publickey')) {
		echo '<div class="notice notice-warning">';
			// @codingStandardsIgnoreStart
			echo '<p>' . esc_html__('Please ask your system administrator to enable the OpenSSL PHP extension. Without this, your site will be unable to decode and validate the license details itself. In the meantime, Skytells-AV Security Scanner will try to offload this task to its own server. This should get the job done, but won\'t be as efficient and could impact performance a bit.', SKYELLSAV_L10N) . '</p>';
			// @codingStandardsIgnoreEnd
		echo '</div>';
	}
	?>

	<div class="updated" v-if="forms.pro.saved"><p><?php echo esc_html__('Your license has been saved!', SKYELLSAV_L10N); ?></p></div>
	<div class="error" v-for="error in forms.pro.errors"><p>{{error}}</p></div>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder skyav-columns ">

			<!-- License -->
			<div class="postbox-container">
				<? oxygen_import('Widgets.Activate'); ?>
				<div class="postbox">
					<h3 class="hndle"><?php echo esc_html__('Activation', SKYELLSAV_L10N); ?></h3>
					<div class="inside">
						<form name="proForm" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" v-on:submit.prevent="proSubmit">
							<textarea id="skyav-license" class="skyav-code" name="license" v-model.trim="forms.pro.license" placeholder="Paste your license key here."></textarea>
							<p><button type="submit" v-bind:disabled="forms.pro.loading" class="button button-primary button-large"><?php echo esc_html__('Save', SKYELLSAV_L10N); ?></button></p>
						</form>
					</div>
				</div>
			</div><!--.postbox-container-->

			<!-- License -->


		</div><!--#post-body-->
	</div><!--#poststuff-->
</div><!--.wrap-->

</div>
<style>
.has-error .form-control {
    border: 1px solid #79c29a !important;
}
.input-group .form-control {
    z-index: auto;
}
.has-error .form-control {
    background-color: #ffffff !important;
    color: #79c29a !important;
}
.has-error .input-group-addon {
    background-color: #56ad7d !important;
    color: #fff;
}
</style>
<? oxygen_import('Layouts.Footer'); ?>
