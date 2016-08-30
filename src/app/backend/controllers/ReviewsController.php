<?php
/**
 * Created by PhpStorm.
 * User: denys
 * Date: 17.12.15
 * Time: 11:29
 */

namespace controllers;


use Phalcon\Mvc\Controller;

class ReviewsController extends Controller
{
    public function indexAction() {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params = $this->dispatcher->getParams();

        $page = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getReviews()->getAllData();
        $total = $this->models->getReviews()->countData();

        $this->view->setVar('paginate', !empty($paginate['output']) ? $paginate['output'] : '');
        $this->view->setVar('info', $data);
    }

    public function addAction() {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['link']   = $this->request->getPost('link', 'string', NULL );
            $data['review'] = $this->request->getPost('review');
            $data['status'] = $this->request->getPost('status', 'int', NULL);
            $data['name']  = $this->request->getPost('name', 'string', NULL );
            $this->uploadImage($data);

            if($this->models->getReviews()->addData( $data ))
            {
                $this->flash->success( 'Сохранение прошло успешно' );
                return $this->response->redirect([ 'for' => 'reviews_index' ]);
            }
            else
            {
                $this->flash->error( 'Произошла ошибка во время добавления банера. Повторите попытку позже' );
            }

        }

        $this->view->pick( 'reviews/addEdit' );
    }

    public function deleteAction($id) {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $this->models->getSales()->deleteData($id);
        return $this->response->redirect([ 'for' => 'sales_index' ]);
    }

    public function updateAction($id) {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $data = $this->models->getReviews()->getOneData($id);

        if( $this->request->isPost() )
        {
            $data[0]['link']     = $this->request->getPost('link', 'string', NULL );
            $data[0]['review'] = $this->request->getPost('review');
            $data[0]['status'] = $this->request->getPost('status', 'int', NULL);
            $data[0]['name']  = $this->request->getPost('name', 'string', NULL );

            $this->uploadImage($data[0]);

            if( $this->models->getReviews()->updateData( $data[0], $id ) )
            {
                $this->flash->success( 'Сохранение прошло успешно' );
                return $this->response->redirect([ 'for' => 'reviews_index' ]);
            }
            else
            {
                $this->flash->error( 'Произошла ошибка во время добавления банера. Повторите попытку позже' );
            }
        }



        $this->view->setVar('page', $data);
        $this->view->pick( 'reviews/addEdit' );
    }

    private function uploadImage(&$data) {
        if ( $this->request->hasFiles() ) {
            foreach ($this->request->getUploadedFiles() as $file) {
                $allowed_filetypes = array('.jpg', '.JPG', '.png', '.PNG');
                $ext = substr($file->getName(), strpos($file->getName(), '.'), strlen($file->getName()) - 1);

                if (in_array($ext, $allowed_filetypes)) {

                    $path = $file->getTempName();
                    $key = $file->getKey();
                    $md5_file = md5_file($path);

                    $image_path = $this->storage->getPhotoPath('reviews', $md5_file, 'original');

                    if (!file_exists(substr($image_path, 0, strlen($image_path) - 13))) {
                        $this->storage->mkdir('reviews', $md5_file);
                    }

                    $file->moveTo($image_path);
                    $size = 92;
                    $this->storage->imageCut($md5_file, 'reviews', $size);
                    $data[$key] =  $md5_file;

                } else {
                    $this->flash->error('Произошла ошибка. Не верный формат файла.');
                }
            }
        }
    }
}