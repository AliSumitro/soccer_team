# Moodle Local Plugin: Soccer Team

## Overview

This Moodle local plugin allows administrators to manage soccer team members within a course. It provides a user interface to assign users to specific positions and jersey numbers.

## Features

*   **Manage Team Members:** Assign users to different positions (e.g., Forward, Defender, Goalkeeper).
*   **Jersey Number Assignment:** Assign jersey numbers to team members.
*   **Course Integration:** Integrates with Moodle courses, allowing management of team members within a specific course context.
*   **Permissions:** Utilizes Moodle's capability system to restrict access to team management features.

## Installation

1.  Place the `local/soccer_team` directory into your Moodle's `local` directory.
2.  Visit the Moodle admin notification page to complete the installation.

## Usage

1.  Navigate to a course where you want to manage the soccer team.
2.  Ensure you have the `local/soccer_team:manage` capability.
3.  Access the "Soccer Team" management page via the course navigation.
4.  Use the form to add, update, or remove team member assignments.

## File Structure

*   **classes/:** Contains PHP classes, such as the `team_form`.
*   **db/:** Contains database-related files, such as `install.xml` and `access.php`.
*   **lang/:** Contains language files for localization.
*   **lib.php:** Contains callback implementations, such as extending the course navigation.
*   **manage.php:** Provides the user interface for managing the soccer team.
*   **version.php:** Contains version information for the plugin.

## License

This plugin is licensed under the GNU General Public License v3 or later. See [http://www.gnu.org/licenses/](http://www.gnu.org/licenses/) for details.

## Copyright

2025 Ali Sumitro <ali@teruselearning.co.uk>