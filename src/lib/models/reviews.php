<?php
/**
 * Created by PhpStorm.
 * User: denys
 * Date: 17.12.15
 * Time: 11:33
 */

namespace models;


class reviews extends \db
{
    public function getAllData()
    {
        return $this->get(
            '
                SELECT * FROM
                    public.user_reviews

            '
            ,
            [
            ],
            -1
        );
    }

    public function getActiveReviews()
    {
        return $this->get(
            '
                SELECT * FROM
                    public.user_reviews
                WHERE status = TRUE
            '
            ,
            [
            ],
            -1
        );
    }

    public function getOneData($id)
    {
        return $this->get(
            '
                SELECT *
                FROM public.user_reviews

                WHERE
                    id = :id
            ',
            [
                'id' => $id
            ],
            -1
        );
    }

    public function deleteData($id)
    {
        return $this->exec(
            '   DELETE
                FROM
                    public.user_reviews
                WHERE
                    id  = :id
            ',
            [
                'id' => $id
            ]
        );
    }

    public function addData($data)
    {

        return $this->get(
            '
                INSERT INTO
                    public.user_reviews
                        (
                          link,
                          review,
                          status,
                          avatar,
                          name
                        )
                        VALUES
                        (
                          :link,
                          :review,
                          :status,
                          :avatar,
                          :name
                        )
                        RETURNING id
            ',
            [
                'link' => $data['link'],
                'review' => $data['review'],
                'name' => $data['name'],
                'status' => !empty($data['status']) ? $data['status'] : 0,
                'avatar' => !empty($data['avatar']) ? $data['avatar'] : null
            ],
            -1
        );
    }

    public function updateData($data, $id)
    {

        return $this->exec(
            '
                UPDATE
                    public.user_reviews
                SET
                    link = :link,
                    review = :review,
                    status = :status,
                    avatar = :avatar,
                    name = :name
                WHERE
                    id  = :id
            ',
            [
                'link' => $data['link'],
                'review' => $data['review'],
                'name' => $data['name'],
                'status' => !empty($data['status']) ? $data['status'] : 0,
                'avatar' => !empty($data['avatar']) ? $data['avatar'] : null,
                'id' => $id
            ]
        );
    }


    public function countData()
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.user_reviews
            ',
            [

            ],
            -1
        );
    }
}