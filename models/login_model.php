<?php

error_reporting(E_ALL);

class Login_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        $sth = $this->db->prepare("SELECT * FROM users WHERE email = :email AND password = :password AND isdeleted = :isdeleted");
        $sth->execute(array(
            ':email' => $_POST['username'],
            ':password' => Hash::create('sha256', $_POST['password'], HASH_PASSWORD_KEY),
            ':isdeleted' => 0
        ));
        $data = $sth->fetch();

        $count = $sth->rowCount();
        $error = "";
        if ($count > 0) {
            Session::init();
            Session::set('loggedIn', true);
            Session::set('userid', $data['userid']);
            Session::set('fullname', $data['fullname']);
            Session::set('image', $data['image']);
            Session::set('role', $data['position']);
            //$this->saveLog("Logged In");
        } else {
            $error = "?hasError";
        }

        header("location: " . URL . $error);
    }

    private function sendEmail($password, $emal, $name) {
        $subject = "Student Attandance System";
        $message = "<h1>Dear {$name}</h1>";
        $message .= "<p>Your password reset successfully below is your new login details:</p>";
        $message .= "<p>Username: {$emal}<br>Password:{$password}</p>";
        $email = new SendEmail();
        $email->toEmail = $emal;
        $email->emailSubject = $subject;
        $email->emailBody = $message;
        if (!$email->sendLoginInfo()) {
            $this->error = $email->errorInfo;
            exit(0);
        }
        $this->error = $email->errorInfo;
    }

    public function sendpassword() {
        $sth = $this->db->prepare("SELECT * FROM users WHERE email = :email AND isdeleted = :isdeleted");
        $sth->execute(array(
            ':email' => $_POST['email'],
            ':isdeleted' => 0
        ));
        $data = $sth->fetch();
        $count = $sth->rowCount();
        $error = "";
        if ($count > 0) {
            $pass = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
            $password = Hash::create('sha256', $pass, HASH_PASSWORD_KEY);
            $dataArr = array("password" => $password);
            if ($this->db->update("users", $dataArr, "userid = {$data["userid"]}")):
                $this->sendEmail($pass, $data["email"], $data["fullname"]);
                $error = "staff/forgotpassword?hasSuccess";
            endif;
        } else {
            $error = "staff/forgotpassword?hasError";
        }

        header("location: " . URL . $error);
    }

    public function userAuthentication() {
        $sth = $this->db->prepare("SELECT  `userid` id, `email`, `fullname` name, `phone` FROM users WHERE email = :email AND password = :password AND isdeleted = :isdeleted");
        $sth->execute(array(':email' => $_POST['username'], ':password' => Hash::create('sha256', $_POST['password'], HASH_PASSWORD_KEY), ':isdeleted' => 0));
        $data = $sth->fetch();

        $count = $sth->rowCount();
        if ($count > 0) {
            return array("result" => 1701, "data" => $data);
        } else {
            return array("result" => -1, "reason" => "Invalid username or password contact your administrator");
        }
    }

    public function getClass($staffid) {
        $classAssigned = $this->db->select("SELECT l.*, c.code FROM course_allocation a JOIN classes l ON "
                . "a.courseAllocationId = l.courseAllocationId JOIN courses c ON c.courseId = a.courseId WHERE "
                . "l.date = '" . date('Y-m-d') . "' AND a.staffid = {$staffid}");

        //$json = array();
        foreach ($classAssigned as $row):
            if (strtotime($row["endTime"]) >= time() && strtotime($row["startTime"]) <= time()):
                return $row;
            endif;
        endforeach;
    }

    public function loadStudentsForVB($search) {
        return $this->db->select("SELECT * FROM student s WHERE NOT EXISTS (SELECT * FROM student_biometric b "
                        . "WHERE s.studentid = b.studentid) AND (s.regNo LIKE '%{$search}%' OR s.fullname LIKE '%{$search}%')");
    }

    public function getStudentInfo($studentId) {
        return $this->db->selectSingleData("SELECT * FROM student WHERE studentid = $studentId");
    }

    public function loadStudentsByClass($classId) {
        return $this->db->select("SELECT s.studentid,regNo,fullname FROM student s JOIN attendance a ON s.studentid = a.studentid WHERE classid={$classId}");
    }

    public function loadStudentsByRegNo($regNo) {
        return $this->db->selectSingleData("SELECT * FROM student WHERE regNo={$regNo}");
    }

    public function deleteEnrolled($studentId) {
        return $this->db->delete("student_biometric", "studentid = $studentId");
    }

    public function enrolled($POST) {
        $ext = "jpeg";
        $image = str_replace("data:image/" . $ext . ";base64,", "", $POST['image']);
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/StudentAttendanceSystem/public/uploads/biometric/";
        $POST['image'] = $this->base64ToImageFile($image, $ext, $uploadPath);
        if ($this->db->insert("student_biometric", $POST)):
            return array("result" => 1, "data" => true);
        endif;
        return array("result" => -1, "data" => false);
    }

    private final function getCourseIdByClassId($classId) {
        $row = $this->db->selectSingleData("SELECT a.courseId FROM `classes` cl JOIN course_allocation a "
                . "ON cl.courseAllocationId = a.courseAllocationId WHERE cl.classid={$classId}");
        return $row["courseId"];
    }

    private final function isStudentRegisteredTheCourse($courseId, $studentid) {
        $row = $this->db->selectSingleData("SELECT cr.studentId FROM `course_registration` cr JOIN registered_courses rc "
                . "ON cr.registrationId = rc.registrationId WHERE cr.studentId ={$studentid} AND rc.courseId={$courseId}");
        return $row ? true : false;
    }

    public function takeAttendance($POST) {
        $courseId = $this->getCourseIdByClassId($POST["classid"]);
        $check = $this->db->selectSingleData("SELECT * FROM attendance WHERE studentid={$POST["studentid"]} AND classid={$POST["classid"]}");
        if ($check):
            return array("result" => 1, "data" => " have already taken the attendance.");
        endif;
        if (!$this->isStudentRegisteredTheCourse($courseId, $POST["studentid"])):
            return array("result" => 1, "data" => " do not registered this course");
        endif;
        if ($this->db->insert("attendance", $POST)):
            return array("result" => 1, "data" => true, "res" => $POST);
        endif;
        return array("result" => 1, "data" => " failed to verified");
    }

    function base64_to_jpeg($base64_string, $output_file) {
        file_put_contents($output_file, $base64_string);
        return $output_file;
    }

}

class SendEmail {

    public $toEmail = [];
    public $emailSubject;
    public $emailBody;
    public $emailAttach = [];
    public $errorInfo = '';

    public function sendLoginInfo() {
        $this->errorInfo = '';
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP(true);
        $mail->Host = "localhost";
        $mail->SMTPDebug = 0;
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
