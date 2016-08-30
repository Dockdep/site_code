COMMENT ON COLUMN items_group_alias.group_id IS 'ID группы товаров';
COMMENT ON COLUMN items_group_alias.lang_id IS 'язык: 1 - ua, 2 - ru';
COMMENT ON COLUMN items_group_alias.type IS 'тип группы товаров';
COMMENT ON COLUMN items_group_alias.subtype IS 'подтип группы товаров';
COMMENT ON COLUMN items_group_alias.alias IS 'alias группы товаров';

COMMENT ON COLUMN items.id IS 'ID товара';
COMMENT ON COLUMN items.group_id IS 'ID группы товаров';
COMMENT ON COLUMN items.type IS 'тип группы товаров';
COMMENT ON COLUMN items.subtype IS 'подтип группы товаров';
COMMENT ON COLUMN items.product_id IS 'код товара';
COMMENT ON COLUMN items.price1 IS 'цена1 товара';
COMMENT ON COLUMN items.price2 IS 'цена2 товара';
COMMENT ON COLUMN items.size IS 'фасовка товара';
COMMENT ON COLUMN items.color IS 'цвет товара';
COMMENT ON COLUMN items.status IS 'статус: 1 - активный, 0 - не активный';

COMMENT ON COLUMN items_i18n.item_id IS 'ID товара';
COMMENT ON COLUMN items_i18n.lang_id IS 'язык: 1 - ua, 2 - ru';
COMMENT ON COLUMN items_i18n.group_id IS 'ID группы товаров';
COMMENT ON COLUMN items_i18n.meta_title IS 'meta title товара';
COMMENT ON COLUMN items_i18n.meta_description IS 'meta description товара';
COMMENT ON COLUMN items_i18n.title IS 'название товара';
COMMENT ON COLUMN items_i18n.content_description IS 'описание товара';
COMMENT ON COLUMN items_i18n.description IS 'короткое описание товара';
COMMENT ON COLUMN items_i18n.content_video IS 'видео товара';

COMMENT ON COLUMN items_group_buy_with.group_id IS 'ID группы товаров';
COMMENT ON COLUMN items_group_buy_with.group_id_buy_with IS 'массив ID груп товаров';



COMMENT ON COLUMN filters_keys_i18n.filter_key_id IS 'ID filters_keys';
COMMENT ON COLUMN filters_keys_i18n.lang_id IS 'язык: 1 - ua, 2 - ru';
COMMENT ON COLUMN filters_keys_i18n.value IS 'значение filters_keys';
COMMENT ON COLUMN filters_keys_i18n.alias IS 'alias filters_keys';


COMMENT ON COLUMN filters_values_i18n.filter_value_id IS 'ID filters_values';
COMMENT ON COLUMN filters_values_i18n.lang_id IS 'язык: 1 - ua, 2 - ru';
COMMENT ON COLUMN filters_values_i18n.value IS 'значение filters_values';
COMMENT ON COLUMN filters_values_i18n.alias IS 'alias filters_values';

COMMENT ON COLUMN filters.id IS 'ID фильтра';
COMMENT ON COLUMN filters.type IS 'тип группы товаров';
COMMENT ON COLUMN filters.subtype IS 'подтип группы товаров';
COMMENT ON COLUMN filters.filter_key_id IS 'ID filters_keys';
COMMENT ON COLUMN filters.filter_value_id IS 'ID filters_values';


COMMENT ON COLUMN filters_items.filter_id IS 'ID фильтра';
COMMENT ON COLUMN filters_items.type IS 'тип группы товаров';
COMMENT ON COLUMN filters_items.subtype IS 'подтип группы товаров';
COMMENT ON COLUMN filters_items.group_id IS 'ID группы товаров';
COMMENT ON COLUMN filters_items.item_id IS 'ID товара';

///


