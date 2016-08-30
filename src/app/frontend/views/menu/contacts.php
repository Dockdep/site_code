<div id="content">
<div class="contacts">
<div class="breadcrumbs">
    <div class="inner">
        <div class="order_menu_shadow"></div>
        <ul class="clearfix">
            <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>" itemprop="url"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
            <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
            <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a href="<?= $this->seoUrl->setUrl('/contacts') ?>" title="<?= $t->_("contacts") ?>" class="breadcrumbs_last" itemprop="url"><span itemprop="title"><?= $t->_("contacts") ?></span></a></li>
        </ul>
    </div>
</div>

<div class="inner contacts_wrapper">
<h2><?= $t->_("contacts") ?></h2>

<div class="clearfix">
    <div class="float contacts_wrapper_map">
        <div class="map_description">
            <p class="map_description_name"><?= $t->_("head_office") ?></p>
            <p><?= $t->_("kiev") ?> <?= $t->_("street_one") ?></p>
            <p><?= $t->_("address_one") ?></p>
            <p>ТМ «Професійне насіння»</p>
            <p><?= $t->_("kiev") ?>, 02002 а/с 115</p>
            <p>/044/ 451 48 59 </p>
            <p>/044/ 581 67 15</p>
            <p>/067/ 464 48 59 <?= $t->_("kievstar_num") ?> </p>
            <p>/050/ 464 48 59 <?= $t->_("mts_num") ?> </p>
            <p><a href="mailto:info@hs.kiev.ua">info@hs.kiev.ua</a></p>
        </div>
        <div class="map">
            <div id="google-map-contacts1" style="width: 100%; height: 300px;"></div>
        </div>
        <div class="map_description_after_map">
            <p><?= $t->_("gps_coordinates") ?>: </p>
            <p><?= $t->_("facility") ?>: 50°21'39.63"N (50.361007) </p>
            <p><?= $t->_("longitude") ?>: 30°36'27.35"Е (30.607597)</p>
        </div>
    </div>


    <div class="float contacts_wrapper_map last">
        <div class="map_description">
            <p class="map_description_name"><?= $t->_("wholesale_warehouse") ?></p>
            <p><?= $t->_("kiev") ?>, <?= $t->_("street_two") ?> </p><br/ >
            <p><?= $t->_("kiev") ?>, <?= $t->_("address_three") ?> </p><br/ >
            <p><?= $t->_("kiev") ?>, <?= $t->_("address_four") ?> </p><br/ >
            <!--p><?= $t->_("kiev") ?>, <?= $t->_("address_five") ?> </p-->
        </div>
        <div class="map clearfix">
            <div id="google-map-contacts2" style="width: 100%; height: 300px;"></div>
        </div>
        <div class="map_description_after_map" style="display:none;">
            <p><?= $t->_("gps_coordinates") ?>: </p>
            <p><?= $t->_("facility") ?>: 50°21'39.63"N (50.361007) </p>
            <p><?= $t->_("longitude") ?>: 30°36'27.35"Е (30.607597)</p>
        </div>
    </div>
</div>

<div class="contacts_email_address">
    <p class="contacts_email_address_name"><?= $t->_("postal_address") ?>:</p>
    <p>02002</p>
    <p><?= $t->_("kiev") ?></p>
    <p><?= $t->_('po_box') ?> 115</p>
</div>

