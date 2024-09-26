<?php

namespace App\Controllers\Admincp;

use App\Models\UsersModel;
use App\Models\ProfileModel;
class Users extends BaseController
{
	protected $add, $addintousers;

	

	 public function index(){  
    return view('admin/adminusers/index');

    }
    public function AddAdminUsers(){

    	if(isset($_POST['submit'])){
    		 $name = $_POST['name'];
    		 $email = $_POST['email'];
    		 $password = $_POST['password'];
    		 

		    $validation =
		    [
		        'name' => [
		            'rules'  => 'required',
		            'errors' => [
		                'required' => 'Name is required.',
		            ],
		        ],
		        'email' => [
		            'rules'  => 'required|valid_email|is_unique[users.email]',
		            'errors' => [
		            	'required'=> 'Email is required',
		                'valid_email' => 'Please check the Email field. It does not appear to be valid.',
		                'is_unique' => 'Email already exists'
		            ],
		        ],
		         'password' => [
		            'rules'  => 'required',
		            'errors' => [
		            	'required'=> 'password is required',
		               
		            ],
		        ],
		    ];

			if (! $this->validate($validation)) {
				$errors = $this->validator->getErrors();

		        session()->setFlashdata('errors', $errors);
		        return redirect()->back();
		    }

    		
    	        $this->add = new ProfileModel();
    		    $last_inserted_profile_id = $this->add->addAdminUsers($name);
    	        $this->addintousers = new UsersModel();
    		    $this->addintousers->AddUsers($name,$email,$password,$last_inserted_profile_id);
    		    session()->setFlashdata('success', 'User Created Successfully');
                 return redirect()->back();
    	    }



    	}

    }




