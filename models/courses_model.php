<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of courses_model
 *
 * @author Jiskit
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class courses_model extends Model {

    //put your code here
    public $limit;
    public $start;
    public $search = '%%';
    public $oCol;
    public $oDir;

    public function __construct() {
        parent::__construct();
    }

    public function getCourses() {
        return $this->db->select("SELECT * FROM courses WHERE code LIKE '{$this->search}' OR title LIKE '{$this->search}' "
                        . "ORDER BY $this->oCol $this->oDir LIMIT $this->start,$this->limit");
    }

    public function getCoursesByStaffid($staffid) {
        return $this->db->select("SELECT c.* FROM courses c JOIN course_allocation a ON c.courseId=a.courseId WHERE a.staffid ="
                        . "{$staffid} AND (code LIKE '{$this->search}' OR title LIKE '{$this->search}') GROUP BY a.courseId "
                        . "ORDER BY $this->oCol $this->oDir LIMIT $this->start,$this->limit");
    }

    public function total_courses() {
        $stmt = $this->db->select("SELECT * FROM courses WHERE code LIKE '{$this->search}' OR title LIKE '{$this->search}'");
        return count($stmt);
    }

    public function total_coursesByStaffid($staffid) {
        $stmt = $this->db->select("SELECT c.* FROM courses c JOIN course_allocation a ON c.courseId=a.courseId WHERE a.staffid ="
                        . "{$staffid} AND code LIKE '{$this->search}' OR title LIKE '{$this->search}'");
        return count($stmt);
    }

    public function getCoursesInfo($courseId) {
        return $this->db->selectSingleData("SELECT * FROM courses WHERE courseId = $courseId");
    }

    private function codeExists($code = "") {
        $check = $this->db->selectSingleData("SELECT * FROM courses WHERE code = '{$code}'");
        return $check ? true : false;
    }

    public function getCoursesList() {
        $list = $this->getCourses();
        $data = array();
        $i = 1;
        foreach ($list as $res) {
            $data[] = array($i, $res["code"], $res["title"], $this->fmtYear($res["level"]), "semester " . $res["semester"], '<a class="btn btn-sm btn-primary btn-edit" href="javascript:void(0)" onclick ="return edit(' . $res['courseId'] . ')"><i class="bi bi-pencil"></i></a>');
            $i++;
        }
        return $data;
    }

    public function getCoursesByStaffList($staffid) {
        $list = $this->getCoursesByStaffid($staffid);
        $data = array();
        $i = 1;
        foreach ($list as $res) {
            $data[] = array($i, $res["code"], $res["title"], $this->fmtYear($res["level"]), "semester " . $res["semester"], '');
            $i++;
        }
        return $data;
    }

    public function add($POST) {
        foreach ($POST as $key => $value):
            if (trim($value) == ""):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;

        if (!filter_var($POST["code"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([A-Z]{3})+[0-9]{4}$/")))) {
            return array("result" => -2, "reason" => "Invalid course code");
        }
        if (!filter_var($POST["code"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[A-Za-z0-9. ]*/")))) {
            return array("result" => -3, "reason" => "Invalid course title");
        }
        $checkCode = $this->db->selectSingleData("SELECT * FROM courses WHERE code = '{$POST['code']}'");

        if ($checkCode != null) {
            return array("result" => -4, "reason" => "Course code already taken.");
        }
        $POST["title"] = ucwords($POST["title"]);
        $dataArr = $POST;
        if ($this->db->insert("courses", $dataArr)):
            return array("result" => 1, "reason" => "Course successfully added.");
        endif;
        return array("result" => -2, "reason" => "Unable to add new Course.");
    }

    public function update($courseId, $POST) {
        foreach ($POST as $key => $value):
            if (trim($value) == ""):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;

        if (!filter_var($POST["code"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([A-Z]{3})+[0-9]{4}$/")))) {
            return array("result" => -2, "reason" => "Invalid course code");
        }
        if (!filter_var($POST["code"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[A-Za-z0-9. ]*/")))) {
            return array("result" => -3, "reason" => "Invalid course title");
        }
        $checkCode = $this->db->selectSingleData("SELECT * FROM courses WHERE code = '{$POST['code']}' AND courseId != {$courseId}");

        if ($checkCode != null) {
            return array("result" => -4, "reason" => "Course code already taken.");
        }
        $POST["title"] = ucwords($POST["title"]);
        $dataArr = $POST;
        if ($this->db->update("courses", $dataArr, "courseId = $courseId")):
            return array("result" => 1, "reason" => "Course successfully updated.");
        endif;
        return array("result" => -2, "reason" => "Unable to update Course.");
    }

    //File Upload
    private $data = [];
    private $validData = [];
    public $invalidData = [];

    public function processImport() {
        if ($_FILES['csv']['error'] == 0):
            $this->loadData();
            $this->validateData($this->data);
            $saveErr = 0;
            $saveSuccess = 0;
            foreach ($this->validData as $POST):
                $courseInfo = $POST;
                if ($this->db->insert("courses", $courseInfo)):
                    $saveSuccess++;
                else:
                    $saveErr++;
                endif;
            endforeach;
            die(json_encode(array("result" => 1, "data" => $this->htmlReport(), "reason" => $this->displayReport($saveErr, $saveSuccess))));
        else:
            echo json_encode(array("result" => -3, "reason" => "An error occured please try again later!"));
        endif;
    }

    private function loadData() {
        $allowed_extension = array('xls', 'xlsx');
        $file_array = explode(".", $_FILES['csv']['name']);
        $file_extension = end($file_array);
        if (!in_array($file_extension, $allowed_extension)):
            die(json_encode(array("result" => -3, "reason" => "Only .xls or .xlsx file allowed")));
        endif;
        $target_file = UPLOAD_DIR . "file/" . $_FILES["csv"]["name"];
        if (!move_uploaded_file($_FILES["csv"]["tmp_name"], $target_file)):
            die(json_encode(array("result" => -3, "reason" => "An error occurred trying to proccess file")));
        endif;
        if (!file_exists($target_file)):
            die(json_encode(array("result" => -3, "reason" => "An error occured please try again later!")));
        endif;
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($target_file);
        $this->data = $spreadsheet->getActiveSheet()->toArray();
        unlink($target_file);
        for ($i = 0; $i <= 8; $i++) {
            if (isset($this->data[$i]) && !is_numeric($this->data[$i][0])):
                unset($this->data[$i]);
            endif;
        }
    }

    protected function validateData($data = array()) {
        $jsonInvalid = array();
        $jsonValid = array();

        foreach ($data as $res):
            if (empty(trim($res[1])) || empty(trim($res[2])) || empty(trim($res[3])) || empty(trim($res[4]))):
                $jsonInvalid[] = array("code" => $res[1], "title" => $res[2], "level" => $res[3], "semester" => $res[4], "reason" => "Required data is/are missing");
            elseif (!filter_var($res[1], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([A-Z]{3})+[0-9]{4}$/")))):
                $jsonInvalid[] = array("code" => $res[1], "title" => $res[2], "level" => $res[3], "semester" => $res[4], "reason" => "Invalid course code");
            elseif (!is_string($res[2])):
                $jsonInvalid[] = array("code" => $res[1], "title" => $res[2], "level" => $res[3], "semester" => $res[4], "reason" => "Invalid course title");
            elseif (!is_numeric($res[3]) || !is_numeric($res[4])):
                $jsonInvalid[] = array("code" => $res[1], "title" => $res[2], "level" => $res[3], "semester" => $res[4], "reason" => "Invalid level or semester");
            elseif ($this->codeExists($res[1])):
                $jsonInvalid[] = array("code" => $res[1], "title" => $res[2], "level" => $res[3], "semester" => $res[4], "reason" => "Course code already exists");
            else:
                $jsonValid[] = array("code" => $res[1], "title" => $res[2], "level" => $res[3], "semester" => $res[4]);
            endif;
        endforeach;
        $this->validData = $jsonValid;
        $this->invalidData = $jsonInvalid;
    }

    private function displayReport($saveErr = 0, $saveSuccess = 0) {
        $html = "<p><span class='text-success'>{$saveSuccess} record successfully imported</span></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>";
        $html .= "<p><span class='text-danger'>" . ($saveErr + count($this->invalidData)) . " record unsuccessful</span></p>";
        return $html;
    }

    private function htmlReport() {
        $html = '';
        if (count($this->invalidData) > 0):
            $html .= '<h6>Course Upload Report</h6>
                <table class="table table-sm table-condensed"><thead><th>Course</th><th>Error</th></thead><tbody>';
            foreach ($this->invalidData as $res):
                $html .= '<tr><td>' . $res["code"] . '</td><td>' . $res["reason"] . '</td></tr>';
            endforeach;
            $html .= '</tbody></table>';
        endif;
        return $html;
    }

    public function getAssigned() {
        $currentYear = $this->getCurrentAcademicYear();
        $currentSemester = $this->getCurrentAcademicSemester();
        return $this->db->select("SELECT a.courseAllocationId,c.code,c.level,u.fullname FROM course_allocation a "
                        . "JOIN courses c ON a.courseId = c.courseId JOIN users u ON a.staffid=u.userid WHERE "
                        . "(c.code LIKE '{$this->search}' OR u.fullname LIKE '{$this->search}') AND a.academicyear="
                        . "'{$currentYear}' AND academicsemester={$currentSemester} ORDER BY $this->oCol $this->oDir "
                        . "LIMIT $this->start,$this->limit");
    }

    public function total_assigned() {
        $currentYear = $this->getCurrentAcademicYear();
        $currentSemester = $this->getCurrentAcademicSemester();
        $stmt = $this->db->select("SELECT a.courseAllocationId,c.code,c.level,u.fullname FROM course_allocation a "
                . "JOIN courses c ON a.courseId = c.courseId JOIN users u ON a.staffid=u.userid WHERE "
                . "(c.code LIKE '{$this->search}' OR u.fullname LIKE '{$this->search}') AND a.academicyear="
                . "'{$currentYear}' AND academicsemester={$currentSemester}");
        return count($stmt);
    }

    public function getAssignedList() {
        $list = $this->getAssigned();
        $data = array();
        $i = 1;
        foreach ($list as $res) {
            $data[] = array($i, $res["code"], $this->fmtYear($res["level"]), $res["fullname"],
                '<button class="btn btn-sm btn-success" onclick="return edit(' . $res['courseAllocationId'] . ')"><i class="bi bi-pencil"></i></button>');
            $i++;
        }
        return $data;
    }

    public function allocate($POST) {
        extract($POST);
        if (!$this->getCurrentAcademicYear() || !$this->getCurrentAcademicSemester()):
            return array("result" => -2, "reason" => "Please set current academic year and semester");
        endif;
        foreach ($POST as $key => $value):
            if (trim($value) == ""):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;

        $checkCode = $this->db->selectSingleData("SELECT * FROM course_allocation WHERE staffid = {$staffId} AND courseId = {$courseId} AND academicyear = '{$this->getCurrentAcademicYear()}'");

        if ($checkCode != null) {
            return array("result" => -4, "reason" => "Course already assigned.");
        }
        $dataArr = array("staffid" => $staffId, "courseId" => $courseId, "academicyear" => $this->getCurrentAcademicYear(), "academicsemester" => $this->getCurrentAcademicSemester());
        if ($this->db->insert("course_allocation", $dataArr)):
            return array("result" => 1, "reason" => "Course successfully assigned.");
        endif;
        return array("result" => -2, "reason" => "Unable to assign Course.");
    }

    public function assigned_update($courseAllocationId, $POST) {
        extract($POST);
        if (!$this->getCurrentAcademicYear() || !$this->getCurrentAcademicSemester()):
            return array("result" => -2, "reason" => "Please set current academic year and semester");
        endif;
        foreach ($POST as $key => $value):
            if (trim($value) == ""):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;

        $checkCode = $this->db->selectSingleData("SELECT * FROM course_allocation WHERE staffid = {$staffId} AND courseId = {$courseId} AND academicyear = '{$this->getCurrentAcademicYear()}' AND courseAllocationId != {$courseAllocationId}");
        if ($checkCode != null) {
            return array("result" => -4, "reason" => "Course already assigned.");
        }
        $dataArr = array("staffid" => $staffId, "courseId" => $courseId);
        if ($this->db->update("course_allocation", $dataArr, "courseAllocationId = $courseAllocationId")):
            return array("result" => 1, "reason" => "Assigned course successfully updated");
        endif;
        return array("result" => -2, "reason" => "Unable to update assigned course.");
    }

    public function dropDownStaff() {
        return $this->fetchStaffDropdown();
    }

    public function dropDownCourses() {
        return $this->fetchCoursesDropdown();
    }

    public function getAssignedInfo($courseAllocationId) {
        return $this->db->selectSingleData("SELECT * FROM course_allocation WHERE courseAllocationId = $courseAllocationId");
    }

    //Registration

    public function getRegistrations() {
        return $this->db->select("SELECT s.jambNo,s.regNo,s.fullname, r.registrationId,r.level FROM course_registration r JOIN student s ON r.studentId = s.studentid "
                        . "WHERE `academicyear` = '{$this->getCurrentAcademicYear()}' AND `academicsemester` = {$this->getCurrentAcademicSemester()}");
    }

    public function getRegistrationCourses($registrationId) {
        return $this->db->select("SELECT code FROM registered_courses r JOIN courses c ON r.courseId=c.courseId WHERE r.registrationId = {$registrationId}");
    }

    public function getRegistration_list() {
        $list = $this->getRegistrations();
        $json = array();
        foreach ($list as $res):
            $json[] = array($res["jambNo"], $res["regNo"], $res["fullname"], $res["level"], $this->getRegistrationCourses_list($res["registrationId"]));
        endforeach;
        return json_encode(array("data" => $json));
    }

    public function getRegistrationCourses_list($registrationId) {
        $list = $this->getRegistrationCourses($registrationId);
        $data = "";
        foreach ($list as $res):
            if ($data != ""):
                $data .= ", " . $res["code"];
            else:
                $data .= $res["code"];
            endif;
        endforeach;
        return $data;
    }

    public function processCourseImport() {
        $html = "";
        if ($_FILES['csv']['error'] == 0):
            $this->loadData2();
            $this->validateData2($this->data);
            $studentsNotExists = 0;
            foreach ($this->validData as $POST):
                if (!$this->MatricNoExists($POST["regNo"])):
                    $studentsNotExists++;
                else:
                    $html .= $this->SaveData1(array_merge($POST, array("level" => $_POST["level"])));
                endif;
            endforeach;
            foreach ($this->validData as $POST):
                if (!$this->MatricNoExists($POST["regNo"])):
                    $studentsNotExists++;
                else:
                    $html .= $this->SaveData1(array_merge($POST, array("level" => $_POST["level"])));
                endif;
            endforeach;
            die(json_encode(array("result" => 1, "reason" => "Operation completed!", "data" => $html)));
        else:
            echo json_encode(array("result" => -3, "reason" => "An error occured please try again later!"));
        endif;
    }

    private function SaveData1($data) {
        $stud = $this->studInfo($data["regNo"]);
        $courseNotExists = 0;
        $couseValue = "";
        $couseExists = "";
        $check = $this->isStudentRegistered($stud["studentid"], $data["level"], 1);
        $Studdata = array("studentId" => $stud["studentid"], "academicyear" => $this->getCurrentAcademicYear(), "academicsemester" => 1, "level" => $data["level"]);
        if (!$check):
            $this->db->insert("course_registration", $Studdata);
        endif;
        $studData = $this->isStudentRegistered($stud["studentid"], $data["level"], 1);
        foreach (explode(",", $data["couse_sem1"]) as $code):
            $course = $this->courseInfo(trim($code));
            if (!$course):
                $courseNotExists++;
                $couseValue .= $couseValue == "" ? $code : ", " . $code;
            else:
                $save = $this->SaveProccedData($stud, $course, $studData);
                $couseExists .= $couseExists == "" ? $save : ", " . $save;
            endif;
        endforeach;
        $html1 = $courseNotExists > 0 ? "<span class='text-danger'>{$courseNotExists} courses ({$couseValue}) not exists</span>" : '';
        $html1 .= $couseExists ? "<span>{$couseExists} already registered</span>" : '';
        return "<div>Semester 1<br>{$html1}</div>";
    }

    private function SaveData2($data) {
        $stud = $this->studInfo($data["regNo"]);
        $courseNotExists = 0;
        $couseValue = "";
        $couseExists = "";
        $check = $this->isStudentRegistered($stud["studentid"], $data["level"], 2);
        $Studdata = array("studentId" => $stud["studentid"], "academicyear" => $this->getCurrentAcademicYear(), "academicsemester" => 2, "level" => $data["level"]);
        if (!$check):
            $this->db->insert("course_registration", $Studdata);
        endif;
        $studData = $this->isStudentRegistered($stud["studentid"], $data["level"], 2);
        foreach (explode(",", $data["couse_sem1"]) as $code):
            $course = $this->courseInfo(trim($code));
            if (!$course):
                $courseNotExists++;
                $couseValue .= $couseValue == "" ? $code : ", " . $code;
            else:
                $save = $this->SaveProccedData($stud, $course, $studData);
                $couseExists .= $couseExists == "" ? $save : ", " . $save;
            endif;
        endforeach;
        $html1 = $courseNotExists > 0 ? "<span class='text-danger'>{$courseNotExists} courses ({$couseValue}) not exists</span>" : '';
        $html1 .= $couseExists ? "<span>{$couseExists} already registered</span>" : '';

        return "<div>Semester 2<br>{$html1}</div>";
    }

    private function isStudentRegistered($id, $level, $semeseter) {
        return $this->db->selectSingleData("SELECT * FROM course_registration WHERE studentId = {$id} AND level={$level} AND academicyear = '{$this->getCurrentAcademicYear()}' AND academicsemester={$semeseter}");
    }

    private function isCourseRegistered($id, $rId) {
        return $this->db->selectSingleData("SELECT * FROM registered_courses WHERE courseId={$id} AND registrationId={$rId}");
    }

    private function SaveProccedData($stud, $course, $regData) {
        if ($this->isCourseRegistered($course["courseId"], $regData["registrationId"])):
            return $course["code"];
        else:
            $this->db->insert("registered_courses", array("registrationId" => $regData["registrationId"], "courseId" => $course["courseId"]));
            return '';
        endif;
    }

    private function loadData2() {
        $allowed_extension = array('xls', 'xlsx');
        $file_array = explode(".", $_FILES['csv']['name']);
        $file_extension = end($file_array);
        if (!in_array($file_extension, $allowed_extension)):
            die(json_encode(array("result" => -3, "errors" => "Only .xls or .xlsx file allowed")));
        endif;
        $target_file = UPLOAD_DIR . "file/" . $_FILES["csv"]["name"];
        if (!move_uploaded_file($_FILES["csv"]["tmp_name"], $target_file)):
            die(json_encode(array("result" => -3, "errors" => "An error occurred trying to proccess file")));
        endif;
        if (!file_exists($target_file)):
            die(json_encode(array("result" => -3, "errors" => "An error occured please try again later!")));
        endif;
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($target_file);
        $this->data = $spreadsheet->getActiveSheet()->toArray();
        unlink($target_file);
        for ($i = 0; $i <= 8; $i++) {
            if (isset($this->data[$i]) && !is_numeric($this->data[$i][0])):
                unset($this->data[$i]);
            endif;
        }
    }

    private function MatricNoExists($regNo = "") {
        $check = $this->db->selectSingleData("SELECT * FROM student WHERE regNo = '{$regNo}'");
        return $check ? true : false;
    }

    private function courseInfo($code = "") {
        return $this->db->selectSingleData("SELECT * FROM courses WHERE code = '{$code}'");
    }

    private function studInfo($regNo = "") {
        return $this->db->selectSingleData("SELECT * FROM student WHERE regNo = '{$regNo}'");
    }

    protected function validateData2($data = array()) {
        $jsonInvalid = array();
        $jsonValid = array();

        foreach ($data as $res):
            if (empty(trim($res[2])) || empty(trim($res[6])) || empty(trim($res[8]))):
                $jsonInvalid[] = array("regNo" => $res[2], "couse_sem1" => $res[6], "couse_sem2" => $res[8], "is_valid" => false, "reason" => "Required data is/are missing");
            elseif (!filter_var($res[2], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([CST])+\/+([0-9]{2})+\/+([COM])+\/+([0-9]{5})+$/")))):
                $jsonInvalid[] = array("regNo" => $res[2], "couse_sem1" => $res[6], "couse_sem2" => $res[8], "is_valid" => false, "reason" => "Invalid Matric Number");
            else:
                $jsonValid[] = array("regNo" => $res[2], "couse_sem1" => $res[6], "couse_sem2" => $res[8]);
            endif;
        endforeach;
        $this->validData = $jsonValid;
        $this->invalidData = $jsonInvalid;
    }

}
