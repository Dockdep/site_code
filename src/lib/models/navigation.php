<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class navigation extends \db
{
    public function getAllData()
    {

        return $this->get(
            '
                SELECT * FROM
                    public.navigation
                ORDER BY
                    weight ASC
            ',
            [
            ],
            -1
        );
    }

    public function getActiveData($lang_id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.navigation
                WHERE
                  status = 1
                AND
                  lang_id = :lang_id
                ORDER BY
                    sort ASC
            ',
            [
                'lang_id'     => $lang_id
            ],
            -1
        );
    }


    public function getOneData($id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.navigation
                WHERE
                    id = :id
            ',
            [
                'id'     => $id
            ],
            -1
        );
    }

    public function deleteData($id){
        return $this->exec(
            '   DELETE
                FROM
                    public.navigation
                WHERE
                    id  = :id
            ',
            [
                'id'     => $id
            ]
        );
    }

    public function addLangData($data,$id)
    {
        return $this->get(
            '
                INSERT INTO
                    public.navigation
                        (
                            id,
                            url,
                            weight,
                            name,
                            status,
                            lang_id
                        )
                        VALUES
                        (
                            :id,
                            :url,
                            :weight,
                            :name,
                            :status,
                            :lang_id
                        )
                        RETURNING id
            ',
            [
                "url" => $data['url'],
                "weight" => $data['weight'],
                "name"  => $data['name'],
                "status" => $data['status'],
                "lang_id" => $data['lang_id'],
                "id" => $id
            ],
            -1
        );



    }

    public function UpdateLangData($data, $id)
    {

        return $this->exec(
            '
                UPDATE
                    public.navigation
                SET
                            url = :url,
                            name = :name,
                            weight = :weight,
                            status = :status,
                            lang_id = :lang_id
                WHERE
                    id              = :id
                AND
                    lang_id         = :lang_id
            ',
            [
                "name" => $data['name'],
                "url" => $data['url'],
                "weight" => $data['weight'],
                "status" => $data['status'],
                "lang_id" => $data['lang_id'],
                "id" => $id
            ]
        );
    }



    public function addData($data)
    {
        try
        {
            $max_id = $this->get(
                '
                    SELECT
                        MAX(id) as max_id
                    FROM
                        public.navigation
                    LIMIT 1
                ',
                [
                ],
                -1
            );

            $id = $max_id['0']['max_id'] + 1;

            if( !empty( $data['1'] ) )
            {
                $data['1']['lang_id'] = 1;
                $this->addLangData($data[1], $id);
            }

            if( !empty( $data['2'] ) )
            {
                $data['2']['lang_id'] = 2;
                $this->addLangData($data[2], $id);
            }

            return true;
        }
        catch(\Exception $e)
        {
            //$this->showException( $e );
        }

        return false;


    }

    public function updateData($data, $id)
    {
        try
        {

            $data_lang = $this->get(
                '
                    SELECT
                        lang_id
                    FROM
                        public.navigation
                    WHERE
                        id      = :id
                ',
                [
                    'id' => $id
                ],
                -1
            );


            $lang_ids = $this->getDi()->get('common')->array_column( $data_lang, 'lang_id' );

            if( !empty( $data['1'] ) )
            {
                if( in_array( 1, $lang_ids ) )
                {
                    $data['1']['lang_id'] = 1;
                    $this->updateLangData($data[1],$id);
                }
                else
                {
                    $data['1']['lang_id'] = 1;
                    $this->addLangData($data[1], $id);
                }
            }

            if( !empty( $data['2'] ) )
            {
                if( in_array( 2, $lang_ids ) )
                {
                    $data['2']['lang_id'] = 2;

                    $this->updateLangData($data[2],$id);
                }
                else
                {
                    $data['2']['lang_id'] = 2;
                    $this->addLangData($data[2], $id);
                }
            }



            return true;
        }
        catch(\Exception $e)
        {
            //$this->showException( $e );
        }

        return false;


    }
}