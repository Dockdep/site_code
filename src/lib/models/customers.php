<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class customers extends \db
{

    ///////////////////////////////////for_backend///////////////////////////////////////////
    public function getLastCustomer()
    {
        $data = $this->get(
            '
              select max(id) from public.customers
            '
            ,
            [
            ],
            -1
        );
        return $data[0]['max'];

    }

    public function getActiveUsers($like){
        return $this->get(
            '
                SELECT * FROM
                    public.customers
                WHERE
                    email LIKE \'%'.$like.'%\''
            ,
            [
            ],
            -1
        );
    }

    public function getAllUsers(){
        return $this->get(
            '
                SELECT * FROM
                    public.customers
                WHERE
                    status = 1'
            ,
            [
            ],
            -1
        );
    }

    public function getActiveUsersData($id = ''){
        return $this->get(
            '
                SELECT * FROM
                    public.customers
                WHERE
                    id IN ('.$id.')'
            ,
            [
            ],
            -1
        );
    }
    public function getAllData($page='')
    {

        return $this->get(
            '
                SELECT * FROM
                    public.customers
                ORDER BY
                     id ASC
                LIMIT
                    '.\config::get( 'limits/admin_orders' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/admin_orders' ))
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
                SELECT * FROM
                    public.customers
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
                    public.customers
                WHERE
                    id  = :id
            ',
            [
                'id'     => $id
            ]
        );
    }

    public function addData($data)
    {

        return $this->get(
            '
                INSERT INTO
                    public.customers
                        (
                            name,
                            email,
                            passwd,
                            birth_date,
                            phone,
                            city,
                            address,
                            delivery,
                            pay,
                            subscribed,
                            comments,
                            status,
                            groups

                        )
                        VALUES
                        (
                            :name,
                            :email,
                            :password,
                            :birth_date,
                            :phone,
                            :city,
                            :address,
                            :delivery,
                            :pay,
                            :subscribed,
                            :comments,
                            :status,
                            :users_group_id,
                            :special_users_id
                        )
                        RETURNING id
            ',
            [
                'name'             => $data['name'],
                'email'            => $data['email'],
                'password'         => $data['password'],
                'birth_date'       => $data['birth_date'],
                'phone'            => $data['phone'],
                'city'             => $data['city'],
                'address'          => $data['address'],
                'delivery'         => $data['delivery'],
                'pay'              => $data['pay'],
                'subscribed'       => $data['subscribed'],
                'comments'         => $data['comments'],
                'status'           => $data['status'],
                'users_group_id'  => $data['users_group_id'],
                'special_users_id' => $data['special_users_id'],
            ],
            -1
        );



    }

    public function updateUsersGroup($user_group_id,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.customers
                SET
                    users_group_id = :users_group_id
                WHERE
                    id = :id
            ',
            [
                'users_group_id'  => $user_group_id,
                "id" => $id
            ]
        );
    }


    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.customers
                SET
                            name = :name,
                            email = :email,
                            passwd = :password,
                            birth_date = :birth_date,
                            phone = :phone,
                            city = :city,
                            address = :address,
                            delivery = :delivery,
                            pay = :pay,
                            subscribed = :subscribed,
                            comments = :comments,
                            status = :status,
                            users_group_id = :users_group_id,
                            special_users_id = :special_users_id
                WHERE
                    id              = :id
            ',
            [
                'name'             => $data['name'],
                'email'            => $data['email'],
                'password'         => $data['password'],
                'birth_date'       => empty($data['birth_date']) ? null : $data['birth_date'],
                'phone'            => $data['phone'],
                'city'             => $data['city'],
                'address'          => $data['address'],
                'delivery'         => $data['delivery'],
                'pay'              => $data['pay'],
                'subscribed'       => $data['subscribed'],
                'comments'         => $data['comments'],
                'status'           => $data['status'],
                'users_group_id'  => $data['users_group_id'],
                'special_users_id' => $data['special_users_id'],
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
                    public.customers
            ',
            [

            ],
            -1
        );
    }

    ////////////////////////////////////end_for_backend//////////////////////////////////////////
    public function addNewCustomer( $order )
    {
        return $this->get(
            '
                INSERT INTO
                    public.customers
                        (
                            name,
                            email,
                            passwd,
                            phone,
                            city,
                            address,
                            delivery,
                            pay,
                            subscribed,
                            comments,
                            user_pass
                        )
                        VALUES
                        (
                            :name,
                            :email,
                            :passwd,
                            :phone,
                            :city,
                            :address,
                            :delivery,
                            :pay,
                            :subscribed,
                            :comments,
                            :user_pass
                        )
                        RETURNING id
            ',
            [
                'name'          => $order['name'],
                'email'         => $order['email'],
                'passwd'        => $order['passwd'],
                'phone'         => $order['phone'],
                'city'          => $order['city'],
                'address'       => $order['address'],
                'delivery'      => $order['delivery'],
                'pay'           => $order['pay'],
                'subscribed'    => $order['subscribed'],
                'comments'      => $order['comments'],
                'user_pass'     => isset($order['user_pass']) ? $order['user_pass'] : ''
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function finishRegistration( $registration )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $data_status = $this->exec(
                '
                    UPDATE
                        public.customers
                    SET
                        passwd          = :passwd,
                        status          = :status,
                        lastlogin_date  = :lastlogin_date
                    WHERE
                        email           = :email
                ',
                [
                    'status'            => 1,
                    'passwd'            => $registration['passwd'],
                    'email'             => $registration['email'],
                    'lastlogin_date'    => date( 'Y-m-d H:i' )
                ]
            );

            $data_id =  $this->get(
                '
                    SELECT
                        id
                    FROM
                        public.customers
                    WHERE
                        email = :email
                    LIMIT
                        1
                ',
                [
                    'email' => $registration['email']
                ],
                -1
            );

            $this->getDi()->get('session')->set( 'isAuth',          true );
            $this->getDi()->get('session')->set( 'id',              $data_id['0']['id'] );

            $connection->commit();

            return true;
        }
        catch(\Exception $e)
        {
            $connection->rollback();
        }

        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function resetPasswd( $registration )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $data_customer_id = $this->get(
                '
                    SELECT
                        customer_id
                    FROM
                        public.customers_confirm
                    WHERE
                        confirm_key = :confirm_key
                    LIMIT
                        1
                ',
                [
                    'confirm_key' => $registration['confirm_key']
                ],
                -1
            );

            if( !empty( $data_customer_id ) )
            {

                $data_status = $this->exec(
                    '
                        UPDATE
                            public.customers
                        SET
                            passwd          = :passwd,
                            user_pass       = :user_pass,
                            status          = :status,
                            lastlogin_date  = :lastlogin_date
                        WHERE
                            id              = :id
                    ',
                    [
                        'status'            => 1,
                        'passwd'            => $registration['passwd'],
                        'user_pass'         => $registration['user_pass'],
                        'id'                => $data_customer_id['0']['customer_id'],
                        'lastlogin_date'    => date( 'Y-m-d H:i' )
                    ]
                );

                $data_delete = $this->exec(
                    '
                        DELETE
                        FROM
                            public.customers_confirm
                        WHERE
                            confirm_key  = :confirm_key
                    ',
                    [
                        'confirm_key'     => $registration['confirm_key']
                    ]
                );

                $this->getDi()->get('session')->set( 'isAuth',          true );
                $this->getDi()->get('session')->set( 'id',              $data_customer_id['0']['customer_id'] );


                $result = 1;

            }
            else
            {
                $result = 0;
            }

            $connection->commit();

            return true;
        }
        catch(\Exception $e)
        {
            $connection->rollback();
        }

        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function customerLogin( $registration )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $data =  $this->get(
                '
                    SELECT
                        id,
                        status,
                        users_group_id,
                        special_users_id
                    FROM
                        public.customers
                    WHERE
                        email = :email
                        AND
                        passwd = :passwd
                    LIMIT
                        1
                ',
                [
                    'email' => $registration['email'],
                    'passwd' => $registration['passwd'],
                ],
                -1
            );

            $result = 0;

            if( !empty($data) )
            {
                $this->exec(
                    '
                        UPDATE
                            public.customers
                        SET
                            lastlogin_date  = :lastlogin_date
                        WHERE
                            id     = :id
                    ',
                    [
                        'id'                => $data['0']['id'],
                        'lastlogin_date'    => date( 'Y-m-d H:i' )
                    ]
                );

                if( $data['0']['status'] == 1 )
                {
                    $result = 1;

                    // auth user
                    $this->getDi()->get('session')->set( 'isAuth',      true );
                    $this->getDi()->get('session')->set( 'id',          $data['0']['id'] );
                    $this->getDi()->get('session')->set( 'users_group_id', $data['0']['users_group_id'] );
                    $this->getDi()->get('session')->set( 'special_users_id', $data['0']['special_users_id'] );
                }
                else
                {
                    $result = 2; // user with status 0
                }

                unset($data);
            }
            else
            {
                $result = -1;
            }

            $connection->commit();

            return $result;

        }
        catch(\Exception $e)
        {
            $connection->rollback();
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getCustomer( $customer_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    name,
                    email,
					passwd,
                    birth_date,
                    phone,
                    city,
                    address,
                    delivery,
                    pay,
                    subscribed,
                    comments,
                    user_pass,
                    users_group_id,
                    special_users_id,
                    avatar
                FROM
                    public.customers
                WHERE
                    id = :id
                LIMIT
                    1
            ',
            [
                'id' => $customer_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getCustomerName( $customer_id )
    {
        $data =  $this->get(
            '
                SELECT
                    name
                FROM
                    public.customers
                WHERE
                    id = :id
                LIMIT
                    1
            ',
            [
                'id' => $customer_id
            ],
            -1
        );

        return $data['0']['name'];
    }

    /////////////////////////////////////////////////////////////////////////////
    public function editCustomerPhoto($id, $avatar) {
        return $this->exec(
            '
            UPDATE
              public.customers
            SET
              avatar = :avatar
            WHERE
              id =  :id
            ',
            [
                'avatar' => $avatar,
                'id'     => $id
            ]
        );
    }
    public function editCustomer( $customer_edit )
    {

        return $this->exec(
            '
                UPDATE
                    public.customers
                SET
                    name        = :name,
					passwd		= :passwd,
					email		= :email,
                    birth_date  = :birth_date,
                    phone       = :phone,
                    city        = :city,
                    address     = :address,


                    subscribed  = :subscribed,
                    users_group_id = :users_group_id
                WHERE
                    id=:id
            ',
            [
                'name'          => $customer_edit['name'],
                'passwd'		=> $customer_edit['passwd'],
                'email'			=> $customer_edit['email'],
                'birth_date'    => $customer_edit['birth_date'],
                'phone'         => $customer_edit['phone'],
                'city'          => $customer_edit['city'],
                'address'       => !empty($customer_edit['address']) ? $customer_edit['address'] : '',
                'subscribed'    => $customer_edit['subscribed'],
                'id'            => $customer_edit['id'],
                'users_group_id'=> !empty($customer_edit['users_group_id']) ? $customer_edit['users_group_id'] : null
            ]
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getAllUsersD(){
        return $this->get(
            '
                SELECT id, name, email FROM
                    public.customers
                WHERE
                    status = 1'
            ,
            [
            ],
            -1
        );
    }

    public function getCustomerAvatar($id) {
        return $this->get(
            '
            SELECT avatar from
              public.customers
            WHERE
              id = :id
            ',
            [
                'id' => $id
            ],
            -1
        );
    }
    
    public function editCustomerPasswd( $customer_edit_passwd )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $data =  $this->get(
                '
                    SELECT
                        passwd,
                        user_pass
                    FROM
                        public.customers
                    WHERE
                        id = :id
                    LIMIT
                        1
                ',
                [
                    'id' => $customer_edit_passwd['id']
                ],
                -1
            );

            if( $data['0']['passwd'] == $customer_edit_passwd['previous_passwd'] )
            {
                $data_change = $this->exec(
                    '
                        UPDATE
                            public.customers
                        SET
                            passwd    = :passwd,
                            user_pass = :user_pass
                        WHERE
                            id      = :id
                    ',
                    [
                        'id'                => $customer_edit_passwd['id'],
                        'passwd'            => $customer_edit_passwd['passwd'],
                        'user_pass'         => $customer_edit_passwd['user_pass']
                    ]
                );

                $result = $data_change ? 1 : -1;
            }
            else
            {
                $result = -1;
            }

            unset($data);

            $connection->commit();

            return $result;

        }
        catch(\Exception $e)
        {
            $connection->rollback();
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function registrateCustomer( $registration )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $data =  $this->get(
                '
                    SELECT
                        status
                    FROM
                        public.customers
                    WHERE
                        email = :email
                    LIMIT
                        1
                ',
                [
                    'email' => $registration['email']
                ],
                -1
            );
            if( empty( $data ) ) // new customer
            {
                $data_add_customer =  $this->get(
                    '
                        INSERT INTO
                            public.customers
                                (
                                    name,
                                    email,
                                    passwd,
                                    status
                                )
                                VALUES
                                (
                                    :name,
                                    :email,
                                    :passwd,
                                    0
                                )
                                RETURNING id
                    ',
                    [
                        'name'          => $registration['name'],
                        'email'         => $registration['email'],
                        'passwd'        => $registration['passwd'],
                    ],
                    -1
                );

                $confirm_key = $this->get(
                    '
                            INSERT INTO
                                public.customers_confirm
                                (
                                    customer_id,
                                    confirm_key
                                )
                                VALUES
                                (
                                    :customer_id,
                                    :confirm_key
                                )
                            RETURNING
                                confirm_key
                        ',
                    [
                        'customer_id' => $data_add_customer['0']['id'],
                        'confirm_key' => md5( rand() )
                    ],
                    -1
                );
            }
            else
            {
                $confirm_key['0']['confirm_key'] = false;
            }

            $connection->commit();

            return $confirm_key['0']['confirm_key'];

        }
        catch(\Exception $e)
        {
            $connection->rollback();
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function checkCustomerByConfirmKey( $confirm_key )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $data =  $this->get(
                '
                    SELECT
                        customer_id
                    FROM
                        public.customers_confirm
                    WHERE
                        confirm_key = :confirm_key
                    LIMIT
                        1
                ',
                [
                    'confirm_key' => $confirm_key
                ],
                -1
            );

            if( !empty( $data ) ) // customer isset
            {
                $data_delete = $this->exec(
                    '
                        DELETE
                        FROM
                            public.customers_confirm
                        WHERE
                            confirm_key  = :confirm_key
                    ',
                    [
                        'confirm_key'     => $confirm_key
                    ]
                );

                $data_update = $this->exec(
                    '
                        UPDATE
                            public.customers
                        SET
                            status          = 1
                        WHERE
                            id              = :id
                    ',
                    [
                        'id'                => $data['0']['customer_id'],
                    ]
                );

                $this->getDi()->get('session')->set( 'isAuth',          true );
                $this->getDi()->get('session')->set( 'id',              $data['0']['customer_id'] );
                $this->getDi()->get('session')->set( 'customer_email',  NULL );
                $this->getDi()->get('session')->remove('customer_email');

                $result = 1;
            }
            else
            {
                $result = 0;
            }

            $connection->commit();

            return $result;

        }
        catch(\Exception $e)
        {
            $connection->rollback();
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function restorePasswd( $email )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $data =  $this->get(
                '
                    SELECT
                        id,
                        name
                    FROM
                        public.customers
                    WHERE
                        email = :email
                    LIMIT
                        1
                ',
                [
                    'email' => $email
                ],
                -1
            );

            if( !empty( $data ) ) // customer isset
            {
                $confirm_key = $this->get(
                    '
                            INSERT INTO
                                public.customers_confirm
                                (
                                    customer_id,
                                    confirm_key
                                )
                                VALUES
                                (
                                    :customer_id,
                                    :confirm_key
                                )
                            RETURNING
                                confirm_key
                        ',
                    [
                        'customer_id' => $data['0']['id'],
                        'confirm_key' => md5( rand() )
                    ],
                    -1
                );

                $result =
                    [
                        'name'          =>  $data['0']['name'],
                        'confirm_key'   =>  $confirm_key['0']['confirm_key']
                    ];
            }
            else
            {
                $result = 0;
            }

            $connection->commit();

            return $result;

        }
        catch(\Exception $e)
        {
            $connection->rollback();
            p($e->getMessage());
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function LoginOrRegisterSocial( $registration )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $data =  $this->get(
                '
                    SELECT
                        name,
                        id
                    FROM
                        public.customers
                    WHERE
                        email = :email
                    LIMIT
                        1
                ',
                [
                    'email' => $registration['email']
                ],
                -1
            );

            if( empty( $data ) ) // new customer
            {
                $data_add_customer =  $this->get(
                    '
                        INSERT INTO
                            public.customers
                                (
                                    name,
                                    email,
                                    passwd,
                                    user_pass,
                                    birth_date,
                                    status
                                )
                                VALUES
                                (
                                    :name,
                                    :email,
                                    :passwd,
                                    :user_pass,
                                    :birth_date,
                                    1
                                )
                                RETURNING id
                    ',
                    [
                        'name'          => $registration['name'],
                        'email'         => $registration['email'],
                        'birth_date'    => $registration['bithday'],
                        'passwd'        => $registration['passwd'],
                        'user_pass'        => $registration['user_pass'],
                    ],
                    -1
                );

                $id = $data_add_customer['0']['id'];
            }
            else
            {
                $id = $data['0']['id'];
            }

            $this->getDi()->get('session')->set( 'isAuth',      true );
            $this->getDi()->get('session')->set( 'id',          $id );

            $connection->commit();

            return true;

        }
        catch(\Exception $e)
        {
            $connection->rollback();
        }
        return false;
    }

    public function getCustomerByEmail($email) {
        return $this->get(
            '
                    SELECT
                        name,
                        id
                    FROM
                        public.customers
                    WHERE
                        email = :email
                    LIMIT
                        1
                ',
            [
                'email' => $email
            ],
            -1
        );
    }


    public function subscrCustomer( $name, $email ){
        $user = $this->getActiveUsers($email);
        if(!$user){
            die('add new user');
        } else {
            die('update old one');
        }

    }

    public function updateUserPass($customers) {
        $sql = '
                        UPDATE
                            public.customers
                        SET user_pass = (CASE name

                            ';

        foreach($customers as $k => $customer) {
            $sql .= " WHEN '$customer[0]' THEN '$customer[1]'";
        }
        $sql .= ' END),
            passwd = (CASE name
        ';
        foreach($customers as $k => $customer) {
            $sql .= " WHEN '$customer[0]' THEN '$customer[2]'";
        }
        $sql .= ' END)';

        $sql .= ' WHERE ';
        foreach($customers as $k => $customer) {
            $sql .= " name LIKE '$customer[0]'";
            if($k != count($customers)-1) {
                $sql .= ' OR ';
            }
        }

        return $this->exec(
            $sql,
            [

            ]
        );
    }

    public function getByName($customers) {
        $sql = '
                        SELECT name, user_pass, passwd FROM
                            public.customers
                        WHERE (
                            ';

        foreach($customers as $k => $customer) {
            $sql .= " name LIKE '%$customer[0]%'";
            if($k != count($customers)-1) {
                $sql .= ' OR ';
            }
        }
        $sql .= ') and user_pass is not null';

        $sql .= ' ORDER BY name asc';

        return $this->get(
            $sql,
            [
            ],
            -1
        );
    }

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////