<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\PagesModel;
use App\Models\ContactModel;
use App\Models\pagesfeedback;
use App\Models\EmailModel;
use App\Traits\ZapptaTrait;

class Pages extends BaseController
{
	use ZapptaTrait;
	protected $data ;
	protected $ContactModel;
	protected $pagesfeedback;
	
	public function __construct() {
		$this->data = [
			'assets_url' => ZapptaHelper::loadAssetsUrl(),
			'css' => ZapptaHelper::loadModifiedThemeCss(),
			'globalSettings' => ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo'])
		];
	}


	public function index()
	{
		$pages = new PagesModel();
		$data = $this->data;
		$data['url'] = $this->request->getUri()->getSegment(1);
		$data['page'] = $pages->getPageByUrl($data['url']);
		$tempid = $data['page']['tempid'];
		// switch ($tempid) {
		// 	case 2:
		// 			return view( 'site/pages/contact',$data);
		// 		break;

		// 	default:
		return view('site/pages/index', $data);
		// 		break;
		// }
	}
	public function contact_us()
	{
		$data = $this->data;
		return view('site/pages/contact-us', $data);
	}
	public function ajaxcontact()
	{
		$this->ContactModel = new ContactModel();
		if ($this->request->isAJAX()) {
			$name = filtreData($this->request->getVar('name'));
			$email = filtreData($this->request->getVar('email'));
			$message = filtreData($this->request->getVar('message'));
			echo $id = $this->ContactModel->AddContactDetails($name, $email, $message);
		}
	}

	public function PrivacyPolicy()
	{
		$data = $this->data;
		$data['url'] = $this->request->getUri()->getSegment(1);
		$data['page'] = ZapptaTrait::privacyPolicy();
		// print_r($data);
		return view('site/pages/privacypolicy', $data);
	}

	public function TermsAndConditions()
	{
		$data = $this->data;
		$pages = new PagesModel();
		$data['url'] = $this->request->getUri()->getSegment(1);
		$data['page'] = $pages->getPageByUrl($data['url']);
		// print_r($data);
		return view('site/pages/termsandconditions', $data);
	}

	public function ReturnPolicy()
	{
		$data = $this->data;
		$pages = new PagesModel();
		$data['url'] = $this->request->getUri()->getSegment(1);
		$data['page'] = $pages->getPageByUrl($data['url']);
		// print_r($data);
		return view('site/pages/returnpolicy', $data);
	}

	public function help()
	{
		$data = $this->data;
		$pages = new PagesModel();
		$data['url'] = $this->request->getUri()->getSegment(1);
		$data['page'] = $pages->getPageByUrl($data['url']);
		// print_r($data);
		return view('site/pages/help', $data);
	}

	public function PaymentMethod()
	{
		$data = $this->data;
		$pages = new PagesModel();
		$data['url'] = $this->request->getUri()->getSegment(1);
		$data['page'] = $pages->getPageByUrl($data['url']);
		// print_r($data);
		return view('site/pages/paymentmethods', $data);
	}

	// public function privacy()
	// {
	// $data['slider'] = (new SlidersModel())->getHomeSlider();
	// return view( theme().'index',$data);
	// }

	public function deletion()
	{
		// $data['slider'] = (new SlidersModel())->getHomeSlider();
		// return view( theme().'index',$data);
	}

	public function AddPagesFeedBack()
	{
		// $page_url = current_url();
		// $page_name = (explode("/",$page_url));
		$data = $this->data;
		$this->pagesfeedback = new pagesfeedback();
		if (isset($_POST['submit'])) {
			$value = $_POST['submit'];
			$page_name = $_POST['hiddenpage'];
			$id = $this->pagesfeedback->AddPagesFeedBack($page_name, $value);
			return view('site/pages/returnpolicy', $data);
		}
	}
	public function notificationpage()
	{
		$data = $this->data;
		return view('site/notification', $data);
	}
}
