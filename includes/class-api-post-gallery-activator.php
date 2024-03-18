<?php

/**
 * Fired during plugin activation

 * @package    API-Post-Gallery
 * @subpackage api-post-gallery/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */
class API_Post_Gallery_Activator
{

	public static function activate()
	{
		deactivate_plugins('api-post-gallery/api-post-gallery.php');
	}
}
