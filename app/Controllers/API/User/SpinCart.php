<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\ZapptaTrait;
use CodeIgniter\HTTP\ResponseInterface;

class SpinCart extends BaseController
{
    use ZapptaTrait;
    public function addRemove()
    {
        $post = (array)request()->getVar();
        $method = request()->getMethod();
        $post['status'] = null;
        if($method == 'POST') {
            $post['status'] = 'add';
        }else {
            $post['status'] = 'remove';
        }
        $rules = [
            'com_id' => 'required',
            'store_id' => 'required',
            'pid' => 'required|is_numeric'
        ];
        $messages = [
            'com_id' => [
                'required' => 'Compaign id is required!',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $response = ZapptaTrait::addToSpreeTrait($post);
        return response()->setJSON($response);
    }

    public function getSprees() {
        $get = request()->getGet();
        if(isset($get->com_id) || isset($get->store_id)) {
            if(!isset($get->com_id) || !$get->com_id ) {
                $response = ZapptaHelper::response('Validation errors!', ['errors' => ['com_id' => 'Compaign id is required!']], 400);
                return response()->setJSON($response);
            }
            if(!isset($get->store_id) || !$get->store_id ) {
                $response = ZapptaHelper::response('Validation errors!', ['errors' => ['store_id' => 'Store id is required!']], 400);
                return response()->setJSON($response);
            }
        } 
        $data['sprees'] = ZapptaTrait::getSpreeOfLoggedInUser();
        $data['sprees'] = count($data['sprees']) ?  array_values($data['sprees']) : [];
        foreach ($data['sprees'] as $key => $spree) {
            if (isset($spree['stores'])) {
                $data['sprees'][$key]['stores'] = array_values($spree['stores']);
            }
        }
        // foreach ($data['sprees'] as $key => $value) {
        //     $data['sprees'][$key]['stores'] = array_values($data['sprees'][$key]['stores']);
        // }
        // $data['coupons'] = $db->table("coupons")->where(['user_id' => getUserId()])->get()->getResult();
        $response = ZapptaHelper::response('Sprees fetched successfully!', $data);
        return response()->setJSON($response);
    }

    public function getSpree() {
        
    }

    public function fetchSpree() {
        $post = request()->getVar();
        $rules = [
            'com_id' => 'required',
            'store_id' => 'required',
        ];
        $messages = [
            'com_id' => [
                'required' => 'Compaign id is required!',
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $resp = ZapptaTrait::spreeData($post->com_id, $post->store_id);
        if(count($resp['spree']) == 0) {
            if($resp['code'] == 200) {
                $msg = 'You have no items selected for spree.';
            }else if($resp['code'] == 404) {
                $msg = 'Spree not found!';
            }
            $response = ZapptaHelper::response($msg, [], $resp['code']);
            return response()->setJSON($response)->setStatusCode($resp['code']);
        }
        return response()->setJSON(ZapptaHelper::response('Spree fetched successfully!', ['game_url' => ZapptaTrait::generateGameUrl($post)]));
    }
}
