<?php
/**
*版权说明：该版本是在“IEB_UPLOAD CLASS Ver 1.1”的基础上二次开发的，原程序对图片的裁剪将使图片变形、失真！本程序用数据参数与原图片文件参数(主要是指宽和高)进行对比，得出比例值，先生成与原图片同比例缩放的图片，然后再以该中间图中心开始截取，从而获得缩略图，当然，图片会被裁剪，但是是最小限度的裁剪！
*@author：swin.wang  Email: php_in_china@yahoo.com.cn
*@update:  sunbeam   Email: sunjingzhi2@126.com
*/
class ieb_upload{
 
 /**
  * 表单中 文件框<input type="file" id="FileName">名称
  * @var string 
  */
 var $FileName = ""; 
 
 /**
  * 上传目录
  * @var string
  */
 var $Directroy = ""; 
 
 /**
  * 最大文件大小
  * @var int
  */
 var $MaxSize = 2097152; 
 
 /**
  * 是否可以上传
  * @var bool
  */
 var $CanUpload = true; 
 
 /**
  * 上传文件名
  * @var string
  */
 var $doUpFile = ''; 
 
 /**
  * 缩略图名
  * @var string
  */
 var $sm_File = ''; 
 
 /**
  * 异常号
  * @var int
  */
 var $Error = 0; 
 
 /**
 * 构造函数
 *
 * @param  string  $FileName
 * @param  string  $dirPath
 * @param  int  $maxSize
 * @return  null
 */
 function ieb_upload($FileName='', $dirPath='', $maxSize=2097152) //(1024*2)*1024=2097152 就是 2M
 {
  //global $FileName, $Directroy, $MaxSize, $CanUpload, $Error, $doUpFile, $sm_File;
  //初始化各种参数
  $this->FileName = $FileName;
  $this->MaxSize = $maxSize;
  
  if ($FileName == ''){
   $this->CanUpload = false;
   $this->Error = 1;
   break;
  }
  
  if ($dirPath != ''){
   $this->Directroy = $dirPath;
  }else{
   $this->Directroy = './';
  }
 }
 

 /**
  * 检查文件是否存在
  * 
  * @return bool 
  */
 function scanFile()
 {  
  if ($this->CanUpload){ 
   $scan = is_readable($_FILES[$this->FileName]['name']);  
   if ($scan){   
    $Error = 2;
   }  
   return $scan;
  }
 }
 

 /**
  * 获取文件大小
  * 
  * @return int 
  */
 function getSize($format = 'B')
 {
  
  if ($this->CanUpload){  
   if ($_FILES[$this->FileName]['size'] == 0){
    $this->Error = 3;
    $this->CanUpload = false;
   }  
   switch ($format){
    case 'B':
    return $_FILES[$this->FileName]['size'];
    break;
    
    case 'M':
    return ($_FILES[$this->FileName]['size'])/(1024*1024);
   }  
  }
 }
 


 /**
  * 获取文件类型
  * 
  * @return string 
  */
 function getExt()
 { 
  if ($this->CanUpload){
   $ext=$_FILES[$this->FileName]['name'];
   $extStr=explode('.',$ext);
   $count=count($extStr)-1;
  }
  return $extStr[$count];
 }
 
 
 /**
  * 获取文件名称
  * 
  * @return string 
  */
 function getName()
 { 
  if ($this->CanUpload){
   return $_FILES[$this->FileName]['name'];
  }
 }
 
 /**
  * 新建文件名
  * 
  * @return string 
  */
 function newName()
 {  
  if ($this->CanUpload){
   $FullName=$_FILES[$this->FileName]['name'];
   $extStr=explode('.',$FullName);
   $count=count($extStr)-1;
   $ext = $extStr[$count];
   
   return date('YmdHis').rand(0,9).'.'.$ext;
  }
 }
 
 
 /**
  * 上传文件，失败时返回异常类型号
  * 
  * @param   string   $fileName
  * @return    
  */ 
 function upload($fileName = '')
 {  
  if ($this->CanUpload){
   if ($_FILES[$this->FileName]['size'] == 0){
    $this->Error = 3;
    $this->CanUpload = false;
    return $this->Error;
    break;
   }
  }
  
  if($this->CanUpload){ 
   if ($fileName == ''){
    $fileName = $_FILES[$this->FileName]['name'];
   }  
   $this->doUpload=@copy($_FILES[$this->FileName]['tmp_name'], $this->Directroy.$fileName);  
   if($this->doUpload)
   {
    $this->doUpFile = $fileName;
    chmod($this->Directroy.$fileName, 0777);
    return true;
   }else{
    $this->Error = 4;
    return $this->Error;
   }
  }
 }
 

