<?php
header('Content-Type: text/html; charset=utf-8');
$limit = 20;
$query = isset($_GET['q']) ? $_GET['q'] : false;
if($query === ""){
	$query = "*:*";
}
$sort = isset($_GET['s']) ? $_GET['s'] : false;
$order = isset($_GET['order']) ? $_GET['order'] : false;
$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : false;
$filter = "New";
$stateFilter = isset($_COOKIE['state'])? ($_COOKIE['state']):"";
$cityFilter = isset($_COOKIE['city'])? ($_COOKIE['city']):"";
session_start();
// some code here
if(isset($_GET['name'])){
	if(isset($_SESSION['name'])){
		unset($_SESSION['name']);
	}
	if(isset($_SESSION['location'])){
		unset($_SESSION['location']);
	}
}
$name = null;
$location = null;
$projectName = null;
if (!isset($_SESSION['location'])) {
    $location = isset($_GET['location']) ? $_GET['location'] : "No location";
	$name = isset($_GET['name']) ? $_GET['name'] : "No name";
	$_SESSION['location'] = $location;
	$_SESSION['name'] = $name;
} else {
    $name = $_SESSION['name'];
	$location = $_SESSION['location'];
}

if($location){
	$filter = $location;
}

$results = false;

require_once( '../include/SolrPhpClient/Apache/Solr/Service.php' );   
if ($query){
	try{
		if($searchType == "Contributor"){
			$solr = new Apache_Solr_Service( 'localhost', '8983', '/solr/contributor1' );
		}
		else{ 
			if($searchType == "Creator"){
				$solr = new Apache_Solr_Service( 'localhost', '8983', '/solr/ProjectCreator' );
			}
			else{
				$solr = new Apache_Solr_Service( 'localhost', '8983', '/solr/collection1' );	
			}
			
		}
		if ( !$solr->ping()) {
			echo 'Solr service not responding.';
		}
		$params = array(
					'sort' => $sort . " " . $order,
					'fq' =>array(
						$stateFilter,
						$cityFilter
					)
				);		
		$results = $solr->search($query, 0, $limit, $params);
	}catch (Exception $e){
		die("<html><head><title>SEARCH EXCEPTION</title><body><pre>{$e->__toString()}</pre></body></html>");
	}
}	

require_once( '../include/SolrPhpClient/Apache/Solr/Service.php' ); 
$solr = new Apache_Solr_Service( 'localhost', '8983', '/solr/collection1' ); 
if ( ! $solr->ping() ) {
    echo 'Solr service not responding.';
    exit;
}
if (true)
{
  try
  {
	$params = array(
		'fq' => $name
	);	
    $ProjectN = $solr->search("*:*", 0, $limit, $params);
	foreach($ProjectN->response->docs as $doc){
		$projectName = $doc->project_title;
	}
  }
  catch (Exception $e)
  {
    // in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>SEARCH EXCEPTION</title><body><pre>{$e->__toString()}</pre></body></html>");
  }
  
  }

 
 
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ThrdPlace Search</title>


<link rel="stylesheet" href="http://thrdplace.com/components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
   <script src="http://thrdplace.com/js/jquery.min.js"></script>
   <script src="http://thrdplace.com/js/jquery-ui.min.js"></script>
   <link rel="stylesheet" type="text/css" href="http://thrdplace.com/css/jquery-ui.css" /><link rel="stylesheet" type="text/css" href="http://thrdplace.com/css/project-screen.css" /><link rel="stylesheet" type="text/css" href="http://thrdplace.com/css/project-global.css" /><link rel="stylesheet" type="text/css" href="http://thrdplace.com/css/jPages.css" />   <link rel="stylesheet" href="//serverapi.arcgisonline.com/jsapi/arcgis/3.3/js/dojo/dijit/themes/claro/claro.css">
   <link rel="stylesheet" href="//serverapi.arcgisonline.com/jsapi/arcgis/3.3/js/esri/css/esri.css">
   <script src="//serverapi.arcgisonline.com/jsapi/arcgis/3.3/"></script>
   <script type="text/javascript" src="http://thrdplace.com/js/jPages.min.js"></script>   
   <script type="text/javascript" src="/js/jquery.bxSlider.js"></script><script type="text/javascript" src="/js/cufon-yui.js"></script><script type="text/javascript" src="/js/din.font.js"></script><script type="text/javascript" src="/components/fancybox/source/jquery.fancybox.js"></script><script type="text/javascript" src="/js/scripts.js"></script><script type="text/javascript" src="/components/jquery-masonry/jquery.masonry.min.js"></script> 
   <script type="text/javascript" src="http://thrdplace.com/js/project.js"></script>   
   <script type="text/javascript" src="http://thrdplace.com/js/jquery.placeholder.min.js"></script>   
   <script type="text/javascript" src="http://thrdplace.com/js/project_frontend.js"></script>
   

