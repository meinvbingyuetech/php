<?php
$host = '*****';
$usr = '*****';
$pwd = '**********';
$local_file = './orderXML/order200.xml';
$ftp_path = 'order200.xml';
$conn_id = ftp_connect($host, 21) or die ("Cannot connect to host");
ftp_pasv($resource, true);
ftp_login($conn_id, $usr, $pwd) or die("Cannot login");

// perform file upload
ftp_chdir($conn_id, '/public_html/abc/');
$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_ASCII);
if($upload) { $ftpsucc=1; } else { $ftpsucc=0; }

// check upload status:
print (!$upload) ? 'Cannot upload' : 'Upload complete';
print "\n";

// close the FTP stream
ftp_close($conn_id);
?>