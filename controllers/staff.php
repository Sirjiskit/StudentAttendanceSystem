<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Staff
 *
 * @author Jiskit
 */
Session::init();

class Staff extends Controller {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->customlibrary = array("staff/js/index");
        $this->view->csslibrary = array('vendors/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min');
        $this->view->jslibrary = array('vendors/DataTables/DataTables-1.10.25/js/jquery.dataTables.min',
            'vendors/DataTables/DataTables-1.10.25/js/dataTables.bootstrap4', 'js/pages/ui-design');
        $this->view->menu = 'staff';
        $this->view->submenu = '';
        $this->view->title = 'Staff';
        $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('staff/index');
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
        $data = $this->model->getStaffLists();
        $total = $this->model->total_staff();
        $json = array("draw" => $draw, "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        die(json_encode($json));
    }

    function edit($staffid) {
        $this->view->staff = $this->model->getStaffInfo($staffid);
        $this->view->render('staff/edit');
    }

    function update($staffid) {
        echo json_encode($this->model->update($staffid, $_POST));
    }

    function upload() {
        $this->view->render('staff/upload');
    }

    function import() {
        //$this->view->upload_report = $this->model->invalidData;
        $this->model->processImport();
    }

    function orderCol($orderCol) {
        switch ((int) $orderCol) {
            case 1: return "email";
            case 2: return "fullname";
            default: return "phone";
        }
    }

    function forgotpassword() {
        $this->view->csslibrary = array('css/pages/auth');
        $this->view->title = 'Forgot Password';
        $this->view->render('header');
        $this->view->render('index/forgotpassword');
        $this->view->render('footer');
    }

}
