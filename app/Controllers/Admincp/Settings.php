<?php

namespace App\Controllers\Admincp;
use App\Models\Setting;

class Settings extends BaseController
{
    protected $setting;
    
    public function index()
    {
        $data['page'] = !empty($this->request->getVar('tabs')) ? $this->request->getVar('tabs') : 'profile';

        return view('admin/setting/index',$data);
    }    

    public function update()
    {
        $post = $this->request->getPost();
        if ( is_array($post) && count($post) > 0 ) {
            foreach( $post as $p => $k ) {
                if ( $p == 'ZAPTA_COMMISSION_STATUS' ) {
                    $ZAPTA_COMMISSION_STATUS = isset($post['ZAPTA_COMMISSION_STATUS']) ? $post['ZAPTA_COMMISSION_STATUS'] : 0;
                    (new \App\Models\Setting())->updateVar(filtreData($p),filtreData($ZAPTA_COMMISSION_STATUS));
                } else {
                    $ZAPTA_COMMISSION_STATUS = isset($post['ZAPTA_COMMISSION_STATUS']) ? $post['ZAPTA_COMMISSION_STATUS'] : 0;
                    if ( $ZAPTA_COMMISSION_STATUS == 0 ) {
                        (new \App\Models\Setting())->updateVar(filtreData('ZAPTA_COMMISSION_STATUS'),filtreData($ZAPTA_COMMISSION_STATUS));
                    }
                    (new \App\Models\Setting())->updateVar(filtreData($p),filtreData($k));
                }
            }
        }
        $this->session->setFlashdata('success','Setting Successfully Updated');
        return redirect()->to(ADMINURL.'settings/?tabs='.$post['_red']);
    }
    public function updateprofile(){
        if(isset($_POST['submit'])){
            $session = session();
            foreach($this->request->getFiles()['logo'] as $key => $file){
                if($file->getName()){
                    $validationRule = [
                         $key => [
                            'label' => "{$key} Logo",
                            'rules' => "is_image[logo.{$key}]"
                        ],
                    ];
                    if (! $this->validate($validationRule)) {
                        $session->setFlashdata('error', $this->validator->getErrors()[$key]);
                        return redirect()->back();
                    }


                    if (! $file->hasMoved()) {
                        $filepath =  ROOTPATH .'public/upload/logo/';
                        $filename = time().'_'.$file->getClientName();
                        $file->move($filepath, $filename);
                        $_POST[$key] = $filename;
                    }
                }
            }
            unset($_POST['submit']);
            $this->setting = new Setting();
            $this->setting->UpdateProfile($_POST);
            return redirect()->back();    
        }
    }
}
