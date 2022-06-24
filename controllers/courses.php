<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of courses
 *
 * @author Jiskit
 */
Session::init();

class courses extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->customlibrary = array("courses/js/index");
        $this->view->csslibrary = array('vendors/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min');
        $this->view->jslibrary = array('vendors/DataTables/DataTables-1.10.25/js/jquery.dataTables.min',
            'vendors/DataTables/DataTables-1.10.25/js/dataTables.bootstrap4', 'js/pages/ui-design');
        $this->view->menu = 'courses';
        $this->view->submenu = 'list';
        $this->view->title = 'Courses List';
        $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('courses/index');
        $this->view->render('footer-bottom');
        $this->view->render('footer');
    }

    function assigned() {
        $this->view->customlibrary = array("courses/js/assigned");
        $this->view->csslibrary = array('vendors/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min');
        $this->view->jslibrary = array('vendors/DataTables/DataTables-1.10.25/js/jquery.dataTables.min',
            'vendors/DataTables/DataTables-1.10.25/js/dataTables.bootstrap4', 'js/pages/ui-design');
        $this->view->menu = 'courses';
        $this->view->submenu = 'assigned';
        $this->view->title = 'Current Semester Assigned Courses';
        $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('courses/assigned');
        $this->view->render('footer-bottom');
        $this->view->render('footer');
    }

    function tableLists() {
        $start = (int) filter_input(INPUT_POST, "start", FILTER_SANITIZE_NUMBER_INT, 0);
        $draw = (int) filter_input(INPUT_POST, "draw", FILTER_SANITIZE_NUMBER_INT, 1);
        $length = (int) filter_input(INPUT_POST, "length", FILTER_SANITIZE_NUMBER_INT, 10);
        $arr = (array) filter_input_array(INPUT_POST);
        $search = (string) filter_var($arr["search"]["value"], FILTER_SANITIZE_STRING, '');
        $orderCol = (int) filter_var($arr["order"][0]["column"], FILTER_SANITIZE_NUMBER_INT, 1);
        $orderDir = (string) filter_var($arr["order"][0]["dir"], FILTER_SANITIZE_STRING, '');
        $this->model->limit = $length;
        $this->model->start = $start;
        $this->model->search = '%' . $search . '%';
        $this->model->oCol = $this->orderCol($orderCol);
        $this->model->oDir = $orderDir;
        $data = array();
        $total = 0;
        if (Session::get('role') == "admin"):
            $data = $this->model->getCoursesList();
            $total = $this->model->total_courses();
        else:
            $staffid = Session::get('userid');
            $data = $this->model->getCoursesByStaffList($staffid);
            $total = $this->model->total_coursesByStaffid($staffid);
        endif;

        $json = array("draw" => $draw, "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        die(json_encode($json));
    }

    function edit($courseId) {
        $this->view->course = $this->model->getCoursesInfo($courseId);
        $this->view->render('courses/edit');
    }

    function upload() {
        $this->view->render('courses/upload');
    }

    function import() {
        //$this->view->upload_report = $this->model->invalidData;
        $this->model->processImport();
    }

    function update($courseId) {
        echo json_encode($this->model->update($courseId, $_POST));
    }

    function assignedtableLists() {
        $start = (int) filter_input(INPUT_POST, "start", FILTER_SANITIZE_NUMBER_INT, 0);
        $draw = (int) filter_input(INPUT_POST, "draw", FILTER_SANITIZE_NUMBER_INT, 1);
        $length = (int) filter_input(INPUT_POST, "length", FILTER_SANITIZE_NUMBER_INT, 10);
        $arr = (array) filter_input_array(INPUT_POST);
        $search = (string) filter_var($arr["search"]["value"], FILTER_SANITIZE_STRING, '');
        $orderCol = (int) filter_var($arr["order"][0]["column"], FILTER_SANITIZE_NUMBER_INT, 1);
        $orderDir = (string) filter_var($arr["order"][0]["dir"], FILTER_SANITIZE_STRING, '');
        $this->model->limit = $length;
        $this->model->start = $start;
        $this->model->search = '%' . $search . '%';
        $this->model->oCol = $this->orderCol2($orderCol);
        $this->model->oDir = $orderDir;
        $data = $this->model->getAssignedList();
        $total = $this->model->total_assigned();
        $json = array("draw" => $draw, "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        die(json_encode($json));
    }

    function assignNew() {
        $this->view->dropDownCourses = $this->model->dropDownCourses();
        $this->view->dropDownStaff = $this->model->dropDownStaff();
        $this->view->render('courses/assignNew');
    }

    function allocate() {
        echo json_encode($this->model->allocate($_POST));
    }

    function assignededit($courseAllocationId) {
        $this->view->dropDownCourses = $this->model->dropDownCourses();
        $this->view->dropDownStaff = $this->model->dropDownStaff();
        $this->view->assigned = $this->model->getAssignedInfo($courseAllocationId);
        $this->view->render('courses/assignededit');
    }

    function assignedupdate($courseAllocationId) {
        echo json_encode($this->model->assigned_update($courseAllocationId, $_POST));
    }

    function registered() {
        $this->view->customlibrary = array("courses/js/registered");
        $this->view->csslibrary = array('vendors/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min');
        $this->view->jslibrary = array('vendors/DataTables/DataTables-1.10.25/js/jquery.dataTables.min',
            'vendors/DataTables/DataTables-1.10.25/js/dataTables.bootstrap4', 'js/pages/ui-design');
        $this->view->menu = 'courses';
        $this->view->submenu = 'registered';
        $this->view->title = 'Students Registered Courses';
        $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('courses/registered');
        $this->view->render('footer-bottom');
        $this->view->render('footer');
    }

    function registeredTableLists() {
        echo $this->model->getRegistration_list();
    }

    function new() {
        $this->view->render('courses/new');
    }

    function add() {
        $this->model->processCourseImport();
    }

    function orderCol($orderCol) {
        switch ((int) $orderCol) {
            case 1: return "code";
            case 2: return "title";
            default: return "title";
        }
    }

    function orderCol2($orderCol) {
        switch ((int) $orderCol) {
            case 1: return "c.code";
            case 2: return "u.fullname";
            default: return "c.level";
        }
    }

}
