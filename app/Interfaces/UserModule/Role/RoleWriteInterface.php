<?php

namespace App\Interfaces\UserModule\Role;

interface RoleWriteInterface{
    public function create($request);
    public function update($request, $id);
}

?>