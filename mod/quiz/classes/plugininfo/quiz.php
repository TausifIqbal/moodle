<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Subplugin info class.
 *
 * @package   mod_quiz
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_quiz\plugininfo;

use core\plugininfo\base , core_plugin_manager, moodle_url;

defined('MOODLE_INTERNAL') || die();


class quiz extends base {
    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    // public static function get_enabled_plugins() {
    //     global $DB;

    //     $plugins = core_plugin_manager::instance()->get_installed_plugins('assignfeedback');
    //     if (!$plugins) {
    //         return array();
    //     }
    //     $installed = array();
    //     foreach ($plugins as $plugin => $version) {
    //         $installed[] = 'assignfeedback_'.$plugin;
    //     }

    //     list($installed, $params) = $DB->get_in_or_equal($installed, SQL_PARAMS_NAMED);
    //     $disabled = $DB->get_records_select('config_plugins', "plugin $installed AND name = 'disabled'", $params, 'plugin ASC');
    //     foreach ($disabled as $conf) {
    //         if (empty($conf->value)) {
    //             continue;
    //         }
    //         list($type, $name) = explode('_', $conf->plugin, 2);
    //         unset($plugins[$name]);
    //     }

    //     $enabled = array();
    //     foreach ($plugins as $plugin => $version) {
    //         $enabled[$plugin] = $plugin;
    //     }

    //     return $enabled;
    // }

    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Pre-uninstall hook.
     *
     * This is intended for disabling of plugin, some DB table purging, etc.
     *
     * NOTE: to be called from uninstall_plugin() only.
     * @private
     */
    public function uninstall_cleanup() {
        global $DB;

        // Do the opposite of db/install.php scripts - deregister the report.

        $DB->delete_records('quiz_reports', array('name'=>$this->name));

        parent::uninstall_cleanup();
    }
}
