<?php

namespace App\Traits;


/**
 * Conatain some utility function to handel the response for api
 * @author Alimul-Mahfuz <alimulmahfuztushar@gamil.com>
 * @method mixed success() Handle success response
 * @method mixed error() Handle error response
 * @copyright 2023 MIS PRAN-RFL Group
 */
trait FilePathTrait
{

  //all are sotrage path
  protected function get_file_path($type)
  {
    if ($type === "profile") {
      return "profile";
    }
    if ($type === "task") {
      return "tasks";
    }
  }
}