<link href="../css/search2.css" rel="stylesheet" type="text/css" />
<link href="../css/list2.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="../js/jquery.chained.min.js"></script>
<script>
  $( document ).ready(function() {
	// Handler for .ready() called.
	$("#series").chained("#mark");
	});
	
	function setCookie(c_name,value,exdays){
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value;
	}
	
	function setState(){
		var s = document.getElementById("mark").value;
		setCookie("state",s,365);
	}
	
	function setCity(){
		var c = document.getElementById("series").value;
		setCookie("city",c,365);
	}
  </script>
</head>


<body class="">
   
<div id="start-a-project">
  <span class="start-project-header">Start a Project with ThrdPlace!</span>
      <div class="left">
        Create an account:<br />
          <span class="teal">Sign up</span>
          <form action="/users/register" id="signup-form" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>          <div class="input text"><label for="first_name">First Name</label><input name="data[User][first_name]" id="first_name" maxlength="200" type="text"/></div><div class="input text"><label for="last_name">Last Name</label><input name="data[User][last_name]" id="last_name" maxlength="200" type="text"/></div><div class="input text required"><label for="register_email">Email</label><input name="data[User][email]" id="register_email" maxlength="200" type="text"/></div><div class="input text"><label for="UserLocation">Location</label><input name="data[User][location]" type="text" id="UserLocation"/></div><div class="input text"><label for="register_user">Username</label><input name="data[User][username]" id="register_user" maxlength="255" type="text"/></div><div class="input password required"><label for="register_password">Password</label><input name="data[User][password]" id="register_password" type="password"/></div><div class="input password"><label for="register_password2">Re-Enter Password</label><input name="data[User][password2]" id="register_password2" type="password"/></div>          <br/>
            <input type="hidden" name="_submit" value="Register"/>
            <div id ="signup-submit" class="btn">
              Submit
            </div>
          </form>           <div style="clear:both;"></div>
            <br/><br/>
            <div id="error-register" class="error-message"></div>
            <br/><br/>
          By clicking submit you are agreeing to the <a id="termsofuse" href="/blog/termsofuse/">terms of use</a> regarding the thrdPlace platform
      </div>
            
      <div class="right">
              Already have an account?<br />
          <span class="teal">Login</span>
          <form action="/users/login" id="login-form" controller="users" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>         <span class="label">Username</span>
          <div class="input text"><input name="data[User][username]" id="login_user" value="" type="text"/></div><br/>
            <div class="input password required"><label for="login_password">Password</label><input name="data[User][password]" id="login_password" type="password"/></div><br/>
                <input type="hidden" name="_submit" value="Login"/>
              <input name="create" type="hidden" id="create"/>
            <a href="/users/recover">Lost Password</a>          <div id="login-submit" class="btn">Login</div> 
            </form>           <br/><br/>
            <div style="clear:both;"></div>
            <div id="login-error" class="error-message"></div>
                    
      <span class="social">OR sign in with <br />facebook</span><br />
      <a href="/users/store_user_data"><img src="/img/icon-fb-button.png" style="margin-right:16px;" alt="" /></a>
<!--        <a href="twitter/twitter-login.php"><img src="/img/icon-twitter-button.png" style="margin-right:16px;" alt="" /></a>-->
      </div>
      <div style="clear:both;"></div>
