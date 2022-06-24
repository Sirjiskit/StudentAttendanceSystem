<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author Jiskit
 */
class Model {

    //put your code here
    function __construct() {
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    function getSettings() {
        $info = $this->db->selectSingleData("SELECT * FROM settings");
        return $info;
    }

    function getCurrentAcademicYear() {
        $info = $this->getSettings();
        return $info ? $info["academicyear"] : null;
    }

    function getCurrentAcademicSemester() {
        $info = $this->getSettings();
        return $info ? $info["accademicsemester"] : null;
    }

    function fetchStaffDropdown() {
        return $this->db->select("SELECT userid id,fullname text FROM `users` WHERE position='lecturer' order by fullname asc");
    }

    function fetchCoursesDropdown() {
        return $this->db->select("SELECT courseId id,code text FROM `courses` WHERE semester = {$this->getCurrentAcademicSemester()} order by code asc");
    }

    function fetchCoursesAllocatedDropdown() {
        return $this->db->select("SELECT courseAllocationId id,CONCAT(code,' : ',fullname) text FROM `course_allocation` a JOIN courses c ON a.courseId = c.courseId "
                        . "JOIN users u ON a.staffid = u.userid  WHERE a.academicyear = '{$this->getCurrentAcademicYear()}' AND a.academicsemester = {$this->getCurrentAcademicSemester()} order by c.code asc");
    }

    public function fmtYear($year) {
        return ["Unknwon", "Part 1", "Part 2", "Part 3", "Part 4"][(int) $year];
    }

    function getStringBetween($string, $start, $end) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0)
            return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function base64ToImageFile($base64String, $ext, $uploadDirectory) {
        $filenamePath = md5(time() . uniqid()) . "." . $ext;
        $decoded = base64_decode($base64String);
        file_put_contents($uploadDirectory . "/" . $filenamePath, $decoded);

        return $filenamePath;
    }

}
