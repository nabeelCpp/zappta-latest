<?php

namespace App\Controllers\Admincp;

use App\Models\ProfileModel;
use App\Models\ProfileRightModel;
use App\Models\PermissionModel;

class Profiles extends BaseController
{
    
    public function index()
    {
        $data['sql'] = (new ProfileModel())->getAllResult();
        return view('admin/profiles/index',$data);
    }    

    public function add()
    {
        return view('admin/profiles/add');
    }    

    public function insert()
    {
        $name_en = filtreData($this->request->getVar('name_en'));
        $id = filtreData($this->request->getVar('id'));
        if ( $name_en == "" ) {
            $this->session->setFlashdata('error','Please fill name');
            return redirect()->to('/admincp/profiles/add');
        }
        if ( $id == 0 ) {
            (new ProfileModel())->add(['name_en' => $name_en]);
        } else {
            (new ProfileModel())->add(['id' => $id,'name_en' => $name_en]);
        }
        $this->session->setFlashdata('success','Profile successfully added');
        return redirect()->to('/admincp/profiles');
    }    

    public function edit()
    {
        $data['sql'] = (new ProfileModel())->find(my_decrypt($this->request->getUri()->getSegment(4)));
        return view('admin/profiles/edit',$data);
    }    

    public function delete()
    {
        // if ( perm('profiles')->deletep == 0 ) {
        //     return redirect()->to('/admincp/'); 
        // }
        $ids = $this->request->getUri()->getSegment(4);
        (new ProfileModel())->deleteR(my_decrypt($ids));
        $this->session->setFlashdata('success', 'Profile successfully deleted');
        return redirect()->to('/admincp/profiles');
    }

    public function permissions()
    {
        $data['row_id'] = $this->request->getUri()->getSegment(4);
        $data['roles'] = (new ProfileRightModel())->getAllResult();
        $data['roletype'] = (new PermissionModel())->findProfileId(my_decrypt($data['row_id']));
        return view('admin/profiles/permissions',$data);
    }

    public function permission_update()
    {
        (new PermissionModel())->deleteRow(my_decrypt($this->request->getVar('hid')));
        $insert_id = my_decrypt($this->request->getVar('hid'));
        if( $insert_id != "" ) {
            foreach($_POST as $post => $also) {
                if($post == 'name' or $post == 'Submit' or $post == 'hid') {
                
                } else {
                    $insert = isset($also['addp']) ? $also['addp'] : '0';
                    $edit = isset($also['editp'])  ? $also['editp'] : '0';
                    $view = isset($also['view']) ? $also['view'] : '0';
                    $delete = isset($also['deletep']) ? $also['deletep'] : '0';
                    $viewall = isset($also['allview']) ? $also['allview'] : '0';
                    $role_data = array (
                        'pid' => $insert_id,
                        'pright' => $post,
                        'addp' => $insert,
                        'view' =>   $view,
                        'editp' =>  $edit,
                        'deletep' =>    $delete,
                        'allview' =>    $viewall,
                        'created' => date('Y-m-d')
                    );
                    (new PermissionModel())->add($role_data);
                }
            }
        } 
        $this->session->setFlashdata('success', 'Permissions successfully added.');
        return redirect()->to('/admincp/profiles/permissions/'.$this->request->getVar('hid'));
    }

}
