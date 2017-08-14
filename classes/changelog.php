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

require_once(dirname(__FILE__) . '/../../../../../local/changeloglib/classes/backup_lib.php');
require_once(dirname(__FILE__) . '/../../../../../local/changeloglib/classes/diff_detector.php');
require_once(dirname(__FILE__) . '/../../../../../local/changeloglib/classes/pdftotext.php');
require_once(dirname(__FILE__) . '/../../../../../local/changeloglib/classes/update_detector.php');

/**
 * Wrapper to access changelog functions
 */
class assign_submission_changes_changelog {

    /**
     * Provides an update detector for the passed submission file data.
     * Wrapper around changeloglib plugin to be used for submissions.
     * @return local_changeloglib_update_detector The update detector
     */
    public static function get_update_detector($file, $user_id, $context_id) {

        $new_file = $file;
        $new_data = array();
        $context = $context_id;
        $scope = $user_id;
        $further_candidates = array();

        return new local_changeloglib_update_detector($new_file, $new_data, $context, $scope, $further_candidates);
    }

    /**
     * Creates a backup of the passed course module.
     * Wrapper around changeloglib plugin to be used for course modules.
     * @param stdClass $coursemodule The course module of which a backup should created.
     */
    public static function backup_submission($submission, $context) {

        // Get information to access the submission and create a copy of it
        $data = array(); // Not needed
        $context_id_from = $context->id;
        $component_from = 'assignsubmission_file';
        $filearea_from = 'submission_files';
        $itemid_from = $submission->id;
        $context_id_to = $context->id;
        $scope_id = $submission->userid;

        // Backup this course module using the changeloglib plugin.
        local_changeloglib_backup_lib::backup($data,
            $context_id_from, $component_from, $filearea_from, $itemid_from,
            $context_id_to, $scope_id);
    }

//    public static function is_changelog_enabled() {
//        require_once(dirname(__FILE__) . '/../../changeloglib/classes/pdftotext.php');
//        return get_config(LOCAL_UPLOADNOTIFICATION_FULL_NAME, 'changelog_enabled')
//            && get_config(LOCAL_UPLOADNOTIFICATION_FULL_NAME, 'diff_enabled')
//            && local_changeloglib_pdftotext::is_installed();
//    }

//
//    /**
//     * Get the context under which a backup is stored.
//     * @param stdClass $coursemodule The coursemodule record.
//     * @return int The context ID under which backups are stored.
//     */
//    private static function get_context($coursemodule) {
//        return context_course::instance($coursemodule->course)->id;
//    }

//    /**
//     * Get the scope under which a backup is stored. For resources this is the section.
//     * @param stdClass $coursemodule The coursemodule record.
//     * @return int The scope under which backups are stored.
//     */
//    private static function get_scope($coursemodule) {
//        return $coursemodule->section;
//    }
//
//    /**
//     * Get all files in the same course and section like the passed course module for which a deletion is marked.
//     * These files are relevant for the update_detector too.
//     * @param stdClass $coursemodule The coursemodule record.
//     * @return stored_file[] All relevant pending files.
//     */
//    private static function get_pending_files($coursemodule) {
//        global $DB;
//
//        // Get candidates_pending
//        // These are all files which are marked for deletion, but are still in the normal storage
//        $candidates_pending = $DB->get_records('course_modules', array(
//            'deletioninprogress' => 1, // The old file should be deleted
//            'course' => $coursemodule->course,
//            'section' => $coursemodule->section
//        ));
//
//        // Get the file instances for pending candidates
//        return array_map(function ($candidate) {
//            return self::get_file($candidate->id);
//        }, $candidates_pending);
//    }
//
//    /**
//     * Get the file of the passed course module.
//     * The course module must be a resource instance and the file be available in the mod_resource component.
//     * @param int $coursemodule_id The ID of the course module from where the file is fetched.
//     * @return stored_file The resource file for the passed course module.
//     */
//    private static function get_file($coursemodule_id) {
//        $fs = get_file_storage();
//        $context = context_module::instance($coursemodule_id);
//        $area_files = $fs->get_area_files(
//            $context->id,
//            'mod_resource',
//            'content',
//            0,
//            'sortorder DESC, id ASC',
//            false);
//        return array_shift($area_files); // Get only the first file
//    }
}
