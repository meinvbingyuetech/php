<?php

header("HTTP/1.1 301 Moved Permanently");
header("location: $url");
header("Content-type: text/html; charset=utf-8");