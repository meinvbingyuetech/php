<?php

$cmt = new stdClass();
$cmt->id   = !empty($_REQUEST['id'])   ? intval($_REQUEST['id'])   : 0;//商品ID
$cmt->type = !empty($_REQUEST['type']) ? intval($_REQUEST['type']) : 0;
$cmt->content = !empty($_REQUEST['cont']) ? $_REQUEST['cont'] : '';
$cmt->rank = !empty($_REQUEST['star']) ? intval($_REQUEST['star']) : 0;