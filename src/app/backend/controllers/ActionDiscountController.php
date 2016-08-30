<?php

namespace controllers;



class ActionDiscountController extends \Phalcon\Mvc\Controller
{

    function indexAction()
    {
        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getActions()->getAllActionDiscount($page);


        $this->view->setVars([
            'info' => $data,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    function deleteAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $this->models->getActions()->deleteActionDiscount($id);

        return $this->response->redirect([ 'for' => 'action_discount_index' ]);
    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $data = $this->models->getActions()->getActionDiscountById($id);

        if( $this->request->isPost() ) {
            $data[0]['name'] = $this->request->getPost('name', 'string', NULL );
            $data[0]['action_id'] = $this->request->getPost('action_id', 'int', null);

            $cover = $this->uploadImage();

            $data[0]['cover'] = $cover != null ? $cover : $data[0]['cover'];


            if( !empty( $data ) )
            {
                if( $this->models->getActions()->updateActionDiscount( $data[0], $id ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'action_discount_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления. Повторите попытку позже' );
                }
            }


        }

        $limits = $this->models->getActions()->getAllInfo();

        foreach($data as $k => $i) {
            $data[$k]['cover'] = $this->storage->getPhotoURL($i['cover'], 'actions', 'original');
        }

        $this->view->pick('action_discount/addEdit');

        $this->view->setVars([
            'page' => $data,
            'limits' => $limits
        ]);
    }

    function addAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() ) {
            $data['name'] = $this->request->getPost('name', 'string', NULL );
            $data['action_id'] = $this->request->getPost('action_id', 'int', NULL );

            $data['cover'] = $this->uploadImage();

            if( !empty( $data ) && $data['cover'] != null && !empty($data['name']) )
            {
                if( $this->models->getActions()->addActionDiscount( $data ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'action_discount_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления. Повторите попытку позже' );
                }
            }
            else
            {
                $this->flash->error( 'Заполните все поля!' );
            }
        }

        $limits = $this->models->getActions()->getAllInfo();

        $this->view->pick('action_discount/addEdit');


        $this->view->setVars([
            'limits' => $limits
        ]);
    }

    private function uploadImage() {
        if ( $this->request->hasFiles() ) {
            foreach ($this->request->getUploadedFiles() as $file) {

                $allowed_filetypes = array('.jpg', '.JPG');

                $ext = substr($file->getName(), strpos($file->getName(), '.'), strlen($file->getName()) - 1);

                if (in_array($ext, $allowed_filetypes)) {

                    $path = $file->getTempName();

                    $md5_file = md5_file($path);
                    $image_path = $this->storage->getPhotoPath('actions', $md5_file, 'original');

                    if (!file_exists(substr($image_path, 0, strlen($image_path) - 13))) {
                        $this->storage->mkdir('actions', $md5_file);
                    }

                    $file->moveTo($image_path);

                    return $md5_file;

                } else {
                    $this->flash->error('Произошла ошибка. Не верный формат файла.');
                }
            }
        }
        return null;
    }
}