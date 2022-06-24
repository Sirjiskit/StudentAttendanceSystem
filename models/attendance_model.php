<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of attendance_model
 *
 * @author Jiskit
 */
class attendance_model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getClasses() {
        return $this->db->select("SELECT cl.classid,cl.date,cl.startTime,cl.endTime,a.staffid,a.courseId FROM "
                        . "classes cl JOIN course_allocation a ON cl.courseAllocationId = a.courseAllocationId WHERE a.academicsemester = " .
                        $this->getCurrentAcademicSemester() . " AND a.academicyear = '" . $this->getCurrentAcademicYear() . "'");
    }

    public function getClassesByStaffid($staffid) {
        return $this->db->select("SELECT cl.classid,cl.date,cl.startTime,cl.endTime,a.staffid,a.courseId FROM "
                        . "classes cl JOIN course_allocation a ON cl.courseAllocationId = a.courseAllocationId WHERE "
                        . "a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND a.academicyear = '" .
                        $this->getCurrentAcademicYear() . "' AND a.staffid={$staffid}");
    }

    public function getClassesById($staffid) {
        return $this->db->select("SELECT cl.classid,cl.date,cl.startTime,cl.endTime,a.staffid,a.courseId FROM "
                        . "classes cl JOIN course_allocation a ON cl.courseAllocationId = a.courseAllocationId WHERE a.academicsemester = " .
                        $this->getCurrentAcademicSemester() . " AND a.academicyear = '" . $this->getCurrentAcademicYear() . "'"
                        . " AND staffid={$staffid}");
    }

    public function getStaffClasses($staffid) {
        return $this->db->select("SELECT cl.classid,cl.date,cl.startTime,cl.endTime,a.staffid,a.courseId FROM "
                        . "classes cl JOIN course_allocation a ON cl.courseAllocationId = a.courseAllocationId WHERE "
                        . "a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND a.academicyear = '" .
                        $this->getCurrentAcademicYear() . "' AND a.staffid={$staffid}");
    }

    public function getClassInfo($classid) {
        return $this->db->selectSingleData("SELECT * FROM classes WHERE classid = $classid");
    }

    public function getCouresName($courseId) {
        $row = $this->db->selectSingleData("SELECT * FROM courses WHERE courseId = $courseId");
        return $row ? $row["code"] : 'Unknwon';
    }

    public function getStaffName($userid) {
        $row = $this->db->selectSingleData("SELECT fullname FROM users WHERE userid = $userid");
        return $row ? $row["fullname"] : 'Unknwon';
    }

    public function getClassLists() {
        $lists = $this->getClasses();
        $data = array();

        foreach ($lists as $item) {
            $date = date("M d, Y", strtotime($item['date']));
            $time = date("h:i A", strtotime($item['startTime'])) . " - " . date("h:i A", strtotime($item['endTime']));
            $data[] = array($date, $this->getCouresName($item["courseId"]), $this->getStaffName($item["staffid"]), $date, $time,
                '<button class="btn btn-sm btn-success" onclick="return edit(' . $item['classid'] . ')"><i class="bi bi-pencil"></i></button>');
        }

        return json_encode(array("data" => $data));
    }

    public function getClassByStaffLists($staffid) {
        $lists = $this->getClassesById($staffid);
        $data = array();

        foreach ($lists as $item) {
            $date = date("M d, Y", strtotime($item['date']));
            $time = date("h:i A", strtotime($item['startTime'])) . " - " . date("h:i A", strtotime($item['endTime']));
            $data[] = array($date, $this->getCouresName($item["courseId"]), $this->getStaffName($item["staffid"]), $date, $time,
                '<button class="btn btn-sm btn-success" onclick="return edit(' . $item['classid'] . ')"><i class="bi bi-pencil"></i></button>');
        }

        return json_encode(array("data" => $data));
    }

    public function getStaffClassLists($staffid) {
        $lists = $this->getStaffClasses($staffid);
        $data = array();

        foreach ($lists as $item) {
            $date = date("M d, Y", strtotime($item['date']));
            $time = date("h:i A", strtotime($item['startTime'])) . " - " . date("h:i A", strtotime($item['endTime']));
            $data[] = array($date, $this->getCouresName($item["courseId"]), $date, $time);
        }

        return json_encode(array("data" => $data));
    }

    public function dropDownAllocation() {
        return $this->fetchCoursesAllocatedDropdown();
    }

    public function dropDownStaffClass($staffid) {
        return $this->db->select("SELECT courseAllocationId id,CONCAT(code,' : ',fullname) text FROM `course_allocation` a JOIN courses c ON a.courseId = c.courseId "
                        . "JOIN users u ON a.staffid = u.userid WHERE a.staffid = {$staffid} AND a.academicyear = '{$this->getCurrentAcademicYear()}' AND a.academicsemester = {$this->getCurrentAcademicSemester()} order by c.code asc");
    }

    public function add($POST) {
        foreach ($POST as $key => $value):
            if (trim($value) == ""):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;
        $startTime = strtotime($POST['startTime']);
        $endTime = strtotime($POST['endTime']);
        if ($startTime > $endTime):
            return array("result" => -2, "reason" => "Start Time must not less than end time");
        endif;
        $POST["startTime"] = date("H:i:s", $startTime);
        $POST["endTime"] = date("H:i:s", $endTime);
        if ($this->checkIfClassesAlreadySheduleForLevelInTheSelectedDate($POST)):
            return array("result" => -3, "reason" => "Another class have been already scheduled for this level at between the selected time");
        endif;
        $dataArr = $POST;
        if ($this->db->insert("classes", $dataArr)):
            return array("result" => 1, "reason" => "Class successfully scheduled.");
        endif;
        return array("result" => -4, "reason" => "Unabled to schedule class");
    }

    public function update($classid, $POST) {
        error_reporting(E_ALL);
        foreach ($POST as $key => $value):
            if (trim($value) == ""):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;
        $startTime = strtotime($POST['startTime']);
        $endTime = strtotime($POST['endTime']);
        if ($startTime > $endTime):
            return array("result" => -2, "reason" => "Start Time must not less than end time");
        endif;
        $POST["startTime"] = date("H:i:s", $startTime);
        $POST["endTime"] = date("H:i:s", $endTime);
        if ($this->checkIfClassesAlreadySheduleForLevelInTheSelectedDateEdit($POST, $classid)):
            return array("result" => -3, "reason" => "Another class have been already scheduled for this level at between the selected time");
        endif;
        $dataArr = $POST;
        if ($this->db->update("classes", $dataArr, "classid = {$classid}")):
            return array("result" => 1, "reason" => "Class scheduled successfully updated.");
        endif;
        return array("result" => -4, "reason" => "Unabled to update scheduled class");
    }

    private function checkIfClassesAlreadySheduleForLevelInTheSelectedDate($POST): bool {
        $date = $POST["date"];
        $startTime = $POST["startTime"];
        $endTime = $POST["endTime"];
        $courseAllocationId = $POST["courseAllocationId"];
        $data = $this->db->select("SELECT c.level FROM classes cl JOIN course_allocation a ON cl.courseAllocationId=a.courseAllocationId "
                . "JOIN courses c ON a.courseId=c.courseId WHERE cl.date = '{$date}' AND (('{$startTime}' BETWEEN  startTime AND endTime) || "
                . "('{$endTime}' BETWEEN startTime AND endTime)) AND endTime != '{$startTime}' AND startTime != '{$endTime}'");
        $res = $this->db->selectSingleData("SELECT c.level FROM course_allocation a JOIN courses c ON a.courseId=c.courseId WHERE courseAllocationId = {$courseAllocationId}");
        foreach ($data as $row):
            if ($res && $row["level"] == $res["level"]):
                return true;
            endif;
        endforeach;
        return false;
    }

    private function checkIfClassesAlreadySheduleForLevelInTheSelectedDateEdit($POST, $classid) {
        $date = $POST["date"];
        $startTime = $POST["startTime"];
        $endTime = $POST["endTime"];
        $courseAllocationId = $POST["courseAllocationId"];
        $data = $this->db->select("SELECT c.level,cl.classid FROM classes cl JOIN course_allocation a ON cl.courseAllocationId=a.courseAllocationId "
                . "JOIN courses c ON a.courseId=c.courseId WHERE cl.date = '{$date}' AND ((('{$startTime}' BETWEEN  startTime AND endTime) || "
                . "('{$endTime}' BETWEEN startTime AND endTime)) AND endTime != '{$startTime}' AND startTime != '{$endTime}') AND classid != {$classid}");
        $res = $this->db->selectSingleData("SELECT c.level FROM course_allocation a JOIN courses c ON a.courseId=c.courseId WHERE courseAllocationId = {$courseAllocationId}");
        foreach ($data as $row):
            if ($res && $row["level"] == $res["level"]):
                return true;
            endif;
        endforeach;
        return false;
    }

    public function getAttendance($POST) {
        $courseid = $POST["courseid"];
        $academicyear = $this->getCurrentAcademicYear();
        $semester = $this->getCurrentAcademicSemester();
        $attend = "(SELECT count(*) FROM `attendance` a JOIN classes cl ON a.classid = cl.classid JOIN course_allocation aa ON aa.courseAllocationId "
                . "=cl.courseAllocationId WHERE a.studentid = s.studentid AND aa.courseId = {$courseid} AND a.academicyear = '{$academicyear}' AND a.academicsemester = {$semester}) count";
        return $this->db->select("SELECT s.*, {$attend} FROM student s JOIN course_registration cr ON s.studentid = cr.studentId"
                        . " JOIN registered_courses rc ON rc.registrationId = cr.registrationId WHERE rc.courseId={$courseid} "
                        . "GROUP BY s.studentid ORDER BY s.regNo ASC");
    }

    public function getCourseClasss($POST) {
        $courseid = $POST["courseid"];
        $academicyear = $POST["academicyear"];
        $semester = $POST["semester"];
        $date = date("Y-m-d");
        $time = date("h:i A", time());
        return $this->db->selectSingleData("SELECT *,(SELECT count(*) FROM classes cl WHERE a.courseAllocationId = cl.courseAllocationId "
                        . "AND date <='{$date}') count FROM course_allocation a WHERE academicyear = '{$academicyear}' "
                        . "AND academicsemester = {$semester} AND courseId={$courseid}");
    }

    public function getStaffInfo($POST) {
        $data = $this->getCourseClasss($POST);
        $staff = $this->getStaff($data["staffid"]);
        $course = $this->getCourseCode($data["courseId"]);
        $level = ["", "Part 1", "Part 2", "Part 3", "Part 4", "Part 5"][(int) $this->getCourseLevel($data["courseId"])];
        return array("staff" => $staff, "code" => $course, "count" => $data["count"], "level" => $level);
    }

    public function getCourses() {
        return $this->db->select("SELECT c.* FROM courses c JOIN course_allocation a ON c.courseId = a.courseId GROUP BY c.courseId ORDER BY code ASC");
    }

    public function getStaffCourses($staffid) {
        return $this->db->select("SELECT c.* FROM courses c JOIN course_allocation a ON c.courseId = a.courseId WHERE "
                        . "a.staffid={$staffid} GROUP BY c.courseId ORDER BY code ASC");
    }

    public function getCourseCode($courseId) {
        $row = $this->db->selectSingleData("SELECT * FROM courses WHERE courseid = $courseId");
        return $row ? ucwords($row["code"]) : 'Unkwnown';
    }

    public function getCourseLevel($courseId) {
        $row = $this->db->selectSingleData("SELECT * FROM courses WHERE courseid = $courseId");
        return $row ? ucwords($row["level"]) : 0;
    }

    public function getStaff($staffid) {
        $row = $this->db->selectSingleData("SELECT * FROM `users` WHERE userid={$staffid}");
        return $row ? ucwords($row["fullname"]) : 'Unkwnown';
    }

}
