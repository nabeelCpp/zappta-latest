<?php

namespace App\Controllers\Admincp;

use App\Controllers\BaseController;
use App\Models\PagesModel;

class Pages extends BaseController
{
	
	private $pages;

	public function __construct()
	{
		$this->pages = new PagesModel();
	}

	public function index()
	{
        $data['perm'] = perm('pages');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp'); 
            }
            return redirect()->to('/admincp'); 
        }
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
		$data['sql'] = $this->pages->getAllResult($data['page']);
		$data['total_pages'] = $this->pages->getTotalAdminPages();
		if ( $data['total_pages'] > 12 ) {
			$data['pager'] = service('pager');
		}
		return view( ADMINVIEW.'pages/index' , $data);
	}

	public function add()
	{
        $data['perm'] = perm('pages');
		if ( $data['perm']->addp == 0 ) {
			return redirect()->to('/admincp/'); 
		}
		$data['parent'] = $this->pages->findAll();
		return view( ADMINVIEW . 'pages/add');
	}

	public function insert()
	{
        $data['perm'] = perm('pages');
		if ( $data['perm']->addp == 0 ) {
			return redirect()->to('/admincp/'); 
		}
		$postForm = $this->request->getPost();

		$title = $postForm['name'];
		$content = $postForm['description'];
		$metakey = $postForm['metakey'];
		$metadesc = $postForm['metadesc'];

		if ( $title == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/pages/add'); 
		}

		$pagedata = [
						'url' => filtreData($title),
						'content' => filtreDataText($content),
						'active' => filtreData($postForm['status']),
						'title' => filtreData($title),
						'metatitle' => filtreData($title),
						'metakeyword' => filtreData($postForm['metakey']),
						'metadescp' => filtreData($postForm['metadesc']),
					];
		$parent_ids = $this->pages->add($pagedata);
		
		
        if ( $_FILES['fimg']['size'] != 0 ) {
            $file = $this->request->getFile('fimg');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $parent_ids, 'fimg' => $newName ];
            $this->pages->add($post);
        }

   		$this->session->setFlashdata('success', 'Page Success fully Added');
		return redirect()->to('/admincp/pages');
	}

	public function edit()
	{
        $data['perm'] = perm('pages');
		if ( $data['perm']->editp == 0 ) {
			return redirect()->to('/admincp/'); 
		}
		$ids = $this->request->getUri()->getSegment(4);
		$data['sql'] = $this->pages->find(my_decrypt($ids));
		
		return view( ADMINVIEW . 'pages/edit',$data);
	}

	public function update()
	{
        $data['perm'] = perm('pages');
		if ( $data['perm']->editp == 0 ) {
			return redirect()->to('/admincp/'); 
		}
		$postForm = $this->request->getPost();

		$id = $postForm['id'];
		$title = $postForm['name'];
		$content = $postForm['description'];
		$metakey = $postForm['metakey'];
		$metadesc = $postForm['metadesc'];

		if ( $title == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
			return redirect()->to('/admincp/pages/edit/'.$id); 
		}

		$pagedata = [
						'id' => my_decrypt($id),
						'content' => filtreDataText($content),
						'active' => filtreData($postForm['status']),
						'title' => filtreData($title),
						'metatitle' => filtreData($title),
						'metakeyword' => filtreData($postForm['metakey']),
						'metadescp' => filtreData($postForm['metadesc']),
					];
		$this->pages->add($pagedata);			
		$parent_ids = my_decrypt($id);
		
		
        if ( $_FILES['fimg']['size'] != 0 ) {
            $file = $this->request->getFile('fimg');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $parent_ids, 'fimg' => $newName ];
            $this->pages->add($post);
        }

   		$this->session->setFlashdata('success', 'Page Successfully Added');
		return redirect()->to('/admincp/pages');
	}
	
	public function delete()
	{
        $data['perm'] = perm('pages');
		if ( $data['perm']->deletep == 0 ) {
			return redirect()->to('/admincp/'); 
		}
		$ids = $this->request->getUri()->getSegment(4);
		$this->pages->deleteR(my_decrypt($ids));
   		$this->session->setFlashdata('success', 'Entry Deleted');
		return redirect()->to('/admincp/pages');
	}


}
