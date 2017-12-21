<?php
/*
mysqli_affected_rows()	返回前一个 Mysql 操作的受影响行数。
mysqli_autocommit()	打开或关闭自动提交数据库修改功能。
mysqli_change_user()	更改指定数据库连接的用户。
mysqli_character_set_name()	返回数据库连接的默认字符集。
mysqli_close()	关闭先前打开的数据库连接。
mysqli_commit()	提交当前事务。
mysqli_connect_errno()	返回最后一次连接调用的错误代码。
mysqli_connect_error()	返回上一次连接错误的错误描述。
mysqli_connect()	打开到 Mysql 服务器的新连接。
mysqli_data_seek()	调整结果指针到结果集中的一个任意行。
mysqli_debug()	执行调试操作。
mysqli_dump_debug_info()	转储调试信息到日志中。
mysqli_errno()	返回最近的函数调用产生的错误代码。
mysqli_error_list()	返回最近的函数调用产生的错误列表。
mysqli_error()	返回字符串描述的最近一次函数调用产生的错误代码。
mysqli_fetch_all()	抓取所有的结果行并且以关联数据，数值索引数组，或者两者皆有的方式返回结果集。
mysqli_fetch_array()	以一个关联数组，数值索引数组，或者两者皆有的方式抓取一行结果。
mysqli_fetch_assoc()	以一个关联数组方式抓取一行结果。
mysqli_fetch_field_direct()	以对象返回结果集中单字段的元数据。
mysqli_fetch_field()	以对象返回结果集中的下一个字段。
mysqli_fetch_fields()	返回代表结果集中字段的对象数组。
mysqli_fetch_lengths()	返回结果集中当前行的列长度。
mysqli_fetch_object()	以对象返回结果集的当前行。
mysqli_fetch_row()	从结果集中抓取一行并以枚举数组的形式返回它。
mysqli_field_count()	返回最近一次查询获取到的列的数目。
mysqli_field_seek()	设置字段指针到特定的字段开始位置。
mysqli_field_tell()	返回字段指针的位置。
mysqli_free_result()	释放与某个结果集相关的内存。
mysqli_get_charset()	返回字符集对象。
mysqli_get_client_info()	返回字符串类型的 Mysql 客户端版本信息。
mysqli_get_client_stats()	返回每个客户端进程的统计信息。
mysqli_get_client_version()	返回整型的 Mysql 客户端版本信息。
mysqli_get_connection_stats()	返回客户端连接的统计信息。
mysqli_get_host_info()	返回 MySQL 服务器主机名和连接类型。
mysqli_get_proto_info()	返回 MySQL 协议版本。
mysqli_get_server_info()	返回 MySQL 服务器版本。
mysqli_get_server_version()	返回整型的 MySQL 服务器版本信息。
mysqli_info()	返回最近一次执行的查询的检索信息。
mysqli_init()	初始化 mysqli 并且返回一个由 mysqli_real_connect() 使用的资源类型。
mysqli_insert_id()	返回最后一次查询中使用的自动生成 id。
mysql_kill()	请求服务器终结某个 MySQL 线程。
mysqli_more_results()	检查一个多语句查询是否还有其他查询结果集。
mysqli_multi_query()	在数据库上执行一个或多个查询。
mysqli_next_result()	从 mysqli_multi_query() 中准备下一个结果集。
mysqli_num_fields()	返回结果集中的字段数。
mysqli_num_rows()	返回结果集中的行数。
mysqli_options()	设置选项。
mysqli_ping()	Ping 一个服务器连接，或者如果那个连接断了尝试重连。
mysqli_prepare()	准备一条用于执行的 SQL 语句。
mysqli_query()	在数据库上执行查询。
mysqli_real_connect()	打开一个到 Mysql 服务端的新连接。
mysqli_real_escape_string()	转义在 SQL 语句中使用的字符串中的特殊字符。
mysqli_real_query()	执行 SQL 查询。
mysqli_reap_async_query()	返回异步查询的结果。
mysqli_refresh()	刷新表或缓存，或者重置复制服务器信息。
mysqli_rollback()	回滚当前事务。
mysqli_select_db()	改变连接的默认数据库。
mysqli_set_charset()	设置默认客户端字符集。
mysqli_set_local_infile_default()	清除用户为 load local infile 命令定义的处理程序。
mysqli_set_local_infile_handler()	设置 LOAD DATA LOCAL INFILE 命令执行的回调函数。
mysqli_sqlstate()	返回前一个 Mysql 操作的 SQLSTATE 错误代码。
mysqli_ssl_set()	使用 SSL 建立安装连接。
mysqli_stat()	返回当前系统状态。
mysqli_stmt_init()	初始化一条语句并返回一个由 mysqli_stmt_prepare() 使用的对象。
mysqli_store_result()	传输最后一个查询的结果集。
mysqli_thread_id()	返回当前连接的线程 ID。
mysqli_thread_safe()	返回是否设定了线程安全。
mysqli_use_result()	初始化一个结果集的取回。
mysqli_warning_count()	返回连接中最后一次查询的警告数量。
*/

//连接数据库
$mysqli = new mysqli('host','username','password','database_name');

//如果连接错误则打印错误信息
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

