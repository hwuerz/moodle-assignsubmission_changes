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

require_once(dirname(__FILE__) . '/definitions.php');
require_once(dirname(__FILE__) . '/configcheckbox_assignsubmissionchanges_diff.php');


$settings->add(new admin_setting_configcheckbox(
    ASSIGNSUBMISSION_CHANGES_NAME . '/default',
    new lang_string('default', ASSIGNSUBMISSION_CHANGES_NAME),
    new lang_string('default_help', ASSIGNSUBMISSION_CHANGES_NAME),
    0));

$settings->add(new admin_setting_configcheckbox_assignsubmission_changes_diff(
    ASSIGNSUBMISSION_CHANGES_NAME . '/diff',
    new lang_string('admin_diff', ASSIGNSUBMISSION_CHANGES_NAME),
    new lang_string('admin_diff_help', ASSIGNSUBMISSION_CHANGES_NAME),
    0));
