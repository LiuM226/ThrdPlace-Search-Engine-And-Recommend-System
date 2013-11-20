<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Count Influence</title>
</head>
<body>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '174032612804508',                        // App ID from the app dashboard
      status     : true,                                 // Check Facebook Login status
      xfbml      : true                                  // Look for social plugins on the page
    });

    // Additional initialization code such as adding Event Listeners goes here
  };

  // Load the SDK asynchronously
  (function(){
     // If we've already installed the SDK, we're done
     if (document.getElementById('facebook-jssdk')) {return;}

     // Get the first script element, which we'll use to find the parent node
     var firstScriptElement = document.getElementsByTagName('script')[0];

     // Create a new script element and set its id
     var facebookJS = document.createElement('script'); 
     facebookJS.id = 'facebook-jssdk';

     // Set the new script's source to the source of the Facebook JS SDK
     facebookJS.src = '//connect.facebook.net/en_US/all.js';

     // Insert the Facebook JS SDK into the DOM
     firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
   }());
</script>

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
require("shareUtilities.php");

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
new Contributor("http://toolspot.org",11,12),
new Contributor("http://sina.com",7,8),
new Contributor("http://baidu.com",8,7),
new Contributor("http://amazon.com",10,20),
new Contributor("http://youtube.com",12,32),
new Contributor("http://yahoo.com",12,32),
new Contributor("http://imdb.com",34,21),
new Contributor("http://163.com",22,22),
new Contributor("http://qq.com",34,11),
new Contributor("http://ifeng.com",8,21));
}


/*
* PROMOTIONS = (weight 1 * Facebook Likes) + (weight 2 * Number of Twitter Shares) + (Weight 3 * Number of Comments)
* INFLUENCE (Contributors) = (Weight 1 * Number of Project Contributed) + (Weight 2 * Promotions)
*/


function updateSocialInfluenceParameters($contributors){
$influenceCountUtilities = new InfluenceCountUtilities();
$weights = getWeights();
foreach($contributors as $contributor){
$influenceCountUtilities->setUrl($contributor->getUrl());
$fbLikesNumber = $influenceCountUtilities->get_fb();
$tweets = $influenceCountUtilities->get_tweets();
$contributor->setTweets($tweets);
$contributor->setfblikes($fbLikesNumber);
$socialInfluenceWeight = $weight['projContriWeight']*$contributor->getContributedProjNumber()+$weights['promotionsWeight']*($weights['fbLikesWeight']*$fbLikesNumber+$weights['tweetsWeight']*$tweets+$weights['commentsWeight']*$contributor->getCommentsNumber());
$contributor->setSocialInfluenceWeight($socialInfluenceWeight);
}
}


function compareBySocialInfluence($contri1,$contri2){
	$influenceWeight1 = $contri1->getSocialInfluenceWeight();
	$influenceWeight2 = $contri2->getSocialInfluenceWeight();
	
	if($influenceWeight1==$influenceWeight2){
	  return 0;
	}
	return ($influenceWeight1<$influenceWeight2) ? 1 : -1;
}


$contributors = getContributors();
updateSocialInfluenceParameters($contributors);
 usort($contributors,'compareBySocialInfluence');

foreach ($contributors as $contributor){
	
	echo "url:".$contributor->getUrl()."&nbsp;&nbsp;social influence:".$contributor->getSocialInfluenceWeight()."&nbsp;&nbsp;";
	$twitterButton = getTwitterShareButton($contributor);
	echo $twitterButton;
	$fblikesButton = getFacebookLikesButton($contributor);
	echo $fblikesButton;
	echo "<br>";
}
?>

</body>
</html>