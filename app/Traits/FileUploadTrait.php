<?php

namespace App\Traits;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Contain file upload related function
 * @author Alimul-Mahfuz <alimulmahfuztushar@gmail.com>
 * @method string upload_file()
 * @method string update_file()
 * @copyright 2023 MIS PRAN-RFL Group
 */
trait FileUploadTrait
{

    /**
     * To upload file inside your storage's public folder. This will check if the given file is exists in the storage of given folder. If exits then it will
     * delete it otherwise it will save the file and return the path
     * @param UploadedFile $uploadfile the actual file instance
     * @param string $foldername the folder name, where the file should be saved under storage folder
     * @return string return the saved path of the file
     */
    protected function upload_file(UploadedFile $uploadfile, string $foldername):string
    {
        $path = null;
        if ($uploadfile) {
        $file = $uploadfile;
        $ext = $file->getClientOriginalExtension();
        $newfilename = time() . '.' . $ext;
        $file->storeAs("public/$foldername", $newfilename);
        $path = "$foldername/" . $newfilename;
        }
        return $path;
    }

    /**
     * Handel the update of file. Delete the previous file if exits any.
     *
     * @param mixed $existing_path
     * @param mixed $newfile
     * @param string $foldername
     * @return string
     */
    protected function update_file(string $existing_path, UploadedFile $newfile,string $foldername):string
    {
        if(Storage::exists('public/'.$existing_path)){
            Storage::delete('public/'.$existing_path);
        }
        return $this->upload_file($newfile,$foldername);
    }
}
