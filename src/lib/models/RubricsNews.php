<?php
namespace models;

class RubricsNews extends \db
{
	
	public function getOneRubric($id){
        return $this->get(
            '
                SELECT
                    *
                FROM
                    public.news_rubrics
                 
                WHERE id=:id'

            ,
            [
					"id"             => $id,
            ],
            -1
        );	
	}
	
	
	
	public function getAllRubrics($lang_id = 0)
    {
        if($lang_id == 2)$field = "name_rus as name";
		elseif($lang_id == 1) $field = "name_ukr as name";
		else $field = "name_rus";
		return $this->get(
            '
                SELECT
                    id,'.$field.'
                FROM
                    public.news_rubrics
                 
                ORDER BY id DESC'

            ,
            [
 
            ],
            -1
        );	
	}
	public function addRubric($data)
    {
        
            $max_id = $this->get(
                '
                    SELECT
                        MAX(id) as max_id
                    FROM
                        public.news_rubrics
                    LIMIT 1
                ',
                [
                ],
                -1
            );

            $id = $max_id['0']['max_id'] + 1;
			
		return $this->get(
            '
                INSERT INTO
                    public.news_rubrics
                        (   id,
                            name_rus,
							name_ukr

                        )
                        VALUES
                        (   :id,
                            :name_rus,
							:name_ukr
                        )
                        RETURNING id
            ',
            [
                "name_rus"             => $data["name_rus"],
				"name_ukr"             => $data["name_ukr"],
                "id"                => $id
            ],
            -1
        );
    }
	
    public function updateRubric($data)
    {

        $this->exec(
            '
                UPDATE
                    public.news_rubrics
                SET
                            name_rus = :name_rus,
                            name_ukr = :name_ukr
                WHERE
                    id              = :id
            ',
            [
                "name_rus"             => $data["name_rus"],
				"name_ukr"             => $data["name_ukr"],

                "id" => $data["update_id"]
            ]
        );

    }

    public function deleteRubric($id){
        return $this->exec(
            '   DELETE
                FROM
                    public.news_rubrics
                WHERE
                    id  = :id
            ',
            [
                'id'     => $id
            ]
        );
    }	

}