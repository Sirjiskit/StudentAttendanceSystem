<?php

Session::init();

class Index extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (Session::get('loggedIn')):
            if (Session::get('role') == "admin") {
                $this->view->total_staff = $this->total_staff();
                $this->view->total_student = $this->total_student();
                $this->view->total_courses = $this->total_courses();
            } else {
                $this->view->total_student = $this->total_staff_student(Session::get("userid"));
                $this->view->total_courses = $this->total_staff_courses(Session::get("userid"));
                $this->view->total_staff = 0;
            }

            $this->view->menu = 'dashboard';
            $this->view->title = 'Dashboard';
            $this->view->render('header');
            $this->view->render('topbar');
            $this->view->render('sidebar');
            $this->view->render('index/index');
            $this->view->render('footer-bottom');
        else:
            $this->view->csslibrary = array('css/pages/auth');
            $this->view->title = 'Login Page';
            $this->view->render('header');
            $this->view->render('index/login');
        endif;

        $this->view->render('footer');
    }

    public function total_staff() {
        $model = new Model();
        $stmt = $model->db->select("SELECT * FROM users");
        return count($stmt);
    }

    public function total_student() {
        $model = new Model();
        return count($model->db->select("SELECT * FROM student"));
    }

    public function total_courses() {
        $model = new Model();
        return count($model->db->select("SELECT * FROM courses"));
    }

    public function total_staff_courses($staffid) {
        $model = new Model();
        $year = $model->getCurrentAcademicYear();
        $smes = $model->getCurrentAcademicSemester();
        return count($model->db->select("SELECT * FROM course_allocation WHERE staffid={$staffid} AND academicyear='{$year}' AND academicsemester={$smes}"));
    }

    public function total_staff_student($staffid) {
        $model = new Model();
        return count($model->db->select("SELECT s.studentid FROM student s JOIN course_registration a ON a.studentId = s.studentId "
                        . "JOIN registered_courses cr ON a.registrationId = cr.registrationId JOIN course_allocation ca ON cr.courseId = ca.courseId "
                        . "WHERE ca.staffid={$staffid} GROUP BY s.studentid"));
    }

}
