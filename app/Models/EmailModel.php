<?php 

namespace App\Models;

use CodeIgniter\Model; 

/**
 * 	Setting Model for update Setting
 */
class EmailModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'setting';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = ['var_name', 'var_detail'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

	

	public function getTheme()
	{
		return $this->where('var_name','THEME_SETTING')->first();
	}

    public function getThemeVar($theme_var)
    {
        $sql = $this->where('var_name',$theme_var)->first();
        if ( !empty($sql) ) {
            return $sql['var_detail'];
        }
    }

    private function smptHost()
    {
        return $this->getThemeVar('SMTPHost');
    }

    private function smptUser()
    {
        return $this->getThemeVar('SMTPUser');
    }

    private function smptPass()
    {
        return $this->getThemeVar('SMTPPass');
    }

    private function smptPort()
    {
        return $this->getThemeVar('SMTPPort');
    }

    private function smptEmail()
    {
        return $this->getThemeVar('EmailFrom');
    }

    private function smptEmailProtocols()
    {
        return $this->getThemeVar('SMTPprotocol');
    }

    private function smptCrypto()
    {
        return $this->getThemeVar('SMTPCrypto');
    }

    private function smptEmailUser()
    {
        return $this->getThemeVar('EmailUserName');
    }

    private function emailConfig($email)
    {
        $config['protocol'] = trim($this->smptEmailProtocols());
        $config['SMTPHost'] = $this->smptHost();
        $config['SMTPUser'] = $this->smptUser();
        $config['SMTPPass'] = $this->smptPass();
        $config['SMTPPort'] = $this->smptPort();
        $config['charset']  = 'iso-8859-1';
        $config['mailType']  = 'html';
        $config['SMTPCrypto']  = $this->smptCrypto();
        $config['wordWrap'] = true;
        $email->initialize($config);
    }

    public function sendMail($to,$subject,$template,$data=[])
    {
        $email = \Config\Services::email();
        $this->emailConfig($email);
        $email->setFrom($this->smptEmail(), $this->smptEmailUser());
        $email->setTo($to);
        $email->setSubject($subject);
        $message = view( 'email/'.$template.'',$data);
        $email->setMessage($message);
        $email->send();
        $email->clear(true);
        // print_r($email->printDebugger());
    }
public function SendEmailByAdmin($to,$subject,$data){
        $email = \Config\Services::email();
        $this->emailConfig($email);
        $email->setFrom($this->smptEmail(), $this->smptEmailUser());
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($data);
        $email->send();
        $email->clear(true);
        print_r($email->printDebugger());
        
}


}