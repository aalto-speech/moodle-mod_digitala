<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Library of functions used by the digitala module.
 *
 * @package     mod_digitala
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function page_url($name, $page, $id, $d) {
	return new moodle_url('/mod/digitala/view.php', array('id' => $id, 'd' => $d, 'page' => $page));
}

function switch_page_button($name, $page, $id, $d, $is_curr) {
	$url = page_url($name, $page, $id, $d);
	$page_out = $page + 1;
	if ($is_curr) {
		$title = '<span class="pb-num active">'.$page_out.'</span>'.$name;
	} else {
		$title = '<span class="pb-num">'.$page_out.'</span>'.$name;
	}
	$out = html_writer::link($url, $title, array('class' => 'display-6'));
	return $out;
}

function start_progress_bar() {
	$out = html_writer::start_div('digitala-progress-bar');
	return $out;
}

function create_progress_bar_step($name, $page, $id, $d, $curr_page) {
	$is_curr = $page == $curr_page;
	if ($is_curr) {
		$out = html_writer::start_div('pb-step active');
	} else {
		$out = html_writer::start_div('pb-step');
	}
	
	$out .= switch_page_button($name, $page, $id, $d, $is_curr);
	$out .= html_writer::end_div();
	return $out;
}

function create_spacer($is_curr) {
	if ($is_curr) {
		$out = html_writer::start_div('pb-spacer active');
		$out .= html_writer::div('','pb-spacer-arrow active');
		$out .= html_writer::end_div();
	} else {
		$out = html_writer::start_div('pb-spacer');
		$out .= html_writer::div('','pb-spacer-arrow');
		$out .= html_writer::end_div();
	}
	
	return $out;
}

function end_progress_bar() {
	$out = html_writer::end_div();
	return $out;
}