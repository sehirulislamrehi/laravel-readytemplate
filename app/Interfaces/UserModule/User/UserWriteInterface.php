<?php

namespace App\Interfaces\UserModule\User;

interface UserWriteInterface{
    public function create($request);
    public function update($request, $user);
    public function reset_password($request, $user);
    public function update_profile($request, $user);
    public function change_my_password($request, $user);
}

?>