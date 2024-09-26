<?php

namespace App\Controllers\Admincp;

use App\Controllers\BaseController;
use App\Models\TermsHeadingModel;
use App\Models\TermsHeadingAnswerModel;

class Terms extends BaseController
{

	public function index()
	{
        $data['perm'] = perm('terms');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp'); 
        }
		$data['sql'] = (new TermsHeadingModel())->getAllResult();
		return view( ADMINVIEW.'terms/index',$data);
	}

	public function add()
	{
        $data['perm'] = perm('terms');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp'); 
        }
		return view( ADMINVIEW . 'terms/add' );
	}

	public function insert()
	{
        $data['perm'] = perm('terms');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 ) {
                return redirect()->to('/admincp'); 
            }
            return redirect()->to('/admincp'); 
        }
		$postForm = $this->request->getPost();
		$name = $postForm['name'];
		if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/terms/add'); 
		}
		$post = [ 'lang_id' => 1 , 'type' => 2 , 'name' => $name ];
		$ids = (new TermsHeadingModel())->add($post);	
   		$this->session->setFlashdata('success', 'Entry Successfully Added');
		return redirect()->to('/admincp/terms');
	}

	public function edit()
	{
        $data['perm'] = perm('terms');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->editp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$ids = $this->request->getUri()->getSegment(4);
		$data['sql'] = (new TermsHeadingModel())->find(my_decrypt($ids));
		return view(ADMINVIEW.'terms/edit',$data);
	}

	public function update()
	{
        $data['perm'] = perm('terms');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->editp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$postForm = $this->request->getPost();
		$id = trim(strip_tags(my_decrypt($postForm['id'])));
		$name = $postForm['name'];

		if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/terms/edit/'.$postForm['id']); 
		}
		$post = [ 'id' => $id, 'lang_id' => 1 , 'name' => $name ];
		(new TermsHeadingModel())->add($post);	 
   		$this->session->setFlashdata('success', 'Entry Successfully Updated');
		return redirect()->to('/admincp/terms');
	}

	public function delete()
	{
        $data['perm'] = perm('terms');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$ids = $this->request->getUri()->getSegment(4);
		(new TermsHeadingModel())->deleteRow(my_decrypt($ids));
   		$this->session->setFlashdata('success', 'Entry Deleted');
		return redirect()->to('/admincp/terms');
	}

	public function faqanswer()
	{
        $data['perm'] = perm('terms');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$data['faq_id'] = $this->request->getUri()->getSegment(4);
		$data['sql'] = (new TermsHeadingAnswerModel())->getAllResultById(my_decrypt($data['faq_id']));
		return view( ADMINVIEW.'terms/faqanswer',$data);
	}

	public function faqadd()
	{
		// if ( perm('terms')->addp == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$data['faq_id'] = $this->request->getUri()->getSegment(4);
		return view( ADMINVIEW . 'terms/faqadd',$data);
	}

	public function faqinsert()
	{
		// if ( perm('terms')->addp == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$postForm = $this->request->getPost();
		$faq_heading_id = $postForm['faq_heading_id'];
		$name = filtreDataText($postForm['short']);
		if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/terms/faqadd/'.$faq_heading_id); 
		}
		$post = [ 'faq_heading_id' => my_decrypt($faq_heading_id) , 'answer' => $name ];
		$ids = (new TermsHeadingAnswerModel())->add($post);	

   		$this->session->setFlashdata('success', 'Entry Successfully Added');
		return redirect()->to('/admincp/terms/faqanswer/'.$faq_heading_id);
	}

	public function faqedit()
	{
		// if ( perm('terms')->editp == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$data['faq_head_id'] = $this->request->getUri()->getSegment(4);
		$data['faq_id'] = $this->request->getUri()->getSegment(5);
		$data['sql'] = (new TermsHeadingAnswerModel())->find(my_decrypt($data['faq_head_id']));
		return view( ADMINVIEW . 'terms/faqedit',$data);
	}

	public function faqupdate()
	{
		// if ( perm('terms')->editp == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$postForm = $this->request->getPost();
		$faq_heading_id = $postForm['faq_heading_id'];
		$id = $postForm['id'];
		$name = filtreDataText($postForm['short']);
		if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/terms/faqedit/'.$id.'/'.$faq_heading_id); 
		}
		$post = [ 'id' => my_decrypt($id),'faq_heading_id' => my_decrypt($faq_heading_id) , 'answer' => $name ];
		(new TermsHeadingAnswerModel())->add($post);	

   		$this->session->setFlashdata('success', 'Entry Successfully Added');
		return redirect()->to('/admincp/terms/faqanswer/'.$faq_heading_id);
	}

	public function faqdelete()
	{
		// if ( perm('terms')->deletep == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$faq_ids = $this->request->getUri()->getSegment(5);
		$ids = $this->request->getUri()->getSegment(4);
		(new TermsHeadingAnswerModel())->deleteRow(my_decrypt($ids));
   		$this->session->setFlashdata('success', 'Entry Deleted');
		return redirect()->to('/admincp/terms/faqanswer/'.$faq_ids);
	}


}
