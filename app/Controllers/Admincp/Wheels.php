<?php

namespace App\Controllers\Admincp;

use App\Models\CompainModel;

class Wheels extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('wheel');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }

        $data['getWheels'] = (new CompainModel())->getWheels();
        return view('admin/wheels/index',$data);
    }    

    public function update()
    {
        $data['perm'] = perm('wheel');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }

        $box_first = $this->request->getVar('box_first');
        $box_second = $this->request->getVar('box_second');
        $box_third = $this->request->getVar('box_third');
        $box_fourth = $this->request->getVar('box_fourth');


        $box_points = $this->request->getVar('box_points');
        $box_points_second = $this->request->getVar('box_points_second');
        $box_points_third = $this->request->getVar('box_points_third');
        $box_points_fourth = $this->request->getVar('box_points_fourth');

        $next_first = !empty($this->request->getVar('next_first')) ? $this->request->getVar('next_first') : 0;
        $next_second = !empty($this->request->getVar('next_second')) ? $this->request->getVar('next_second') : 0;
        $next_third = !empty($this->request->getVar('next_third')) ? $this->request->getVar('next_third') : 0;

        if ( !empty($box_first) ) {
            (new CompainModel())->updateWheelData(1,$box_first);
            (new CompainModel())->updateWheelPointsData(1,$box_points);
            (new CompainModel())->updateWheelNextData(1,$next_first);
        }
        if ( !empty($box_second) ) {
            (new CompainModel())->updateWheelData(2,$box_second);
            (new CompainModel())->updateWheelPointsData(2,$box_points_second);
            (new CompainModel())->updateWheelNextData(2,$next_second);
        }
        if ( !empty($box_third) ) {
            (new CompainModel())->updateWheelData(3,$box_third);
            (new CompainModel())->updateWheelPointsData(3,$box_points_third);
            (new CompainModel())->updateWheelNextData(3,$next_third);
        }
        if ( !empty($box_fourth) ) {
            (new CompainModel())->updateWheelData(4,$box_fourth);
            (new CompainModel())->updateWheelPointsData(4,$box_points_fourth);
        }
        $this->session->setFlashdata('success','Wheels successfully Updated');
        return redirect()->to('/admincp/wheels');
    }    


}
