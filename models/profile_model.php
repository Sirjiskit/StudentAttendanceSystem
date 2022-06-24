<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profile_model
 *
 * @author Jiskit
 */
class profile_model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUserInfo($userId) {
        return $this->db->selectSingleData("SELECT * FROM users WHERE userid = $userId");
    }

    public function update($POST,$userId) {

        $info = $this->getUserInfo($userId);

        $checkUser = $this->db->selectSingleData("SELECT * FROM users WHERE email = '{$POST['email']}' AND userid != $userId");

        if ($checkUser != null) {
            return array("result" => -1, "reason" => "Email already taken.");
        }

        if (trim($POST['phone']) == "") {
            return array("result" => -2, "reason" => "Mobile Number cannot be empty");
        }

        if (!is_numeric($POST['phone']) || strlen($POST['phone']) != 11) {
            return array("result" => -3, "reason" => "Invalid Mobile Number");
        }

        if ($POST['image'] != "") {
            $ext = $this->getStringBetween($POST['image'], "data:image/", ";base64,");
            $image = str_replace("data:image/" . $ext . ";base64,", "", $POST['image']);
            $POST['image'] = $this->base64ToImageFile($image, $ext, UPLOAD_DIR . "user/");

            if ($info['image'] != "") {
                unlink(UPLOAD_DIR . "user/" . $info['image']);
            }

            Session::set('image', $POST['image']);
        } else {
            unset($POST['image']);
        }

        if ($POST['password'] != "") {
            $POST['password'] = Hash::create('sha256', $POST['password'], HASH_PASSWORD_KEY);
        } else {
            unset($POST['password']);
        }

        $this->db->update("users", $POST, "userid = $userId");

        Session::set('fullname', $POST['fullname']);

        return array("result" => 1, "reason" => "User successfully updated.");
    }

}
