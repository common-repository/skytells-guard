<? oxygen_import('Layouts.Header', array("title" => 'Security Analysis', 'page' => 'analysis')); ?>

        <div class="content">
        

<?php
/**
 * Admin: Configuration Analysis
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

use \skytells\wp\skyav\core;
use \skytells\wp\skyav\vendor\common;

// Flesh out inactive content errors.
$inactive = array();
if (!core::analyze_inactive_plugins()) {
	$tmp = core::get_plugins();
	foreach ($tmp as $k=>$v) {
		if (!$v['active']) {
			$inactive[] = '<li>' . esc_html__('Plugin', SKYELLSAV_L10N) . ': <code>' . esc_html($v['name']) . '</code></li>';
		}
	}
}
if (!core::analyze_inactive_themes()) {
	$tmp = core::get_themes();
	foreach ($tmp as $k=>$v) {
		if (!$v['active']) {
			$inactive[] = '<li>' . esc_html__('Theme', SKYELLSAV_L10N) . ': <code>' . esc_html($v['name']) . '</code></li>';
		}
	}
}

// And onto the data!
$data = array(
	'tests'=>array(
		array(
			'title'=>__('Administrator Accounts', SKYELLSAV_L10N),
			'status'=>core::analyze_administrators(),
			'errors'=>array(
				sprintf(
					esc_html__('Generic usernames like "admin" or "administrator" are present and should be renamed. Plugins like %s (pro) and %s can help with this.', SKYELLSAV_L10N),
					'<a href="https://wordpress.org/plugins/apocalypse-meow/" target="_blank" rel="noopener">Apocalypse Meow</a>',
					'<a href="https://wordpress.org/plugins/rename-users/" target="_blank" rel="noopener">Rename Users</a>'
				),
			),
		),
		array(
			'title'=>__('Authentication Salts & Keys', SKYELLSAV_L10N),
			'status'=>core::analyze_salts(true),
			'errors'=>array(
				sprintf(
					esc_html__('Your site contains weak and/or missing authentication salts. Visit %s and copy the output into %s.', SKYELLSAV_L10N),
					'<a href="https://api.wordpress.org/secret-key/1.1/salt/" target="_blank" rel="noopener">' . __('here', SKYELLSAV_L10N) . '</a>',
					'<code>wp-config.php</code>'
				),
			),
		),
		array(
			'title'=>__('Database Prefix', SKYELLSAV_L10N),
			'status'=>core::analyze_prefix(),
			'errors'=>array(
				sprintf(
					esc_html__('Your site is currently using the default table prefix, %s. It is not completely straightforward to retroactively fix this, however %s can point you in the right direction.', SKYELLSAV_L10N),
					'<code>wp_</code>',
					'<a href="http://www.wpbeginner.com/wp-tutorials/how-to-change-the-wordpress-database-prefix-to-improve-security/" target="_blank" rel="noopener">' . esc_html__('this tutorial', SKYELLSAV_L10N) . '</a>'
				),
			),
		),
		array(
			'title'=>__('Directory Listing', SKYELLSAV_L10N),
			'status'=>core::analyze_index(),
			'errors'=>array(
				sprintf(
					esc_html__('Your site currently lists directory contents. For example, click %s. For information on how to fix this, visit %s.', SKYELLSAV_L10N),
					'<a href="' . SKYELLSAV_PLUGIN_URL . 'img/" target="_blank">' . esc_html__('here', SKYELLSAV_L10N) . '</a>',
					'<a href="https://www.netsparker.com/blog/web-security/disable-directory-listing-web-servers/" target="_blank" rel="noopener">' . esc_html__('here', SKYELLSAV_L10N) . '</a>'
				),
			),
		),
		array(
			'title'=>__('File Editor', SKYELLSAV_L10N),
			'status'=>core::analyze_editor(),
			'errors'=>array(
				sprintf(
					esc_html__('The editor is currently enabled on your site. To disable it, add the following code to %s:', SKYELLSAV_L10N),
					'<code>wp-config.php</code>'
				),
				"<code>define('DISALLOW_FILE_EDIT', true);</code>",
			),
		),
		array(
			'title'=>__('File Scans', SKYELLSAV_L10N),
			'status'=>core::analyze_scan(),
			'errors'=>array(
				sprintf(
					esc_html__('You have not completed a file scan recently. Click %s to do that now.', SKYELLSAV_L10N),
					'<a href="' . admin_url('admin.php?page=skyav-scan') . '">' . esc_html__('here', SKYELLSAV_L10N) . '</a>'
				),
			),
		),
		array(
			'title'=>__('SSL', SKYELLSAV_L10N),
			'status'=>core::analyze_ssl(),
			'errors'=>array(
				esc_html__('It appears that your site might not be fully protected with SSL. Skytells-AV is not able to determine this with 100% accuracy, so if this assessment is wrong, please ignore it.', SKYELLSAV_L10N),
				sprintf(
					esc_html__("Otherwise, you're in for a treat! For a rundown on how to get an existing WordPress web site up and running over SSL, click %s.", SKYELLSAV_L10N),
					'<a href="https://www.skytells.org/ssl-certificates" target="_blank" rel="noopener">' . esc_html__('here', SKYELLSAV_L10N) . '</a>'
				),
			),
		),
		array(
			'title'=>__('SVG', SKYELLSAV_L10N),
			'status'=>core::analyze_svg(),
			'errors'=>array(
				sprintf(
					esc_html__('SVG support has been manually enabled for your site, leaving you at extreme risk. In order to protect yourself, please install %s.', SKYELLSAV_L10N),
					'<a href="https://wordpress.org/plugins/blob-mimes/" target="_blank" rel="noopener">Lord of the Files</a>'
				),
			),
		),
		array(
			'title'=>__('Inactive Plugins & Themes', SKYELLSAV_L10N),
			'status'=>!count($inactive),
			'errors'=>array(
				esc_html__('The following inactive content is still publicly accessible on your server. You should fully delete any content you are not using.', SKYELLSAV_L10N),
				'<ul>' . implode("\n", $inactive) . '</ul>',
			),
		),
		array(
			'title'=>__('Updates & Security Patches', SKYELLSAV_L10N),
			'status'=>core::analyze_updates(),
			'errors'=>array(
				sprintf(
					esc_html__('Your copy of WordPress is not fully up-to-date. Please head on over to %s to apply all available updates.', SKYELLSAV_L10N),
					'<a href="' . admin_url('update-core.php') . '">' . esc_html__('the update page', SKYELLSAV_L10N) . '</a>'
				),
			),
		),
	),
	'meow'=>core::analyze_meow(),
	'modal'=>'',
	'modals'=>array(
		// @codingStandardsIgnoreStart
		__('Administrator Accounts', SKYELLSAV_L10N)=>array(
			sprintf(
				esc_html__('WordPress\' popularity makes it a strong target for automated, %s login attacks. The vast majority of these attacks are waged by rather stupid robots that assume the existence of default usernames like "admin" or "administrator".', SKYELLSAV_L10N),
				'<a href="https://en.wikipedia.org/wiki/Brute-force_attack" target="_blank" rel="noopener">' . esc_html__('brute-force', SKYELLSAV_L10N) . '</a>'
			),
			esc_html__('By not having logins with these names, the vast majority of login attacks are moot.', SKYELLSAV_L10N),
		),
		__('Authentication Salts & Keys', SKYELLSAV_L10N)=>array(
			sprintf(
				esc_html__('WordPress uses site-defined %s to improve session security. It is important that each salt is defined in %s, and that that definition is strong.', SKYELLSAV_L10N),
				'<a href="https://en.wikipedia.org/wiki/Salt_(cryptography)" target="_blank" rel="noopener">' . esc_html__('salts', SKYELLSAV_L10N) . '</a>',
				'<code>wp-config.php</code>'
			),
			sprintf(
				esc_html__("Don't try to think of random values on your own. Just visit %s and copy-and-paste the results into your %s.", SKYELLSAV_L10N),
				'<a href="https://api.wordpress.org/secret-key/1.1/salt/" target="_blank" rel="noopener">WP.org</a>',
				'<code>wp-config.php</code>'
			),
		),
		__('Database Prefix', SKYELLSAV_L10N)=>array(
			sprintf(
				esc_html__('%s attacks often require that the attacker already know the names of tables in the database. To help combat this, WordPress allows sites to prepend a custom prefix to each table name.', SKYELLSAV_L10N),
				'<a href="https://en.wikipedia.org/wiki/SQL_injection" target="_blank" rel="noopener">' . esc_html__('SQL Injection', SKYELLSAV_L10N) . '</a>'
			),
		),
		__('Directory Listing', SKYELLSAV_L10N)=>array(
			sprintf(
				esc_html__('Depending on the server configuration, if someone visits a directory that does not include a file named %s or %s, etc., in a web browser, the contents of that directory will be listed.', SKYELLSAV_L10N),
				'<code>index.html</code>',
				'<code>index.php</code>'
			),
			esc_html__('This can make it much easier for attackers to gather information about the files on your server and better target their attacks.', SKYELLSAV_L10N)
		),
		__('File Editor', SKYELLSAV_L10N)=>array(
			esc_html__('WordPress ships with a tool that allows site administrators to directly edit the code of themes, plugins, and other files on the server.', SKYELLSAV_L10N),
			esc_html__('If this tool is enabled and someone manages to break into WordPress, it will give them broader system access than they might otherwise have.', SKYELLSAV_L10N),
		),
		__('File Scans', SKYELLSAV_L10N)=>array(
			esc_html__("It is important that you run frequent file scans of your site to ensure that everything is as it should be. But hey, that's what Skytells-AV is for!", SKYELLSAV_L10N),
		),
		__('SSL', SKYELLSAV_L10N)=>array(
			esc_html__('Without an SSL certificate, any communication between a visitor and your site can be intercepted by anybody else on the networks.', SKYELLSAV_L10N),
			esc_html__('This means things like login and other personal information can be stolen, but the corruption can work in the other direction too. Many cheap hotel, cafe, and airport networks, for example, will inject advertising into unencrypted pages, and sinister networks can even inject malware.', SKYELLSAV_L10N),
			esc_html__('Thus it is important that EVERY communication is encrypted, not just administrative areas.', SKYELLSAV_L10N),
		),
		__('SVG', SKYELLSAV_L10N)=>array(
			sprintf(
				esc_html__('Despite the massive popularity of the %s image format (particularly with modern web designers), WordPress does not allow them to be uploaded by default. As it turns out, SVG is insanely susceptible to malicious content and %s impossible to sanitize.', SKYELLSAV_L10N),
				'<a href="https://en.wikipedia.org/wiki/Scalable_Vector_Graphics" target="_blank" rel="noopener">SVG</a>',
				'<a href="https://skytells.com/2017/03/when-a-stranger-calls-sanitizing-svgs/" target="_blank" rel="noopener">' . esc_html__('almost', SKYELLSAV_L10N) . '</a>'
			),
		),
		__('Inactive Plugins & Themes', SKYELLSAV_L10N)=>array(
			esc_html__('Any code on your server has the potential to contain exploitable vulnerabilities, even if it is part of a theme or plugin that is not currently "active".', SKYELLSAV_L10N),
		),
		__('Updates & Security Patches', SKYELLSAV_L10N)=>array(
			sprintf(
				esc_html__('WordPress and its plugins and themes are %s. This is beneficial in that bugs and security issues can be identified and fixed more quickly, however in order for users to benefit, updates must be applied.', SKYELLSAV_L10N),
				'<a href="https://en.wikipedia.org/wiki/Open-source_software_development#Model" target="_blank" rel="noopener">' . esc_html__('open-source', SKYELLSAV_L10N) . '</a>'
			),
		),
		// @codingStandardsIgnoreEnd
	),
);


// JSON doesn't appreciate broken UTF.
common\ref\sanitize::utf8($data);
?>
<script>var skyavData=<?php echo json_encode($data, JSON_HEX_AMP); ?>;</script>
<div class="wrap" id="vue-analysis" v-cloak>


	<div id="poststuff">
		<div id="post-body" class="metabox-holder skyav-columns" v-bind:class="{'one-two' : !meow}">

			<!-- Main Items -->
			<div class="postbox-container">
				<div class="postbox">
					<h3 class="hndle"><?php echo esc_html__('Security Analysis', SKYELLSAV_L10N); ?></h3>
					<div class="inside">
						<table class="skyav-results">
							<thead>
								<tr>
									<th><?php echo esc_html__('Status', SKYELLSAV_L10N); ?></th>
									<th><?php echo esc_html__('Configuration', SKYELLSAV_L10N); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr class="skyav-analysis" v-for="item in tests">
									<td>
										<span class="dashicons" v-bind:class="{'dashicons-yes' : item.status, 'dashicons-no' : !item.status}"></span>
									</td>
									<td>
										<div class="skyav-analysis--title">
											<span v-bind:class="{'skyav-fg-orange' : !item.status}">{{ item.title }}</span>

											<span class="dashicons dashicons-info skyav-info-toggle" v-bind:class="{'is-active' : modal === item.title}" v-on:click.prevent="toggleModal(item.title)"></span>
										</div>

										<div v-if="!item.status" class="skyav-analysis--resolution">
											<p v-for="p in item.errors" v-html="p"></p>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div><!--.postbox-container-->



		</div><!--#post-body-->
	</div><!--#poststuff-->



	<!-- ==============================================
	HELP MODAL
	=============================================== -->
	<transition name="fade">
		<div v-if="modal" class="skyav-modal">
			<span class="dashicons dashicons-dismiss skyav-modal--close" v-on:click.prevent="toggleModal('')"></span>
			<div class="skyav-modal--inner">
				<p v-for="p in modals[modal]" v-html="p"></p>
			</div>
		</div>
	</transition>
</div><!--.wrap-->

<?
oxygen_import('Layouts.Footer'); ?>