<div class="clearfix partners_dealers">
    <center><h3><?= $t->_("opt_vopros") ?></h3></center><br />
    <div class="partners">
        <table width="100%">
            <tbody>
            <tr class="dillers_district">
                <td>
                    <p align="center">РЕГІОНАЛЬНИЙ ПРЕДСТАВНИК</p>
                </td>
                <td>
                    <p align="center">ОБЛАСТЬ</p>
                </td>
                <td class="dillers_district">
                    <p align="center">ТЕЛЕФОН</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Абрамович Олена</p>
                </td>
                <td>
                    <p>Житомирська, Рівненська</p>
                </td>
                <td>
                    <p align="center">050 692 41 52,</p>

                    <p align="center">067-683-95-73</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Заскока Олександр</p>
                </td>
                <td>
                    <p>Полтавська, Сумська, Дніпропетровська</p>
                </td>
                <td>
                    <p align="center">050 412 22 00</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Кобзар Федір</p>
                </td>
                <td>
                    <p>Київська</p>
                </td>
                <td>
                    <p align="center">066 260 99 85</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Кучма Денис</p>
                </td>
                <td>
                    <p>Донецька, Луганська</p>
                </td>
                <td>
                    <p align="center">050 314 88 70</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Ликов Ігор</p>
                </td>
                <td>
                    <p>Одеська, Миколаївська</p>
                </td>
                <td>
                    <p align="center">099 498 40 08</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Марченко Михайло</p>
                </td>
                <td>
                    <p>Сумська, Чернігівська</p>
                </td>
                <td>
                    <p align="center">050 315 01 11</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Невлад Юрій</p>
                </td>
                <td>
                    <p>Вінницька, Хмельницька</p>
                </td>
                <td>
                    <p align="center">050 339 69 38</p>
                </td>
            </tr>

            <tr>
                <td>
                    <p>Подлужний Юрій</p>
                </td>
                <td>
                    <p>Херсонська, Миколаївська</p>
                </td>
                <td>
                    <p align="center">050 381 68 71</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Чабанюк Євген</p>
                </td>
                <td>
                    <p>Херсонська, Миколаївська</p>
                </td>
                <td>
                    <p align="center">066 828 96 52</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Свистун Сергій</p>
                </td>
                <td>
                    <p>Харківська</p>
                </td>
                <td>
                    <p align="center">050 315 11 16</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Сіренко Денис</p>
                </td>
                <td>
                    <p>Черкаська, Кіровоградська</p>
                </td>
                <td>
                    <p align="center">067 254 78 97</p>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="contacts_email_address clearfix">
    <p class="contacts_email_address_name"><?= $t->_("addresses retail_stores") ?> ТМ ‎"Професійне насіння"</p>

    <table class="contacts_list" cellpadding="0" cellspacing="0">
        <tr>
            <th><?= $t->_("city")?></th>
            <th>Адреса</th>
            <th><?= $t->_("time_work")?></th>
			<th>Телефон</th>
            <!--<th><?= $t->_("rout_map") ?></th>-->
        </tr>

        <?php
        /*
                            if( !empty( $shops ) )
                            {
                                $data_shops = '';

                                foreach( $shops as $s )
                                {
                                    $data_shops .=
                                        '<tr>'.
                                            '<td class="contacts_list_phone">'.$s['city'].'</td>'.
                                            '<td>'.$s['address'].'</td>'.
                                            '<td class="contacts_list_phone">'.$s['phone'].'</td>'.
                                            '<td class="contacts_list_phone">'.(!empty($s['map']) ? '<a href="'.$s['map'].'" title="Карта проїзду" target="_blank" rel="no-follow">Карта проїзду</a>' : '').'</td>'.
                                        '</tr>';
                                }

                                echo( $data_shops );
                            }
        */
        ?>
        <!--tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><?= $t->_("new_address_fifth") ?></td>
            <td>9.00-19.00 (<?= $t->_("vt_nd") ?>)</td>
            <td class="contacts_list_phone">050 315 50-56</td>
        </tr-->
        <tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><a href="https://www.google.com/maps?cid=10560965128246975743&hl=ru" title="<?= $t->_("new_address_second") ?>"><?= $t->_("new_address_second") ?></a></td>
            <td>8.30-17.30 (<?= $t->_("vt_nd") ?>)</td>
            <td class="contacts_list_phone">050-313-22-00</td>
            <!--<td class="contacts_list_phone"><a href="https://www.google.com.ua/maps/place/%D0%B2%D1%83%D0%BB.+%D0%92%D0%B5%D0%BB%D0%B8%D0%BA%D0%B0+%D0%9E%D0%BA%D1%80%D1%83%D0%B6%D0%BD%D0%B0,+%D0%9A%D0%B8%D1%97%D0%B2,+%D0%BC%D1%96%D1%81%D1%82%D0%BE+%D0%9A%D0%B8%D1%97%D0%B2/@50.4092713,30.3904529,17z/data=!3m1!4b1!4m2!3m1!1s0x40d4cbdcd3b45185:0x481b85b82221ba1a?hl=ru" title="<?= $t->_("rout_map") ?>" target="_blank" rel="no-follow"><?= $t->_("rout_map") ?></a></td>-->
        </tr>
        <tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><a href="https://www.google.com/maps?cid=5949473995652042489&hl=ru" title="<?= $t->_("new_address_third") ?>"><?= $t->_("new_address_third") ?></a></td>
            <td>9.00-19.00 (<?= $t->_("pn_sb") ?>)</td>
            <td class="contacts_list_phone">050-413-61-68</td>
            <!--<td class="contacts_list_phone"><a href="https://www.google.com.ua/maps/place/%D0%BF%D1%80%D0%BE%D1%81%D0%BF.+%D0%90%D0%BA%D0%B0%D0%B4%D0%B5%D0%BC%D1%96%D0%BA%D0%B0+%D0%93%D0%BB%D1%83%D1%88%D0%BA%D0%BE%D0%B2%D0%B0,+%D0%9A%D0%B8%D1%97%D0%B2,+%D0%BC%D1%96%D1%81%D1%82%D0%BE+%D0%9A%D0%B8%D1%97%D0%B2/@50.371692,30.4609831,17z/data=!3m1!4b1!4m2!3m1!1s0x40d4c850f75e048f:0xee142a65f4bd318a?hl=ru" title="<?= $t->_("rout_map") ?>" target="_blank" rel="no-follow"><?= $t->_("rout_map") ?></a></td>-->
        </tr>
        <!--tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><?= $t->_("new_address_nine") ?></td>
            <td>9.00-19.00 (<?= $t->_("pn_sb") ?>)</td>
        </tr-->
        <tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><a href="https://www.google.com/maps?cid=7171470467069443373&hl=ru" title="<?= $t->_("new_address_sixth") ?>"><?= $t->_("new_address_sixth") ?></a></td>
            <td>8.30-17.00 (<?= $t->_("pn_sb") ?>)</td>
            <td class="contacts_list_phone">050-476-16-55</td>
            <!--<td class="contacts_list_phone"><a href="https://www.google.com.ua/maps/place/%D0%A5%D0%B0%D1%80%D0%BA%D1%96%D0%B2%D1%81%D1%8C%D0%BA%D0%B5+%D1%88.,+166,+%D0%9A%D0%B8%D1%97%D0%B2,+%D0%BC%D1%96%D1%81%D1%82%D0%BE+%D0%9A%D0%B8%D1%97%D0%B2/@50.414657,30.660084,17z/data=!3m1!4b1!4m2!3m1!1s0x40d4c4e339783c01:0x9de857a6571ac29a?hl=ru" title="<?= $t->_("rout_map") ?>" target="_blank" rel="no-follow"><?= $t->_("rout_map") ?></a></td>-->
        </tr>
        <tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><a href="https://www.google.com/maps?cid=18229979471982705936&hl=ru" title="<?= $t->_("new_address_first") ?>"><?= $t->_("new_address_first") ?></a></td>
			<td noWrap>9.00-19.00 (<?= $t->_("pn_sb") ?>)</td>
            <td class="contacts_list_phone">050-442-63-53</td>
        </tr>
        <tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><a href="https://www.google.com/maps?cid=18042029842893234019&hl=ru" title="<?= $t->_("new_address_fourth") ?>"><?= $t->_("new_address_fourth") ?></a></td>
			<td>9.00-19.00 (<?= $t->_("pn_pt") ?>), 9.00-18.00 (<?= $t->_("sb_vs") ?>)</td>
            <td class="contacts_list_phone">050-410-38-92</td>
            <!--<td class="contacts_list_phone"><a href="https://www.google.com.ua/maps/place/%D0%A5%D0%B0%D1%80%D0%BA%D1%96%D0%B2%D1%81%D1%8C%D0%BA%D0%B5+%D1%88.,+166,+%D0%9A%D0%B8%D1%97%D0%B2,+%D0%BC%D1%96%D1%81%D1%82%D0%BE+%D0%9A%D0%B8%D1%97%D0%B2/@50.414657,30.660084,17z/data=!3m1!4b1!4m2!3m1!1s0x40d4c4e339783c01:0x9de857a6571ac29a?hl=ru" title="<?= $t->_("rout_map") ?>" target="_blank" rel="no-follow"><?= $t->_("rout_map") ?></a></td>-->
        </tr>
        <tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><a href="https://www.google.com/maps?cid=9290546046647461249&hl=ru" title="<?= $t->_("new_address_eighth") ?>"><?= $t->_("new_address_eighth") ?></a></td>
			<td>9.00-19.00 (<?= $t->_("pn_sb") ?>)</td>
            <td class="contacts_list_phone">050-442-62-31</td>
            <!--<td class="contacts_list_phone"><a href="https://www.google.com.ua/maps/place/%D0%A5%D0%B0%D1%80%D0%BA%D1%96%D0%B2%D1%81%D1%8C%D0%BA%D0%B5+%D1%88.,+166,+%D0%9A%D0%B8%D1%97%D0%B2,+%D0%BC%D1%96%D1%81%D1%82%D0%BE+%D0%9A%D0%B8%D1%97%D0%B2/@50.414657,30.660084,17z/data=!3m1!4b1!4m2!3m1!1s0x40d4c4e339783c01:0x9de857a6571ac29a?hl=ru" title="<?= $t->_("rout_map") ?>" target="_blank" rel="no-follow"><?= $t->_("rout_map") ?></a></td>-->
        </tr>
        <tr>
            <td class="contacts_list_phone"><?= $t->_("kiev") ?></td>
            <td><a href="https://www.google.com/maps?cid=17095950403227136610&hl=ru" title="<?= $t->_("new_address_ten") ?>"><?= $t->_("new_address_ten") ?></a></td>
            <td>8.00-19.00 (<?= $t->_("without_day_off") ?>)</td>
            <td class="contacts_list_phone">050-312-68-43</td>
            <!--<td class="contacts_list_phone"><a href="https://www.google.com.ua/maps/place/%D0%A5%D0%B0%D1%80%D0%BA%D1%96%D0%B2%D1%81%D1%8C%D0%BA%D0%B5+%D1%88.,+166,+%D0%9A%D0%B8%D1%97%D0%B2,+%D0%BC%D1%96%D1%81%D1%82%D0%BE+%D0%9A%D0%B8%D1%97%D0%B2/@50.414657,30.660084,17z/data=!3m1!4b1!4m2!3m1!1s0x40d4c4e339783c01:0x9de857a6571ac29a?hl=ru" title="<?= $t->_("rout_map") ?>" target="_blank" rel="no-follow"><?= $t->_("rout_map") ?></a></td>-->
        </tr>
    </table>


</div>



<?= $this->partial('partial/share'); ?>

</div>



</div>
</div>