COMMENT ON COLUMN properties_keys_i18n.property_key_id IS 'ID property_key';
COMMENT ON COLUMN properties_keys_i18n.lang_id IS 'язык: 1 - ua, 2 - ru';
COMMENT ON COLUMN properties_keys_i18n.value IS 'значение property_key';


COMMENT ON COLUMN properties_values_i18n.property_value_id IS 'ID property_value';
COMMENT ON COLUMN properties_values_i18n.lang_id IS 'язык: 1 - ua, 2 - ru';
COMMENT ON COLUMN properties_values_i18n.value IS 'значение property_value';

COMMENT ON COLUMN properties.id IS 'ID характеристики';
COMMENT ON COLUMN properties.type IS 'тип группы товаров';
COMMENT ON COLUMN properties.subtype IS 'подтип группы товаров';
COMMENT ON COLUMN properties.property_key_id IS 'ID property_key';
COMMENT ON COLUMN properties.property_value_id IS 'ID property_value';


COMMENT ON COLUMN properties_items.property_id IS 'ID характеристики';
COMMENT ON COLUMN properties_items.type IS 'тип группы товаров';
COMMENT ON COLUMN properties_items.subtype IS 'подтип группы товаров';
COMMENT ON COLUMN properties_items.group_id IS 'ID группы товаров';
COMMENT ON COLUMN properties_items.item_id IS 'ID товара';


///


COMMENT ON COLUMN orders.id IS 'ID заказа';
COMMENT ON COLUMN orders.customer_id IS 'ID заказчика ( >0 - customers.id, 0 - не зарегистрирован )';
COMMENT ON COLUMN orders.name IS 'имя заказчика';
COMMENT ON COLUMN orders.email IS 'email заказчика';
COMMENT ON COLUMN orders.phone IS 'телефон заказчика';
COMMENT ON COLUMN orders.city IS 'город заказчика';
COMMENT ON COLUMN orders.address IS 'адрес заказчика';
COMMENT ON COLUMN orders.delivery IS 'способ доставки';
COMMENT ON COLUMN orders.pay IS 'способ оплаты';
COMMENT ON COLUMN orders.comments IS 'комментарии заказчика';
COMMENT ON COLUMN orders.created_date IS 'дата создания заказа';
COMMENT ON COLUMN orders.last_modified_date IS 'дата последней правки заказа';
COMMENT ON COLUMN orders.status IS 'статус: 1 - активный, 0 - не активный, ...';

COMMENT ON COLUMN orders2items.order_id IS 'ID заказа';
COMMENT ON COLUMN orders2items.item_id IS 'ID товара';
COMMENT ON COLUMN orders2items.item_count IS 'количество';



///////

DROP TABLE customers;

