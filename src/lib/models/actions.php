<?php

namespace models;


class actions extends \db
{
    public function getAllInfo() {
        return $this->get(
            '
            SELECT
                *
            FROM actions
            ORDER BY
            "limit" ASC
            ',
            [

            ],
            -1
        );
    }

    public function addData($data) {
        return $this->get(
            '
            INSERT INTO
              public.actions
              (
                "limit"
              )
              VALUES
              (
                :limit
              )
              RETURNING id
            ',
            [
              'limit' => $data['limit']
            ],
            -1
        );
    }

    public function getOneData($id) {
        return $this->get(
            '
            SELECT id, "limit"
              FROM actions
              WHERE id = :id
            ',
            [
                'id' => $id
            ],
            -1
        );
    }

    public function updateData($data, $id) {
        return $this->get(
            '
            UPDATE
                    public.actions
                SET
                    "limit" = :limit
                WHERE
                    id = :id
            ',
            [
                'limit' => $data['limit'],
                'id'    => $id
            ],
            -1
        );
    }

    public function deleteData($id) {
        return $this->exec(
            '
                DELETE FROM public.actions
                WHERE id = :id
            ',
            [
                'id' => $id
            ]
        );
    }

    public function getActionDiscountByActionId($action_id) {
        return $this->get(
            '
            SELECT
                *
            FROM action_discount
            WHERE action_id = :id
            ',
            [
                'id' => $action_id
            ],
            -1
        );
    }

    public function addActionDiscount($data) {
        return $this->get(
            '
                INSERT INTO
                    public.action_discount
                        (
                            name,
                            cover,
                            action_id

                        )
                        VALUES
                        (
                            :name,
                            :cover,
                            :action_id
                        )
                        RETURNING id
            ',
            [
                'name'             => $data['name'],
                'cover'            => $data['cover'],
                'action_id'        => $data['action_id']
            ],
            -1
        );
    }

    public function getAllActionDiscount() {
        return $this->get(
            '
            SELECT
                *
            FROM action_discount
            ',
            [
            ],
            -1
        );
    }

    public function getActionDiscountById($id) {
        return $this->get(
            '
            SELECT
                *
            FROM action_discount
            WHERE id = :id
            ',
            [
                'id' => $id
            ],
            -1
        );
    }

    public function updateActionDiscount($data, $id)
    {

        return $this->exec(
            '
                UPDATE
                    public.action_discount
                SET
                    name = :name,
                    cover = :cover,
                    action_id = :action_id
                WHERE
                    id = :id
            ',
            [
                'name'         => $data['name'],
                'cover'        => $data['cover'],
                'action_id'    => $data['action_id'],
                'id'    => $id
            ]
        );
    }

    public function deleteActionDiscount($id) {
        return $this->exec(
            '
                DELETE FROM public.action_discount
                WHERE id = :id
            ',
            [
                'id' => $id
            ]
        );
    }
}