</div>   
                          
   <input id="email" type="hidden" value=""/>
   <div id="fb-root"></div>
   <script>
      window.fbAsyncInit = function() {
        // init the FB JS SDK
        FB.init({
          appId      : '255802944545281', // App ID from the App Dashboard
            status     : true, // check the login status upon init?
            cookie     : true, // set sessions cookies to allow your server to access the session?
            xfbml      : true  // parse XFBML tags on this page?
        });
        // Additional initialization code such as adding Event Listeners goes here
      }; 
      
      
   </script>
   <div id="fb-root"></div>
   <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
   </script>
   <header id="masthead">
    <div id="create_flag" redirect=""></div>
  	<div class="wrap"><a href="/">
		<img src="http://thrdplace.com/img/new_images/beta-logo.jpg" alt="ThrdPlace" id="logo" />    </a>
		      <section class="utilityNav">
		<div class="divdr"></div>
		<div class="din bold discoverProject"><a href="/map/discover">Discover a Project</a></div>
		<div class="divdr"></div>
		<div class="din bold discoverProject" style="padding-right:15px;"><a id="createproject2" href="/projects/manage">Start a Project</a></div>
		<div class="divdr" style="padding-left:100px;"></div>
		<div class="din bold discoverProject" style="padding-right:15px;margin-left:-80px;"><a id="searchproject2" href="http://sandbox.thrdplace.com/php/contributorSearch2.php">Search a Project</a></div>
		<div id="signUp" class="signUp"><a href="#start-a-project" class="signUp din bold">Sign Up // Login</a></div><a href="https://www.facebook.com/pages/ThrdPlace/287657154590667" class="facebook social" target="_blank">Facebook</a><a href="https://twitter.com/thrdplace" class="twitter social" target="_blank">Twitter</a><a href="/blog/?feed=rss2" class="rss social" target="_blank">RSS</a>  <a href="mailto:admin@thrdplace.com?subject=Build your community at thrdplace.com" class="contact social">Email</a>
		<a href="/blog" class="blog social">Blog</a>      </section>
		  </div>


		<!-- PARTENR SECTION -->
		  <div id="show-partner-form">
		    <a href="#partner-form">
		<img src="/img/new_images/partner-with-us.jpg" class="fixed-btn partner" alt="" /></a>
		  </div>
		  <div id="partner-form">
		  <div class="left">
		    <span class="partner-form-header">Want to Become a Partner?</span>
		      <p>THRDPLACE IS BUILT TO SUPPORT COMMUNITY ACTIVITY. WE UNDERSTAND THE POWER OF PARTNERSHIP. WITHOUT PEOPLE AND ORGANIZATIONS LIKE YOU, OUR COMMUNITIES WOULD NOT BE THE SAME.  </p>
		    <p>PARTNERING WITH THRDPLACE HELPS YOU TO FOCUS ON YOUR MISSION AND CREATE MORE IMPACT. WE CAN HELP INCREASE YOUR COMMUNITIES ENGAGEMENT, STREAMLINE YOUR PROJECT MANAGEMENT PROCESSES AND EXPAND YOUR REACH. </p>
		    <p>DROP US A NOTE. WE WANT TO WORK WITH YOU TO IMPROVE OUR COMMUNITIES.</p>

		    Cheers,<br />
		        <span class="signature">THRDPLACE STAFF</span>
		  </div>
		    <div class="right">
		      <form method="POST" action="/emails/sendPartner" id="partner-submission-form" enctype="multipart/form-data">
		            <input name="from_address" type="text" placeholder="YOUR EMAIL ADDRESS"/><br />

		            <input name="organization" type="text" placeholder="your organization name"/><br />
		            <input type="file" name="attatchment_1" style="height:26px"/>

		      <textarea name="comments" placeholder="JUST TO GIVE US A HEADS UP.....TELL US A BIT ABOUT YOUR WORK AND YOU INTEREST IN THRDPLACE."></textarea>
		<button type="submit" id="partner-form-submit" class="feedbtn send">Send</button>
		        </form>
		    </div>
		</div>
		<!-- END PARTNER SECTION -->


		<!-- FEEDBACK SECTION -->
		  <div id="show-feedback">
		    <a href="#feedback">
		      <img src="/img/new_images/feedback.jpg" class="fixed-btn feedback" alt="" />    </a>
		  </div>        
		<div id="feedback">
		  <span class="feedback-header">We love to hear from you!</span>
		  <p> The needs of our community are the primary driver for the development of the platform. So, tell us what you think thrdPlace needs. Any and all insights are appreciated...</p><p>Please submit your suggestion(s) and attach any relevant media.</p><p> Cheers, thrdPlace Staff</p>
		    From:
		    <form action="/emails/sendFeedback" id="feedback-form" enctype="multipart/form-data" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>       <input type="hidden" name="subject" value="Feedback Form Submission">
		        <input name="from_address" type="text" value="YOUR EMAIL ADDRESS"/><br />

		      <input name="organization" type="text"  value="your organization name"/><br />
		        <input type="file" name="attatchment_1" style="height:26px"/>
		                
		    <textarea name="comments">JUST TO GIVE US A HEADS UP.....TELL US A BIT ABOUT YOUR WORK AND YOU INTEREST IN THRDPLACE.</textarea>
		 
		    <button type="submit" id="partner-form-submit" class="feedbtn send">Send</button></form></div>

		<!-- END FEEDBACK SECTION -->

		<!-- OPEN PROJECTS -->

		<div id="open-projects">
		  <span class="start-project-header">Open Projects!</span> None
		</div>
