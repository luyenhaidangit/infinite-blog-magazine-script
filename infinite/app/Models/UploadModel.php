<?php namespace App\Models;

require_once APPPATH . 'ThirdParty/intervention-image/vendor/autoload.php';
require_once APPPATH . "ThirdParty/webp-convert/vendor/autoload.php";

use CodeIgniter\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use WebPConvert\WebPConvert;


class UploadModel extends BaseModel
{
    protected $jpgQuality;
    protected $webpQuality;

    public function __construct()
    {
        parent::__construct();
        $this->jpgQuality = 85;
        $this->webpQuality = 80;
        $this->imgExt = '.jpg';
        if ($this->generalSettings->image_file_format == 'PNG') {
            $this->imgExt = '.png';
        }
        if ($this->generalSettings->image_file_format == 'WEBP') {
            //do not compress JPG image if it will be converted to WEBP
            $this->jpgQuality = 100;
        }
    }

    //upload file
    public function upload($inputName, $directory, $namePrefix, $allowedExtensions = null, $keepOrjName = false)
    {
        if ($allowedExtensions != null && is_array($allowedExtensions) && !empty($allowedExtensions[0])) {
            if (!$this->checkAllowedFileTypes($inputName, $allowedExtensions)) {
                return null;
            }
        }
        $file = $this->request->getFile($inputName);
        if (!empty($file) && !empty($file->getName())) {
            $orjName = $file->getName();
            $ext = $this->getFileExtension($file->getName());
            $newName = $namePrefix . generateToken(true) . '.' . $ext;
            if ($keepOrjName == true) {
                if (file_exists(FCPATH . $directory . '/' . $orjName)) {
                    $orjName = pathinfo($orjName, PATHINFO_FILENAME) . '-' . uniqid() . '.' . pathinfo($orjName, PATHINFO_EXTENSION);
                }
                $newName = $orjName;
            }
            $path = $directory . $newName;
            if (!$file->hasMoved()) {
                if ($file->move(FCPATH . $directory, $newName)) {
                    return ['name' => $newName, 'orj_name' => $orjName, 'path' => $path, 'ext' => $ext];
                }
            }
        }
        return null;
    }

    //upload temp image
    public function uploadTempImage($inputName)
    {
        return $this->upload($inputName, "uploads/temp/", "img_temp_", ['jpg', 'jpeg', 'webp', 'png', 'gif']);
    }

    //upload temp file
    public function uploadTempFile($inputName)
    {
        return $this->upload($inputName, "uploads/temp/", "file_temp_");
    }

    //upload file
    public function uploadFile($inputName)
    {
        $extArray = @explode(',', $this->generalSettings->allowed_file_extensions ?? '');
        return $this->upload($inputName, "uploads/files/", "file_", $extArray);
    }

    //post gif image upload
    public function postGifImageupload($fileName)
    {
        $directory = $this->createUploadDirectory('images');
        rename(FCPATH . 'uploads/temp/' . $fileName, FCPATH . 'uploads/images/' . $directory . $fileName);
        return 'uploads/images/' . $directory . $fileName;
    }

