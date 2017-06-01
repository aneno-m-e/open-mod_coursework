<?php

/**
 * This class allows us to add functionality to the users, despite the fact that Moodle has no
 * core user class. Initially, it is using the active record approach, but this may need to change to
 * a decorator if Moodle implements such a class in future.
 */

namespace mod_coursework\models;

use mod_coursework\framework\table_base;
use \mod_coursework\allocation\allocatable;
use \mod_coursework\allocation\moderatable;
use mod_coursework\traits\allocatable_functions;

/**
 * Class group
 *
 * @property string name
 * @property mixed courseid
 * @package mod_coursework\models
 */
class group extends table_base implements allocatable, moderatable {

    use allocatable_functions;

    /**
     * @var string
     */
    protected static $table_name = 'groups';

    /**
     * @return string
     */
    public function name() {
        return $this->name;
    }

    /**
     * @return int
     */
    public function id() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function type() {
        return 'group';
    }

    /**
     * @return string
     */
    public function picture() {
        return print_group_picture($this, $this->courseid);
    }

    /**
     * @return user[]
     */
    public function get_members() {
        $members = groups_get_members($this->id());
        $member_objects = array();
        foreach ($members as $member) {
            $member_objects[] = user::find($member);
        }
        return $member_objects;
    }

    /**
     * @param bool $with_picture
     * @return string
     */
    public function profile_link($with_picture = false) {
        // TODO: Implement profle_link() method.
    }

    /**
     * @param \stdClass $course
     * @return mixed
     */
    public function is_valid_for_course($course) {
        return $this->courseid == $course->id;
    }
}