//设置字符集
$mysqli->query("set names gb2312");

/********************************获取数据列表****************************************/
$results = $mysqli->query("SELECT id, product_code, product_desc, price FROM products");
while($row = $results->fetch_assoc()) {
    echo $row["id"]."<br>";
}  

while($row = $results->fetch_array()) {
	echo $row["id"]."<br>";
	echo $row[0]."<br>";
}

while($row = $results->fetch_object()) {
	echo $row->id."<br>";
}

//释放内存
$results->free();

//关闭连接
$mysqli->close();


/********************************获取单条数据****************************************/
$product_name = $mysqli->query("SELECT product_name FROM products WHERE id = 1")->fetch_object()->product_name; 
echo $product_name;
$mysqli->close();

/********************************获取行数****************************************/
$results = $mysqli->query("SELECT COUNT(*) FROM users");
$get_total_rows = $results->fetch_row(); 
$mysqli->close();

/********************************预处理****************************************/
$search_product = "PD1001";

$query = "SELECT id, product_code, product_desc, price FROM products WHERE product_code=?";
$statement = $mysqli->prepare($query);
$statement->bind_param('s', $search_product);
$statement->execute();
$statement->bind_result($id, $product_code, $product_desc, $price);

while($statement->fetch()) {
    echo $id;
    echo $product_code;
    echo $product_desc;
    echo $price;
}   

$statement->close();


--------------
$search_ID = 1; 
$search_product = "PD1001"; 

$query = "SELECT id, product_code, product_desc, price FROM products WHERE ID=? AND product_code=?";
$statement = $mysqli->prepare($query);
$statement->bind_param('is', $search_ID, $search_product);
$statement->execute();
$statement->bind_result($id, $product_code, $product_desc, $price);

while($statement->fetch()) {
    echo $id;
    echo $product_code;
    echo $product_desc;
    echo $price;

}   

$statement->close();

/********************************插入****************************************/
//-----------普通
$product_code = '"'.$mysqli->real_escape_string('P1234').'"';
$product_name = '"'.$mysqli->real_escape_string('42 inch TV').'"';
$product_price = '"'.$mysqli->real_escape_string('600').'"';

$insert_row = $mysqli->query("INSERT INTO products (product_code, product_name, price) VALUES($product_code, $product_name, $product_price)");

if($insert_row){
    print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
}else{
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}

//------------预处理
$product_code = 'P1234';
$product_name = '42 inch TV';
$product_price = '600';

$query = "INSERT INTO products (product_code, product_name, price) VALUES(?, ?, ?)";
$statement = $mysqli->prepare($query);

//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
$statement->bind_param('sss', $product_code, $product_name, $product_price);

if($statement->execute()){
    print 'Success! ID of last inserted record is : ' .$statement->insert_id .'<br />'; 
}else{
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}
$statement->close();


//------------批量
//product 1
$product_code1 = '"'.$mysqli->real_escape_string('P1').'"';
$product_name1 = '"'.$mysqli->real_escape_string('Google Nexus').'"';
$product_price1 = '"'.$mysqli->real_escape_string('149').'"';

//product 2
$product_code2 = '"'.$mysqli->real_escape_string('P2').'"';
$product_name2 = '"'.$mysqli->real_escape_string('Apple iPad 2').'"';
$product_price2 = '"'.$mysqli->real_escape_string('217').'"';

//product 3
$product_code3 = '"'.$mysqli->real_escape_string('P3').'"';
$product_name3 = '"'.$mysqli->real_escape_string('Samsung Galaxy Note').'"';
$product_price3 = '"'.$mysqli->real_escape_string('259').'"';

//Insert multiple rows
$insert = $mysqli->query("INSERT INTO products(product_code, product_name, price) VALUES
($product_code1, $product_name1, $product_price1),
($product_code2, $product_name2, $product_price2),
($product_code3, $product_name3, $product_price3)");

if($insert){
    //return total inserted records using mysqli_affected_rows
    echo 'Success! Total ' .$mysqli->affected_rows .' rows added.<br />'; 
}else{
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}

/********************************更新、删除****************************************/
//-----------普通
$results = $mysqli->query("UPDATE products SET product_name='inch TV', product_code='1' WHERE ID=1");
$results = $mysqli->query("DELETE FROM products WHERE ID=1");

if($results){
    echo 'Success! '; 
}else{
    echo 'Error : ('. $mysqli->errno .') '. $mysqli->error;
} 


//-----------预处理更新
$product_name = '52 inch TV';
$product_code = '9879798';
$find_id = 24;

$query = "UPDATE products SET product_name=?, product_code=? WHERE ID=?";
$statement = $mysqli->prepare($query);

//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
$results =  $statement->bind_param('ssi', $product_name, $product_code, $find_id);

if($results){
    print 'Success! record updated'; 
}else{
    print 'Error : ('. $mysqli->errno .') '. $mysqli->error;
}

//-----------删除
$results = $mysqli->query("DELETE FROM products WHERE added_timestamp < (NOW() - INTERVAL 1 DAY)");

if($results){
    print 'Success! deleted one day old records'; 
}else{
    print 'Error : ('. $mysqli->errno .') '. $mysqli->error;
}