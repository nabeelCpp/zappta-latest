<?php

namespace App\Controllers;

class Images extends BaseController
{
    public function index()
    {
        $url = $this->request->getUri()->getSegments();
        switch ($url[1]) {
            case 'product':
                    $image = '/upload/products/'.$url[4].'-'.$url[4].'-'.$url[2].'.'.$url[3];
                    if ( file_exists( $_SERVER['DOCUMENT_ROOT'].$image ) ) {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$image;
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        echo file_get_contents($filepath);
                    } else {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].'/upload/img-not-found.jpg';
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        ob_end_clean();
                        echo file_get_contents($filepath);
                    }
                break;

            case 'media':
                    $image = '/upload/media/'.$url[4].'-'.$url[4].'-'.$url[2].'.'.$url[3];
                    if ( file_exists( $_SERVER['DOCUMENT_ROOT'].$image ) ) {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$image;
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        echo file_get_contents($filepath);
                    } else {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].'/upload/img-not-found.jpg';
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        ob_end_clean();
                        echo file_get_contents($filepath);
                    }
                break;
            
            case 'slider':
                    $image = '/upload/slider/'.$url[4].'-'.$url[4].'-'.$url[2].'.'.$url[3];
                    if ( file_exists( $_SERVER['DOCUMENT_ROOT'].$image ) ) {
                        if ( $url[4] == 1980 ) {
                            $images = '/upload/slider/'.$url[2].'.'.$url[3];
                            $filepath = $_SERVER['DOCUMENT_ROOT'].$images;
                            $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                            header('Content-type:' . $image_mime);
                            header("Content-Length: " . filesize($filepath));
                            ob_clean();
                            flush();
                            echo file_get_contents($filepath);
                        } else {
                            $filepath = $_SERVER['DOCUMENT_ROOT'].$image;
                            $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                            header('Content-type:' . $image_mime);
                            header("Content-Length: " . filesize($filepath));
                            ob_clean();
                            flush();
                            echo file_get_contents($filepath);
                        }
                    } else {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].'/upload/img-not-found.jpg';
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        ob_end_clean();
                        echo file_get_contents($filepath);
                    }
                break;

            default:

                break;
        }
    }
    
    public function fullpath()
    {
        $url = $this->request->getUri()->getSegments();
        switch ($url[1]) {
            case 'full':
                    $image = '/upload/media/'.$url[2].'.'.$url[3];
                    if ( file_exists( $_SERVER['DOCUMENT_ROOT'].$image ) ) {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$image;
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        echo file_get_contents($filepath);
                    } else {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].'/upload/img-not-found.jpg';
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        ob_end_clean();
                        echo file_get_contents($filepath);
                    }
                break;            
            default:
                break;
        }
    }
    
}
