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
 * Latorre block form
 *
 * @package   block_latorre
 * @copyright 2022 Cristóbal Latorre Padilla - clatorre@bcnschool.cl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 require_once("$CFG->libdir/formslib.php");

 class latorre_form extends moodleform
 {
    function definition()
    {
        $mform =& $this->_form;
        $mform->addElement('header', 'displayinfo', get_string('textfields', 'block_latorre'));

        $mform->addElement('text', 'pagetitle', get_string('pagetitle', 'block_latorre'));
        $mform->setType('pagetitle', PARAM_RAW);
        $mform->addRule('pagetitle', null, 'required', null, 'clioent');
        
        $mform->addElement('editor', 'displaytext', get_string('displaytext', 'block_latorre'));
        $mform->setType('displaytext', PARAM_RAW);
        $mform->addRule('displaytext', null, 'required', null, 'clioent');

        // File picker
        $mform->addElement('filepicker', 'filename', get_string('file'), null, array('accepted_types' => '*'));

        // Un grupo de elementos de la imagen
        $mform->addElement('header', 'picfield', get_string('picturefields', 'block_latorre'), null, false);

        // Opcion si/no
        $mform->addElement('selectyesno', 'displaypicture', get_string('displaypicture', 'block_latorre'));
        $mform->setDefault('displaypicture', 1);
    }
 }
 