</header>
          


<!-- Search Section -->
<div class="search-section">
<div class="container">
  <div class="header">
	
    
	
	<!-- end .header --></div>
	<div class="sidebar1">
		<div class="user-profile">
			<P> Welcome,</br> contributors! </p>
		</div>
		<H4 class="section-title">RANKING</H4>
		<div class="type-tag">
			<ul class="nav">
<?php
			if((isset($searchType) && $searchType === "Creator")){
?>				
				<li><a href="/php/contributorSearch2.php?q=<?php echo $query?>&searchType=Creator&s=username&order=DESC&rows=20">Username</a></li>				
<?php			
			}
			else{
				if((isset($searchType) && $searchType === "Contributor")){
?>
					<li><a href="/php/contributorSearch2.php?q=<?php echo $query?>&searchType=Contributor&s=promotion&order=DESC&rows=20">Influence</a></li>
					<li><a href="/php/contributorSearch2.php?q=<?php echo $query?>&searchType=Contributor&s=contribute_money&order=DESC&rows=20">Money</a></li>
					<li><a href="/php/contributorSearch2.php?q=<?php echo $query?>&searchType=Contributor&s=contribute_volunteer_hours&order=DESC&rows=20">Hours</a></li>
					<li><a href="/php/contributorSearch2.php?q=<?php echo $query?>&searchType=Contributor&s=contribute_supplies&order=DESC&rows=20">Supplies</a></li>
					
<?php
				}
				else{
?>
					<li><a href="/php/contributorSearch2.php?q=<?php echo $query?>&searchType=Project&s=influence&order=DESC&rows=20">Influence</a></li>
					<li><a href="/php/contributorSearch2.php?q=<?php echo $query?>&searchType=Project&s=success&order=DESC&rows=20">Success</a></li>
<?php
				}
			}
?>
			</ul>
		</div>
		<H4 class="section-title">FILTER</H4>
		<div class="type-tag">
		
			
			<form>
			<p>State</p>
			<select id="mark" name="mark" style="width:200px;" class="search-type" onchange="setState()">		
<?php
			//pseudo
			$arr = array("", "Alabama", "California", "NewYork");
			foreach($arr as $value) {
				echo '<option value="' . $value . '" ';
				if($stateFilter === $value) {
					echo "selected = \"selected\"";
				}
				if($value===""){
					echo '>--</option>';
				}
				else{
					echo '>' . $value . "</option>";
				}
			}
?>				
			</select>
			<p>&nbsp;</p>
			
			<p>City</p>
			<select id="series" name="series" style="width:200px;" class="search-type" onchange="setCity()">
<?php
			//pseudo
			$arr = array("", "Adamsville", "Cottonwood", "Eclectic", "Gurley", "Hollins", "Mobile", "NewHope", "Sheffield", "SpanishFort");
			foreach($arr as $value) {
				echo '<option value="' . $value . '" ';
				if($cityFilter === $value) {
					echo "selected = \"selected\"";
				}
				if($value===""){
					echo '>--</option>';
				}
				else{
					echo ' class="Alabama">' . $value . "</option>";
				}
			}
			
			$arr = array("Austerlitz", "Brooklyn", "Cassadaga", "EastElmhurst", "FlyCreek", "Haverstraw", "Inwood", "LakeLuzerne", "Thomson");
			foreach($arr as $value) {
				echo '<option value="' . $value . '" ';
				if($cityFilter === $value) {
					echo "selected = \"selected\"";
				}
				if($value===""){
					echo '>--</option>';
				}
				else{
					echo ' class="NewYork">' . $value . "</option>";
				}
			}
			
			$arr = array("Aguanga", "Anaheim", "Arbuckle", "Arcadia", "Arleta", "Baker", "Ballico", "BirdsLanding", "BodegaBay", "LosMolinos","LosAngeles");
			foreach($arr as $value) {
				echo '<option value="' . $value . '" ';
				if($cityFilter === $value) {
					echo "selected = \"selected\"";
				}
				if($value===""){
					echo '>--</option>';
				}
				else{
					echo ' class="California">' . $value . "</option>";
				}
			}
