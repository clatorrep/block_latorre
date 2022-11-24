<?php
/**
 * Archivo de funciones auxiliares
 *
 * @package   block_latorre
 * @copyright 2022 Cristóbal Latorre Padilla - clatorre@bcnschool.cl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 function block_latorre_images()
 {
    return array(
        html_writer::tag('img', '',array('alt' => get_string('red', 'block_latorre'), 'src' => 'pix/red.png', 'width' => '30px')),
        html_writer::tag('img', '',array('alt' => get_string('blue', 'block_latorre'), 'src' => 'pix/blue.png', 'width' => '30px')),
        html_writer::tag('img', '',array('alt' => get_string('green', 'block_latorre'), 'src' => 'pix/green.png', 'width' => '30px'))
    );
 }

 function block_latorre_print_page($latorre, $return = false)
 {
    print_object($latorre);
    return $return;
 }