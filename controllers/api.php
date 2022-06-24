<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api
 *
 * @author Jiskit
 */
class api extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function load($id) {
        $this->model->loadData($id);
    }

    function students($id) {
        $this->model->getLecturerStudentsLists($id);
    }

    function courses($id) {
        $this->model->getMyCourses($id);
    }

    function lectures($id) {
        $this->model->getLectures($id);
    }

    function printMopileReport($staffId, $courseId) {
        $data = array("lecturerId" => $staffId, "courseid" => $courseId);
        $this->view->orientation = "A4 portrait";
        $this->view->autoPrint = "No";
        $this->view->render('headerPrint');
        $this->view->data = $this->model->getData($data);
        $this->view->students = $this->model->getMobileAttendance($data);
        $this->view->lectures = $this->model->getLectureInfo($data);
        $this->view->render('attendance/printReport');
        $this->view->render('footerPrint');
    }

    function attendance($id) {
        $this->model->getAttendance($id);
    }

    function take_attendance() {
        $this->model->takeAttendance(filter_input_array(INPUT_POST));
    }

    function printReport($staffId, $courseId) {
        $data = array("staffid" => $staffId, "courseid" => $courseId);
        $this->view->orientation = "A4 portrait";
        $this->view->render('headerPrint');
        $this->view->data = $data;
        $this->view->students = $this->model->fetchAttendance($data);
        $this->view->class = $this->model->getStaffInfo($data);
        $this->view->render('attendance/printReport');
        $this->view->render('footerPrint');
    }

}