?>	
			</select>
			<p>&nbsp;</p>
			</form>
		</div>
    <p>&nbsp;</p>
    <!-- end bar1 --></div>

    <!-- Search Box-->
    <div class="search-box">
		<FORM  accept-charset="utf-8" method="get">
			<LABEL for = "q"></LABEL>
			<INPUT id = "search-text" id = "q" name = "q" type = "text" placeholder="Search on ThrdPlace" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'utf-8');?>"/>
			<INPUT id = "search-button" type = "submit" value="search"/>
			<select id="search-type" class="search-type" name = "searchType">
                    <option <?php if((isset($searchType) && $searchType === "Project")) echo "selected = \"selected\""?>>Project</option>
                    <option <?php if((isset($searchType) && $searchType === "Contributor")) echo "selected = \"selected\""?>>Contributor</option>
                    <option <?php if((isset($searchType) && $searchType === "Creator")) echo "selected = \"selected\""?>>Creator</option>
            </select>
			<INPUT type="hidden" name="s" value="id">
			<INPUT type="hidden" name="order" value="DESC">
		<FORM>
	</div>
	<!-- Search Box-->

  <div class="content">
    <div class="results-div">
	
	<div class="results">

<?php

	if($results){
		$total = (int) $results->response->numFound;
		$start = min(1, $total);
		$end = min($limit, $total);
?>
<?php
		if($total < 1){
			echo "<H3>NO RESULTS<H3>";
		}
		else{
			$projcet_count = 0;
			if($searchType == "Contributor"){
?>
<?php
				foreach($results->response->docs as $doc){
					$projcet_count++;
?>	
					<div class="results-list">
						<H4 class="result-title"><?php echo "[" . $projcet_count . "] " . $doc->contributor_first_name . " " . $doc->contributor_last_name;?></H4>
						<div class="project-img">
							<img src="../img/Contributor.jpg" alt="No image" width="100%" height="100%">
						</div>
						<div class="result-details">
							<div class="project-profile">
								<div>
									<span class="item-owner" ><?php echo "Email:   " . $doc->contributor_email;?></span>
									<span class="item-owner" ><?php echo "Phone:   " . $doc->contributor_phone;?></span>
									<span class="item-location" ><?php echo "Address:   " . $doc->contributor_address . ", " . $doc->contributor_city . ", " . $doc->contributor_state;?></span>
								</div>
							<div>
								<span class="item11" ><?php echo "Total Contribution(Money):   $" . $doc->contribute_money;?></span>
								<span class="item11" ><?php echo "Total Contribution(Hours):   " . $doc->contribute_volunteer_hours. " hour(s)";?></span>
								<span class="item11" ><?php echo "Total Contribution(Supply):   " . $doc->contribute_supplies;?></span>
								<span class="item11" >Influence:   <span class="influence"><?php echo $doc->promotion;?></span></span>
							
							</div>
						
							<div class="detail">
								<?php echo "Project:   " . $doc->project_title;?>	
							</div>
							</div>
						</div>
								<p>&nbsp;</p>
							</div>
						
<?php
				}
			}
			else{ 
				if($searchType == "Creator"){
					foreach($results->response->docs as $doc){
						$projcet_count++;
?>
						<div class="results-list">
						<H4 class="result-title"><?php echo "[" . $projcet_count . "] " . $doc->creator_first_name . " " . $doc->creator_last_name;?></H4>
						<div class="project-img">
							<img src="../img/creator.jpg" alt="No image" width="100%" height="100%">
						</div>
						<div class="result-details">
							<div class="project-profile">
								<div>
									<span class="item-owner" ><?php echo "User Name:   " . $doc->username;?></span>
									<span class="item-owner" ><?php echo "Email:   " . $doc->creator_email;?></span>
									<span class="item-owner" ><?php echo "Phone:   " . $doc->creator_phone;?></span>
								</div>
							<div>
								<span class="item11" ><?php echo "Address   " . $doc->creator_address;?></span>
								<span class="item11" ><?php echo "City:   " . $doc->creator_city;?></span>
								<span class="item11" ><?php echo "State:   " . $doc->creator_state;?></span>
								<span class="item11" ><?php echo "Zip:   " . $doc->creator_zip;?></span>
							</div>

							<div class="detail">
								<?php echo "Project(Created):   " . $doc->project_title;?>	
							</div>
							</div>
						</div>
								<p>&nbsp;</p>
							</div>
						


<?php
					}
				}
				else{
					foreach($results->response->docs as $doc){
						$projcet_count++;
?>	
						<div class="results-list">
						<H4 class="result-title"><?php echo "[" . $projcet_count . "] " . $doc->project_title;?></H4>
						<div class="project-img">
							<img src="../img/school_3.jpg" alt="No image" width="100%" height="100%">
						</div>
						<div class="result-details">
							<div class="project-profile">
								<div>
									<span class="item-owner" ><?php echo "Creator:   " . $doc->username;?></span>
									<span class="item-location" ><?php echo "Location:   " . $doc->project_address . ", " . $doc->project_city . ", " . $doc->project_state;?></span>
								</div>

							<div>
								<span class="item11" ><?php echo "Funds(needed):   " . $doc->money_needed;?></span>
								<span class="item11" ><?php echo "Volunteers(needed):   " . $doc->volunteer_needed;?></span>
								<span class="item11" ><?php echo "Supply(needed):   " . $doc->supplies_needed;?></span>
								<span class="item11" ><?php echo "Success:   " . number_format($doc->success,1) . "%";?></span>
								<span class="item11" >Influence: <span class="influence"><?php echo number_format($doc->influence,1);?></span></span>
							</div>
						
							<div class="detail">
								<?php echo "Detail:   " . $doc->project_description;?>	
							</div>
							</div>
						</div>
								<p>&nbsp;</p>
							</div>
<?php		
					}
				}
			}
		}	
	}
