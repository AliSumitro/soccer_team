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
 * Strings for component 'access', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   local_soccer_team
 * @copyright 2025 onwards Ali Sumitro
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_soccer_team\form;

use moodleform;
use context_course;
use html_writer;

class team_form extends moodleform
{
    protected function definition()
    {
        $mform = $this->_form;
        $course = $this->_customdata['course'];

        // Add hidden course ID field.
        $mform->addElement('hidden', 'id', $course->id);
        $mform->setType('id', PARAM_INT);

        // Get enrolled students.
        $context = context_course::instance($course->id);
        $students = get_enrolled_users($context, 'mod/assign:submit');

        $studentoptions = [];
        foreach ($students as $student) {
            $studentoptions[$student->id] = fullname($student);
        }

        $positionoptions = [
            'Goalkeeper' => get_string('goalkeeper', 'local_soccer_team'),
            'Defender' => get_string('defender', 'local_soccer_team'),
            'Midfielder' => get_string('midfielder', 'local_soccer_team'),
            'Forward' => get_string('forward', 'local_soccer_team')
        ];

        $mform->addElement('select', 'userid', get_string('student', 'local_soccer_team'), $studentoptions);
        $mform->addRule('userid', get_string('required'), 'required');

        $mform->addElement('select', 'position', get_string('position', 'local_soccer_team'), $positionoptions);
        $mform->addRule('position', get_string('required'), 'required');

        $mform->addElement('text', 'jerseynumber', get_string('jerseynumber', 'local_soccer_team'), ['size' => 3]);
        $mform->setType('jerseynumber', PARAM_INT);
        $mform->addRule('jerseynumber', get_string('required'), 'required');

        $this->add_action_buttons();
    }

    public function validation($data, $files)
    {
        global $DB;
        $errors = parent::validation($data, $files);

        if ($data['jerseynumber'] < 1 || $data['jerseynumber'] > 25) {
            $errors['jerseynumber'] = get_string('invalidjerseynumber', 'local_soccer_team');
        }

        $existing = $DB->get_record('local_soccer_team', [
            'courseid' => $data['id'], // Use course ID from form data.
            'jerseynumber' => $data['jerseynumber']
        ]);

        if ($existing && $existing->userid != $data['userid']) {
            $errors['jerseynumber'] = get_string('duplicatenumber', 'local_soccer_team');
        }

        return $errors;
    }
}
