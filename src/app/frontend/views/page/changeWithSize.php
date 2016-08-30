<?php
if(isset($special_user)) {
    $data['price'] = number_format(isset($item['prices'][$special_user['status']])
        ? $item['prices'][$special_user['status']]
        : $item['price2'], 2, '.', '');
} else {
    $data['price'] = $item['price2'];
}
$data['html'] = '<div class="clearfix buy_compare">
                    <div class="one_item_price float">'. $t->_("price") .
    ' <span>' . $data['price'] . '</span> грн';

$data['html'] .= '</ul></div><div data-group_id="' . $item['group_id'] .'" class="one_item_buttons float">';

$data['html'] .= '<a data-group_id="' . $item['group_id'] .'" href="javascript:;" title="" class="';

if($item['status_real'] == 1) {
    $data['html'] .= 'btn green buy';
} else {
    $data['html'] .= 'not_available grey';
}
$data['html'] .= '">' . $t->_("buy") . '</a>';

$data['html'] .= '</div><div class="one_item_compare float">' .
'<input type="checkbox" id="compare_item_' . $item['id'] . '" value="' . $item['type'] . '-'. $item['catalog'] . '-' . $item['id'] . '" />' .
'<label for="compare_item_'. $item['id'] .'"><span></span>' . $t->_("compared_to") . '</label>' .
'<input type="hidden" class="item_id_for_basket" value="'. $item['id'] .'">' .
'<input type="hidden" class="current_item_size" value="'. $item['size'] .'">' .
'</div>' .
'</div>' .
'<div class="clearfix features">';


foreach($item['filters'] as $v) {
    $data['html'] .= '<a href="#" class="float">' . $v['value_value'] . '</a>';
}

$data['image'] = $item['image'];
$data['status'] = $item['status'];
$data['product_id'] = $item['product_id'];
$data['color'] = $item['color'];
$data['group_id'] = $item['group_id'];

if(!empty($item['prices'][0])) {
    $data['recommended_prices']['name'] = $t->_('recommended_prices');
    $data['recommended_prices']['stock_availability'] = $item['stock_availability'];
    $data['recommended_prices']['firm'] = $item['firm'];
    $data['recommended_prices']['firm_product'] = $t->_('firm_product');
    for($i = 0; $i < $special_user['status']; $i++) {
        $data['recommended_prices']['dealer'][$i]['dealer_price'] = $item['prices'][$i];
        $data['recommended_prices']['dealer'][$i]['dealer_name'] = $special_users[$i]['title'];
    }
}


echo json_encode($data);