    //upload post image
    public function uploadPostImage($tempPath, $type)
    {
        $img = Image::make($tempPath)->orientate();
        $name = '';
        if ($type == 'big') {
            $name = 'image_750x_';
            $img->resize(750, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } elseif ($type == 'mid') {
            $name = 'image_750x415_';
            $img->fit(750, 415);
        } elseif ($type == 'slider') {
            $name = 'image_650x434_';
            $img->fit(650, 434);
        } elseif ($type == 'small') {
            $name = 'image_100x75_';
            $img->fit(100, 75);
        }
        if ($this->getFileExtension($tempPath) == 'webp') {
            $this->jpgQuality = 100;
        }
        $newPath = 'uploads/images/' . $this->createUploadDirectory('images') . $name . uniqid();
        $img->save(FCPATH . $newPath . $this->imgExt, $this->jpgQuality);
        return $this->convertImageFormat($newPath);
    }

    //gallery image upload
    public function uploadGalleryImage($tempPath, $width)
    {
        $newPath = 'uploads/gallery/' . $this->createUploadDirectory('gallery') . 'image_' . $width . 'x_' . uniqid();
        $img = Image::make($tempPath)->orientate();
        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(FCPATH . $newPath . $this->imgExt, 100);
        return $this->convertImageFormat($newPath);
    }

    //gallery gif image upload
    public function galleryGifImageUpload($file_name)
    {
        $directory = $this->createUploadDirectory('gallery');
        rename(FCPATH . 'uploads/temp/' . $file_name, FCPATH . 'uploads/gallery/' . $directory . $file_name);
        return 'uploads/gallery/' . $directory . $file_name;
    }

    //logo upload
    public function uploadLogo($inputName)
    {
        return $this->upload($inputName, "uploads/logo/", "logo_", ['jpg', 'jpeg', 'webp', 'png', 'gif']);
    }

    //favicon upload
    public function uploadFavicon()
    {
        return $this->upload("favicon", "uploads/logo/", "favicon_", ['jpg', 'jpeg', 'webp', 'png', 'gif']);
    }

    //avatar image upload
    public function uploadAvatar($userId, $path)
    {
        $directory = $this->createUploadDirectory('profile');
        $newPath = 'uploads/profile/' . $directory . 'avatar_' . $userId . '_' . uniqid();
        $img = Image::make($path)->orientate()->fit(240, 240)->save(FCPATH . $newPath . $this->imgExt, 100);
        return $this->convertImageFormat($newPath);
    }

    //ad upload
    public function adUpload($inputName)
    {
        return $this->upload($inputName, "uploads/blocks/", "block_", ['jpg', 'jpeg', 'webp', 'png', 'gif']);
    }

    //convert image format
    public function convertImageFormat($sourcePath)
    {
        if ($this->generalSettings->image_file_format == 'WEBP') {
            WebPConvert::convert($sourcePath . $this->imgExt, $sourcePath . '.webp', ['quality' => $this->webpQuality]);
            @unlink($sourcePath . $this->imgExt);
            return $sourcePath . '.webp';
        }
        return $sourcePath . $this->imgExt;
    }

    //get file original name
    public function getFileOriginalName($path)
    {
        if (!empty($path)) {
            return pathinfo($path, PATHINFO_FILENAME);
        }
        return '';
    }

    //create file name by extension
    public function createFileNameByExt($name, $ext)
    {
        if (empty($name)) {
            return 'file.jpg';
        }
        if (empty($ext)) {
            $ext = 'jpg';
        }
        return pathinfo($name, PATHINFO_FILENAME) . '.' . $ext;
    }

    //delete temp file
    public function deleteTempFile($path)
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    //create upload directory
    public function createUploadDirectory($folder)
    {
        $directory = date("Ym");
        $directory_path = FCPATH . 'uploads/' . $folder . '/' . $directory . '/';

        //If the directory doesn't already exists.
        if (!is_dir($directory_path)) {
            //Create directory.
            @mkdir($directory_path, 0755, true);
        }
        //add index.html if does not exist
        if (!file_exists($directory_path . "index.html")) {
            @copy(FCPATH . "uploads/index.html", $directory_path . "index.html");
        }
        return $directory . "/";
    }

    //check allowed file types
    public function checkAllowedFileTypes($fileName, $allowedTypes)
    {
        if (!isset($_FILES[$fileName])) {
            return false;
        }
        if (empty($_FILES[$fileName]['name'])) {
            return false;
        }

        $ext = pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION);
        $ext = strtolower($ext ?? '');

        $extArray = array();
        if (!empty($allowedTypes) && is_array($allowedTypes)) {
            foreach ($allowedTypes as $item) {
                $item = trim($item ?? '', '"');
                $item = trim($item ?? '', "'");
                array_push($extArray, $item);
            }
        }
        if (!empty($extArray) && in_array($ext, $extArray)) {
            return true;
        }
        return false;
    }

    //check allowed file types
    public function getFileExtension($name)
    {
        $ext = "";
        if (!empty($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $ext = strtolower($ext ?? '');
        }
        return $ext;
    }
}
