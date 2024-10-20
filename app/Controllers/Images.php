<?php

namespace App\Controllers;

class Images extends BaseController
{
    private $public = '/public';
    // private $public = '';
    public function index()
    {
        
        $url = $this->request->getUri()->getSegments();
        switch ($url[1]) {
            case 'product':
                    $image = $this->public.'/upload/products/'.$url[4].'-'.$url[4].'-'.$url[2].'.'.$url[3];
                    if ( file_exists( $_SERVER['DOCUMENT_ROOT'].$image ) ) {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$image;
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        echo file_get_contents($filepath);
                    } else {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$this->public.'/upload/img-not-found.jpg';
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
                    $image = $this->public.'/upload/media/'.$url[4].'-'.$url[4].'-'.$url[2].'.'.$url[3];
                    if ( file_exists( $_SERVER['DOCUMENT_ROOT'].$image ) ) {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$image;
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        echo file_get_contents($filepath);
                    } else {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$this->public.'/upload/img-not-found.jpg';
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
                    $image = $this->public.'/upload/slider/'.$url[4].'-'.$url[4].'-'.$url[2].'.'.$url[3];
                    if ( file_exists( $_SERVER['DOCUMENT_ROOT'].$image ) ) {
                        if ( $url[4] == 1980 ) {
                            $images = $this->public.'/upload/slider/'.$url[2].'.'.$url[3];
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
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$this->public.'/upload/img-not-found.jpg';
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
                    $image = $this->public.'/upload/media/'.$url[2].'.'.$url[3];
                    if ( file_exists( $_SERVER['DOCUMENT_ROOT'].$image ) ) {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$image;
                        $image_mime = image_type_to_mime_type(exif_imagetype($filepath));
                        header('Content-type:' . $image_mime);
                        header("Content-Length: " . filesize($filepath));
                        ob_clean();
                        flush();
                        echo file_get_contents($filepath);
                    } else {
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$this->public.'/upload/img-not-found.jpg';
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