?>
	
	</div>
	</div>
	<div class="recommendation">
	<H6 class="section-title">RECOMMADATION</H3>
	<div class="influential-project" align="center">Most Influencial Project</div>	
	<div class="recommended_project">
		<a href="/projects/project1.html"><img src="../img/PR.jpg" width="100%" height="100%"></img></a>
	</div>
		
<?php
	$solr = new Apache_Solr_Service( 'localhost', '8983', '/solr/collection1' );
	$params = array(
		'sort' => 'influence desc',
		'fl' => 'project_title username success project_address influence'	
	);
	$results = $solr->search("*:*", 0, 1, $params);	
	foreach($results->response->docs as $doc){
?>
		<TABLE class="recommendation-table" align = "center">	
			<TR>
				
				<TD><H6>PROJECT: <?php echo $doc->project_title;?></H6></TD>
			</TR>
			<TR>
				<TD><H6>OWNER: <?php echo $doc->username;?></H6></TD>
			</TR>
			<TR>
				<TD><H6>ADDRESS: <?php echo $doc->project_address;?></H6></TD>
			</TR>
			<TR>
				<TD><H6>INFLUENCE: <?php echo number_format($doc->influence,1)?></H6></TD>
			</TR>
			<TR>
				<TD><H6>SUCCESS: <?php echo number_format($doc->success,1) . "%"?></H6></TD>
			</TR>
		</TABLE>
<?php
	}
?>
	</div>
    <!-- end .content --></div>
	<div class="footer">
		<div id="colophon">
		<div class="wrap">
			<a href="/blog/?p=1013">Join the team</a> //
			<a href="/blog/?p=999">Contact us</a> //
			<a href="/blog/?p=123">The team</a> //
			<a href="/blog/">Blog</a> //
			<a href="/blog/?p=132 ">How to create a project</a>  //
			<a href="/blog/?cat=21">FAQs</a>// 
			<a href="/blog/?p=1018">Terms of use</a>
			
		</div>	
		</div>
    <!-- end .footer --></div>
  <!-- end .container --></div>
<!-- end .search-section --></div>
</body>
</html>


