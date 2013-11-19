<?php

function getTwitterShareButton($contributor){
	$attrs = " data-url=\"".$contributor->getUrl()."\""." data-text=\"This is\"";
	return "<a href=\"https://twitter.com/share\" class=\"twitter-share-button\"".$attrs.">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>";
}

function getFacebookLikesButton($contributor){
	return "<div class=\"fb-like\" data-href=\"".$contributor->getUrl()."\" data-width=\"90\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-share=\"true\"></div>";
}

?>