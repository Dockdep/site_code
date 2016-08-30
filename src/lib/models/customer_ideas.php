<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class customer_ideas extends \db
{
    public function addIdea($idea) {
        return $this->get(
            '
            INSERT INTO
                  public.customer_ideas
                  (idea_text, customer_id)
                  VALUES
                  (:idea_text, :customer_id)
            ',
            [
                'idea_text' => $idea['idea_text'],
                'customer_id' => $idea['customer_id']
            ],
            -1
        );
    }

    public function getAllData() {
        return $this->get(
            '
            SELECT * FROM
                  public.customer_ideas
            ',
            [
            ],
            -1
        );
    }

    public function getOneData($id)
    {
        return $this->get(
            '
                SELECT customer_ideas.id as id, idea_text, customers.name as customer
                FROM public.customer_ideas
                INNER JOIN customers
                ON customer_ideas.customer_id=customers.id
                WHERE
                    customer_ideas.id = :id
            ',
            [
                'id'     => $id
            ],
            -1
        );
    }

    public function countData( )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.customer_ideas
            ',
            [

            ],
            -1
        );
    }
}