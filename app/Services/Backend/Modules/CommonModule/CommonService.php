<?php

namespace App\Services\Backend\Modules\CommonModule;

use App\Traits\FilePathTrait;
use DateTime;
use Illuminate\Support\Facades\Storage;

class CommonService
{
     use FilePathTrait;

     public function file_upload($file, $filename, $folder, $existing_filename = null)
     {
          $this->remove_file($folder,$existing_filename,"public");
          
          return $file->storeAs($folder, $filename, 'public');
     }

     public function get_image_link($filename = null, $type)
     {
          if ($filename == null) {
               return null;
          }
          $path = "$type/$filename";
          return Storage::url($path);
     }

     public function remove_file($folder,$filename,$type)
     {
          $existing_file_path = "{$type}/{$folder}/{$filename}";
          if( Storage::exists($existing_file_path) ){
               Storage::delete($existing_file_path);
          }
     }

     public function convert_two_date_to_second($start_date, $end_date)
     {
          //date format ("Y-m-d")
          $dateTime1 = new DateTime($start_date);
          $dateTime2 = new DateTime($end_date);
          $timestamp1 = $dateTime1->getTimestamp();
          $timestamp2 = $dateTime2->getTimestamp();
          return abs($timestamp2 - $timestamp1);
     }

     public function convert_second_to_hour_minute($seconds)
     {
          $hours = floor($seconds / 3600);
          $minutes = floor(($seconds % 3600) / 60);

          $time = sprintf('%02d:%02d', $hours, $minutes);

          return $time;
     }
}
