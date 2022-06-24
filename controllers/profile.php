<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profile
 *
 * @author Jiskit
 */
Session::init();
class profile extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }

    function index() {
        Session::init();
         $userId = Session::get('userid');
        $this->view->customlibrary = array("profile/js/index");
        $this->view->jslibrary = array('js/pages/ui-design');
        $this->view->user = $this->model->getUserInfo($userId);

        $this->view->menu = 'profile';
        $this->view->title = 'Profile';
         $this->view->render('header');
        $this->view->render('topbar');
        $this->view->render('sidebar');
        $this->view->render('profile/index');
        $this->view->render('footer-bottom');
        $this->view->render('footer');
    }

    function update() {
        
        $userId = Session::get('userid');
        echo json_encode($this->model->update($_POST,$userId));
    }

}
