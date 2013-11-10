<?php
#######################################################################
#				PHP Social Share Count Class
#	Script Url: http://toolspot.org/script-to-get-shared-count.php
#	Author: Sunny Verma
#	Website: http://toolspot.org
#	License: GPL 2.0, @see http://www.gnu.org/licenses/gpl-2.0.html
########################################################################

/*as
*
* CAPITAL = Integer value of Funds, Supply Items and Volunteer hours
* PROJECT SUCCESS = Raised Capital / Expected Value
* PROMOTIONS = (weight 1 * Facebook Likes) + (weight 2 * Number of Twitter Shares) + (Weight 3 * Number of Comments)
* INFLUENCE (Contributors) = (Weight 1 * Number of Project Contributed) + (Weight 2 * Promotions)
*
*
*/

require("InfluenceCountUtilities.php");
require("Contributor.php");

function getWeights(){
return array(
'projContriWeight'=>0.5,
'promotionsWeight'=>0.5,
'fblikesWeight'=>0.333,
'tweetsWeight'=>0.333,
'commentsWeight'=>0.333
);
}


function getContributors(){
return array(
new Contributor("http://toolspot.org",0,11,12),
new Contributor("http//youku.com",0,7,8),
new Contributor("http://baidu.com",0,8,7),
new Contributor("http://amazon.com",0,10,20),
new Contributor("http://youtube.com",0,12,32),
new Contributor("http://yahoo.com",0,12,32),
new Contributor("http//sina.com",0,34,21),
new Contributor("http://163.com",0,22,22),
new Contributor("http://qq.com",0,34,11),
new Contributor("http://ifeng.com",0,8,21));
}


/*
* PROMOTIONS = (weight 1 * Facebook Likes) + (weight 2 * Number of Twitter Shares) + (Weight 3 * Number of Comments)
* INFLUENCE (Contributors) = (Weight 1 * Number of Project Contributed) + (Weight 2 * Promotions)
*/


function updateSocialInfluence($contributors){
$influenceCountUtilities = new InfluenceCountUtilities();
$weights = getWeights();
foreach($contributors as $contributor){
$influenceCountUtilities->setUrl($contributor->getUrl());
$fbLikesNumber = $influenceCountUtilities->get_fb();
$tweets = $influenceCountUtilities->get_tweets();
$influenceWeight = $weight['projContriWeight']*$contributor->getContributedProjNumber()+$weights['promotionsWeight']*($weights['fbLikesWeight']*$fbLikesNumber+$weights['tweetsWeight']*$tweets+$weights['commentsWeight']*$contributor->getCommentsNumber());
$contributor->setInfluenceWeight($influenceWeight);
}
}

function compareBySocialInfluence($contri1,$contri2){
	$influenceWeight1 = $contri1->getInfluenceWeight();
	$influenceWeight2 = $contri2->getInfluenceWeight();
	
	if($influenceWeight1==$influenceWeight2){
	  return 0;
	}
	return ($influenceWeight1<$influenceWeight2) ? 1 : -1;
}


$contributors = getContributors();
updateSocialInfluence($contributors);
 usort($contributors,'compareBySocialInfluence');

foreach ($contributors as $contributor){
	echo "url:".$contributor->getUrl()."&nbsp;&nbspsocial influence:".$contributor->getInfluenceWeight()."<br>";
}
?>