<?php

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");

class answerrecording_form extends moodleform {
    public function __construct() {
        parent::__construct('/mod/digitala/view.php/?id=4&d=0&page=1', null, 'post', '', 'id="answerrecording"');
    }
    public function definition() {
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('hidden', 'audiostring', $this->_formname);
        $mform->setType('audiostring', PARAM_RAW);

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('digitalasubmitanswer', 'digitala'));
        $mform->addGroup($buttonarray, 'buttons', '', ' ', false);
    }
}