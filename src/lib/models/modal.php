<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class modal extends \db
{
    public function getAllData($page='')
    {

        return $this->get(
            '
                SELECT * FROM
                    public.modal
                WHERE lang_id = :lang_id
            '
               /* LIMIT
                    '.\config::get( 'limits/admin_orders' )
                  OFFSET
                    .($page-1)*(\config::get( 'limits/admin_orders' ))*/
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
                    public.modal
                WHERE
                  status = 1
                AND lang_id = :lang_id

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
                    public.modal
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
                    public.modal
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
                    public.modal
                        (
                            id,
                            text,
                            status,
                            lang_id,
                            link
                        )
                        VALUES
                        (
                            :id,
                            :text,
                            :status,
                            :lang_id,
                            :link
                        )
                        RETURNING id
            ',
            [
                "text"  => $data['text'],
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
                    public.modal
                SET
                            text = :text,
                            status = :status,
                            lang_id = :lang_id,
                            link = :link

                WHERE
                    id              = :id
                AND lang_id         = :lang_id
            ',
            [
                "status" => $data['status'],
                "lang_id" => $data['lang_id'],
                "text" => $data['text'],
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
                    public.modal
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
                        public.modal
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
                        public.modal
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

    public function getModalLike(){
        $link =  $this->getDi()->get('request')->get('_url');
        $data = $this->get(
            "  SELECT * FROM
                    public.modal
                WHERE
                    status = 1
                    AND
                    link = :link",
                [
                    'link' => $link
                ]
        );
        foreach($data as $row){

            if( stristr($link, $row['link']) ){
                return $row;
            }
        }
    }
}