<?php

namespace App\Controllers\Admincp\Sliders;

use App\Controllers\Admincp\BaseController;
use App\Models\SliderModel;

class Homepage extends BaseController
{
    
    public function index()
    {
        $data['slider'] = (new SliderModel())->getAllResult();
        return view('admin/sliders/home/index',$data);
    }    

    public function add()
    {
        return view('admin/sliders/home/add');
    }

    public function insert()
    {
        if ( $_FILES['fimg']['size'] != 0 ) {
            $file = $this->request->getFile('fimg');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/slider';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'name' => $newName ];
            (new SliderModel())->add($post);
            cache()->delete('homeslider');
        }
        return redirect()->to(base_url().'admincp/sliders/homepage');
    }

    public function edit()
    {
        $data['id'] = $this->request->getUri()->getSegment(5);
        $data['file'] = $this->request->getVar('m');
        return view('admin/sliders/home/edit',$data);
    }

    public function update()
    {
        $id = $this->request->getVar('_id');
        if ( $_FILES['fimg']['size'] != 0 ) {
            $file = $this->request->getFile('fimg');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/slider';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $id , 'name' => $newName ];
            (new SliderModel())->add($post);
            cache()->delete('homeslider');
        }
        return redirect()->to(base_url().'admincp/sliders/homepage');
    }

    public function delete()
    {
        $id = $this->request->getUri()->getSegment(5);
        $file = $this->request->getVar('m');
        removeImage('slider',$file);
        (new SliderModel())->deleteR($id);
        cache()->delete('homeslider');
        return redirect()->to(base_url().'admincp/sliders/homepage');
    }

}
