<?php

namespace App\Interfaces\UserModule\User;

interface UserReadInterface{
    public function get_all_user_data();
    public function get_active_user_data();
    public function user_datatable($user);
    public function get_user_by_id($id);
    public function get_user_by_email($email);
}

?>