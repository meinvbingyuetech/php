<?php
/*
导出
SELECT * INTO OUTFILE 'c:/name.txt'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\''
LINES TERMINATED BY '\n'
FROM zones;

导入
LOAD DATA INFILE 'c:/name.txt' INTO TABLE zones
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\''
LINES TERMINATED BY '\n';
*/
set_time_limit(0);
define(HOST,'localhost');
define(USER,'root');
define(PWD,'kang20051');
define(DBNAME,'movie');
define(DIR,'D:/www/movie/mysql_data/');
//0为导入 1为导出 2为修复
define(OPERATION,1);

mysql_connect(HOST,USER,PWD) or
die("Could not connect: " . mysql_error());
mysql_select_db(DBNAME) or
die("Could not select db: " . mysql_error());
$result = mysql_query("show tables");

if(!is_dir(DIR)){
	die('Folder does not exist');
}
if(OPERATION==0){
	//前提：需要先前导入表结构
	//导出命令：mysqldump -u root -p -d test>test.sql
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		$fileName=DIR.$row[0].".txt";
		if(file_exists($fileName)){
			//delete  truncate
			$querySql='TRUNCATE TABLE `'.$row[0].'`';
			mysql_query($querySql) or
			die("Could not truncate table: ". $querySql . mysql_error());

			$querySql = "LOAD DATA INFILE '".$fileName."'
			INTO TABLE `".$row[0]."`
			FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\''
			LINES TERMINATED BY '\n'";
			mysql_query($querySql) or
			die("Could not insert into table: ". $querySql . mysql_error());
			echo 'insert into table '.$row[0].' success.<br/>';
		}else{
			echo 'Not insert into table '.$row[0].'<br/>';
		}
	}
	echo "The task is finished";
}else if(OPERATION==1){
	if (is_writable(DIR)) {
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$fileName=DIR.$row[0].".txt";
			if(file_exists($fileName)){
				unlink($fileName);
			}
			$querySql = "SELECT * INTO OUTFILE '".$fileName."'
			FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\''
			LINES TERMINATED BY '\n'
			FROM `".$row[0]."`";
			mysql_query($querySql) or
			die("Could not dump table: ". $querySql . mysql_error());
			echo 'dump table '.$row[0].' success.<br/>';
		}
		echo "The task is finished";
	}else{
		echo 'Folder '.DIR.' can not writeable';
	}
}else if(OPERATION==2){
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		$fileName=DIR.$row[0].".txt";
		if(file_exists($fileName)){
			unlink($fileName);
		}
		$querySql = "REPAIR TABLE `$row[0]`";
		mysql_query($querySql) or
		die("Could not repair table: ". $querySql . mysql_error());
		echo 'repair table '.$row[0].' success.<br/>';
	}
}

mysql_free_result($result);
mysql_close();
?>