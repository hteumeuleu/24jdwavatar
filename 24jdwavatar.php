<?php
/*
Plugin Name: 24jdw Avatar
Plugin URI: http://github.com/HTeuMeuLeu/24jdwavatar
Version: 1.0.0
Description: Adding a field for author avatars for 24joursdeweb.fr.
Author: HTeuMeuLeu
Author URI: http://www.hteumeuleu.fr
License: WTFPL
License URI: http://www.wtfpl.net/
*/

class jdwavatar {

	function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks for actions and filters through WordPress.
	 */
	private function init_hooks() {
		// Add the field
		add_action('show_user_profile', array(&$this, 'add_field'));
		add_action('edit_user_profile', array(&$this, 'add_field'));
		// Save information
		add_action('personal_options_update', array(&$this, 'save_field'), 1, 1);
		add_action('edit_user_profile_update', array(&$this, 'save_field'), 1, 1);
	}

	/**
	 * Add an 'jdwavatar' field on the User add/edit screen.
	 */
	function add_field($user) {
?>
		<table class="form-table">
			<tr>
				<th><label for="jdwavatar">Avatar</label></th>
				<td>
					<input type="url" name="jdwavatar" id="jdwavatar" value="<?php echo esc_attr(get_the_author_meta('jdwavatar', $user->ID)); ?>" placeholder="http://" class="regular-text" /><br />
					<span class="description">Saisissez l'URL d'une image.</span>
				</td>
			</tr>
		</table>
<?php
	}

	/**
	 * Saves the 'jdwavatar' field information.
	 * Based on the code found here : 
	 * http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
	 */
	function save_field($user_id) {
		if(!current_user_can('edit_user', $user_id))
			return false;
		update_usermeta($user_id, 'jdwavatar', $_POST['jdwavatar']);
	}
}

$jdwavatar = new jdwavatar();