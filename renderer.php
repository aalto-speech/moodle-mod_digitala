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
 * This file contains a renderer for the digitala class
 *
 * @package   mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/locallib.php');

/**
 * A custom renderer class that extends the plugin_renderer_base and is used by the digitala module.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_digitala_renderer extends plugin_renderer_base {
	
	protected function render_digitala_navigation(digitala_navigation $navigation) {
		$out  = switch_page_button(get_string('digitalainfo', 'digitala'), 0, $navigation->id, $navigation->d);
		$out .= ' ';
		$out .= switch_page_button(get_string('digitalaassignment', 'digitala'), 1, $navigation->id, $navigation->d);
		$out .= ' ';
		$out .= switch_page_button(get_string('digitalafeedback', 'digitala'), 2, $navigation->id, $navigation->d);
		return $out;
	}
	
	protected function render_digitala_info() {
		$out  = $this->output->heading(format_string(get_string('digitalainfo', 'digitala')), 2);
		$out .= $this->output->container(format_text('', FORMAT_HTML), 'content');
		return $this->output->container($out, 'info');
	}
	
	protected function render_digitala_assignment() {
		$out  = $this->output->heading(format_string(get_string('digitalaassignment', 'digitala')), 2);
		$out .= $this->output->container(format_text('', FORMAT_HTML), 'content');
		return $this->output->container($out, 'assignment');
	}
	
	protected function render_digitala_feedback() {
		$out  = $this->output->heading(format_string(get_string('digitalafeedback', 'digitala')), 2);
		$out .= $this->output->container(format_text('', FORMAT_HTML), 'content');
		return $this->output->container($out, 'feedback');
	}
}
