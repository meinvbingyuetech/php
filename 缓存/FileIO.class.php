<?php
$FILEERRORMSG[0] = "Cannot create dir. Please check you system set.";
$FILEERRORMSG[1] = "Cannot create file. Please check you system set.";
$FILEERRORMSG[2] = "The file is not exists.";
$FILEERRORMSG[3] = "The dir is not exists.";

class FileIO
{
	function FileIO()
	{
	}
	/**
	*读取目录
	*@param $dirPath	dir名称
	*@return array		返回数组
	*/
	function getDirFile($dirPath)
	{
		$fArray = array();
		$dArray = array();
		//如果是文件
		if(FileIO::isFileExists($dirPath))
		{
			$fArray[] = $dirPath;
			return array('file'=>$fArray,'dir'=>$dArray);
		}
		//如果不是目录
		if(!FileIo::isDirExists($dirPath))
		{
			return array('file'=>$fArray,'dir'=>$dArray);
		}

		$handle=opendir($dirPath);
		while($file=readdir($handle))
		{
			if($file=='.' || $file=='..') continue;
			$fileName = $dirPath.$file;
			if(FileIo::isDirExists($fileName))
			{
				$dArray[] = $file;
			}
			if(FileIO::isFileExists($fileName))
			{
				$fArray[] = $file;
			}
		}
		closedir($handle);
		return array('file'=>$fArray,'dir'=>$dArray);
		
	}
	/**
	* 
	* @author  sanshi
	* @version 1.0.0 Thu Aug 18 01:08:55 CST 2005
	* @param 		string		$fileName	文件名		
	* @return  		string		$fileType	文件后缀
	* @deprecated
	*	取得文件后缀（只取得文件的最后一个后缀名）
	*/
	function getFileType($fileName)
	{
		return strtolower(end(explode('.',$fileName)));
	}
	/**
	*写入一个文件
	*@param $fileName	文件名称
	*@param $data		文件里写入的内容
	*@param $mode		文件写入模式
	*@return bool		成功返回true 失败有警告提示
	*/
	function writeFile($fileName,$data,$mode="",$isCp=false)
	{
		global $FILEERRORMSG;
		$fileName = str_replace("\\","/",$fileName);
		$dirName = dirname( $fileName );//获得部分文件目录
		//$data=strval($data);
		if( !is_dir($dirName) ) //如果不是目录
		{
			if( !FileIo::createDir($dirName) ) //如果不能建立目录
			{
				return false; 
			}
		}
		//建立bak文件
		if( FileIO::isFileExists($fileName) && $isCp ) //判断文件是否存在
				FileIO::copyFile($fileName,$fileName."_".date("Y,m,d,H,i,s")); //复制文件，成功返回true
		if( function_exists("file_put_contents") && empty($mode) ) //如果方法存在与$mode是空
		{
			$inputLen = file_put_contents($fileName,strval($data)); //将$date以字符串写入$fileName文件里面
			if( $inputLen != strlen($data) ) //如果$inputLen 没有长度
			{
				//trigger_error($FILEERRORMSG[1],SystemExceptionType(2));
				return false; 
			}
		}else{
			$mode .= empty($mode) ? "w+":"b";  //是空就写入，否则就是二进制b
			//echo $mode; exit();
			$fp = fopen($fileName,$mode);
			if( !$fp )
			{
				//trigger_error($FILEERRORMSG[1],SystemExceptionType(2));
				return false;
			}
			fwrite($fp,$data,strlen($data));  //写入数据
			@fclose($fp); //关闭数据 
		}
		return true;
	}
	/**
	* 建立目录
	*@parma		$dirName	目录名称
	*@return	bool		成功返回true
	*/
	function createDir($dirName)
	{
		//echo $dirName;exit();
		global $FILEERRORMSG;
		$dirName = str_replace("\\","/",$dirName);
		$dirArr = explode('/',$dirName);
		//增加对绝对目录的判断
		if(substr($dirName,0,1)=='/')
			$dirTemp = "/";
		else
			$dirTemp = "";
		foreach( (array)$dirArr as $dir )
		{
			if( empty($dir) ) continue;
			$dirTemp.= $dir."/";
			if( !is_dir($dirTemp) )
			{
				if( !@mkdir($dirTemp,0777) )
				{
					trigger_error($FILEERRORMSG[0]."dir:".$dirTemp,SystemExceptionType(2));
					return false;
				}
				chmod($dirTemp,0777);
			}
		}
		
		return true;
	}
	/**
	*取得文件的内容
	*@parma		$fileName	要取得的文件名称
	*@return	如果失败返回 false 成功返回文件内容
	*/
	function getFileContent( $fileName )
	{
		if( !FileIO::isFileExists($fileName) ) return false;
		if( function_exists("file_get_contents") )
			return file_get_contents( $fileName );
		else
			return fread( fopen($fileName,"r"),filesize($fileName)+1 );

	}
	/**
	*判断一个文件是否存在
	*@param		$fileName	判断的文件名称
	*@return	bool		如果存在返回true
	*/
	function isFileExists( $fileName )
	{
		clearstatcache();
		return file_exists( $fileName ) && is_file( $fileName );
	}
	/**
	*判断一个文件是否存在
	*@param		$dirName	判断的文件名称
	*@return	bool		如果存在返回true
	*/
	function isDirExists( $dirName )
	{
		clearstatcache();
		return file_exists( $dirName ) && is_dir( $dirName );
	}
	/**
	*删除文件
	*@param		$fileName	删除的文件名称	
	*@return	bool		删除成功返回true
	*/
	function delFile($fileName)
	{
		//global $FILEERRORMSG;
		if( FileIO::isFileExists($fileName) )
			return unlink($fileName);
		//trigger_error($FILEERRORMSG[2],SystemExceptionType(2));
		return true;
	}
	/**
	*删除目录
	*@param		$dirName	删除的目录名称	
	*@return	bool		删除成功返回true
	*/
	function delDir($dirName)
	{
		global $FILEERRORMSG;
		 if( !FileIO::isDirExists($dirName) )
		 {
			trigger_error($FILEERRORMSG[3],SystemExceptionType(2));
		 }
		 $handle = @opendir($dirName);
		 while(false !== ($file = @readdir($handle)))
		 {
            if($file != "." && $file != "..")
            {
                @chmod($dirName . "/" . $file, 0777); //改变文件模式
                if(FileIO::isDirExists($dirName . "/" . $file))  //判断目录是否存在
                {
                    FileIO::delDir($dirName . "/" . $file); //存在就删除目录
                }else{
                    if( !FileIO::delFile($dirName . "/" . $file)) return false; //
                }
            }
         }
        @closedir($handle);
        @rmdir($dirName);
		return true;
	}
	/**
	*文件复制
	*@param		$source		源文件
	*@param		$dest		目标文件
	*return		bool		复制成功返回true
	*/
	function copyFile($source, $dest)
	{
		if( !FileIO::isFileExists($source) ) return false;
		$destDir = dirname($dest);
		if( !FileIO::isDirExists($destDir))
		{
			if( !FileIO::createDir($destDir) ) return false;
		}
		return copy($source, $dest);
	}
	/**
	*目录复制
	*@param		$source		源文件
	*@param		$dest		目标文件
	*return		bool		复制成功返回true
	*/
	function copyDir($source, $dest)
	{
		if( !FileIO::isDirExists($source) ) return false;
		if( !FileIO::isDirExists($dest) ) FileIO::createDir( $dest );
		$handle = @opendir($source);
		 while(false !== ($file = @readdir($handle)))
		 {
            if($file != "." && $file != "..")
            {
				@chmod($source . "/" . $file, 0777);
				if( FileIO::isDirExists($source . "/" . $file) )
				{ 
					FileIO::copyDir( $source."/".$file."/",$dest."/".$file."/" );
				}else{
					if( !FileIO::copyFile( $source."/".$file,$dest."/".$file ) )
					{
						@closedir($handle);
						return false;
					}
				}
			}
         }
        @closedir($handle);
		return true;
	}
	/**
	*文件移动
	*@param		$source		源文件
	*@param		$dest		目标文件
	*return		bool		复制成功返回true
	*/
	function moveFile($source,$dest)
	{
		return FileIO::copyFile($source,$dest) && FileIo::delFile($source);
	}
	/**
	*目录移动
	*@param		$source		源文件
	*@param		$dest		目标文件
	*return		bool		复制成功返回true
	*/
	function moveDir($source,$dest)
	{
		return FileIO::copyDir($source,$dest) && FileIo::delDir($source);
	}
	
