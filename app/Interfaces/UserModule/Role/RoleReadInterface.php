<?php

namespace App\Interfaces\UserModule\Role;

interface RoleReadInterface{
    public function get_all_role_data();
    public function get_active_role_data();
    public function role_datatable($roles);
    public function get_role_by_id($id);
}

?>