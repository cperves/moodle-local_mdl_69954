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
 * @category    table
 * @copyright   2020 ESUP-Portail {@link https://www.esup-portail.org/}
 * @author Céline Pervès<cperves@unistra.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/tablelib.php');

class mdl_69954_management_table extends table_sql implements renderable{
    public function __construct($url,$courseid) {
        parent::__construct('local_mdl_69954_management');
        $this->set_sql('mdl.*, u.username',
            '{mdl_69954} mdl inner join  {user} u  on u.id=mdl.userid',
            'courseid='.$courseid);
        $this->set_count_sql('select count(*) from {mdl_69954} mdl inner join {user} u on u.id=mdl.userid');
        $columns[] = $headers[]= 'id';
        $columns[] = $headers[]= 'userid';
        $columns[] = $headers[]= 'username';
        $columns[] = $headers[] = 'moderator';
        $columns[] = $headers[]= 'courseid';
        $this->define_columns($columns);
        $this->define_headers($headers);
        $this->sortable(true,'userid');
        $this->use_pages =false;
        $this->define_baseurl($url);
    }


}
