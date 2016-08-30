<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class slider extends \db
{
    public function getAllData($page='')
    {

        return $this->get(
            '
                SELECT * FROM
                    public.slider
                WHERE lang_id = :lang_id
                ORDER BY
                    weight ASC
                LIMIT
                    '.\config::get( 'limits/admin_orders' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/admin_orders' ))
            ,
            [
                'lang_id' => 1
            ],
            -1
        );
    }

    public function getActiveData($lang_id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.slider
                WHERE
                  status = 1
                AND lang_id = :lang_id
                ORDER BY
                    weight ASC
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }


    public function getOneData($id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.slider
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
                    public.slider
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
                    public.slider
                        (
                            id,
                            image,
                            weight,
                            name,
                            status,
                            lang_id,
                            link
                        )
                        VALUES
                        (
                            :id,
                            :image,
                            :weight,
                            :name,
                            :status,
                            :lang_id,
                            :link
                        )
                        RETURNING id
            ',
            [
                "image" => $data['image'],
                "weight" => $data['weight'],
                "name"  => $data['name'],
                "status" => $data['status'],
                "lang_id" => $data['lang_id'],
                "link" => $data['link'],
                'id'     => $id
            ],
            -1
        );



    }

    public function UpdateLangData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.slider
                SET
                            name = :name,
                            image = :image,
                            weight = :weight,
                            status = :status,
                            lang_id = :lang_id,
                            link = :link

                WHERE
                    id              = :id
                AND lang_id         = :lang_id
            ',
            [
                "image" => $data['image'],
                "weight" => $data['weight'],
                "status" => $data['status'],
                "lang_id" => $data['lang_id'],
                "name" => $data['name'],
                "link" => $data['link'],
                "id" => $id
            ]
        );
    }


    public function countData( )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.slider
            ',
            [

            ],
            -1
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
                        public.slider
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
                        public.slider
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