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
 * Plugin event observers class.
 *
 * @package     local_mdl_69954
 * @category    event
 * @copyright   2020 ESUP-Portail {@link https://www.esup-portail.org/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author Céline Pervès <cperves@unistra.fr>
 */

namespace local_mdl_69954;

class observers {

    public static function role_assigned(\core\event\role_assigned $event) {
        global $DB;
        $courseid = $event->get_context()->instanceid;
        $roleid = $event->objectid;
        $teacher = $DB->get_record('role', array('shortname' => 'teacher'));
        $userid = $event->relateduserid;
        // Unenrol user to mdl_69554 plugin.
        $enrolledrecords = $DB->get_record('mdl_69954', array('userid' => $userid, 'courseid' => $courseid));
        if(!$enrolledrecords){
            $record = new \stdClass();
            $record->userid = $userid;
            $record->courseid = $courseid;
            $record->moderator = ($roleid == $teacher->id);
            $DB->insert_record('mdl_69954', $record);
        } else{
            // Update.
            $enrolledrecords->moderator = ($roleid == $teacher->id);
            $DB->update_record('mdl_69954', $enrolledrecords);
        }
    }

    public static function role_unassigned(\core\event\role_unassigned $event) {
        global $DB;
        $courseid = $event->get_context()->instanceid;
        $userid = $event->relateduserid;
        // Unenrol user to mdl_69554 plugin.
        $DB->delete_records('mdl_69954', array('userid' => $userid, 'courseid' => $courseid));
    }
}