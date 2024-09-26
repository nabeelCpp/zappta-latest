<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\VendorDesignModel;
use App\Models\CategoriesModel;
use RuntimeException;

class Design extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Dashboard';
        $data['design'] = (new VendorDesignModel())->getVendorDesign();
        $data['getVendorCategory'] = (new CategoriesModel())->getVendorCategory();
        return view('vendors/design/index',$data);
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
                    $field = str_replace('.','_',filtreData($this->request->getVar('field')));
                    $newName = $file->getRandomName();
                    $dir = ROOTPATH . 'public/upload/media';
                    $file->move($dir,$newName);
                    $path = $dir.'/'.$newName;
                    imageThumb($path,$dir,$newName);
                    if ( (new VendorDesignModel())->getFeild($field) > 0 ) {
                        (new VendorDesignModel())->updatedata( $field , $newName, getVendorUserId());
                    }
                    $img_ext = explode('.',$newName);
                    echo json_encode([
                        'status' => 'ok',
                        'path' => $newName,
                        'medium' => base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/600',
                        // 'csrf_token' => csrf_hash()
                    ]);
                }
            }

        } catch (RuntimeException $e) {
            // Something went wrong, send the err message as JSON
            http_response_code(400);

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                // 'csrf_token' => csrf_hash()
            ]);
        }
    }

    public function status()
    {
        $selectblock = filtreData($this->request->getVar('selectblock'));
        $selectCat = filtreData($this->request->getVar('selectCat'));
        $selecttitle = filtreData($this->request->getVar('selecttitle'));
        $catetitle = filtreData($this->request->getVar('catetitle'));
        if ( (new VendorDesignModel())->getFeild($selectblock) > 0 ) {
            (new VendorDesignModel())->updatedata( $selectblock , $selectCat, getVendorUserId());
            (new VendorDesignModel())->updatedata( $selecttitle , $catetitle, getVendorUserId());
        }
        return json_encode([ 'status' => 'ok' ]);
    }    


}