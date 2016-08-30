<?php
namespace{
    class deliveryServ{
        public $data = array();
        public $new_data = array();
        public $del_db;
        public $del_em_db;


        public function __construct($del_db, $del_em_db)
        {
            $this->del_db = $del_db;
            $this->del_em_db = $del_em_db;
            $this->data['name'] = null;
            $this->data['campaign_id'] = null;
            $this->data['date'] = null;
            $this->data['status'] = null;
            $this->data['total'] = null;
            $this->data['ok_delivered'] = null;
            $this->data['ok_read'] = null;
            $this->data['campaign'] = null;
            $this->data['email'] = null;
            $this->data['send_result'] = null;
            $this->data['last_update'] = null;
            $this->data['request_time'] = null;
            $this->data['ip'] = null;
            $this->data['url'] = null;
            $this->data['event_id'] = null;
            $this->data['delivery_id'] = null;
            $this->data['ok_unsubscribed'] = null;
            $this->data['ok_fbl'] = null;
            $this->data['ok_link_visited'] = null;
            $this->data['delivered'] = null;
        }

        public function getPercent(){
            $this->new_data['delivered'] = $this->new_data['delivered'] ? round($this->new_data['delivered']/$this->new_data['total']*100) : $this->new_data['delivered'];
            $this->new_data['ok_unsubscribed'] = $this->new_data['ok_unsubscribed'] ? round($this->new_data['ok_unsubscribed']/$this->new_data['total']*100) : $this->new_data['ok_unsubscribed'];
            $this->new_data['ok_fbl'] = $this->new_data['ok_fbl'] ? round($this->new_data['ok_fbl']/$this->new_data['total']*100) : $this->new_data['ok_fbl'];
            $this->new_data['ok_link_visited'] = $this->new_data['ok_link_visited'] ? round($this->new_data['ok_link_visited']/$this->new_data['total']*100) : $this->new_data['ok_link_visited'];
            $this->new_data['ok_read'] = $this->new_data['ok_read'] ? round($this->new_data['ok_read']/$this->new_data['total']*100) : $this->new_data['ok_read'];
        }

        public function addProp($array){
            $this->new_data += $array;
        }

        public function save($id)
        {

            $check = $this->del_db->CheckDelivery($id);
            if(!empty($check)){
                $this->getPercent($this->new_data);

                $check =  array_merge($check[0],$this->new_data);

                return $this->del_db->UpdateData($check);

            } else {
                $this->getPercent($this->new_data);

                $this->data = array_merge($this->data,$this->new_data);

                return $this->del_db->addData($this->data);

            }
        }

        public function showData(){
            p($this->data,1);
        }

        public function getDelivered()
        {
            return $this->new_data['ok_delivered']+$this->new_data['ok_read']+$this->new_data['ok_unsubscribed']+$this->new_data['ok_fbl']+$this->new_data['ok_link_visited'];
        }


    }
}