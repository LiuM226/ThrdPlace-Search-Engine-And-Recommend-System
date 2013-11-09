<?php
header('Content-Type: text/html; charset=utf-8');
$limit = 10;
$query = isset($_GET['q']) ? $_GET['q'] : false;
$sort = isset($_GET['s']) ? $_GET['s'] : false;
$order = isset($_GET['order']) ? $_GET['order'] : false;
$filter = "New";
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
require_once( '../include/SolrPhpClient\Apache\Solr\Service.php' ); 
$solr = new Apache_Solr_Service( 'localhost', '8983', '/solr' );
  
  if ( ! $solr->ping() ) {
    echo 'Solr service not responding.';
    exit;
  }

  
if ($query)
{
    
  //
  //
  // Try to connect to the named server, port, and url
  //
  
  
  try
  {
	$query = $query;
	$params = array(
		'sort' => $sort . " " . $order
		
	);
	
	
    $results = $solr->search($query, 0, $limit, $params);
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
<link rel="stylesheet" type="text/css" href="http://thrdplace.com/css/screen.css" /> 
<link href="../css/search.css" rel="stylesheet" type="text/css" /><!--[if lte IE 7]>

<style>
.content { margin-right: -1px; } /* this 1px negative margin can be placed on any of the columns in this layout with the same corrective effect. */
ul.nav a { zoom: 1; }  /* the zoom property gives IE the hasLayout trigger it needs to correct extra whiltespace between the links */
</style>
<![endif]-->
</head>

<body>

<div class="container">
  <div class="header">
	<div class="logo-header">
		<a href="#">
			<img src="img/beta-logo.jpg" alt="Insert Logo Here" width="100%" name="Insert_logo"  id="Insert_logo" style="background-color: #8090AB; display:block;" />
		</a>
	</div>
	<div class="search-box">
		<FORM accept-charset="utf-8" method="get">
			<LABEL for = "q">Search:</LABEL>
			<INPUT id = "q" name = "q" type = "text" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'utf-8');?>"/>
			<BR>
			<LABEL for = "s">Sort By:</LABEL>
			<SELECT name=s>
				<OPTION selected >pid</OPTION>
				<OPTION>title</OPTION>
				<OPTION>fund</OPTION>
			</SELECT>
			<INPUT type=radio name=order value="ASC"> ASC
			<INPUT type=radio name=order value="DESC" checked> DESC
			<BR>
			<P>Name: <?php echo htmlspecialchars($name, ENT_QUOTES, 'utf-8');?></p>
			<P>Location: <?php echo htmlspecialchars($filter, ENT_QUOTES, 'utf-8');?></P>
			<INPUT type = "submit" value="search"/>
		<FORM>
	</div>
    
	
	<!-- end .header --></div>
  <div class="sidebar1">
    <ul class="nav">
      <li><a href="#">Link one</a></li>
      <li><a href="#">Link two</a></li>
      <li><a href="#">Link three</a></li>
      <li><a href="#">Link four</a></li>
    </ul>
    <p>&nbsp;</p>
    <!-- end .sidebar1 --></div>
  <div class="content">
    <div class="results">
	<p>No results</p>
	</div>
	<div class="recommendation">
	<p>No Recommendations</p>
	</div>
    <!-- end .content --></div>
  <div class="footer">
    <footer id="colophon">
	<div class="wrap">
		<a href="/blog/?p=1013">Join the team</a> //
		<a href="/blog/?p=999">Contact us</a> //
		<a href="/blog/?p=123">The team</a> //
		<a href="/blog/">Blog</a> //
		<a href="/blog/?p=132 ">How to create a project</a>  //
		<a href="/blog/?cat=21">FAQs</a>// 
		<a href="/blog/?p=1018">Terms of use</a>
		<div class="footer-logos">
      <img src="/img/rackspace.jpg" class="rackspace">
        <img src="/img/logo-footer.png" style="padding-top:15px;">
	    </div>
	</div>	
</footer>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>


