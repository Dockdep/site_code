<?php
/*
foreach($groups as $i){
//print_r($i);
	$res = $this->models->getItems()->getSizesByGroupId( 2, $i['group_id'] );
	echo $i['id'].'-[';
	foreach($res as $m){
		$r = $this->models->getItems()->getOneItem( 2, $m['id'] );
		echo $m['id'].'-'.$r[0]['price2'].';';
	}
	echo'];';
}*/

$price_list = array();
$num = 1;
foreach($groups as $i){
//print_r($i);
    $res = $this->models->getItems()->getSizesByGroupId( 2, $i['group_id'] );

    $sub_num = 1;
    foreach($res as $m){
        $r = $this->models->getItems()->getOneItem( 2, $m['id'] );

        $row_name = 'p_list_'.$i['id'];
        $price_list[$row_name][$sub_num++] = $r[0]['price2'];
    }

    $num++;
}

echo json_encode($price_list);

?>