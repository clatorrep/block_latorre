<?php
/**
 * Latorre block's to delete the pages created with the block
 *
 * @package   block_latorre
 * @copyright 2022 Cristóbal Latorre Padilla - clatorre@bcnschool.cl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 require_once('../../config.php');

 $courseid = required_param('courseid', PARAM_INT);
 $id = optional_param('id', 0, PARAM_INT);
 $confirm = optional_param('confirm', 0, PARAM_INT);

 if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_latorre', $courseid);
 }

 require_login($course);

 if (!$latorrepage = $DB->get_record('block_latorre', array('id' => $id,))) {
    print_error('nopage', 'block_latorre', '', $id);
 }

 $site = get_site();
 $PAGE->set_url(
    '/blocks/latorre/view.php', 
    array('id' => $id, 'courseid' => $courseid)
);
$heading = $site->fullname . ' :: ' . $course->shortname . ' :: ' . $latorrepage->pagetitle;
$PAGE->set_heading($heading);
echo $OUTPUT->header();
echo $OUTPUT->footer();