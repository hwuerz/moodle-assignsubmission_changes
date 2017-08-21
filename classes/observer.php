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

        $user_id = $event->relateduserid;
        $context_id = $event->contextid;
        $submission_id = $event->other['submissionid'];

        // Check whether the changelog is enabled for this submission
        $assignment = self::get_assignment($submission_id);
        $changelog = self::get_config($assignment, 'changelog');
        if ($changelog != 1) { // The changelog is not enabled --> Abort
            return;
        }

        // Get the submitted files. For these files a predecessor should be found.
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
            self::generate_changelog($file, $user_id, $context_id, $assignment, $submission_id);
        }
    }

    /**
     * Checks whether the passed file is an update.
     * Generates a changelog if a predecessor was found and stores it in the database.
     * The changelog includes the differences of the files, if this function is activated.
     * @param stored_file $file The file which should be checked as an update.
     * @param int $user_id The user who owns the file and has submitted the assignment.
     * @param int $context_id The context of this submission.
     * @param int $assignment The assignment ID corresponding to this submission.
     * @param int $submission_id The submission under which the file is stored.
     */
    private static function generate_changelog($file, $user_id, $context_id, $assignment, $submission_id) {
        global $DB;

        $update_detector = assign_submission_changes_changelog::get_update_detector($file, $user_id, $context_id);
        $predecessor = $update_detector->is_update();
        if ($predecessor) { // A valid predecessor was found

            $diff_output = $file->get_filename() . ' is an update of ' . $predecessor->get_filename();

            if (self::get_config($assignment, 'diff') == 1) { // Check whether the diff is enabled for this submission
                $diff_output .= self::generate_diff($predecessor, $file);
            }

            $DB->insert_record('assignsubmission_changes', (object) array(
                'submission' => $submission_id,
                'author' => $user_id,
                'changes' => $diff_output,
                'timestamp' => time()
            ));

        }
    }

    /**
     * Detects differences between the predecessor and the file.
     * @param stored_file $predecessor The predecessor of the file.
     * @param stored_file $file The current version of the submission.
     * @return string The detected differences between the predecessor and the file.
     */
    private static function generate_diff($predecessor, $file) {

        $diff_output = '';
        $predecessor_txt_file = local_changeloglib_pdftotext::convert_to_txt($predecessor);
        $file_txt_file = local_changeloglib_pdftotext::convert_to_txt($file);

        // Only continue if valid text files could be generated.
        if ($predecessor_txt_file !== false && $file_txt_file !== false) {
            $diff_detector = new local_changeloglib_diff_detector($predecessor_txt_file, $file_txt_file);

            // TODO Abort output if to many changes

            $diff_output .= ' Geandert wurde Seite ';
            $diff_output .= $diff_detector->get_info();
        }

        // Delete auto generated text files
        if ($predecessor_txt_file) {
            unlink($predecessor_txt_file);
        }
        if ($file_txt_file) {
            unlink($file_txt_file);
        }

        return $diff_output;
    }

    /**
     * Get the ID of the assignment of the passed submission ID.
     * @param int $submission The ID of the submission.
     * @return int The ID of the corresponding assignment.
     */
    private static function get_assignment($submission) {
        global $DB;

        return $DB->get_record('assign_submission', array(
            'id' => $submission
        ), 'assignment')->assignment;
    }

    /**
     * Get the config with the passed name for the passed assignment.
     * In the assignment settings each sub plugin can be configured (see locallib.php get_settings(...))
     * @param int $assignment The ID of the assignment whose settings should be fetched.
     * @param string $name The name of the config property which should be fetched.
     *              Must be identically to the name in locallib.php get_settings(...)
     * @return string The setting stored for the assignemt.
     */
    private static function get_config($assignment, $name) {
        global $DB;

        return $DB->get_record('assign_plugin_config', array(
            'assignment' => $assignment,
            'plugin' => 'changes',
            'subtype' => 'assignsubmission',
            'name' => $name
        ), 'value')->value;
    }

}