CREATE TABLE customers
(
  id serial NOT NULL, -- ID заказчика
  name character varying(255) NOT NULL, -- имя заказчика
  email character varying(255), -- email заказчика
  passwd character varying(128) NOT NULL, -- пароль заказчика
  birth_date timestamp without time zone, -- дата рождения заказчика
  phone character varying(255), -- контактный телефон заказчика
  city character varying(255), -- город проживания заказчика
  address character varying(255), -- адрес проживания заказчика
  delivery integer,
  pay integer,
  subscribed integer NOT NULL DEFAULT 0, -- подписка на рассылку новостей и предложений [1 - да, 0 - нет]
  comments text,
  registration_date timestamp without time zone NOT NULL DEFAULT now(),
  lastlogin_date timestamp without time zone NOT NULL DEFAULT now(),
  options hstore,
  status integer NOT NULL DEFAULT 0,
  CONSTRAINT customers_id_pk PRIMARY KEY (id),
  CONSTRAINT customers_email_unique UNIQUE (email)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE customers
  OWNER TO semena;
COMMENT ON COLUMN customers.id IS 'ID заказчика';
COMMENT ON COLUMN customers.name IS 'имя заказчика';
COMMENT ON COLUMN customers.email IS 'email заказчика';
COMMENT ON COLUMN customers.passwd IS 'пароль заказчика';
COMMENT ON COLUMN customers.birth_date IS 'дата рождения заказчика';
COMMENT ON COLUMN customers.phone IS 'контактный телефон заказчика';
COMMENT ON COLUMN customers.city IS 'город проживания заказчика';
COMMENT ON COLUMN customers.address IS 'адрес проживания заказчика';
COMMENT ON COLUMN customers.subscribed IS 'подписка на рассылку новостей и предложений [1 - да, 0 - нет]';

DROP TABLE customers_confirm;

CREATE TABLE customers_confirm
(
  customer_id integer NOT NULL,
  confirm_key character varying(255) NOT NULL,
  CONSTRAINT customers_confirm_customerid_confirmkey_pk PRIMARY KEY (customer_id, confirm_key),
  CONSTRAINT customersconfirm_customerid_fk FOREIGN KEY (customer_id)
      REFERENCES customers (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE customers_confirm
  OWNER TO semena;


DROP TABLE orders2items;

CREATE TABLE orders2items
(
  order_id integer NOT NULL, -- ID заказа
  item_id integer NOT NULL, -- ID товара
  item_count integer NOT NULL, -- количество
  CONSTRAINT orders2items_orderid_itemid_pk PRIMARY KEY (order_id, item_id),
  CONSTRAINT orders2items_itemid_fk FOREIGN KEY (item_id)
      REFERENCES items (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT orders2items_orderid_fk FOREIGN KEY (order_id)
      REFERENCES orders (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE orders2items
  OWNER TO semena;
COMMENT ON COLUMN orders2items.order_id IS 'ID заказа';
COMMENT ON COLUMN orders2items.item_id IS 'ID товара';
COMMENT ON COLUMN orders2items.item_count IS 'количество';






CREATE TABLE orders
(
  id serial NOT NULL, -- ID заказа
  customer_id integer NOT NULL DEFAULT 0, -- ID заказчика ( >0 - customers.id, 0 - не зарегистрирован )
  name character varying(255) NOT NULL, -- имя заказчика
  email character varying(255), -- email заказчика
  phone character varying(255) NOT NULL, -- телефон заказчика
  city character varying(255), -- город доставки заказа
  address character varying(255), -- адрес доставки заказа
  delivery integer NOT NULL, -- способ доставки
  pay integer NOT NULL, -- способ оплаты
  comments text, -- комментарии заказчика к заказу
  created_date timestamp without time zone NOT NULL DEFAULT now(), -- дата создания заказа
  last_modified_date timestamp without time zone NOT NULL DEFAULT now(),
  novaposhta_tnn integer NOT NULL DEFAULT 0,
  options hstore,
  status integer NOT NULL DEFAULT 1, -- статус: 1 - активный, 0 - не активный, ...
  CONSTRAINT orders_id_pk PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);

COMMENT ON COLUMN orders.id IS 'ID заказа';
COMMENT ON COLUMN orders.customer_id IS 'ID заказчика ( >0 - customers.id, 0 - не зарегистрирован )';
COMMENT ON COLUMN orders.name IS 'имя заказчика';
COMMENT ON COLUMN orders.email IS 'email заказчика';
COMMENT ON COLUMN orders.phone IS 'телефон заказчика';
COMMENT ON COLUMN orders.city IS 'город доставки заказа';
COMMENT ON COLUMN orders.address IS 'адрес доставки заказа';
COMMENT ON COLUMN orders.delivery IS 'способ доставки';
COMMENT ON COLUMN orders.pay IS 'способ оплаты';
COMMENT ON COLUMN orders.comments IS 'комментарии заказчика к заказу';
COMMENT ON COLUMN orders.created_date IS 'дата создания заказа';
COMMENT ON COLUMN orders.last_modified_date IS 'дата последней правки заказа';
COMMENT ON COLUMN orders.tnn IS 'номер TNN в Новой Почте';
COMMENT ON COLUMN orders.status IS 'статус: 1 - активный, 0 - не активный, ...';