	//根据数组建立缓存数组文件
	/**
	 * @param  $result 为建立的数据数组,下标为id,值为title
	 * @param  $cacheName 为建立的数组名称,文件名为 .data.php
	 * @param  $dir       为建立文件保存的地址
	 * @param  $key       数组里的下标 取得里面的值作为生成数组下标
	 * @param  $value     数组里的下标 取得里面的值作为生成数组的值
	 * */
	function makeCacheFile($result,$cacheName,$dir,$key='id',$value='title')
	{
		$temp[] ="<?php";
		$temp[] ="\${$cacheName} = array();";
		for ($i=0;$i<count($result);$i++)
		{
			if(isset($result[$i][$key]))
				$temp[] = "\${$cacheName}['{$result[$i][$key]}']=\"{$result[$i][$value]}\";";
			else 
				$temp[] = "\${$cacheName}[]=\"{$result[$i][$value]}\";";
		}
		$temp[] = "?>";
		$fileName = $dir."{$cacheName}.data.php";
		//print_r(implode("\n",$temp));exit();
		unset($result);
		return $make = FileIO::writeFile($fileName,implode("\n",$temp));
	}
	function makeCacheFile2($result,$cacheName,$dir,$key='id',$value='title')
	{
		$temp[] ="<?php";
		$temp[] ="\${$cacheName} = array();";
		for ($i=0;$i<count($result);$i++)
		{
			if(isset($result[$i][$key]))
				$temp[] = "\${$cacheName}['{$result[$i][$key]}'][]=\"{$result[$i][$value]}\";";
			else 
				$temp[] = "\${$cacheName}[]=\"{$result[$i][$value]}\";";
		}
		$temp[] = "?>";
		$fileName = $dir."{$cacheName}.data.php";
		//print_r(implode("\n",$temp));exit();
		unset($result);
		return $make = FileIO::writeFile($fileName,implode("\n",$temp));
	}
	function makeArrayCache($cacheName,$cacheArr,$dir,$filePostfix="data.php")
	{
		$temp[] ="<?php";
		$temp[] ="\${$cacheName} = array();";
		foreach ($cacheArr as $i => $value)
		{
			$cache = $cacheArr[$i];
			if(is_array($cache))
			{
				foreach($cache As $k=>$v)
				{
					$v = str_replace("\n","",$v);
					$temp[] = "\${$cacheName}[{$i}][{$k}]=\"{$v}\";";
				}
				
			}else{
				$cache = str_replace("\n","",$cache);
				$temp[] ="\${$cacheName}[{$i}]=\"{$cache}\";";
			}
		}
		$temp[] = "?>";
		$fileName = $dir."{$cacheName}.{$filePostfix}";
		//print_r(implode("\n",$temp));exit();
		unset($cacheArr);
		return $make = FileIO::writeFile($fileName,implode("\n",$temp));
	}
	//根据数组建立缓存数组文件
	/**
	 * @param  $str 为hash的字段
	 * @return fileName 为hash后的文件名，加目录名
	 * */
	function getHashFileName($str,$isFileName=false)
	{
		$fileName = "";
		$hashTemp = md5(strval($str));
		$fileName .=substr($hashTemp,0,2)."/";//一级目录为256个
		$fileName .=substr($hashTemp,2,2)."/";//二级目录下单个目录为 256个
		$fileName .=substr($hashTemp,4,3);//三级目录下单个目录为 4096个
		if($isFileName)
		{
			$fileName .=substr($hashTemp,7);
		}
		//$fileName .=substr($hashTemp,7);
		return $fileName;
	}
	/**
	 * @param  $fileName  文件名
	 * @param  $overTime  过期时间
	 * @return 返回true
	 * */
	function isOverTime($fileName,$overTime)
	{
		if(FileIO::isFileExists($fileName))
		{
			//echo fileatime($fileName);
			if(time()-filemtime($fileName)>$overTime)
			{
				return true;
			}else {
				return false;
			}
		}
		return true;
	}
}

function SystemExceptionType($type)
{
	$type = intval($type);
	if($type <0 || $type>2 ) $type = 0;
	$ErrorType[0] = E_USER_ERROR;
	$ErrorType[1] = E_USER_WARNING;
	$ErrorType[2] = E_USER_NOTICE;
	return $ErrorType[$type];
}
//echo FileIO::moveDir("c2","c3");
//echo FileIO::copyDir("cache","c2");
//echo FileIO::delDir("c2");
?>