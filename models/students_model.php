<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of students_model
 *
 * @author Jiskit
 */
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class students_model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getStudents() {
        return $this->db->select("SELECT * FROM student");
    }

    

    public function getStaffStudents($staffId) {
        return $this->db->select("SELECT s.* FROM student s JOIN course_registration cr ON s.studentid = cr.studentId JOIN "
                        . "registered_courses rc ON cr.registrationId=rc.registrationId JOIN course_allocation a ON a.courseId = rc.courseId "
                        . " WHERE a.staffid = {$staffId} AND a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND "
                        . "a.academicyear = '" . $this->getCurrentAcademicYear() . "' GROUP BY s.studentid ORDER BY fullname ASC");
    }

    public function getStudentInfo($studentId) {
        return $this->db->selectSingleData("SELECT s.*,b.image biometric FROM student s LEFT JOIN student_biometric b ON s.studentid=b.studentid WHERE s.studentid = $studentId");
    }

    public function getSchedulesLists($studentId) {
        return $this->db->select("SELECT l.courseAllocationId,c.code,count(l.courseAllocationId) class FROM classes l JOIN course_allocation a ON l.courseAllocationId=a.courseAllocationId "
                        . "JOIN courses c ON c.courseId = a.courseId JOIN registered_courses rc ON rc.courseId = a.courseId JOIN course_registration cr ON rc.registrationId = cr.registrationId "
                        . "WHERE l.date <= '" . date('Y-m-d') . "' AND cr.studentId = {$studentId} GROUP BY l.courseAllocationId");
    }

    public function getSchedulesListsByStaff($studentId, $staffid) {
        return $this->db->select("SELECT l.courseAllocationId,c.code,count(l.courseAllocationId) class FROM classes l JOIN course_allocation a ON l.courseAllocationId=a.courseAllocationId "
                        . "JOIN courses c ON c.courseId = a.courseId JOIN registered_courses rc ON rc.courseId = a.courseId JOIN course_registration cr ON rc.registrationId = cr.registrationId "
                        . "WHERE l.date <= '" . date('Y-m-d') . "' AND cr.studentId = {$studentId} AND a.staffid={$staffid} GROUP BY l.courseAllocationId");
    }

    public function getStudentsLists() {
        $lists = $this->getStudents();

        $data = array();

        foreach ($lists as $item) {
            $data[] = array($item['jambNo'], $item['regNo'], ucwords($item['fullname']),
                '<button class="btn btn-sm btn-primary" onclick="return view(' . $item['studentid'] . ')"><i class="bi bi-eye"></i></button> '
                . '<a class="btn btn-sm btn-primary" href="' . URL . 'students/attendance/' . $item['studentid'] . '"><i class="bi bi-list"></i></a> '
                . '<button class="btn btn-sm btn-primary" onclick="return edit(' . $item['studentid'] . ')"><i class="bi bi-pencil"></i></button> ');
        }

        return json_encode(array("data" => $data));
    }

    public function getStaffStudentsLists($staffId) {
        $lists = $this->getStaffStudents($staffId);

        $data = array();

        foreach ($lists as $item) {
            $data[] = array($item['jambNo'], $item['regNo'], ucwords($item['fullname']),
                '<button class="btn btn-sm btn-primary" onclick="return view(' . $item['studentid'] . ')"><i class="bi bi-eye"></i></button> '
                . '<a class="btn btn-sm btn-primary" href="' . URL . 'students/attendance/' . $item['studentid'] . '"><i class="bi bi-list"></i></a> ');
        }

        return json_encode(array("data" => $data));
    }

    public function getStudentAttendancesByClass($studentId) {
        return $this->db->select("SELECT cl.courseAllocationId,count(cl.courseAllocationId) count FROM attendance a JOIN classes cl ON a.classid=cl.classid WHERE a.studentid = $studentId AND a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND a.academicyear = '" . $this->getCurrentAcademicYear() . "'");
    }

    public function add($POST) {
        foreach ($POST as $key => $value):
            if (trim($value) == ""):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;
        if (!filter_var($POST["jambNo"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([0-9]{8})+[A-Z]{2}$/")))) {
            return array("result" => -3, "reason" => "Invalid JAMB registration number");
        }
        if (!filter_var($POST["regNo"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([CST])+\/+([0-9]{2})+\/+([COM])+\/+([0-9]{5})+$/")))) {//CST/19/COM/00251
            return array("result" => -3, "reason" => "Invalid Matric No");
        }
        if (!is_string($POST['fullname'])) {
            return array("result" => -1, "reason" => "Fullname must be letters and white space only");
        }
        if (trim($POST['image']) == "") {
            return array("result" => -3, "reason" => "Student must take a snapshot");
        }
        $checkJamb = $this->db->selectSingleData("SELECT * FROM student WHERE jambNo = '{$POST['jambNo']}'");

        if ($checkJamb != null) {
            return array("result" => -5, "reason" => "Student jamb number already exist.");
        }
        $checkStudent = $this->db->selectSingleData("SELECT * FROM student WHERE regNo = '{$POST['regNo']}'");

        if ($checkStudent != null) {
            return array("result" => -4, "reason" => "Student registration number already exist.");
        }
        $ext = $this->getStringBetween($POST['image'], "data:image/", ";base64,");
        $image = str_replace("data:image/" . $ext . ";base64,", "", $POST['image']);
        $POST['image'] = $this->base64ToImageFile($image, $ext, UPLOAD_DIR . "student/");
        $barcode = $POST['regNo'];
        $studentInfo = $POST;
        if ($this->db->insert("student", $studentInfo)):
            $studentID = $this->db->lastInsertId();
            $this->db->insert("student_barcode", array("studentid" => $studentID, "barcode" => $barcode));
            return array("result" => 1, "reason" => "Student successfully added.");
        endif;
        return array("result" => -4, "reason" => "Unable to add new student.");
    }

    public function update($studentId, $POST) {
        $info = $this->getStudentInfo($studentId);
        foreach ($POST as $key => $value):
            if (trim($value) == "" && $key != "image"):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;
        if (!filter_var($POST["jambNo"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([0-9]{8})+[A-Z]{2}$/")))) {
            return array("result" => -3, "reason" => "Invalid JAMB registration number");
        }
        if (!filter_var($POST["regNo"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([CST])+\/+([0-9]{2})+\/+([COM])+\/+([0-9]{5})+$/")))) {//CST/19/COM/00251
            return array("result" => -3, "reason" => "Invalid Matric No");
        }
        if (!is_string($POST['fullname'])) {
            return array("result" => -1, "reason" => "Fullname must be letters and white space only");
        }
        $checkJamb = $this->db->selectSingleData("SELECT * FROM student WHERE jambNo = '{$POST['jambNo']}' AND studentid !={$studentId}");

        if ($checkJamb != null) {
            return array("result" => -5, "reason" => "Student jamb number already exist.");
        }
        $checkStudent = $this->db->selectSingleData("SELECT * FROM student WHERE regNo = '{$POST['regNo']}' AND studentid !={$studentId}");

        if ($checkStudent != null) {
            return array("result" => -4, "reason" => "Student registration number already exist.");
        }
        if (trim($POST['image']) != "") {
            $ext = $this->getStringBetween($POST['image'], "data:image/", ";base64,");
            $image = str_replace("data:image/" . $ext . ";base64,", "", $POST['image']);
            $POST['image'] = $this->base64ToImageFile($image, $ext, UPLOAD_DIR . "student/");
            if ($info['image'] != "") {
                unlink(UPLOAD_DIR . "student/" . $info['image']);
            }
        } else {
            unset($POST['image']);
        }
        $barcode = $POST['regNo'];
        $studentInfo = $POST;
        if ($this->db->update("student", $studentInfo, "studentid = $studentId")):
            $checkBarcode = $this->db->selectSingleData("SELECT * FROM student_barcode WHERE studentid = $studentId");
            if ($checkBarcode != null) {
                $this->db->update("student_barcode", array("barcode" => $barcode), "studentid = $studentId");
            } else {
                $this->db->insert("student_barcode", array("studentid" => $studentId, "barcode" => $barcode));
            }
            return array("result" => 1, "reason" => "Student successfully updated.");
        endif;
        return array("result" => -4, "reason" => "Unable to update student.");
    }

    public function getClasses() {
        return $this->db->select("SELECT l.* FROM classes cl JOIN course_allocation a ON cl.courseAllocationId = a.courseAllocationId "
                        . "WHERE a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND academicyear = '" . $this->getCurrentAcademicYear() . "' "
                        . "AND cl.date <= '" . date('Y-m-d') . "'");
    }

    public function getAttendances($studentId) {
        return $this->db->select("SELECT * FROM attendance WHERE studentid = $studentId AND academicsemester = " . $this->getCurrentAcademicSemester() . " AND academicyear = '" . $this->getCurrentAcademicYear() . "'");
    }

    private $data = [];
    private $validData = [];
    private $invalidData = [];

    public function processStudentImport() {
        if ($_FILES['csv']['error'] == 0):
            $this->loadData();
            $this->validateData($this->data);
            $saveErr = 0;
            $saveSuccess = 0;
            foreach ($this->validData as $POST):
                $barcode = $POST['regNo'];
                $studentInfo = $POST;
                if ($this->db->insert("student", $studentInfo)):
                    $saveSuccess++;
                else:
                    $saveErr++;
                endif;
            endforeach;
            die(json_encode(array("result" => 1, "reason" => "Operation completed", "data" => $this->displayReport($saveErr, $saveSuccess))));
        else:
            echo json_encode(array("result" => -3, "errors" => "An error occured please try again later!"));
        endif;
    }

    private function loadData() {
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
        for ($i = 0; $i <= 5; $i++) {
            if (isset($this->data[$i]) && !is_numeric($this->data[$i][0])):
                unset($this->data[$i]);
            endif;
        }
    }

    private function JambNoExists($jambNo = "") {
        $checkJamb = $this->db->selectSingleData("SELECT * FROM student WHERE jambNo = '{$jambNo}'");
        return $checkJamb ? true : false;
    }

    private function MatricNoExists($regNo = "") {
        $check = $this->db->selectSingleData("SELECT * FROM student WHERE regNo = '{$regNo}'");
        return $check ? true : false;
    }

    protected function validateData($data = array()) {
        $jsonInvalid = array();
        $jsonValid = array();

        foreach ($data as $res):
            if (empty(trim($res[1])) || empty(trim($res[2])) || empty(trim($res[3]))):
                $jsonInvalid[] = array("jambNo" => $res[1], "regNo" => $res[2], "fullname" => $res[3], "is_valid" => false, "reason" => "Required data (Jamb No,Reg No. or Fullname) is/are missing");
            elseif (!filter_var($res[1], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([0-9]{8})+[A-Z]{2}$/")))):
                $jsonInvalid[] = array("jambNo" => $res[1], "regNo" => $res[2], "fullname" => $res[3], "is_valid" => false, "reason" => "Invalid JAMB Number");
            elseif (!filter_var($res[2], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([CST])+\/+([0-9]{2})+\/+([COM])+\/+([0-9]{5})+$/")))):
                $jsonInvalid[] = array("jambNo" => $res[1], "regNo" => $res[2], "fullname" => $res[3], "is_valid" => false, "reason" => "Invalid Matric Number");
            elseif (!is_string($res[3])):
                $jsonInvalid[] = array("jambNo" => $res[1], "regNo" => $res[2], "fullname" => $res[3], "is_valid" => false, "reason" => "Invalid fullname");
            elseif ($this->JambNoExists($res[1])):
                $jsonInvalid[] = array("jambNo" => $res[1], "regNo" => $res[2], "fullname" => $res[3], "is_valid" => false, "reason" => "Jamb Number already exists");
            elseif ($this->MatricNoExists($res[2])):
                $jsonInvalid[] = array("jambNo" => $res[1], "regNo" => $res[2], "fullname" => $res[3], "is_valid" => false, "reason" => "Matric Number already exists");
            else:
                $jsonValid[] = array("jambNo" => $res[1], "regNo" => $res[2], "fullname" => $res[3]);
            endif;
        endforeach;
        $this->validData = $jsonValid;
        $this->invalidData = $jsonInvalid;
    }

    private function displayReport($saveErr = '', $saveSuccess = '') {
        $error = count($this->invalidData);
        $html = '<div class=""><div class="col-12"><div class="alert alert-success">' . $saveSuccess . ' Student(s) successfully imported</div><div class="alert alert-danger">' . ($saveErr + $error) . ' student(s) Unabled to import</div>';
        if ($error > 0):
            $html .= '<span class="text-danger">' . $error . ' Invalid data found; details showed bellow</span><table class="table table-striped"><thead><tr><th>Data</th><th>Error</th></tr></thead><tbody>';
            foreach ($this->invalidData as $err):
                $html .= '<tr><td>' . $err["regNo"] . ' :: ' . $err["fullname"] . '</td><td>' . $err["reason"] . '</td></tr>';
            endforeach;
            $html .= '</tbody></table>';
        endif;
        $html .= '</div></div>';
        return $html;
    }

}
