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
 * Latorre block view
 *
 * @package   block_latorre
 * @copyright 2022 Cristóbal Latorre Padilla - clatorre@bcnschool.cl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('latorre_form.php');

global $DB, $OUTPUT, $PAGE;

// Verifique todas las variables requeridas
$courseid = required_param('courseid', PARAM_INT);

// Identificador del bloque
$blockid = required_param('blockid', PARAM_INT);

// Busca si hay más variables
$id = optional_param('id', 0, PARAM_INT);

// Recuper el parámetro viewpage
$viewpage = optional_param('viewpage', false, PARAM_BOOL);

// Devuelve un único registro de la base de datos como un objeto
// donde se cumplen todas las condiciones dadas.
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_latorre', $courseid);
}

require_login($course);
/* require_capability(
    'block/latorre:managepages',
    context_course::instance($courseid)
); */

$PAGE->set_url('/blocks/latorre/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('edithtml', 'block_latorre'));

// Crear el nodo del bloque en las migas de pan
$settingsnode = $PAGE->settingsnav->add(get_string('latorresettings', 'block_latorre'));

// Creamos la URL del bloque con el id del bloque
$editurl = new moodle_url('/blocks/latorre/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
// Añadimos el nodo con la url del bloque
$editnode = $settingsnode->add(get_string('editpage', 'block_latorre'), $editurl);
// Activamos las migas de pan
$editnode->make_active();

$latorre = new latorre_form();
// Rescatar información importante
$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$toform['id'] = $id;

$latorre->set_data($toform);

if ($latorre->is_cancelled()) {
    // Los formularios cancelados redirigen a la pagina principal del curso.
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);
} elseif ($fromform = $latorre->get_data()) {
    // Código de proceso de datos.
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));

    $fromform->displaytext = $fromform->displaytext['text'];


    if ($fromform->id != 0) {
        
        if (!$DB->update_record('block_latorre', $fromform)) {
            print_error('inserterror', 'block_latorre');
        }
    } else {
        if (!$DB->insert_record('block_latorre', $fromform)) {
            print_error('inserterror', 'block_latorre');
        }
    }

    redirect($courseurl);
} else {
    // Primera vez o con errores
    $site = get_site();
    // Desplegamos nuestra pagina
    echo $OUTPUT->header();
    if ($id) {
        $latorrepage = $DB->get_record('block_latorre', array('id' => $id));
        if ($viewpage) {
            block_latorre_print_page($latorrepage);
        } else {
            $latorrepage->displaytext = array('text' => $latorrepage->displaytext);
            $latorre->set_data($latorrepage);
            $latorre->display();
        }
    } else {
        $latorre->display();
    }
    echo $OUTPUT->footer();
}
