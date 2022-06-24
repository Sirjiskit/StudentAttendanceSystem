<?php

class Login extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        header("location: " . URL);
    }

    function run() {
        $this->model->run();
    }

    function sendpassword() {
        $this->model->sendpassword();
    }

    function userAuthentication() {//userAuthentication
        echo json_encode($this->model->userAuthentication());
    }

    function authentication() {//userAuthentication
        echo json_encode($this->model->userAuthentication());
    }

    function loadStudents() {
        $search = "";
        $search = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);
        if (!$search):
            $search = "";
        endif;
        echo json_encode(array("result" => 1, "data" => $this->model->loadStudentsForVB($search)));
    }

    function loadStudentsInfo() {
        $id = (int) filter_input(INPUT_POST, "studentid", FILTER_SANITIZE_NUMBER_INT);
        echo json_encode(array("result" => 1, "data" => $this->model->getStudentInfo($id)));
    }

    function loadStudentsByClass() {
        $id = filter_input(INPUT_POST, "classid", FILTER_SANITIZE_STRING);
        echo json_encode(array("result" => 1, "data" => $this->model->loadStudentsByClass($id)));
    }

    function loadStudentsByRegNo() {
        $id = filter_input(INPUT_POST, "regNo", FILTER_SANITIZE_STRING);
        echo json_encode(array("result" => 1, "data" => $this->model->loadStudentsByRegNo($id)));
    }

    function deleteEnrolled() {
        $id = filter_input(INPUT_POST, "studentid", FILTER_SANITIZE_STRING);
        echo json_encode(array("result" => 1, "data" => $this->model->deleteEnrolled($id)));
    }

    function enrolled() {
        echo json_encode($this->model->enrolled($_POST));
    }

    function takeAttendance() {
        echo json_encode($this->model->takeAttendance($_POST));
    }

}
