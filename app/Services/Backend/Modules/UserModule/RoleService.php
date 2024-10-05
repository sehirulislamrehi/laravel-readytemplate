<?php

namespace App\Services\Backend\Modules\UserModule;

use App\Models\UserModule\Module;
use Exception;

class RoleService
{
    public function get_modules_for_role()
    {
        try {
            if (can("roles")) {
                return Module::orderBy("position", "asc")
                    ->select("id", "name", "key")
                    ->with("permission")
                    ->get();
            } else {
                throw new Exception("Unauthorized access.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

?>