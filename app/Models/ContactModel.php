<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'contact';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'name',
										'email',
										'message','read'
									];


	public function AddContactDetails($name,$email,$message)
	{
	    $data = ['name'=>$name ,'email'=>$email ,'message'=>$message];
		$this->save($data);
        return $this->getInsertID();
	}
	public function GetMessagesOfUsers(){
		        $sql = $this->db->table('contact pq')
        				->select('pq.*')
             		    ->get()
        				->getResultArray();
        return $sql;
	}
	public function  GetMessageofspecificusers($id){
		  $sql = $this->db->table('contact pq')
        				->select('pq.*')
        				->where('pq.id',$id )
             		    ->get()
        				->getResultArray();
        return $sql;

	}
	  public function deleteA($id)
    {
        return $this->where('id',$id)->delete();
    }

    

}
