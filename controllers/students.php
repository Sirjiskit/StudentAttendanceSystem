<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of students
 *
 * @author Jiskit
 */
class students extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }

    function index() {
        $this->view->customlibrary = array("students/js/index");
        $this->view->csslibrary = array('vendors/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min');
        $this->view->jslibrary = array('vendors/DataTables/DataTables-1.10.25/js/jquery.dataTables.min',
            'vendors/DataTables/DataTables-1.10.25/js/dataTables.bootstrap4', 'js/pages/ui-design');
        $this->view->menu = 'students';
        $this->view->title = 'Students';
        $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('students/index');
        $this->view->render('footer-bottom');
        $this->view->render('footer');
    }

    function view($studentId) {
        $this->view->student = $this->model->getStudentInfo($studentId);
        $this->view->render('students/view');
    }

    function new() {
        $this->view->render('students/add');
    }

    function tableLists() {
        if (Session::get('role') == "admin") {
            echo $this->model->getStudentsLists();
        } else {
            echo $this->model->getStaffStudentsLists(Session::get("userid"));
        }
    }

    function add() {
        echo json_encode($this->model->add($_POST));
    }

    function edit($studentId) {
        $this->view->student = $this->model->getStudentInfo($studentId);
        $this->view->render('students/edit');
    }

    function update($studentId) {
        echo json_encode($this->model->update($studentId, $_POST));
    }

    function attendance($studentId) {
        $staffid = Session::get("userid");
        $this->view->customlibrary = array("students/js/index");
        $this->view->csslibrary = array('vendors/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min');
        $this->view->jslibrary = array('vendors/DataTables/DataTables-1.10.25/js/jquery.dataTables.min',
            'vendors/DataTables/DataTables-1.10.25/js/dataTables.bootstrap4', 'js/pages/ui-design');
        if (Session::get('role') == "admin") {
            $this->view->studentInfo = $this->model->getStudentInfo($studentId);
            $this->view->attendances = $this->model->getAttendances($studentId);
            $this->view->student_class = $this->model->getSchedulesLists($studentId);
            $this->view->attended_class = $this->model->getStudentAttendancesByClass($studentId);
        } else {
            $this->view->studentInfo = $this->model->getStudentInfo($studentId);
            $this->view->attendances = $this->model->getAttendances($studentId);
            $this->view->student_class = $this->model->getSchedulesListsByStaff($studentId, $staffid);
            $this->view->attended_class = $this->model->getStudentAttendancesByClass($studentId);
        }
        $this->view->menu = 'students';
        $this->view->title = 'Student Attendance Statement';
        $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('students/attendance');
        $this->view->render('footer-bottom');
        $this->view->render('footer');
    }

    function printAttendance($studentId) {
        $this->view->studentInfo = $this->model->getStudentInfo($studentId);
        $this->view->attendances = $this->model->getAttendances($studentId);
        $this->view->student_class = $this->model->getSchedulesLists($studentId);
        $this->view->attended_class = $this->model->getStudentAttendancesByClass($studentId);
        //$this->view->orientation = "A4 landscape";
        $this->view->render('headerPrint');
        $this->view->render('students/printAttendance');
        $this->view->render('footerPrint');
    }

    function import() {
        $this->model->processStudentImport();
    }

    function updateRegNo() {
        $model = new Model();
        $list = $model->db->select("select * from student");
        foreach ($list as $row):
            $regNo = str_replace("CST/19/COM/", "TSU/FSC/CS/16/", $row["regNo"]);
            $model->db->update("student", array("regNo"=>$regNo),"studentid = {$row["studentid"]}");
        endforeach;
    }

}
