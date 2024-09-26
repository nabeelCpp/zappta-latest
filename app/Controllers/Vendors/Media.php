<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\MediaModal;
use RuntimeException;

class Media extends BaseController
{
    public function index()
    {
        // $data['homeslider'] = (new SliderModel())->getAllResult();
        // return view('site/home',$data);
    }
    
    public function gallery()
    {
        $page = filtreData($this->request->getVar('page'));
        $data = (new MediaModal())->getAllResult($page);
        print json_encode($data);
    }

    public function upload()
    {
        try {
            if ($this->request->isAJAX())
            {
                if (
                    !isset($_FILES['file']['error']) ||
                    is_array($_FILES['file']['error'])
                ) {
                    throw new RuntimeException('Invalid parameters.');
                }

                switch ($_FILES['file']['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('No file sent.');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('Exceeded filesize limit.');
                    default:
                        throw new RuntimeException('Unknown errors.');
                }
                // $formDataRaw['csrf_token'] = csrf_hash();
                if ( $_FILES['file']['size'] != 0 ) {
                    $file = $this->request->getFile('file');
                    $newName = $file->getRandomName();
                    $dir = ROOTPATH . 'public/upload/products';
                    $file->move($dir,$newName);
                    $path = $dir.'/'.$newName;
                    imageThumb($path,$dir,$newName);
                    $media_id = (new MediaModal())->add(['images' => $newName , 'status' => 1 , 'store_id' => getVendorUserId()]);
                    $img_ext = explode('.',$newName);
                    echo json_encode([
                        'status' => 'ok',
                        'path' => $newName,
                        'id' => $media_id,
                        'small' => base_url().'/images/product/'.$img_ext[0].'/'.$img_ext[1].'/100',//getImageThumg('products',$newName,100),
                        'medium' => base_url().'/images/product/'.$img_ext[0].'/'.$img_ext[1].'/250',//getImageThumg('products',$newName,250),
                        'csrf_token' => csrf_hash()
                    ]);
                }
            }

        } catch (RuntimeException $e) {
            // Something went wrong, send the err message as JSON
            http_response_code(400);

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'csrf_token' => csrf_hash()
            ]);
        }
    }

    
}
