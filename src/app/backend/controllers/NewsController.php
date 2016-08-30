<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class NewsController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $params         = $this->dispatcher->getParams();

        $page           = !empty( $params['page']  ) ? $params['page'] : 1;

        $total = $this->models->getNews()->countData2();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {

            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'news_index_paged', 'page' => $page ],
                    'index_page'       => 'news_index'
                ], true
            );


        }


        $news = $this->models->getNews()->getAllNewsData(1,$page );

        $this->view->setVars([
            'info' => $news,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    function deleteAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $this->models->getNews()->deleteNews($id);
        return $this->response->redirect([ 'for' => 'news_index' ]);
    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {


            $page_add['title']['1']            = $this->request->getPost('title_1', 'string', NULL );
            $page_add['alias']['1']            = $this->request->getPost('alias_1', 'string', NULL );
            $page_add['content']['1']          = $this->request->getPost('page_content_text_1', NULL );
            $page_add['meta_title']['1']       = $this->request->getPost('meta_title_1', 'string', NULL );
            $page_add['meta_keywords']['1']    = $this->request->getPost('meta_keywords_1', 'string', NULL );
            $page_add['meta_description']['1'] = $this->request->getPost('meta_description_1', 'string', NULL );
            $page_add['video']['1']            = $this->request->getPost('video_1', 'string', NULL);
			$page_add['video_sort']['1']            = $this->request->getPost('video_sort_1', 'string', NULL);
            $page_add['status']['1']           = $this->request->getPost('status_1', 'int', NULL );
            $page_add['options']['1']          = $this->request->getPost('options_1', 'string', NULL );
            $page_add['abstract']['1']         = $this->request->getPost('abstract_1', 'string', NULL );


            $page_add['title']['2']            = $this->request->getPost('title_2', 'string', NULL );
            $page_add['alias']['2']            = $this->request->getPost('alias_2', 'string', NULL );
            $page_add['content']['2']          = $this->request->getPost('page_content_text_2', NULL );
            $page_add['meta_title']['2']       = $this->request->getPost('meta_title_2', 'string', NULL );
            $page_add['meta_keywords']['2']    = $this->request->getPost('meta_keywords_2', 'string', NULL );
            $page_add['meta_description']['2'] = $this->request->getPost('meta_description_2', 'string', NULL );
            $page_add['video']['2']            = $this->request->getPost('video_2', 'string', NULL);
			$page_add['video_sort']['2']            = $this->request->getPost('video_sort_2', 'string', NULL);
            $page_add['status']['2']           = $this->request->getPost('status_2', 'int', NULL );
            $page_add['options']['2']          = $this->request->getPost('options_2', 'string', NULL );
            $page_add['abstract']['2']         = $this->request->getPost('abstract_2', 'string', NULL );
			
			$page_add['rubric']['1']           = $this->request->getPost('rubric', 'int', NULL );
			$page_add['rubric']['2']           = $this->request->getPost('rubric', 'int', NULL );

            $page_add['pic_status']['2']       = $page_add['pic_status']['1']       = $this->request->getPost('pic_status', 'string', NULL );
            $page['covers']                 = $this->request->getPost('cover', 'string', NULL );
            $page_add['cover']['1']            = $page_add['cover']['2'] = $page['covers'] ? $page['covers'] : '79846ba311e2be434940b8e570642e98';

            $page_add['status']['1']           = empty( $page_add['status']['1'] ) ? 0 : 1;
            $page_add['status']['2']           = empty( $page_add['status']['2'] ) ? 0 : 1;
            $page_add['pic_status']['1']       = empty( $page_add['pic_status']['1'] ) ? 0 : 1;
            $page_add['pic_status']['2']       = empty( $page_add['pic_status']['2'] ) ? 0 : 1;

            if(empty($page_add['video']['1']) ){
                $page_add['video']['1'] = NULL;
            }
            if(empty($page_add['video']['2']) ){
                $page_add['video']['2'] = NULL;
            }
            if(empty($page_add['video_sort']['1']) ){
                $page_add['video_sort']['1'] = 0;
            }
            if(empty($page_add['video_sort']['2']) ){
                $page_add['video_sort']['2'] = 0;
            }			

            $group_id = $this->request->getPost('group_id' );
            $page_add['products_id']['1'] = $page_add['products_id']['2'] = !empty($group_id)? '{'.implode(',',array_unique($group_id)).'}' : null;

            $page_add_with_lang                = [];

            if ($this->request->hasFiles() == true) {

                foreach ($this->request->getUploadedFiles() as $file){

                    $allowed_filetypes = array('.jpg','.JPG');

                    $ext = substr($file->getName() ,strpos($file->getName() ,'.'),strlen($file->getName() )-1);
                    if(in_array($ext,$allowed_filetypes))
                    {
                        $path = $file->getTempName();

                        $md5_file = md5_file($path);

                        $image_path = $this->storage->getPhotoPath( 'news', $md5_file, 'original' );
                        if(!file_exists($image_path))
                        {
                            $this->storage->mkdir( 'news', $md5_file );
                            $file->moveTo($image_path);
                            $this->storage->imageResizeWithCrop( [], $md5_file, 'news' );
                        }
                        $page_add['cover']['1'] = $page_add['cover']['2']  = $md5_file;
                    } else {
                        $this->flash->error( 'Произошла ошибка. Не верный формат файла.' );
                    }

                }
            }

            if( !empty($page_add['title']['1']) && !empty($page_add['alias']['1']) && !empty($page_add['content']['1']) )
            {

                foreach( $page_add as $k => $p )
                {
                    $page_add_with_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($page_add['title']['2']) && !empty($page_add['alias']['2']) && !empty($page_add['content']['2']) )
            {
                foreach( $page_add as $k => $p )
                {
                    $page_add_with_lang['2'][$k] = $p['2'];
                }
            }

            //p($page_add_with_lang,1);

            if( !empty( $page_add_with_lang ) )
            {
                if( $this->models->getNews()->updateData( $page_add_with_lang, $id ) )
                {
                    $this->flash->success( 'Вы удачно обновили стаью' );
                    return $this->response->redirect([ 'for' => 'news_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления статьи. Повторите попытку позже' );
                }
            }
        }
        $news_lang = '';
        $news = $this->models->getNews()->getOneNewsData( $id);
        $groups_data = '';
        if(!empty($news[0]['group_id'])) {
            $group_id = $this->etc->int2arr($news[0]['group_id'],true);

            $groups_data = $this->models->getItems()->getGroupLike(implode("','",$group_id));
        }

        $this->view->pick( 'news/addEdit' );
        foreach($news as $p )
        {
            $news_lang[$p['lang_id']] = $p;
        }
        $rubrics = $this->models->getRubricsNews()->getAllRubrics();
		$this->view->setVars([
            'rubrics' => $rubrics,
			'page' => $news_lang,
            'group' => $groups_data
        ]);

    }

    function addAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $page_add['title']['1']            = $this->request->getPost('title_1', 'string', NULL );
            $page_add['alias']['1']            = $this->request->getPost('alias_1', 'string', NULL );
            $page_add['content']['1']          = $this->request->getPost('page_content_text_1', NULL );
            $page_add['meta_title']['1']       = $this->request->getPost('meta_title_1', 'string', NULL );
            $page_add['meta_keywords']['1']    = $this->request->getPost('meta_keywords_1', 'string', NULL );
            $page_add['meta_description']['1'] = $this->request->getPost('meta_description_1', 'string', NULL );
            $page_add['video']['1']            = $this->request->getPost('video_1', 'string', NULL );
			$page_add['video_sort']['1']            = $this->request->getPost('video_sort_1', 'string', NULL);
            $page_add['status']['1']           = $this->request->getPost('status_1', 'int', NULL );
            $page_add['options']['1']          = $this->request->getPost('options_1', 'string', NULL );
            $page_add['abstract']['1']         = $this->request->getPost('abstract_1', 'string', NULL );

            $page_add['title']['2']            = $this->request->getPost('title_2', 'string', NULL );
            $page_add['alias']['2']            = $this->request->getPost('alias_2', 'string', NULL );
            $page_add['video']['2']            = $this->request->getPost('video_2', 'string', NULL );
			$page_add['video_sort']['2']            = $this->request->getPost('video_sort_2', 'string', NULL);
            $page_add['status']['2']           = $this->request->getPost('status_2', 'int', NULL );
            $page_add['options']['2']          = $this->request->getPost('options_2', 'string', NULL );
            $page_add['content']['2']          = $this->request->getPost('page_content_text_2', NULL );
            $page_add['abstract']['2']         = $this->request->getPost('abstract_2', 'string', NULL );
            $page_add['meta_title']['2']       = $this->request->getPost('meta_title_2', 'string', NULL );
            $page_add['meta_keywords']['2']    = $this->request->getPost('meta_keywords_2', 'string', NULL );
            $page_add['meta_description']['2'] = $this->request->getPost('meta_description_2', 'string', NULL );
			
			$page_add['rubric']['1']           = $this->request->getPost('rubric', 'int', NULL );
			$page_add['rubric']['2']           = $this->request->getPost('rubric', 'int', NULL );


            $group_id = $this->request->getPost('group_id' );

            if(empty($page_add['video']['1']) ){
                $page_add['video']['1'] = NULL;
            }
            if(empty($page_add['video']['2']) ){
                $page_add['video']['2'] = NULL;
            }
            if(empty($page_add['video_sort']['1']) ){
                $page_add['video_sort']['1'] = 0;
            }
            if(empty($page_add['video_sort']['2']) ){
                $page_add['video_sort']['2'] = 0;
            }			

            $page_add['pic_status']['2']       = $page_add['pic_status']['1'] = $this->request->getPost('pic_status', 'string', NULL );

            $page_add['products_id']['1'] = $page_add['products_id']['2'] = !empty($group_id)? '{'.implode(',',array_unique($group_id)).'}' : null;

            $page['covers']                    = $this->request->getPost('cover', 'string', NULL );
            $page_add['cover']['1']            = $page_add['cover']['2'] = $page['covers'] ? $page['covers'] : '79846ba311e2be434940b8e570642e98';

            $page_add['status']['1']           = empty( $page_add['status']['1'] ) ? 0 : 1;
            $page_add['status']['2']           = empty( $page_add['status']['2'] ) ? 0 : 1;
            $page_add['pic_status']['1']       = empty( $page_add['pic_status']['1'] ) ? 0 : 1;
            $page_add['pic_status']['2']       = empty( $page_add['pic_status']['2'] ) ? 0 : 1;


            $page_add_with_lang                     = [];

            if ($this->request->hasFiles() == true) {

                foreach ($this->request->getUploadedFiles() as $file){

                    $allowed_filetypes = array('.jpg','.JPG');

                    $ext = substr($file->getName() ,strpos($file->getName() ,'.'),strlen($file->getName() )-1);
                    if(in_array($ext,$allowed_filetypes))
                    {
                        $path = $file->getTempName();

                        $md5_file = md5_file($path);

                        $image_path = $this->storage->getPhotoPath( 'news', $md5_file, 'original' );
                        if(!file_exists(substr($image_path ,0,strlen($image_path )-13)))
                        {
                            $this->storage->mkdir( 'news', $md5_file );
                            $file->moveTo($image_path);
                            $this->storage->imageResizeWithCrop( [], $md5_file, 'news' );
                        }
                        $page_add['cover']['1'] = $page_add['cover']['2']  = $md5_file;
                    } else {
                        $this->flash->error( 'Произошла ошибка. Не верный формат файла.' );
                    }


                }
            }

            if( !empty($page_add['title']['1']) && !empty($page_add['alias']['1']) && !empty($page_add['content']['1']) )
            {

                foreach( $page_add as $k => $p )
                {

                    $page_add_with_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($page_add['title']['2']) && !empty($page_add['alias']['2']) && !empty($page_add['content']['2']) )
            {
                foreach( $page_add as $k => $p )
                {
                    $page_add_with_lang['2'][$k] = $p['2'];
                }
            }

            //p($page_add_with_lang,1);

            if( !empty( $page_add_with_lang ) )
            {
                if( $this->models->getNews()->addData( $page_add_with_lang ) )
                {
                    $this->flash->success( 'Вы удачно добавили статическую страницу' );
                    return $this->response->redirect([ 'for' => 'news_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления страницы. Повторите попытку позже' );
                }
            }
        }

        $this->view->pick( 'news/addEdit' );
		$rubrics = $this->models->getRubricsNews()->getAllRubrics();
        $this->view->setVars([
			'rubrics' => $rubrics,
        ]);

    }

    public function getProductLikeAction()
    {
        $like = $this->request->getPost('like', 'string', NULL );
        $data = $this->models->getItems()->getProductLike($like);
        $result = json_encode($data);
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        echo $result;
    }
	
	
	
	
	
	
	
	
	
	
    function rubricsAction()
    {
        $params         = $this->dispatcher->getParams();
		$lang_id = (!empty($params['lang_id'])) ? $params['lang_id'] : 1;
		$rubric = array();
		
		if(!empty($_POST['name_rus'])){
			if(!empty($_POST['update_id']))
			$this->models->getRubricsNews()->updateRubric($_POST);
			else
			$this->models->getRubricsNews()->addRubric($_POST);
			
			return $this->response->redirect([ 'for' => 'news_rubrics' ]);
		}
		
		if(!empty($params['id'])){
			$rubric = $this->models->getRubricsNews()->getOneRubric($params['id'],$lang_id);
		}
		$rubrics = $this->models->getRubricsNews()->getAllRubrics();
		$this->view->setVars([
			'rubrics' => $rubrics,
			'rubric' => $rubric,
        ]);
	}
	
	public function rubrics_deleteAction(){
		$params         = $this->dispatcher->getParams();
		$this->models->getRubricsNews()->deleteRubric($params['id']);
		return $this->response->redirect([ 'for' => 'news_rubrics' ]);
	}

	
	
	
	
	
}