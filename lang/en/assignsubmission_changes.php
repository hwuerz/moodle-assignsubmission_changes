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
$string['pluginname'] = 'AssignSubmission Changes';
$string['pluginname_help'] = 'AssignSubmission Changes';
$string['pluginname_link'] = 'https://github.com/hwuerz/moodle-assignsubmission_changes';
$string['pluginname_desc'] = 'AssignSubmission Changes';

$string['enabled'] = 'AssignSubmission Changes';
$string['enabled_help'] = 'If enabled, a changelog for PDF submissions will be generated. Only compatible with file submissions';

$string['updates'] = 'Detect updates';
$string['updates_help'] = 'Detect updates of student submissions.';

$string['last_grading'] = 'The last grading was on ';
$string['no_last_grading'] = 'There is no grading until now.';
$string['new_changes_prefix'] = 'The following changes were performed by the user after the last grading';
$string['no_new_changes'] = 'There are no changes of the submission after the last grading';
$string['old_changes_prefix'] = 'The following changes were performed by the user before the last grading';
$string['no_old_changes'] = 'The student has not submitted any uploads before the last grading';