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

    public static function submission_updated(\core\event\base $event) {
        global $DB;

        $user_id = $event->relateduserid;
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
            $update_detector = assign_submission_changes_changelog::get_update_detector($file, $user_id, $context_id);
            $predecessor = $update_detector->is_update();
            if ($predecessor) {

                $diff_output = $file->get_filename() . ' is an update of ' . $predecessor->get_filename();

                if (assign_submission_changes_changelog::is_changelog_enabled()) {
                    $predecessor_txt_file = local_changeloglib_pdftotext::convert_to_txt($predecessor);
                    $file_txt_file = local_changeloglib_pdftotext::convert_to_txt($file);

                    // Only continue of valid text files could be generated.
                    if ($predecessor_txt_file !== false && $file_txt_file !== false) {
                        $diff_detector = new local_changeloglib_diff_detector($predecessor_txt_file, $file_txt_file);

                        // TODO Abort output if to many changes

//                        $diff_output .= get_string('printed_diff_prefix', LOCAL_UPLOADNOTIFICATION_FULL_NAME);
                        $diff_output .= ' Geandert wurde Seite ';
                        $diff_output .= $diff_detector->get_info();
                    }

                    // Delete auto generated text files
                    unlink($predecessor_txt_file);
                    unlink($file_txt_file);
                }

                $DB->insert_record('assignsubmission_changes', (object) array(
                    'submission' => $submission_id,
                    'author' => $event->userid,
                    'changes' => $diff_output,
                    'timestamp' => time()
                ));
                echo $file->get_filename() . ' is an update of ' . $predecessor->get_filename();

            }
        }
    }

}