<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Staff_nodel
 *
 * @author Jiskit
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Staff_model extends Model {

    //put your code here
    public $limit;
    public $start;
    public $search = '%%';
    public $oCol;
    public $oDir;

    public function __construct() {
        parent::__construct();
    }

    public function getStaff() {
        return $this->db->select("SELECT * FROM users WHERE (email LIKE '{$this->search}' OR fullname LIKE '{$this->search}' OR "
                        . "phone LIKE '{$this->search}') AND position = 'lecturer' ORDER BY $this->oCol $this->oDir LIMIT $this->start , $this->limit");
    }

    public function total_staff() {
        $stmt = $this->db->select("SELECT * FROM users WHERE (email LIKE '{$this->search}' OR fullname LIKE '{$this->search}' OR "
                . "phone LIKE '{$this->search}') AND position = 'lecturer'");
        return count($stmt);
    }

    public function getStaffInfo($staffId) {
        return $this->db->selectSingleData("SELECT * FROM users WHERE userid = $staffId");
    }

    public function fetchStaffCourses($staffId) {
        $stmt = $this->db->select("SELECT c.code FROM course_allocation a JOIN courses c ON a.courseId=c.courseId  WHERE "
                . "a.staffid = $staffId AND academicyear = '{$this->getCurrentAcademicYear()}' AND academicsemester={$this->getCurrentAcademicSemester()}");
        $courses = "";
        foreach ($stmt as $res):
            $courses .= $courses != "" ? ", " . $res["code"] : $res["code"];
        endforeach;
        return $courses;
    }

    public function getStaffLists() {
        $lists = $this->getStaff();

        $data = array();
        $i = 1;
        foreach ($lists as $item) {
            $course = $this->fetchStaffCourses($item['userid']);
            $data[] = array($i, $item['email'], $item['fullname'], $item['phone'], $course, '<button class="btn btn-sm btn-success" type="button" onclick="edit(' . $item['userid'] . ')"><i class="bi bi-pencil"></i></button>');
            $i++;
        }

        return $data;
    }

    public function getCouresName($courseId) {
        $row = $this->db->selectSingleData("SELECT * FROM courses WHERE courseId = $courseId");
        return $row ? $row["code"] : 'Unknwon';
    }

    public function getLecturerLectures($lecturerId) {
        $date = date("Y-m-d");
        return $this->db->select("SELECT l.lectureId,l.date,l.startTime,l.endTime,a.lecturerId,a.courseId FROM "
                        . "lectures l JOIN course_allocation a ON l.courseAllocationId = a.courseAllocationId WHERE "
                        . "a.lecturerId = {$lecturerId} AND l.date = '{$date}' AND a.academicsemester = " . $this->getCurrentAcademicSemester() . " AND a.academicyear = '" . $this->getCurrentAcademicYear() . "'");
    }

    public function getLecturerLecturesList($lecturerId) {
        $lists = $this->getLecturerLectures($lecturerId);
        $data = array();

        foreach ($lists as $item) {
            $date = date("M d, Y", strtotime($item['date']));
            $time = date("h:i A", strtotime($item['startTime'])) . " - " . date("h:i A", strtotime($item['endTime']));
            $data[] = array("date" => $date, "code" => $this->getCouresName($item["courseId"]), "time" => $time, "endTime" => $item["endTime"]);
        }

        return $data;
    }

    public function add($POST) {
        foreach ($POST as $key => $value):
            if (trim($value) == ""):
                return array("result" => -1, "reason" => ucwords($key) . " cannot be empty");
            endif;
        endforeach;
        $POST["fullname"] = ucwords($POST["fullname"]);
        if (!filter_var($POST["email"], FILTER_VALIDATE_EMAIL)):
            return array("result" => -2, "reason" => "Invalid Email address");
        endif;
        if (!is_numeric($POST['phone']) || strlen($POST['phone']) != 11 || !filter_var($POST["phone"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^(080|091|090|070|081)+[0-9]{8}$/")))) {
            return array("result" => -3, "reason" => "Invalid Phone Number");
        }
        $checkUser = $this->db->selectSingleData("SELECT * FROM user WHERE email = '{$POST['email']}'");

        if ($checkUser != null) {
            return array("result" => -4, "reason" => "Email address already taken.");
        }
        $checkUser1 = $this->db->selectSingleData("SELECT * FROM user WHERE phone = '{$POST['phone']}'");

        if ($checkUser1 != null) {
            return array("result" => -5, "reason" => "Phone number already taken.");
        }
        $pass = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
        $password = Hash::create('sha256', $pass, HASH_PASSWORD_KEY);
        $dataArr = array_merge(array("password" => $password), $POST);

        if ($this->db->insert("users", $dataArr)):
            $this->sendEmail($pass, $POST["email"], $POST["fullname"]);
            return array("result" => 1, "reason" => "Lecturer successfully added.", "pass" => $pass);
        endif;
        return array("result" => -2, "reason" => "Unable to add new Lecturer.");
    }

    private function sendEmail($password, $emal, $name) {
        $subject = "Student Attandance System";
        $message = "<h1>Dear {$name}</h1>";
        $message .= "<p>Welcome to Student Attandance System below are your login details:</p>";
        $message .= "<p>Username: {$emal}<br>Password:{$password}</p>";
        $email = new Email();
        $email->toEmail = $emal;
        $email->emailSubject = $subject;
        $email->emailBody = $message;
        if (!$email->sendLoginInfo()) {
            $this->error = $email->errorInfo;
            exit(0);
        }
        $this->error = $email->errorInfo;
    }

    public function update($staffid, $POST) {
        $POST["fullname"] = ucwords($POST["fullname"]);
        if (!filter_var($POST["email"], FILTER_VALIDATE_EMAIL)):
            return array("result" => -2, "reason" => "Invalid Email address");
        endif;
        if (!is_numeric($POST['phone']) || strlen($POST['phone']) != 11 || !filter_var($POST["phone"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^(080|091|090|070|081)+[0-9]{8}$/")))) {
            return array("result" => -3, "reason" => "Invalid Phone Number");
        }
        $checkUser = $this->db->selectSingleData("SELECT * FROM users WHERE email = '{$POST['email']}' AND userid != {$staffid}");

        if ($checkUser != null) {
            return array("result" => -4, "reason" => "Email address already taken.");
        }
        $checkUser1 = $this->db->selectSingleData("SELECT * FROM user WHERE phone = '{$POST['phone']}' AND userid != {$staffid}");

        if ($checkUser1 != null) {
            return array("result" => -5, "reason" => "Phone number already taken.");
        }

        if ($this->db->update("users", $POST, "userid = $staffid")):
            return array("result" => 1, "reason" => "Staff successfully updated.");
        endif;
        return array("result" => 2, "reason" => "Unable to update Staff.");
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
                $pass = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
                $password = Hash::create('sha256', $pass, HASH_PASSWORD_KEY);
                $staffInfo = array_merge(array("password" => $password), $POST);
                if ($this->db->insert("users", $staffInfo)):
                    $this->sendEmail($pass, $POST["email"], $POST["fullname"]);
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
                $jsonInvalid[] = array("email" => $res[1], "fullname" => ucwords($res[2]), "phone" => $res[3], "position" => $res[4], "reason" => "Required data is/are missing");
            elseif (!filter_var($res[1], FILTER_VALIDATE_EMAIL)):
                $jsonInvalid[] = array("email" => $res[1], "fullname" => ucwords($res[2]), "phone" => $res[3], "position" => $res[4], "reason" => "Invalid email address");
            elseif (!is_string($res[2])):
                $jsonInvalid[] = array("email" => $res[1], "fullname" => ucwords($res[2]), "phone" => $res[3], "position" => $res[4], "reason" => "Invalid staff name");
            elseif (strlen($res[3]) != 11 || !filter_var($res[3], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^(080|091|090|070|081)+[0-9]{8}$/")))):
                $jsonInvalid[] = array("email" => $res[1], "fullname" => ucwords($res[2]), "phone" => $res[3], "position" => $res[4], "reason" => "Invalid phone number");
            elseif ($this->emailExists($res[1])):
                $jsonInvalid[] = array("email" => $res[1], "fullname" => ucwords($res[2]), "phone" => $res[3], "position" => $res[4], "reason" => "Email address already exists");
            elseif ($this->phoneExists($res[3])):
                $jsonInvalid[] = array("email" => $res[1], "fullname" => ucwords($res[2]), "phone" => $res[3], "position" => $res[4], "reason" => "Phone number already exists");
            else:
                $jsonValid[] = array("email" => $res[1], "fullname" => ucwords($res[2]), "phone" => $res[3], "position" => $res[4]);
            endif;
        endforeach;
        $this->validData = $jsonValid;
        $this->invalidData = $jsonInvalid;
    }

    private function emailExists($email = "") {
        $check = $this->db->selectSingleData("SELECT * FROM users WHERE email = '{$email}'");
        return $check ? true : false;
    }

    private function phoneExists($phone = "") {
        $check = $this->db->selectSingleData("SELECT * FROM users WHERE phone = '{$phone}'");
        return $check ? true : false;
    }

    private function displayReport($saveErr = 0, $saveSuccess = 0) {
        $html = "<p><span class='text-success'>{$saveSuccess} record successfully imported</span></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>";
        $html .= "<p><span class='text-danger'>" . ($saveErr + count($this->invalidData)) . " record unsuccessful</span></p>";
        return $html;
    }

    private function htmlReport() {
        $html = '';
        if (count($this->invalidData) > 0):
            $html .= '<h6>Staff Upload Report</h6>
                <table class="table table-sm table-condensed"><thead><th>User</th><th>Error</th></thead><tbody>';
            foreach ($this->invalidData as $res):
                $html .= '<tr><td>' . $res["email"] . " :: " . $res["fullname"] . '</td><td>' . $res["reason"] . '</td></tr>';
            endforeach;
            $html .= '</tbody></table>';
        endif;
        return $html;
    }

}

class Email {

    public $toEmail = [];
    public $emailSubject;
    public $emailBody;
    public $emailAttach = [];
    public $errorInfo = '';

    public function sendLoginInfo() {
        $this->errorInfo = '';
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP(true);
        //$mail->CharSet = "UTF-8";
        $mail->Host = "localhost";
        //$mail->Host = "imap.gmail.com";
        $mail->SMTPDebug = 0;
        //$mail->Port = 465; //465 or 587
        $mail->Port = 25; //465 or 587
        //$mail->SMTPSecure = 'ssl';
        //$mail->SMTPAuth = true;
        //Authentication
        $mail->Username = "localhost";
        //$mail->Username = "jigbashio@gmail.com";
        //$mail->Password = "@Jiskit015";
        $mail->addAddress($this->toEmail);
        $mail->setFrom("no-reply@buksas.edu.ng", "Student Attendance System");
        $mail->isHTML(true);
        $mail->Subject = $this->emailSubject;
        $body = preg_replace('/\\\\/', '', $this->emailBody);
        $mail->msgHTML($body);
        $mail->isHTML(true);
        if (!$mail->send()):
            $this->errorInfo = $mail->ErrorInfo;
            return false;
        endif;
        return true;
    }

}