 /**
  * 创建图片缩略图,成功返回真，否则返回错误类型号
  *
  * @param string $dscChar   前缀
  * @param int $width    缩略图宽
  * @param int $height   缩略图高
  * @return 
  */
 function thumb($dscChar='',$width=160,$height=120)
 {  
  if ($this->CanUpload && $this->doUpFile != ''){
   $srcFile = $this->doUpFile;
   
   if ($dscChar == ''){
    $dscChar = 'sm_';
   }
   
   $dscFile = $this->Directroy.$dscChar.$srcFile;
   $data = getimagesize($this->Directroy.$srcFile,&$info);
   
   switch ($data[2]) {
    case 1:
    $im = @imagecreatefromgif($this->Directroy.$srcFile);
    break;
    
    case 2:
    $im = @imagecreatefromjpeg($this->Directroy.$srcFile);
    break;
    
    case 3:
    $im = @imagecreatefrompng($this->Directroy.$srcFile);
    break;
   }
   
   $srcW=imagesx($im);
   $srcH=imagesy($im);
   
   if(($srcW/$width)>=($srcH/$height)){
    $temp_height=$height;
    $temp_width=$srcW/($srcH/$height);
    $src_X=abs(($width-$temp_width)/2);
    $src_Y=0;
   }
   else{
    $temp_width=$width;
    $temp_height=$srcH/($srcW/$width);
    $src_X=0;
    $src_Y=abs(($height-$temp_height)/2);
   }
   $temp_img=imagecreatetruecolor($temp_width,$temp_height);
   imagecopyresized($temp_img,$im,0,0,0,0,$temp_width,$temp_height,$srcW,$srcH);
      
   $ni=imagecreatetruecolor($width,$height);
   imagecopyresized($ni,$temp_img,0,0,$src_X,$src_Y,$width,$height,$width,$height);
   $cr = imagejpeg($ni,$dscFile);
   chmod($dscFile, 0777);
      
   if ($cr){
    $this->sm_File = $dscFile;
    return true;
   }else{
    $this->Error = 5;
    return $this->Error;
   }
  }
 }
 
 
 /**
  * 返回错误类型号，用做异常处理
  *
  * @return int
  */
 function Err(){
  return $this->Error;
 }
 
 
 /**
  * 上传后的文件名
  *
  * @return unknown
  */
 function UpFile(){
  if ($this->doUpFile != ''){
   return $this->doUpFile;
  }else{
   $this->Error = 6;
  }
 }
 
 
 /**
  * 上传文件的路径
  *
  * @return unknown
  */
 function filePath(){
  if ($this->doUpFile != ''){
   return $this->Directroy.$this->doUpFile;
  }else{
   $this->Error = 6;
  }  
 }
 
 
 /**
  * 缩略图文件名称
  *
  * @return unknown
  */
 function thumbMap(){
  if ($this->sm_File != ''){
   return $this->sm_File;
  }else{
   $this->Error = 6;
  }
 }
 
 /**
  * 版本信息
  *
  * @return unknown
  */
 function ieb_version(){
  return 'Ver 0.1';
 }
}

?>

<HTML> 
<HEAD> 
<TITLE>文件上传表格</TITLE> 
</HEAD> 
<BODY> 
<TABLE> 
<FORM ENCTYPE="multipart/form-data" NAME="MyForm"  METHOD="POST"> 
<TR><TD>选择上传文件</TD><TD>
<INPUT NAME="MyFile" TYPE="File"></TD></TR> 
<TR><TD COLSPAN="2">
<INPUT NAME="submit" VALUE="上传" TYPE="submit"></TD></TR> 
</TABLE> 
</BODY> 
</HTML> 

<?
 //var_dump($_FILES['MyFile']);
 $dir = dirname(__FILE__);
 $imgHandle = new ieb_upload('MyFile',$dir."/"); 
 $old_file_name = $imgHandle->getName();
 $old_file_fooder = $imgHandle->getExt();
 $file_size=$imgHandle-> getSize();
 $file_name=$imgHandle-> newName();
 $imgHandle->upload($file_name); 
 $imgHandle->thumb("small_",160,120);

?>

