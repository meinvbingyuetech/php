<?php



/*
 * 自定义的curl类:
 * 新用法
 $web = new AizhanCurl('http://www.baidu.com/');
 $web->setTimeout(4);
 $web->setFollow(0);
 $web->setUserAgent('Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; BOIE9;ZHCN)');
 $web->makeRequest('GET'); 或 $web->makeRequest('POST', 'a=1&b=2&c=3');


 $html = $web->GetContent();
 $httpCode = $web->GetHttpCode();
 */

class AizhanCurl {
	private $_url;
	private $_method;
	private $_headers;

	private $_follow = 0;
	private $_timeout = 30;
	private $_host = '';//需要指定访问域名ip的时候有用
	private $_useragent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; BOIE9;ZHCN)';

	private $_content;
	private $_infos;
	private $_responseHeaders;
	private $_responseHeadersSize;

	private $_postfields;

	function __construct($url){
		$this->_method = 'GET';
		$this->setUrl($url);
	}

	//Set
	public function setMethod($mtd){
		if (in_array(strtoupper(trim($mtd)), array('GET', 'POST', 'HEAD'))) {
			$this->_method = strtoupper(trim($mtd));
		} else {
			$this->_method = 'GET';
		}
	}
	
	/*
	  $method	请求方法 GET POST HEAD
	  $vars		主要用于POST请求的参数
	*/
	public function makeRequest($method, $vars = null) {
		$method = strtoupper(trim($method));
		if (in_array($method, array('GET', 'POST', 'HEAD'))) {
			$this->_method = $method;
		} else {
			$this->_method = 'GET';
		}

		if ($this->_method == 'POST') {
			$this->_postfields = $vars;
		}
		
		//发起请求
		$this->send();
	}

	public function setUrl($url){
		$this->_url = $url;
	}

	public function setHost($host) {
		$this->_host = $host;
	}

	public function setTimeout($timeout = 30) {
		$this->_timeout = (int)$timeout;
	}

	public function setFollow($follow = 0) {
		$follow = (int)$follow;
		if ($follow != 0) {
			$follow = 1;
		}
		$this->_follow = $follow;
	}

	public function setUserAgent($agent) {
		$this->_useragent = $agent;
	}

	//Get
	public function GetHttpCode(){
		return $this->_infos['http_code'];
	}
	
	public function GetHttpInfo(){
		return $this->_infos;
	}

	/*
	 * 代替老版本的 GetHttpInfo
	 * curl_getinfo
	 */
	public function GetHttpInfos(){
		return $this->_infos;
	}

	public function GetContent(){
		return $this->_content;
	}

	public function GetHeaders(){
		return $this->_responseHeaders;
	}

	//Send
	public function send() {
		//头部放在这里是为了更好的模拟
		$this->_headers = array('Accept: */*',
				'Accept-Language: zh-CN',
				'Accept-Encoding: gzip, deflate',
				'User-Agent: ' . $this->_useragent,
				'Connection: Keep-Alive',
				'Cache-Control: no-cache',
				);
		if (!empty($this->_host)) {
			$this->_headers[] = 'Host: ' . $this->_host;
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_url);
		
		if ($this->_method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_postfields);
		}
		
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);//设定超时时间
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->_follow);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_headers);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

		if ($this->_method == 'HEAD') {
			curl_setopt($ch, CURLOPT_NOBODY, 1);
		}
		
		//if (!empty($cookie)) {
		//	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		//}

		$this->_content = curl_exec($ch);

		$this->_infos = curl_getinfo($ch);
		$this->_responseHeadersSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

		if ($this->_responseHeadersSize) {
			//echo "<textarea>{$this->_content}</textarea>";
			$this->_responseHeaders = substr($this->_content, 0, $this->_responseHeadersSize);
			$this->_content = substr($this->_content, $this->_responseHeadersSize);
			//echo "<textarea>{$this->_content}</textarea>";
			//list(, $this->_content) = explode("\r\n\r\n", $this->_content, 2);
			//if (!empty($this->_info['download_content_length'])) {
			//	echo "[" . $this->_info['download_content_length'] . "]";
			//	$this->_content = substr($this->_content, -1 * $this->_info['download_content_length']);
			//} else {
			//	$this->_content = substr($this->_content, $this->_responseHeadersSize);
			//}
		} else {
			list($this->_responseHeaders, $this->_content) = explode("\r\n\r\n", $this->_content, 2);
		}

		curl_close($ch);
	}

	/*
	 * 以下为调试函数
	 */
	public function getUrl() {
		return $this->_url;
	}

	public function getMethod(){
		return $this->_method;
	}
}
?>