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
 * TODO describe file manage
 *
 * @package    local_soccer_team
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/local/soccer_team/classes/form/team_form.php');

// Get course ID from both GET and POST requests.
$courseid = required_param('id', PARAM_INT);
$course = get_course($courseid);
$context = context_course::instance($course->id);

require_login($course);
require_capability('local/soccer_team:manage', $context);

$PAGE->set_url(new moodle_url('/local/soccer_team/manage.php', ['id' => $courseid]));
$PAGE->set_title(get_string('pluginname', 'local_soccer_team'));
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('admin');

// Pass course ID to form.
$mform = new \local_soccer_team\form\team_form(null, ['course' => $course]);

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]));
} elseif ($data = $mform->get_data()) {
    global $DB;

    $record = new stdClass();
    $record->courseid = $courseid; // Use validated course ID from URL.
    $record->userid = $data->userid;
    $record->position = $data->position;
    $record->jerseynumber = $data->jerseynumber;

    if ($existing = $DB->get_record('local_soccer_team', ['courseid' => $courseid, 'userid' => $data->userid])) {
        $record->id = $existing->id;
        $DB->update_record('local_soccer_team', $record);
    } else {
        $DB->insert_record('local_soccer_team', $record);
    }

    redirect(
        new moodle_url('/local/soccer_team/manage.php', ['id' => $courseid]),
        get_string('savess', 'local_soccer_team'),
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('manageheading', 'local_soccer_team'));
$mform->display();
echo $OUTPUT->footer();
