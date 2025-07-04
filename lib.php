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
 * Callback implementations for Soccer team
 *
 * @package    local_soccer_team
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function local_soccer_team_extend_navigation_course($navigation, $course, $context)
{
    if (has_capability('local/soccer_team:manage', context: $context)) {
        $url = new moodle_url('/local/soccer_team/manage.php', ['id' => $course->id]);
        $navigation->add(
            get_string('pluginname', 'local_soccer_team'),
            $url,
            navigation_node::TYPE_SETTING,
            null,
            null,
            new pix_icon('i/group', '')
        );
    }
}
