<?php

namespace App\Controllers;

use App\Models\User;

class InstallController extends Controller {

    public function index() {
        $this->user();
        return "OK";
    }

    private function user() {
        $this->db;
        User::create([
            "name" => "admin",
            "avatar" => "/public/avatar-default.png",
            "username" => "admin",
            "password" => password_hash("admin", PASSWORD_BCRYPT),
        ]);
    }

}