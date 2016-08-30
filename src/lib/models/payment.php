<?php

namespace models;

class payment extends \db
{
    public function getPaymentByCustomer($customer_id) {
        return $this->get('
            select * from public.payment where "customer_id" = :customer_id ORDER by id DESC

            ',
            [
                'customer_id' => $customer_id
            ]
        );
    }
}