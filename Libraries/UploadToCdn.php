<?php
namespace App\Libraries;

class UploadToCdn
{
    public function __construct()
    {
        require_once APPPATH . "/ThirdParty/cloudinary/src/Cloudinary.php";
        require_once APPPATH . "/ThirdParty/cloudinary/src/Uploader.php";
        require_once APPPATH . "/ThirdParty/cloudinary/src/Api.php";

        \Cloudinary::config(array(
            "cloud_name" => "dohbjk1wi",
            "api_key" => "224614396527733", 
            "api_secret" => "6UQ71AkiMusRypxOrvVSabfUFdE"
        ));
    }
    
    public function uploadToCloudNary($fileName , $folder){
        $cldImg = \Cloudinary\Uploader::upload(ROOTPATH.CLOUDNARY_UPLOADS_PATH.$fileName, ['folder' => $folder]);
        return $cldImg['secure_url'];
    }
    
}


?>