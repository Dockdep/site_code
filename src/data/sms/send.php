<?php
require_once('sms.php');

$tel = "+380502360568";
$text = "Vash zakaz prinyat.
V blijayshee vremya menedjer svyajetsya s Vami
(044) 303-97-60";
sendSMS($tel,$text);