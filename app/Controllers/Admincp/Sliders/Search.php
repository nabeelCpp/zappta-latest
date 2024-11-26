<?php

namespace App\Controllers\Admincp\Sliders;

use App\Controllers\Admincp\BaseController;
use App\Models\SearchSliderModel;

class Search extends BaseController
{
    
    public function index()
    {
        $data['slider'] = (new SearchSliderModel())->getAllResult();
        return view('admin/sliders/search/index',$data);
    }

    public function add()
    {
        return view('admin/sliders/search/add');
    }

    public function insert()
    {
        $name = filtreData($this->request->getVar('name'));
        $post = [ 'name' => $name ];
        (new SearchSliderModel())->add($post);
        cache()->delete('cms_search_slider');
        return redirect()->to(base_url().'admincp/sliders/search');
    }

    public function edit()
    {
        $data['id'] = $this->request->getUri()->getSegment(5);
        $data['file'] = $this->request->getVar('m');
        return view('admin/sliders/search/edit',$data);
    }

    public function update()
    {
        $id = filtreData($this->request->getVar('_id'));
        $name = filtreData($this->request->getVar('name'));
        $post = [ 'id' => $id, 'name' => $name ];
        (new SearchSliderModel())->add($post);
        cache()->delete('cms_search_slider');
        return redirect()->to(base_url().'admincp/sliders/search');
    }

    public function delete()
    {
        $id = $this->request->getUri()->getSegment(5);
        (new SearchSliderModel())->deleteR($id);
        cache()->delete('cms_search_slider');
        return redirect()->to(base_url().'admincp/sliders/search');
    }

}
