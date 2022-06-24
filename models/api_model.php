<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api_model
 *
 * @author Jiskit
 */
class api_model extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getCouresName($courseId) {
        $row = $this->db->selectSingleData("SELECT * FROM courses WHERE courseId = $courseId");
        return $row ? $row["code"] : 'Unknwon';
    }

    public function getLectereName($userid) {
        $row = $this->db->selectSingleData("SELECT fullname FROM users WHERE userid = $userid");
        return $row ? $row["fullname"] : 'Unknwon';
    }

    private function getDepartmentName($id) {
        $row = $this->db->select("SELECT * FROM department WHERE departmentid = {$id}");
        return count($row) > 0 ? $row[0]["department_name"] : 'Unknown';
    }

    public function loadLectures($id) {
        return $this->db->select("SELECT c.classid,c.date,c.startTime,c.endTime,a.staffid,a.courseId FROM "
                        . "classes c JOIN course_allocation a ON c.courseAllocationId = a.courseAllocationId "
                        . "WHERE a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND a.academicyear = '"
                        . "" . $this->getCurrentAcademicYear() . "' AND a.staffid = $id");
    }

    public function getLecturesJSON($id) {
        $lists = $this->loadLectures($id);
        $dataArr = array();
        if ($lists != null && count($lists) > 0) {
            foreach ($lists as $event) {
                $date = $event['date'];

                $dataArr[] = array(
                    "title" => $this->getCouresName($event["courseId"]),
                    "date" => $date
                );
            }
        }

        return $dataArr;
    }

    function upcomingLectures($id) {
        $lists = $this->loadLectures($id);
        $data = array();
        foreach ($lists as $item) {
            $currentTime = time();
            $lectureEnd = strtotime($item['endTime']);
            $date = date("M d, Y", strtotime($item['date']));
            $time = date("h:i A", strtotime($item['startTime'])) . " - " . date("h:i A", strtotime($item['endTime']));
            $toDate = date("Y-m-d");
            if ($item['date'] > $toDate):
                $data[] = array("date" => $date, "code" => $this->getCouresName($item["courseId"]), "lecturer" => $this->getLectereName($item["staffid"]), "time" => $time);
            endif;
        }

        return $data;
    }

    function getTodaysLectures($id) {
        $lists = $this->loadLectures($id);
        $data = array();
        foreach ($lists as $item) {
            $currentTime = time();
            $lectureEnd = strtotime($item['endTime']);
            $date = date("M d, Y", strtotime($item['date']));
            $time = date("h:i A", strtotime($item['startTime'])) . " - " . date("h:i A", strtotime($item['endTime']));
            $toDate = date("Y-m-d");
            if ($currentTime <= $lectureEnd && $item['date'] == $toDate):
                $data[] = array("date" => $date, "code" => $this->getCouresName($item["courseId"]), "lecturer" => $this->getLectereName($item["staffid"]), "time" => $time);
            endif;
        }

        return $data;
    }

    function loadData($id) {
        $calendar = $this->getLecturesJSON($id);
        $today = $this->getTodaysLectures($id);
        $upcomming = $this->upcomingLectures($id);
        die(json_encode(array("result" => array("cal" => $calendar, "today" => $today, "upcoming" => $upcomming), 'reason' => '')));
    }

    public function getLecturerStudents($lecturerId) {
        return $this->db->select("SELECT s.* FROM student s JOIN course_registration cr ON s.studentid = cr.studentId JOIN "
                        . "registered_courses rc ON cr.registrationId=rc.registrationId JOIN course_allocation a ON a.courseId = rc.courseId "
                        . " WHERE a.staffid = {$lecturerId} AND a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND "
                        . "a.academicyear = '" . $this->getCurrentAcademicYear() . "' GROUP BY s.studentid ORDER BY fullname ASC");
    }

    public function getLecturerStudentsLists($lecturerId) {
        $lists = $this->getLecturerStudents($lecturerId);

        $data = array();

        foreach ($lists as $item) {
            $data[] = array("dpm" => "Computer Science", "regNo" => $item['regNo'], "name" => ucwords($item['fullname']),
                "image" => URL . "public/" . ($item["image"] ? 'uploads/student/' . $item["image"] : 'no-image.gif'));
        }

        die(json_encode(array("result" => $data, "reason" => '')));
    }

    function getMyCourses($id) {
        $lists = $this->db->select("SELECT c.* FROM `course_allocation` a JOIN courses c ON a.courseId = c.courseId WHERE a.staffid=$id");
        $data = array();

        foreach ($lists as $item) {
            $data[] = array("id" => $item["courseId"], "dpm" => "Computer Science", "code" => $item['code'], "title" => ucwords($item['title']),
                "level" => ['Unknown', 'Part 1', 'Part 2', 'Part 3', 'Part 4'][$item['level']], "semester" => "semester {$item["semester"]}");
        }

        die(json_encode(array("result" => $data, "reason" => '')));
    }

    public function getLecturerLectures($lecturerId) {
        return $this->db->select("SELECT c.classid,c.date,c.startTime,c.endTime,a.staffid,a.courseId FROM "
                        . "classes c JOIN course_allocation a ON c.courseAllocationId = a.courseAllocationId WHERE "
                        . "a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND a.academicyear = '" .
                        $this->getCurrentAcademicYear() . "' AND a.staffid={$lecturerId}");
    }

    public function getLectures($lecturerId) {
        $lists = $this->getLecturerLectures($lecturerId);
        $data = array();

        foreach ($lists as $item) {
            $date = date("M d, Y", strtotime($item['date']));
            $time = date("h:i A", strtotime($item['startTime'])) . " - " . date("h:i A", strtotime($item['endTime']));
            $data[] = array("date" => $date, "code" => $this->getCouresName($item["courseId"]), "time" => $time);
        }

        die(json_encode(array("result" => $data, "reason" => '')));
    }

    public function getStaffCourses($staffid) {
        return $this->db->select("SELECT c.* FROM courses c JOIN course_allocation a ON c.courseId = a.courseId WHERE "
                        . "a.staffid={$staffid} GROUP BY c.courseId ORDER BY code ASC");
    }

    public function getMobileAttendance($GET) {
        $courseid = $GET["courseid"];
        $academicyear = $this->getCurrentAcademicYear();
        $semester = $this->getCurrentAcademicSemester();
        $attend = "(SELECT count(*) FROM `attendance` a JOIN lectures l ON a.classid = l.lectureId JOIN course_allocation aa ON aa.courseAllocationId "
                . "=l.courseAllocationId WHERE a.studentid = s.studentid AND aa.courseId = {$courseid} AND a.academicyear = '{$academicyear}' AND a.academicsemester = {$semester}) count";
        $dpm = "(SELECT department_name FROM `department` WHERE s.dpmId=departmentid) dpmName";
        return $this->db->select("SELECT s.*, $attend,$dpm FROM student s JOIN course_registration cr ON s.studentid = cr.studentId"
                        . " JOIN registered_courses rc ON rc.registrationId = cr.registrationId WHERE rc.courseId={$courseid} "
                        . "GROUP BY s.studentid ORDER BY s.regNo ASC");
    }

    public function getCourseLectures($POST) {
        $courseid = $POST["courseid"];
        $academicyear = $this->getCurrentAcademicYear();
        $semester = $this->getCurrentAcademicSemester();
        $date = date("Y-m-d");
        $time = date("h:i A", time());
        return $this->db->selectSingleData("SELECT *,(SELECT count(*) FROM lectures l WHERE a.courseAllocationId = l.courseAllocationId "
                        . "AND date <='{$date}') count FROM course_allocation a WHERE academicyear = '{$academicyear}' "
                        . "AND academicsemester = {$semester} AND courseId={$courseid}");
    }

    public function getLectureInfo($POST) {
        $data = $this->getCourseLectures($POST);
        $lecturer = $this->getLectereName($data["lecturerId"]);
        $course = $this->getCouresName((int) $data["courseId"]);
        $level = ['Unknown', 'Part 1', 'Part 2', 'Part 3', 'Part 4'][(int) $this->getCourseLevel($data["lecturerId"])];
        return array("lecturer" => $lecturer, "code" => $course, "count" => $data["count"], "level" => $level);
    }

    public function getCourseLevel($courseId) {
        $row = $this->db->selectSingleData("SELECT * FROM courses WHERE courseid = $courseId");
        return $row ? ucwords($row["level"]) : 0;
    }

    function getData($data) {
        return array_merge($data, array("academicyear" => $this->getCurrentAcademicYear(), "semester" => $this->getCurrentAcademicSemester()));
    }

    public function getOngoingLectures($lecturerId) {
        $lectureAssigned = $this->db->select("SELECT l.*, c.code,c.courseId id,a.staffid FROM course_allocation a JOIN classes l ON "
                . "a.courseAllocationId = l.courseAllocationId JOIN courses c ON c.courseId = a.courseId WHERE "
                . "l.date = '" . date('Y-m-d') . "' AND a.staffid = {$lecturerId}");

        $json = array();
        foreach ($lectureAssigned as $row):
            if (strtotime($row["endTime"]) >= time()):
                $row["startTime"] = date("h:i A", strtotime($row['startTime']));
                $row["endTime"] = date("h:i A", strtotime($row['endTime']));
                $json[] = $row;
            endif;
        endforeach;
        return $json;
    }

    public function lectureAttendance($lectureId) {
        $lists = $this->db->select("SELECT s.*,a.date FROM attendance a JOIN student s ON s.studentid = a.studentid WHERE"
                . " a.classid = {$lectureId} AND a.academicsemester = " . $this->getCurrentAcademicSemester() . " "
                . "AND a.academicyear = '" . $this->getCurrentAcademicYear() . "' ORDER BY a.date DESC");
        $data = array();

        foreach ($lists as $item) {
            $data[] = array("dpm" => $this->getDepartmentName($item['dpmId']), "regNo" => $item['regNo'],
                "name" => ucwords($item['fullname']), "time" => date("h:i A", strtotime($item['date'])),
                "image" => URL . "public/" . ($item["image"] ? 'uploads/student/' . $item["image"] : 'no-image.gif'));
        }
        return $data;
    }

    public function taken($sId, $classid) {
        $lists = $this->db->select("SELECT * FROM `attendance` WHERE studentid={$sId} AND classid={$classid}");
        return count($lists) > 0 ? 1 : 0;
    }

    public function getAttendance($id) {
        $data = $this->getOngoingLectures($id);
        $lists = $this->getLecturerStudents($id);
        $tData = array();
        foreach ($lists as $item) {
            $tData[] = array("dpm" => "Computer Science", "regNo" => $item['regNo'], "name" => ucwords($item['fullname']),
                "image" => URL . "public/" . ($item["image"] ? 'uploads/student/' . $item["image"] : 'no-image.gif'), "token" => $this->taken($item["studentid"], $data[0]["classid"]));
        }

        die(json_encode(array("result" => array("lecture" => $data, "taken" => $tData), "reason" => '')));
    }

    public function takeAttendance($POST) {
        $check = $this->checkRegNo($POST["regNo"]);
        if (!$check):
            die(json_encode(array("result" => 1702, "reason" => 'Barcode image does no match any student or student does not registered this course!')));
        endif;
        $check2 = $this->checkIfTaken($check["studentid"], $POST["classId"]);
        if ($check2):
            die(json_encode(array("result" => 1702, "reason" => 'Attendance already taken!')));
        endif;
        $data = array("studentid" => $check["studentid"], "classid" => $POST["classId"], "academicyear" => $this->getCurrentAcademicYear(), "academicsemester" => $this->getCurrentAcademicSemester());
        if ($this->db->insert("attendance", $data)):
            die(json_encode(array("result" => 1701, "reason" => 'Attendance successfully taken!', "data" => $this->getLoggedDataStudent($this->db->lastInsertId()))));
        endif;
        die(json_encode(array("result" => 1702, "reason" => 'AUnabled to take attendance!')));
    }

    public function getLoggedDataStudent($attendanceId) {
        $data = $this->db->selectSingleData("SELECT s.*,a.date FROM attendance a LEFT JOIN student s ON s.studentid = a.studentid WHERE "
                . "a.attendanceid != {$attendanceId}  ORDER BY a.date DESC");
        $data["name"] = ucwords($data['fullname']);
        $data["image"] = URL . "public/" . ($data["image"] ? 'uploads/student/' . $data["image"] : 'no-image.gif');
        $data["time"] = date("h:i A", strtotime($data['date']));
        return $data;
    }

    private function checkRegNo($regNo) {
        return $this->db->selectSingleData("SELECT * FROM student WHERE regNo = '{$regNo}'");
    }

    public function checkIfTaken($studentId, $lectureId) {
        return $this->db->selectSingleData("SELECT * FROM `attendance` WHERE studentid={$studentId} AND classid = {$lectureId}");
    }

    public function fetchAttendance($POST) {
        $courseid = $POST["courseid"];
        $academicyear = $this->getCurrentAcademicYear();
        $semester = $this->getCurrentAcademicSemester();
        $attend = "(SELECT count(*) FROM `attendance` a JOIN classes cl ON a.classid = cl.classid JOIN course_allocation aa ON aa.courseAllocationId "
                . "=cl.courseAllocationId WHERE a.studentid = s.studentid AND aa.courseId = {$courseid} AND a.academicyear = '{$academicyear}' AND a.academicsemester = {$semester}) count";
        return $this->db->select("SELECT s.*, {$attend} FROM student s JOIN course_registration cr ON s.studentid = cr.studentId"
                        . " JOIN registered_courses rc ON rc.registrationId = cr.registrationId WHERE rc.courseId={$courseid} "
                        . "GROUP BY s.studentid ORDER BY s.regNo ASC");
    }

    public function getStaffInfo($POST) {
        $data = $this->getCourseClasss($POST);
        $staff = $this->getStaff($data["staffid"]);
        $course = $this->getCourseCode($data["courseId"]);
        $level = ["", "Part 1", "Part 2", "Part 3", "Part 4", "Part 5"][(int) $this->getCourseLevel($data["courseId"])];
        return array("staff" => $staff, "code" => $course, "count" => $data["count"], "level" => $level);
    }

    public function getCourseClasss($POST) {
        $courseid = $POST["courseid"];
        $academicyear = $this->getCurrentAcademicYear();
        $semester = $this->getCurrentAcademicSemester();
        $date = date("Y-m-d");
        $time = date("h:i A", time());
        return $this->db->selectSingleData("SELECT *,(SELECT count(*) FROM classes cl WHERE a.courseAllocationId = cl.courseAllocationId "
                        . "AND date <='{$date}') count FROM course_allocation a WHERE academicyear = '{$academicyear}' "
                        . "AND academicsemester = {$semester} AND courseId={$courseid}");
    }

    public function getStaff($staffid) {
        $row = $this->db->selectSingleData("SELECT * FROM `users` WHERE userid={$staffid}");
        return $row ? ucwords($row["fullname"]) : 'Unkwnown';
    }

    public function getCourseCode($courseId) {
        $row = $this->db->selectSingleData("SELECT * FROM courses WHERE courseid = $courseId");
        return $row ? ucwords($row["code"]) : 'Unkwnown';
    }

}
