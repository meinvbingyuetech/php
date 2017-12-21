<?php

function get_extension($file)
{
return pathinfo($file, PATHINFO_EXTENSION);
}

function get_extension($file)
{
return substr(strrchr($file, '.'), 1);
}