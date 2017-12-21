<?php

$arr = [
    0 => [
      'id'=>100,
      'title'=>'标题100',
      'author'=>'作者100',
    ],
    1 => [
        'id'=>200,
        'title'=>'标题200',
        'author'=>'作者200',
    ],
    2 => [
        'id'=>300,
        'title'=>'标题300',
        'author'=>'作者300',
    ],
];
print_r(array_column($arr, 'id'));
print_r(array_column($arr, null, 'id'));


/*

结果1：
Array
(
    [0] => 100
    [1] => 200
    [2] => 300
)

结果2：
Array
(
    [100] => Array
        (
            [id] => 100
            [title] => 标题100
            [author] => 作者100
        )

    [200] => Array
        (
            [id] => 200
            [title] => 标题200
            [author] => 作者200
        )

    [300] => Array
        (
            [id] => 300
            [title] => 标题300
            [author] => 作者300
        )

)

*/