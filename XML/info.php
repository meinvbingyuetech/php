<?php

$str = "<xml><ToUserName><![CDATA[gh_adb3723a197b]]></ToUserName>
<FromUserName><![CDATA[oU6dEw9cCbB5bsdQNrFTeCUledFU]]></FromUserName>
<CreateTime>1458796797</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
<EventKey><![CDATA[qrscene_147]]></EventKey>
<Ticket><![CDATA[gQHT7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3BEajJNcnJsOE1PSmhJWXVlaGFYAAIEJ3fzVgMEgDoJAA==]]></Ticket>
</xml>";

libxml_disable_entity_loader(true);
$postObj = simplexml_load_string($str, 'SimpleXMLElement', LIBXML_NOCDATA);
$fromUsername = $postObj->FromUserName;
$toUsername = $postObj->ToUserName;
$msgType = trim($postObj->MsgType);
$event = trim($postObj->Event);
$eventKey = trim($postObj->EventKey);