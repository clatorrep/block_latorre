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
 * Latorre block
 *
 * @package   block_latorre
 * @copyright 2022 Cristóbal Latorre Padilla - clatorre@bcnschool.cl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_latorre extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_latorre');
    }

    public function get_content()
    {
        global $COURSE, $DB, $PAGE;

        // Deshabilitar
        if ($this->content !== null) {
            if (!$this->config->disabled) {
                return $this->content;
            } else {
                return null;
            }
        }

        $this->content = new stdClass;

        if (!empty($this->config->text)) {
            $this->content->text = $this->config->text;
        } else {
            $this->content->text = '<h2><b>Este es el bloque del Latorre</b></h2>';
        }

        // Verifica si se encuentra en modo edición
        $context = context_course::instance($COURSE->id);
        $canmanage = has_capability('block/latorre:managepages', $context) && $PAGE->user_is_editing($this->instance->id);
        $canview = has_capability('block/latorre:viewpages', $context);

        // Desplegar los registros de la tabla
        if ($simplehtmlpages = $DB->get_records('block_latorre', array('blockid' => $this->instance->id))) {
            $this->content->text .= html_writer::start_tag('ul');
            foreach ($simplehtmlpages as $simplehtmlpage) {

                if ($canmanage) {
                    //EDIT
                    $pageparam = array(
                        'blockid' => $this->instance->id,
                        'courseid' => $COURSE->id,
                        'id' => $simplehtmlpage->id
                    );
                    $editurl = new moodle_url('/blocks/latorre/view.php', $pageparam);
                    $editpicurl = new moodle_url('/pix/t/edit.png');
                    $edit = html_writer::link(
                        $editurl,
                        html_writer::img($editpicurl, 'edit')
                    );

                    // DELETE
                    $deleteparam = array(
                        'id' => $simplehtmlpage->id,
                        'courseid' => $COURSE->id
                    );
                    $deleteurl = new moodle_url('/blocks/latorre/delete.php', $deleteparam);
                    $deletepicurl = new moodle_url('/pix/t/delete.png');
                    $delete = html_writer::link(
                        $deleteurl,
                        html_writer::img($deletepicurl, 'delete')
                    );
                } else {
                    $edit = '';
                    $delete = '';
                }

                $pageurl = new moodle_url(
                    '/blocks/latorre/view.php',
                    array(
                        'blockid' => $this->instance->id,
                        'courseid' => $COURSE->id,
                        'id' => $simplehtmlpage->id,
                        'viewpage' => '1'
                    )
                );

                $this->content->text .= html_writer::start_tag('li');
                if ($canview) {
                    $this->content->text .= html_writer::link($pageurl, $simplehtmlpage->pagetitle);
                } else {
                    $this->content->text .= html_writer::tag('p', $simplehtmlpage->pagetitle);
                }
                $this->content->text .= "&nbsp$edit";
                $this->content->text .= "&nbsp$delete";
                $this->content->text .= html_writer::end_tag('li');
            }
            $this->content->text .= html_writer::end_tag('ul');
        }

        // footer
        if (has_capability('block/latorre:managepages', $context)) {
            $url = new moodle_url('/blocks/latorre/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
            $this->content->footer = html_writer::link($url, get_string('addpage', 'block_latorre'));
        } else {
            $this->content->footer = html_writer::tag('p', get_string('latorrefooter', 'block_latorre'));
        }

        return $this->content;
    }

    public function specialization()
    {
        if (isset($this->config)) {
            // Titulo
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_latorre');
            } else {
                $this->title = $this->config->title;
            }

            // Texto
            if (empty($this->config->text)) {
                $this->config->text = get_string('defaulttext', 'block_latorre');
            }
        }
    }

    public function instance_config_save($data, $nolongerused = false)
    {
        global $CFG;

        if (!empty($CFG->block_latorre_allowhtml)) {
            $data->text = strip_tags($data->text);
        }

        // Implementación predeterminada definida en la clase principal
        return parent::instance_config_save($data, $nolongerused);
    }

    /**
     * Dónde se puede o no instalar el bloque.
     */
    /* public function applicable_formats()
    {
        return array(
            'site-index' => true,
            'course-view' => false,
            'course-view-social' => false,
            'mod' => true,
            'mod-quiz' => false,
        );
    } */

    public function instance_allow_multipe()
    {
        return true;
    }

    public function has_config()
    {
        return true;
    }

    public function instance_delete()
    {
        global $DB;
        $DB->delete_records('block_latorre', array('blockid' => $this->instance->id));
    }

    /* public function hide_header()
    {
        return true;
    } */
}
