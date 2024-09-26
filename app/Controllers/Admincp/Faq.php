<?php

namespace App\Controllers\Admincp;

use App\Controllers\BaseController;
use App\Models\FaqHeadingModel;
use App\Models\FaqHeadingAnswerModel;

class Faq extends BaseController
{

	public function index()
	{
        $data['perm'] = perm('faq');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$data['sql'] = (new FaqHeadingModel())->getAllResult();
		return view( ADMINVIEW.'faq/index',$data);
	}

	public function add()
	{
        $data['perm'] = perm('faq');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		return view( ADMINVIEW . 'faq/add' );
	}

	public function insert()
	{
        $data['perm'] = perm('faq');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$postForm = $this->request->getPost();
		$name = $postForm['name'];
		if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/faq/add'); 
		}
		$post = [ 'lang_id' => 1 , 'type' => 1 , 'name' => $name ];
		$ids = (new FaqHeadingModel())->add($post);	
   		$this->session->setFlashdata('success', 'Entry Successfully Added');
		return redirect()->to('/admincp/faq');
	}

	public function edit()
	{
        $data['perm'] = perm('faq');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->editp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$ids = $this->request->getUri()->getSegment(4);
		$data['sql'] = (new FaqHeadingModel())->find(my_decrypt($ids));
		return view(ADMINVIEW.'faq/edit',$data);
	}

	public function update()
	{
        $data['perm'] = perm('faq');
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
			return redirect()->to('/admincp/faq/edit/'.$postForm['id']); 
		}
		$post = [ 'id' => $id, 'lang_id' => 1 , 'name' => $name ];
		(new FaqHeadingModel())->add($post);	 
   		$this->session->setFlashdata('success', 'Entry Successfully Updated');
		return redirect()->to('/admincp/faq');
	}

	public function delete()
	{
        $data['perm'] = perm('faq');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$ids = $this->request->getUri()->getSegment(4);
		(new FaqHeadingModel())->deleteRow(my_decrypt($ids));
   		$this->session->setFlashdata('success', 'Entry Deleted');
		return redirect()->to('/admincp/faq');
	}

	public function faqanswer()
	{
        $data['perm'] = perm('faq');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
		$data['faq_id'] = $this->request->getUri()->getSegment(4);
		$data['sql'] = (new FaqHeadingAnswerModel())->getAllResultById(my_decrypt($data['faq_id']));
		return view( ADMINVIEW.'faq/faqanswer',$data);
	}

	public function faqadd()
	{
		// if ( perm('faq')->addp == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$data['faq_id'] = $this->request->getUri()->getSegment(4);
		return view( ADMINVIEW . 'faq/faqadd',$data);
	}

	public function faqinsert()
	{
		// if ( perm('faq')->addp == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$postForm = $this->request->getPost();
		$faq_heading_id = $postForm['faq_heading_id'];
		$name = filtreDataText($postForm['short']);
		if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/faq/faqadd/'.$faq_heading_id); 
		}
		$post = [ 'faq_heading_id' => my_decrypt($faq_heading_id) , 'answer' => $name ];
		$ids = (new FaqHeadingAnswerModel())->add($post);	

   		$this->session->setFlashdata('success', 'Entry Successfully Added');
		return redirect()->to('/admincp/faq/faqanswer/'.$faq_heading_id);
	}

	public function faqedit()
	{
		// if ( perm('faq')->editp == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$data['faq_head_id'] = $this->request->getUri()->getSegment(4);
		$data['faq_id'] = $this->request->getUri()->getSegment(5);
		$data['sql'] = (new FaqHeadingAnswerModel())->find(my_decrypt($data['faq_head_id']));
		return view( ADMINVIEW . 'faq/faqedit',$data);
	}

	public function faqupdate()
	{
		// if ( perm('faq')->editp == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$postForm = $this->request->getPost();
		$faq_heading_id = $postForm['faq_heading_id'];
		$id = $postForm['id'];
		$name = filtreDataText($postForm['short']);
		if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/faq/faqedit/'.$id.'/'.$faq_heading_id); 
		}
		$post = [ 'id' => my_decrypt($id),'faq_heading_id' => my_decrypt($faq_heading_id) , 'answer' => $name ];
		(new FaqHeadingAnswerModel())->add($post);	

   		$this->session->setFlashdata('success', 'Entry Successfully Added');
		return redirect()->to('/admincp/faq/faqanswer/'.$faq_heading_id);
	}

	public function faqdelete()
	{
		// if ( perm('faq')->deletep == 0 ) {
		// 	return redirect()->to('/admincp/'); 
		// }
		$faq_ids = $this->request->getUri()->getSegment(5);
		$ids = $this->request->getUri()->getSegment(4);
		(new FaqHeadingAnswerModel())->deleteRow(my_decrypt($ids));
   		$this->session->setFlashdata('success', 'Entry Deleted');
		return redirect()->to('/admincp/faq/faqanswer/'.$faq_ids);
	}


}
