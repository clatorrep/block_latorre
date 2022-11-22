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
        global $COURSE;

        // Deshabilitar
        if ($this->content !== null) {
            if ($this->config->disabled) {
                return null;
            } else {
                return $this->content;
            }
        }

        $this->content = new stdClass;

        if (!empty($this->config->text)) {
            $this->content->text = $this->config->text;
        } else {
            $this->content->text = '<h2><b>Este es el bloque del Latorre</b></h2>';
        }

        //$this->content->footer = '<i><small>Todos los derechos reservados.</small></i>';

        $url = new moodle_url('/blocks/latorre/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
        $this->content->footer = html_writer::link($url, get_string('addpage', 'block_latorre'));

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
    public function applicable_formats()
    {
        return array(
            'site-index' => true,
            'course-view' => false,
            'course-view-social' => false,
            'mod' => true,
            'mod-quiz' => false,
        );
    }

    public function instance_allow_multipe()
    {
        return true;
    }

    public function has_config()
    {
        return true;
    }

    /* public function hide_header()
    {
        return true;
    } */
}
