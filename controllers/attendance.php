<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of attendance
 *
 * @author Jiskit
 */
class attendance extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }

    function index() {
        $this->view->customlibrary = array("attendance/js/index");
        $this->view->csslibrary = array('vendors/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min');
        $this->view->jslibrary = array('vendors/DataTables/DataTables-1.10.25/js/jquery.dataTables.min', 'vendors/DataTables/DataTables-1.10.25/js/dataTables.bootstrap4', 'js/pages/ui-design');
        $this->view->menu = 'attendance';
        $this->view->submenu = 'class';
        $this->view->title = 'Class Scheduled';
        $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('attendance/index');
        $this->view->render('footer-bottom');
        $this->view->render('footer');
    }

    function new() {
        if (Session::get('role') == "admin") {
            $this->view->dropDownAllocation = $this->model->dropDownAllocation();
        } else {
            $this->view->dropDownAllocation = $this->model->dropDownStaffClass(Session::get('userid'));
        }
        $this->view->render('attendance/add');
    }

    function add() {
        echo json_encode($this->model->add($_POST));
    }

    function tableLists() {
        if (Session::get('role') == "admin") {
            echo $this->model->getClassLists();
        } else {
            echo $this->model->getClassByStaffLists(Session::get('userid'));
        }
    }

    function report() {
        if (Session::get('role') == "admin") {
            $this->view->courses = $this->model->getCourses();
        } else {
            $this->view->courses = $this->model->getStaffCourses(Session::get('userid'));
        }

        $this->view->currentSY = $this->model->getCurrentAcademicYear();
        $this->view->academicyear = $this->model->getCurrentAcademicYear();
        $this->view->menu = 'attendance';
        $this->view->submenu = 'report';
        $this->view->title = 'General report';
        $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('attendance/report');
        $this->view->render('footer-bottom');
        $this->view->render('footer');
    }

    function edit($classid) {
        if (Session::get('role') == "admin") {
            $this->view->dropDownAllocation = $this->model->dropDownAllocation();
        } else {
            $this->view->dropDownAllocation = $this->model->dropDownStaffClass(Session::get('userid'));
        }
        $this->view->class = $this->model->getClassInfo($classid);
        $this->view->render('attendance/edit');
    }

    function update($classid) {
        echo json_encode($this->model->update($classid, $_POST));
    }

    function printReport() {
        $this->view->orientation = "A4 portrait";
        $this->view->render('headerPrint');
        $this->view->data = $_POST;
        $this->view->students = $this->model->getAttendance($_POST);
        $this->view->class = $this->model->getStaffInfo($_POST);
        $this->view->render('attendance/printReport');
        $this->view->render('footerPrint');
    }

}
