<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class seo_info extends \db
{
    public function getAllSeo()
    {

        return $this->get(
            '
                SELECT * FROM
                    public.seo_info
                ORDER BY
                    id ASC
            ',
            [
            ],
            -1
        );
    }

    function getByUrl($url)
    {
        return $this->get(
            '
                SELECT * FROM
                    public.seo_info
                WHERE
                    url = :url
            ',
            [
                'url' => $url
            ],
            -1
        );

    }

    public function getOneSeo($id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.seo_info
                WHERE
                    id = :id
            ',
            [
                'id'     => $id
            ],
            -1
        );
    }

    public function deleteSeo($id){
        return $this->exec(
            '   DELETE
                FROM
                    public.seo_info
                WHERE
                    id  = :id
            ',
            [
                'id'     => $id
            ]
        );
    }

    public function addSeoData($data)
    {

        return $this->get(
            '
                INSERT INTO
                    public.seo_info
                        (
                            title,
                            url,
                            h1,
                            description,
                            seo_text
                        )
                        VALUES
                        (
                            :title,
                            :url,
                            :h1,
                            :description,
                            :seo_text
                        )
                        RETURNING id
            ',
            [
                "title" => $data['title'],
                "url" => $data["url"],
                "h1" => $data['h1'],
                "description" => $data['description'],
                "seo_text" => $data['seo_text'],
            ],
            -1
        );


    }

    public function UpdateSeo($data)
    {

        return $this->exec(
            '
                UPDATE
                    public.seo_info
                SET
                            title = :title,
                            url = :url,
                            h1 = :h1,
                            description = :description,
                            seo_text = :seo_text
                WHERE
                    id              = :id
            ',
            [
                "title" => $data['title'],
                "url" => $data["url"],
                "h1" => $data['h1'],
                "description" => $data['description'],
                "seo_text" => $data['seo_text'],
                "id" => $data['id']
            ]
        );
    }



}