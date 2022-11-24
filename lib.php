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
        html_writer::tag('img', '', array('alt' => get_string('red', 'block_latorre'), 'src' => 'pix/red.png', 'width' => '50px')),
        html_writer::tag('img', '', array('alt' => get_string('blue', 'block_latorre'), 'src' => 'pix/blue.png', 'width' => '50px')),
        html_writer::tag('img', '', array('alt' => get_string('green', 'block_latorre'), 'src' => 'pix/green.png', 'width' => '50px'))
    );
}

function block_latorre_print_page($latorre, $return = false)
{
    global $OUTPUT, $COURSE;

    $display = $OUTPUT->heading($latorre->pagetitle);
    if ($latorre->displaydate) {
        $display .= html_writer::div(userdate($latorre->displaydate), 'block_latorre');
    }
    $display .= clean_text($latorre->displaytext);

    if ($latorre->displaypicture) {
        $images = block_latorre_images();
        $display .= html_writer::end_tag('br');
        $display .= $images[$latorre->picture];
    }

    if ($return) {
        return $display;
    } else {
        echo $display;
    }
}
