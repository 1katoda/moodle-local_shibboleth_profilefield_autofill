<?php
// This file is part of local_shibboleth_profilefield_autofill plugin for Moodle - http://moodle.org/
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
 * Admin settings and defaults.
 *
 * @package    local_shibboleth_profilefield_autofill
 * @copyright  2025 1katoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
        $ADMIN->add('localplugins', new admin_category('local_shibboleth_profilefield_autofill', new lang_string('pluginname', 'local_shibboleth_profilefield_autofill')));

        $settings = new admin_settingpage('local_shibboleth_profilefield_autofill_settings', new lang_string('generalsettings', 'local_shibboleth_profilefield_autofill'));

        


        // Introductory explanation.
        $readmeurl = (new moodle_url('/auth/shibboleth/README.txt'))->out();
        $settings->add(new admin_setting_heading('local_shibboleth_profilefield_autofill/pluginname', '',
                new lang_string('local_shibboleth_profilefield_autofill/readme','local_shibboleth_profilefield_autofill',new lang_string('auth_shibbolethdescription', 'auth_shibboleth', $readmeurl))));

        // Attribute.
        $settings->add(new admin_setting_configtext('local_shibboleth_profilefield_autofill/shibboleth_attribute', get_string('shibbolethattribute', 'local_shibboleth_profilefield_autofill'),
                get_string('shibbolethattribute_desc', 'local_shibboleth_profilefield_autofill'), '', PARAM_RAW));
        
        // Get list of Auth plugins and make the key => value.
        $fields = $DB->get_records('user_info_field', ['visible' => 1]);
        $options = ["0" => "-"];
        foreach($fields as $field) {
                $options["$field->id"] = $field->name;
        }
        $settings->add(new admin_setting_configselect('local_shibboleth_profilefield_autofill/profilefield',
                get_string('local_shibboleth_profilefield_autofill/profilefield', 'local_shibboleth_profilefield_autofill'),
                get_string('local_shibboleth_profilefield_autofill/profilefield_desc', 'local_shibboleth_profilefield_autofill'), '0', $options));

        $ADMIN->add('localplugins', $settings);
}