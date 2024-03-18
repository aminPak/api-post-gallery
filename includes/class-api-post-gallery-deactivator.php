<?php

/**
 * Fired during plugin deactivation
 *
 * @package    API-Post-Gallery
 * @subpackage api-post-gallery/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 */
class API_Post_Gallery_Deactivator
{

	public static function deactivate()
	{
		// Remove temporary data or settings
		// Example: Flush rewrite rules to remove custom post type rules
		flush_rewrite_rules();
	}
}
