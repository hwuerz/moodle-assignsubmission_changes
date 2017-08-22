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

// Module metadata
$string['pluginname'] = 'Changes';
$string['pluginname_help'] = 'AssignSubmission Changes';
$string['pluginname_link'] = 'https://github.com/hwuerz/moodle-assignsubmission_changes';
$string['pluginname_desc'] = 'AssignSubmission Changes';

// Admin settings
$string['default'] = 'Enable Changelog by default';
$string['default_help'] = 'If set, the changelog will be enabled by default for all new assignments.';
$string['admin_diff'] = 'Enable Difference Detection by default';
$string['admin_diff_help'] = 'If set, the generation of the differences between the uploades will be enabled by default for all new assignments.<br>Diff generation requires the changelog generation.';
$string['diff_requires_changelog'] = 'You must enable the changelog for the diff generation';
$string['allow_changelog'] = 'Allow detection of changes in student submissions';
$string['allow_changelog_help'] = 'If set, a changelog with all updates of the submission can be generated. You can set this option in the submission settings. If this option is deactivated, a changelog can not be generated.';
$string['allow_diff'] = 'Allow detection of differences in student submissions';
$string['allow_diff_help'] = 'If set, the changelog can contain detailed information about the changes. You can set this option in the submission settings. If this option is deactivated, a difference between files can not be generated.<br>This functionality requires the activation of the changelog.';
$string['max_filesize'] = 'Max filesize in MB for diff detection';
$string['max_filesize_help'] = 'The maximum filesize of the submission where differences to a predecessor will be detected. A higher value can impact the server response time and workload.';

// Assignment Settings
$string['enabled'] = 'Changelog';
$string['enabled_help'] = 'Enable the detection of changes.';
$string['diff'] = 'Auto detect diff';
$string['diff_help'] = 'Detect differences in student submissions';

// Outputs
$string['last_grading'] = 'The last grading was on ';
$string['no_last_grading'] = 'There is no grading until now.';
$string['no_changes'] = 'There are no detected changes.';
$string['new_changes_prefix'] = 'The following changes were performed by the user after the last grading';
$string['no_new_changes'] = 'There are no changes of the submission after the last grading';
$string['old_changes_prefix'] = 'The following changes were performed by the user before the last grading';
$string['no_old_changes'] = 'The student has not submitted any changes before the last grading';
$string['ungraded_changes'] = 'There are ungraded changes';
$string['no_ungraded_changes'] = 'No ungraded changes';
$string['diff_prefix'] = 'The following pages of the new file were changed: ';
$string['long_diff'] = '{$a} pages were changed';
$string['is_an_update'] = ' is an update of ';
$string['was_uploaded'] = ' was uploaded';