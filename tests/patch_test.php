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
 * mod_rocketchat event observers test.
 * recycle bin tests included into observer_testcase
 * @package    local_digital_training_account_services
 * @copyright   2020 ESUP-Portail {@link https://www.esup-portail.org/}
 * @author Céline Pervès<cperves@unistra.fr>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class local_mdl_69954_patch_testcase extends advanced_testcase{

    public function test_enrol_unenrol(){
        $this->resetAfterTest();
        global $DB;
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $user = $generator->create_user();
        $studentrole = $DB->get_record('role', array('shortname' => 'student'));
        $teacherrole = $DB->get_record('role', array('shortname' => 'teacher'));
        $generator->enrol_user($user->id, $course->id, $studentrole->id);
        $enrollingrecords = $DB->get_records('mdl_69954', array('userid' => $user->id, 'courseid' => $course->id));
        $this->assertNotFalse($enrollingrecords);
        $this->assertCount(1, $enrollingrecords);
        $enrollingrecord = array_pop($enrollingrecords);
        $this->assertEmpty($enrollingrecord->moderator);
        $generator->enrol_user($user->id, $course->id, $teacherrole->id);
        $enrollingrecords = $DB->get_records('mdl_69954', array('userid' => $user->id, 'courseid' => $course->id));
        $this->assertNotFalse($enrollingrecords);
        $this->assertCount(1, $enrollingrecords);
        $enrollingrecord = array_pop($enrollingrecords);
        $this->assertNotEmpty($enrollingrecord->moderator);
        $enrol = enrol_get_plugin('manual');
        $enrolinstances = enrol_get_instances($course->id, true);
        foreach ($enrolinstances as $courseenrolinstance) {
            if ($courseenrolinstance->enrol == "manual") {
                $instance = $courseenrolinstance;
                break;
            }
        }
        // Unenrol and then enrol -> always enrolled.
        $enrol->unenrol_user($instance, $user->id);
        $enrollingrecords = $DB->get_records('mdl_69954', array('userid' => $user->id, 'courseid' => $course->id));
        $this->assertEmpty($enrollingrecords);
        $generator->enrol_user($user->id, $course->id, $studentrole->id);
        $enrollingrecords = $DB->get_records('mdl_69954', array('userid' => $user->id, 'courseid' => $course->id));
        $this->assertCount(1,$enrollingrecords);
    }
}