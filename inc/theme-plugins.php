<?php
/*-----------------------------------------------------------------------------------*/
/* Required Plugins
/*-----------------------------------------------------------------------------------*/
add_action('admin_notices', 'theme_plugin_dependencies');
function theme_plugin_dependencies($checkonly = null) {
	$theme = wp_get_theme();
	$format = '<div class="notice notice-error"><p>Theme required plugin %s: %s</p></div>';
	$plugins = array(
		'advanced-custom-fields/acf.php' => array( 'name' => '<a href="https://www.advancedcustomfields.com/" target="_blank">Advanced Custom Fields</a>', 'slug' => 'advanced-custom-fields'),
		'timber-library/timber.php' => array( 'name' => '<a href="https://wordpress.org/plugins/timber-library/" target="_blank">Timber</a>', 'slug' => 'timber-library' )
	);

	$out = '';
	foreach ($plugins as $plugin => $nfo) {
		if (is_wp_error(validate_plugin($plugin))) {
			if (!$nfo['slug']) {
				$out .= sprintf($format, $nfo['name'], "Please contact your developer for installation instructions.");
			} else {
				$link = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $nfo['slug']), 'install-plugin_' . $nfo['slug']);
				$out .= sprintf($format, $nfo['name'], "Please <a href='$link'>install</a> this Plugin.");
			}
		} elseif (is_plugin_inactive($plugin)) {
			$link = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . urlencode($plugin), 'activate-plugin_' . $plugin);
			$out .= sprintf($format, $nfo['name'], "Please <a href='$link'>activate</a> this Plugin.");
		}
	}
	if ($checkonly) return $out != '';
	echo $out;
}