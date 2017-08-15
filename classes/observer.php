<?php
// This file is part of AssignSubmission_Changes plugin for Moodle - http://moodle.org/
//
// AssignSubmission_Changes is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// AssignSubmission_Changes is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with AssignSubmission_Changes.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Assign Submission Changes
 *
 * @package   assignsubmission_changes
 * @author    Hendrik Wuerz <hendrikmartin.wuerz@stud.tu-darmstadt.de>
 * @copyright (c) 2017 Hendrik Wuerz
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once(dirname(__FILE__) . '/../definitions.php');
require_once(dirname(__FILE__) . '/changelog.php');

class assign_submission_changes_observer {

    public static function submission_updated($event) {
        global $DB;

        $context_id = $event->contextid;
        $submission_id = $event->other['submissionid'];

        // Get the submitted file
        $fs = get_file_storage();
        $area_files = $fs->get_area_files(
            $context_id,
            'assignsubmission_file',
            'submission_files',
            $submission_id,
            'sortorder DESC, id ASC',
            false);

        // Iterate all files. A submission can have multiple uploads.
        foreach ($area_files as $file) {
            $update_detector = assign_submission_changes_changelog::get_update_detector($file, $event->userid, $event->contextid);
            $predecessor = $update_detector->is_update();
            if ($predecessor) {

                echo $file->get_filename() . ' is an update of ' . $predecessor->get_filename();

            }
        }
    }

}