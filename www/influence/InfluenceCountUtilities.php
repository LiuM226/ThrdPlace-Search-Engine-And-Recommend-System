<?php
#######################################################################
#				PHP Social Share Count Class
#	Script Url: http://toolspot.org/script-to-get-shared-count.php
#	Author: Sunny Verma
#	Website: http://toolspot.org
#	License: GPL 2.0, @see http://www.gnu.org/licenses/gpl-2.0.html
########################################################################
class InfluenceCountUtilities {
private $url,$timeout;

function __contruct(){
$num = func_num_args();
$args = func_get_args();
switch ($num){   
case 0:
$this->timeout=10;
break;   
case 1:     
$this->url=rawurlencode($args[0]);
$this->timeout=10; 
break;   
case 2:     
$this->url=rawurlencode($args[0]);
$this->timeout=$args[1]; 
break;   
} 
}

function setUrl($url){
$this->url=$url;
}

function setTimeout($timeout){
$this->timeout = $timeout;
}

function get_tweets() { 
$json_string = $this->file_get_contents_curl('http://urls.api.twitter.com/1/urls/count.json?url=' . $this->url);
$json = json_decode($json_string, true);
return isset($json['count'])?intval($json['count']):0;
}
function get_linkedin() { 
$json_string = $this->file_get_contents_curl("http://www.linkedin.com/countserv/count/share?url=$this->url&format=json");
$json = json_decode($json_string, true);
return isset($json['count'])?intval($json['count']):0;
}
function get_fb() {
$json_string = $this->file_get_contents_curl('http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$this->url);
$json = json_decode($json_string, true);
return isset($json[0]['total_count'])?intval($json[0]['total_count']):0;
}
function get_plusones()  {
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.rawurldecode($this->url).'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
$curl_results = curl_exec ($curl);
curl_close ($curl);
$json = json_decode($curl_results, true);
return isset($json[0]['result']['metadata']['globalCounts']['count'])?intval( $json[0]['result']['metadata']['globalCounts']['count'] ):0;
}
function get_stumble() {
$json_string = $this->file_get_contents_curl('http://www.stumbleupon.com/services/1.01/badge.getinfo?url='.$this->url);
$json = json_decode($json_string, true);
return isset($json['result']['views'])?intval($json['result']['views']):0;
}
function get_delicious() {
$json_string = $this->file_get_contents_curl('http://feeds.delicious.com/v2/json/urlinfo/data?url='.$this->url);
$json = json_decode($json_string, true);
return isset($json[0]['total_posts'])?intval($json[0]['total_posts']):0;
}
function get_pinterest() {
$return_data = $this->file_get_contents_curl('http://api.pinterest.com/v1/urls/count.json?url='.$this->url);
$json_string = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $return_data);
$json = json_decode($json_string, true);
return isset($json['count'])?intval($json['count']):0;
}
private function file_get_contents_curl($url){
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FAILONERROR, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
$cont = curl_exec($ch);
if(curl_error($ch))
{
die(curl_error($ch));
}
return $cont;
}
}
?>