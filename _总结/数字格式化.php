<?php
/* 
string number_format ( float $number [, int $decimals ] )
string number_format ( float $number , int $decimals , string $dec_point , string $thousands_sep )
decimals :小数点后面2位
dec_point ：小数点用什么符号
thousands_sep：每隔3位时用什么符号
*/
$number = 1234.56;

// english notation (default)
$english_format_number = number_format($number);
// 1,235

// French notation
$nombre_format_francais = number_format($number, 2, ',', ' ');
// 1 234,56

$number = 1234.5678;

// english notation without thousands seperator
$english_format_number = number_format($number, 2, '.', '');
// 1234.57


/**
 * 通过千位分组来格式化数字
 */
echo number_format("1000000"); //1,000,000
echo number_format("1000000", 2); //1,000,000.00
echo number_format("1000000", 2, ",", "."); //1.000.000,00
?>