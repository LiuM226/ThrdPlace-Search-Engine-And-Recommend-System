<?php
	
class Contributor{
private $url;
private $commentsNumber;
private $contributedProjNumber;
private $tweets;
private $fblikes;
private $socialInfluenceWeight;

function __construct(){
$num = func_num_args();
$args = func_get_args();
switch ($num){
case 0:
case 1:
case 2:
break;
case 3:
$this->url=$args[0];
$this->commentsNumber=$args[1];
$this->contributedProjNumber=$args[2];
break;
case 4:
case 5:
break;
case 6:
$this->url=$args[0];
$this->commentsNumber=$args[1];
$this->contributedProjNumber=$args[2];
$this->tweets=$args[3];
$this->fblikes=$args[4];
$this->socialInfluenceWeight=$args[5];
break;
}
}

function setCommentsNumber($commentsNumber){
$this->commentsNumber=$commentsNumber;
}

function getCommentsNumber(){
return $this->commentsNumber;
}

function setContributedProjNumber($contributedProjNumber){
$this->contributedProjNumbe=$contributedProjNumber;
}

function getContributedProjNumber(){
return $this->contributedProjNumber;
}

function setUrl($url){
$this->url=$url;
}

function getUrl(){
	return $this->url;
}

function getTweets(){
	return $this->tweets;
}

function setTweets($tweets){
	$this->tweets=$tweets;
}

function getfblikes(){
	return $this->fblikes;
}

function setfblikes($fblikes){
	$this->fblikes=$fblikes;
}

function getSocialInfluenceWeight(){
	return $this->socialInfluenceWeight;
}

function setSocialInfluenceWeight($socialInfluenceWeight){
	$this->socialInfluenceWeight=$socialInfluenceWeight;
}

}

?>