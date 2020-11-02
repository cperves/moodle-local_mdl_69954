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
 * management page
 *
 * @package     local_mdl_69954
 * @category    page
 * @copyright   2020 ESUP-Portail {@link https://www.esup-portail.org/}
 * @author Céline Pervès<cperves@unistra.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once(dirname(__FILE__).'/mdl_69954_management_table.php');
$courseid = required_param('courseid', PARAM_INT);
$url = new moodle_url('/local/mdl_69954/management.php');
$PAGE->set_url($url);
$PAGE->set_context(context_course::instance($courseid));
$PAGE->navbar->add(get_string('pluginmanagement', 'local_mdl_69954'));
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginmanagement', 'local_mdl_69954'));
$table = new mdl_69954_management_table($url, $courseid);
echo $table->out(0, true);
echo $OUTPUT->footer();