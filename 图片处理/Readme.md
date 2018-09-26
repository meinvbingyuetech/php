```php

/**
 * 上传文件
 *
 * @param string $url 访问链接
 * @param mixed $params POST的提交数据
 * @param string $timeout 超时时间
 *
 * @return json
 */
public function upload($url, $param, $timeout) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                                    // 设置访问链接
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);                         // 是否返回信息
    curl_setopt($ch, CURLOPT_HEADER, 'Content-type: application/json');     // 设置返回信息数据格式 application/json
    curl_setopt($ch, CURLOPT_POST, TRUE);                                   // 设置post方式提交
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));        // POST提交数据
    $keyName = array_keys($_FILES);
    $curlFile = new \CURLFile($_FILES[$keyName[0]]['tmp_name'], $_FILES[$keyName[0]]['type'], $_FILES[$keyName[0]]['name']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [$keyName[0] => $curlFile]);        // POST提交文件

    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);                            // 超时时间
    $result = curl_exec($ch);
    $err_no = curl_errno($ch);                                              // 获取错误编号，0为正常
    curl_close($ch);
    if ($err_no) {
        return '请求失败，错误码：' . $err_no;
    } elseif (is_null(json_decode($result))) {
        return '请求返回异常：' . $result;
    }
    return $result;
}
    
```
