<?php

namespace controllers;


class SalesController extends \Phalcon\Mvc\Controller
{
    public function indexAction() {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params = $this->dispatcher->getParams();
        $lang_id = 1; // ua
        $page = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getSales()->getAllData($lang_id);
        $total = $this->models->getSales()->countData();

        $this->view->setVar('paginate', !empty($paginate['output']) ? $paginate['output'] : '');
        $this->view->setVar('info', $data);
    }

    public function addAction() {
        $titlecmp = function ($a, $b) {
            return strcasecmp($a['title'], $b['title']);
        };
        $lang_id = 1; // ua language
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['name_1']     = $this->request->getPost('name_1', 'string', NULL );
            $data['name_2']     = $this->request->getPost('name_2', 'string', NULL );
            $data['start_date'] = $this->request->getPost('start_date');
            $data['end_date'] = $this->request->getPost('end_date');
            $data['description_1'] = $this->request->getPost('description_1');
            $data['description_2'] = $this->request->getPost('description_2');
            $data['group_ids'] = $this->request->getPost('items', 'string', NULL );
            $data['is_seasonal'] = $this->request->getPost('is_seasonal', 'int', NULL);
            $data['alias_1'] = $this->request->getPost('alias_1', 'string', null);
            $data['alias_2'] = $this->request->getPost('alias_2', 'string', null);
            $data['full_name_1'] = $this->request->getPost('full_name_1', 'string', null);
            $data['full_name_2'] = $this->request->getPost('full_name_2', 'string', null);
            $data['show_banner'] = $this->request->getPost('show_banner', 'int', null);
            $data['show_counter'] = $this->request->getPost('show_counter', 'int', null);

            $this->uploadImage($data);

            if(!empty($data['group_ids']) && $this->models->getSales()->addData( $data ))
            {
                $this->flash->success( 'Сохранение прошло успешно' );
                return $this->response->redirect([ 'for' => 'sales_index' ]);
            }
            else
            {
                $this->flash->error( 'Выберите товары для акции' );
            }

        }

        $catalog_temp = $this->common->getTypeSubtype1(NULL, $lang_id)['catalog'];
        usort($catalog_temp, $titlecmp);

        $this->view->setVar('catalog_temp', $catalog_temp);
        $this->view->pick( 'sales/addEdit' );
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
        $titlecmp = function ($a, $b) {
            return strcasecmp($a['title'], $b['title']);
        };
        $lang_id = 1; // ua language

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }


        if( $this->request->isPost() )
        {
            $data = $this->models->getSales()->getOneData($id);
            $data[0]['seasonal_cover_1'] = $data[0]['seasonal_cover'];
            $data[0]['classic_cover_1'] = $data[0]['classic_cover'];
            $data[0]['banner_1'] = $data[0]['banner'];
            $data[0]['seasonal_cover_2'] = $data[1]['seasonal_cover'];
            $data[0]['classic_cover_2'] = $data[1]['classic_cover'];
            $data[0]['banner_2'] = $data[1]['banner'];
            $data[0]['name_1']     = $this->request->getPost('name_1', 'string', NULL );
            $data[0]['name_2']     = $this->request->getPost('name_2', 'string', NULL );
            $data[0]['start_date'] = $this->request->getPost('start_date');
            $data[0]['end_date'] = $this->request->getPost('end_date');
            $data[0]['description_1'] = $this->request->getPost('description_1');
            $data[0]['description_2'] = $this->request->getPost('description_2');
            $data[0]['group_ids'] = $this->request->getPost('items', 'string', NULL );
            $data[0]['is_seasonal'] = $this->request->getPost('is_seasonal', 'int', NULL);
            $data[0]['alias_1'] = $this->request->getPost('alias_1', 'string', null);
            $data[0]['alias_2'] = $this->request->getPost('alias_2', 'string', null);
            $data[0]['full_name_1'] = $this->request->getPost('full_name_1', 'string', null);
            $data[0]['full_name_2'] = $this->request->getPost('full_name_2', 'string', null);
            $data[0]['show_banner'] = $this->request->getPost('show_banner', 'int', null);
            $data[0]['show_counter'] = $this->request->getPost('show_counter', 'int', null);
            $this->uploadImage($data[0]);

            if(!empty($data[0]['group_ids'])
                && $this->models->getSales()->updateData( $data[0], $id )
                && $this->models->getSales()->updateLang( $data[0], $id ))
            {
                $this->flash->success( 'Сохранение прошло успешно' );
                return $this->response->redirect([ 'for' => 'sales_index' ]);
            }
            else
            {
                $this->flash->error( 'Выберите товары для акции.' );
            }
        }

        $data = $this->models->getSales()->getOneData($id);

        $data[0]['group_ids'] = $this->common->parseArray($data[0]['group_ids']);
        $groups = $this->models->getItems()->getGroupsByGroupId($lang_id, $data[0]['group_ids']);
        $catalog_temp = $this->common->getTypeSubtype1(NULL, $lang_id)['catalog'];
        usort($catalog_temp, $titlecmp);
        usort($groups, $titlecmp);


        $this->view->setVar('catalog_temp', $catalog_temp);
        $this->view->setVar('page', $data);
        $this->view->setVar('groups', $groups);
        $this->view->pick( 'sales/addEdit' );
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

                    $image_path = $this->storage->getPhotoPath('sales/'.substr($key, 0, -2), $md5_file, 'original');

                    if (!file_exists(substr($image_path, 0, strlen($image_path) - 13))) {
                        $this->storage->mkdir('sales/'.substr($key, 0, -2), $md5_file);
                    }

                    $file->moveTo($image_path);

                    $data[$key] =  $md5_file;

                } else {
                    $this->flash->error('Произошла ошибка. Не верный формат файла.');
                }
            }
        }
    }
}