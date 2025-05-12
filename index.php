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

// Shibboleth protected page.

require('../../config.php');

// Support for WAYFless URLs.
$target = optional_param('target', '', PARAM_LOCALURL);
if (!empty($target) && empty($SESSION->wantsurl)) {
    $SESSION->wantsurl = $target;
}

$urltogo = '/';
if (isset($SESSION->wantsurl) and (strpos($SESSION->wantsurl, $CFG->wwwroot) === 0)) {
    $urltogo = $SESSION->wantsurl;    /// Because it's an address in this site
    unset($SESSION->wantsurl);

} else {
    $urltogo = $CFG->wwwroot.'/';      /// Go to the standard home page
    unset($SESSION->wantsurl);         /// Just in case
}


// redirect($urltogo);


$pluginconfig   = get_config('local_shibboleth_profilefield_autofill');


// Check whether Shibboleth is configured properly
$readmeurl = (new \moodle_url('/auth/shibboleth/README.txt'))->out();
if (empty($pluginconfig->shibboleth_attribute)) {
    throw new \moodle_exception('shib_not_set_up_error', 'auth_shibboleth', '', $readmeurl);
}

$context = \context_system::instance();
$PAGE->set_url('/local/shibboleth_profilefield_autofill/index.php');
$PAGE->set_context($context);

if (!isloggedin() || isguestuser()) {
    require_login();
}

/// If we can find the Shibboleth attribute, save it in session and return to main login page
if (empty($_SERVER[$pluginconfig->shibboleth_attribute])) {
    throw new \moodle_exception('error:missingrequiredattribute', 'local_shibboleth_profilefield_autofill', '', $pluginconfig->shibboleth_attribute);
} else {
    // Save profile field
    $fieldvalue = strtolower($_SERVER[$pluginconfig->shibboleth_attribute]);

    if(empty($$pluginconfig->profilefield) ||
        !$DB->record_exists(
            'user_info_field',
            [
                'id' => $pluginconfig->profilefield
            ]
        )
            ) {
        throw new \moodle_exception('missingprofilefielddefinition');
    }

    $data = $DB->get_record(
        'user_info_data',
        [
            'fieldid' => $pluginconfig->profilefield,
            'userid' => $USER->id,
        ]
    );
    if(empty($data)) {
        $data = new \stdClass();
        $data->fieldid = $pluginconfig->profilefield;
        $data->userid = $USER->id;
        $data->data = $_SERVER[$pluginconfig->shibboleth_attribute];
        $data->dataformat = 0;
        $DB->insert_record('user_info_data', $data);
    } else {
        $data->data = $_SERVER[$pluginconfig->shibboleth_attribute];
        $data->dataformat = 0;
        $DB->update_record('user_info_data', $data);
    }
}
redirect($urltogo);

