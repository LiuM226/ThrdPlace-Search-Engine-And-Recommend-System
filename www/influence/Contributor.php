<?php
	
class Contributor{
private $url;
private $influenceWeight;
private $commentsNumber;
private $contributedProjNumber;

function __construct(){
$num = func_num_args();
$args = func_get_args();
switch ($num){   
case 0:
case 1:
case 2:
break;   
case 3:
case 4:     
$this->url=$args[0];
$this->influenceWeight=$args[1];
$this->commentsNumber=$args[2];
$this->contributedProjNumber=$args[3];
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

function setInfluenceWeight($influenceWeight){
$this->influenceWeight=$influenceWeight;
}

function getInfluenceWeight(){
return $this->influenceWeight;
}

}

?>