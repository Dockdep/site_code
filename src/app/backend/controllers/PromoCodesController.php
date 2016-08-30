<?php

namespace controllers;


use Phalcon\Mvc\Controller;

class PromoCodesController extends Controller
{
    public function indexAction() {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getPromoCodes()->getAllData($page);
        $total = $this->models->getPromoCodes()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'promo_codes_index_paged', 'page' => $page ],
                    'index_page'        => 'promo_codes_index'
                ], true
            );
        }
        $this->view->setVars([
            'info' => $data,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
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

            $data['name']     = $this->request->getPost('name', 'string', NULL );
            $data['code']     = $this->request->getPost('code', 'string', NULL );
            $data['start_date'] = $this->request->getPost('start_date');
            $data['end_date'] = $this->request->getPost('end_date');
            $data['discount'] = $this->request->getPost('discount', 'string', NULL );
            $data['description'] = $this->request->getPost('description');
            $data['catalog_ids'] = $this->request->getPost('catalog', 'string', NULL );
            $data['group_ids'] = $this->request->getPost('items', 'string', NULL );
            $data['all_items'] = $this->request->getPost('all_items', 'int', NULL);
            $data['image'] = $this->uploadImage();

            if( empty($this->models->getPromoCodes()->getPromoByCode( $data['code'] )[0]) )
            {
                if(!empty($data['group_ids']) && $this->models->getPromoCodes()->addData( $data ))
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'promo_codes_index' ]);
                }
                else
                {
                    $this->flash->error( 'Выберите товары для промокода' );
                }
            }
            else {
                $this->flash->error('Такой промокод уже существует');
            }
        }

        $catalog_temp = $this->common->getTypeSubtype1(NULL, $lang_id)['catalog'];
        usort($catalog_temp, $titlecmp);


        $this->view->setVar('catalog_temp', $catalog_temp);
        $this->view->pick( 'promo_codes/addEdit' );
    }

    public function deleteAction($id) {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $this->models->getPromoCodes()->deleteData($id);

        return $this->response->redirect([ 'for' => 'promo_codes_index' ]);
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

        $data = $this->models->getPromoCodes()->getOneData($id);

        if( $this->request->isPost() )
        {
            $data[0]['name']     = $this->request->getPost('name', 'string', NULL );
            $prev_code = $data[0]['code'];
            $data[0]['code']     = $this->request->getPost('code', 'string', NULL );
            $data[0]['discount'] = $this->request->getPost('discount', 'string', NULL );
            $data[0]['start_date'] = $this->request->getPost('start_date');
            $data[0]['end_date'] = $this->request->getPost('end_date');
            $data[0]['description'] = $this->request->getPost('description');
            $data[0]['group_ids'] = $this->request->getPost('items', 'string', NULL );
            $data[0]['all_items'] = $this->request->getPost('all_items', 'int', NULL);

            $cover = $this->uploadImage();

            $data[0]['image'] = $cover != null ? $cover : $data[0]['image'];


            if( $prev_code == $data[0]['code']
                || empty($this->models->getPromoCodes()->getPromoByCode($data[0]['code'])[0]) )
            {
                if(!empty($data[0]['group_ids']) && $this->models->getPromoCodes()->updateData( $data[0], $id ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'promo_codes_index' ]);
                }
                else
                {
                    $this->flash->error( 'Выберите товары для промокода.' );
                }
            }
            else
            {
                $this->flash->error( 'Такой промокод уже существует' );
            }
        }

        $data[0]['group_ids'] = $this->common->parseArray($data[0]['group_ids']);
        $data[0]['catalog_ids'] = $this->common->parseArray($data[0]['catalog_ids']);

        $catalog_temp = $this->common->getTypeSubtype1(NULL, $lang_id)['catalog'];
        usort($catalog_temp, $titlecmp);

        foreach($catalog_temp as &$group) {
            usort($group['sub'], $titlecmp);
        }

        if(!empty($data[0]['group_ids'][0])) {
            $groups = $this->models->getItems()->getItemsByIds($lang_id, $data[0]['group_ids']);
            usort($groups, $titlecmp);
        }

        foreach($data as $k => $i) {
            if(isset($i['image']) && !empty($i['image']))
                $data[$k]['image'] = $this->storage->getPhotoURL($i['image'], 'promo_codes', 'original');
        }

        $this->view->pick( 'promo_codes/addEdit' );

        $this->view->setVars([
            'page' => $data,
            'catalog_temp' => $catalog_temp,
            'groups' => !empty($groups) ? $groups : null
        ]);
    }

    public function getFiltersByCatalogAction() {
        $lang_id = 1; // ua language
        $this->view->disable();
        $catalog_id = $this->request->get('catalog_id');
        $filters_ = $this->models->getFilters()->getFiltersWithCatalogId( $lang_id, $catalog_id );
        $filters            = [];

        if( !empty( $filters_ ) )
        {
            foreach( $filters_ as $f )
            {
                $filters[$f['filter_key_value']][] = $f;
            }
        }
        echo json_encode($filters);
    }

    public function getItemsByFilterAction() {
        $lang_id = 1; // ua language
        $this->view->disable();
        $titlecmp = function ($a, $b) {
            return strcasecmp($a['title'], $b['title']);
        };
        $filters_ids = $this->request->getPost('filters');
        $catalog_id = $this->request->getPost('catalog_id');
        $prices = $this->request->getPost('prices');
        if(empty($filters_ids)) {
            $groups = $this->models->getItems()->getGroupsByCatalogIdBackend($lang_id, $catalog_id, $prices);
        } else {
            $groups_by_filters = $this->models->getItems()->getGroupsByFiltersWithCatalog($filters_ids, $prices, $catalog_id);
            $groups_by_key_id = array();
            foreach ($groups_by_filters as $g) {
                $groups_by_key_id[$g['key_id']][] = $g['group_id'];
                $groups_by_key_id[$g['key_id']] = array_unique($groups_by_key_id[$g['key_id']]);
            }

            sort($groups_by_key_id);
            $result_groups = array();
            if (count($groups_by_key_id) > 1) {
                $result_groups = call_user_func_array('array_intersect', $groups_by_key_id);
            } elseif (isset($groups_by_key_id['0'])) {
                $result_groups = $groups_by_key_id['0'];
            }
            if (!empty($result_groups)) {
                $groups = $this->models->getItems()->getResultGroupsWithLimit($lang_id, $result_groups, $filters_ids, $prices);
            }
        }

        $groups  = $this->common->explodeAlias($groups);
        $groups_ = $this->common->getGroupsBackend( $lang_id, $groups );

        usort($groups_, $titlecmp);

        echo json_encode($groups_);
    }

    private function uploadImage() {
        if ( $this->request->hasFiles() ) {
            foreach ($this->request->getUploadedFiles() as $file) {

                $allowed_filetypes = array('.jpg', '.JPG', '.png', '.PNG');

                $ext = substr($file->getName(), strpos($file->getName(), '.'), strlen($file->getName()) - 1);

                if (in_array($ext, $allowed_filetypes)) {

                    $path = $file->getTempName();

                    $md5_file = md5_file($path);
                    $image_path = $this->storage->getPhotoPath('promo_codes', $md5_file, 'original');

                    if (!file_exists(substr($image_path, 0, strlen($image_path) - 13))) {
                        $this->storage->mkdir('promo_codes', $md5_file);
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