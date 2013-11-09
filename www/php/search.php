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
<link href="../css/search.css" rel="stylesheet" type="text/css" /><!--[if lte IE 7]>

<style>
.content { margin-right: -1px; } /* this 1px negative margin can be placed on any of the columns in this layout with the same corrective effect. */
ul.nav a { zoom: 1; }  /* the zoom property gives IE the hasLayout trigger it needs to correct extra whiltespace between the links */
</style>
<![endif]-->
</head>

<body>
<div class="status-bar">
	<P>Name: <?php echo htmlspecialchars($name, ENT_QUOTES, 'utf-8') . "    ";?>Location: <?php echo htmlspecialchars($filter, ENT_QUOTES, 'utf-8');?></p>
</div>
<div class="container">
  <div class="header">
	<div class="logo-header">
		<a href="#">
			<img src="../img/beta-logo.jpg" alt="Insert Logo Here" width="100%" name="Insert_logo"  id="Insert_logo" style="background-color: #8090AB; display:block;" />
		</a>
	</div>
	<div class="search-box">
		<FORM  accept-charset="utf-8" method="get">
			<LABEL for = "q"></LABEL>
			<INPUT id="search-text" id = "q" name = "q" type = "text" placeholder="Which project do you want to search for?"<?php echo htmlspecialchars($query, ENT_QUOTES, 'utf-8');?>"/>
			<INPUT id="search-button" type = "submit" value="search"/>
			<INPUT type="hidden" name="s" value="title">
			<INPUT type="hidden" name="order" value="DESC">
		<FORM>
	</div>
    
	
	<!-- end .header --></div>
	<div class="sidebar1">
		<h4 class="section-title">TYPE</h4>
		<div class="type-tag">
			<ul class="nav">
			<li><a href="#">General</a></li>
			<li><a href="#">Government</a></li>
			<li><a href="#">Individual</a></li>
			<li><a href="#">Non-profit</a></li>
			<li><a href="#">Profit</a></li>
			</ul>
		</div>
		<h4 class="section-title">CAPITAL</h4>
		<div class="type-tag">
			<ul class="nav">
			<li><a href="#">Funds</a></li>
			<li><a href="#">Volunteer</a></li>
			<li><a href="#">Nearest</a></li>
			</ul>
		</div>
    <p>&nbsp;</p>
    <!-- end .sidebar1 --></div>
  <div class="content">
    <div class="results-div">
	<div class="results-tool">
		<div class="results-sort">
		<ul>
			<li><a href="/php/search.php?q=<?php echo $query?>&s=fund&order=DESC">Funds</a></li>
			<li><a href="/php/search.php?q=<?php echo $query?>&s=title&order=DESC">Title</a></li>
			<li><a href="/php/search.php?q=<?php echo $query?>&s=N_volunteer&order=DESC">Volunteers</a></li>
		</ul>
		</div>
	</div>
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

?>	

<?php
		foreach($results->response->docs as $doc){
?>
		<div class="results-list">
		<h4 class="result-title"><?php echo "PROJECT:   " . $doc->title;?></h4>
		<div class="project-img">
			<img src="../img/school_3.jpg" alt="No image" width="100%" height="100%">
		</div>
		
		<div class="project-profile">
			<div>
			<span class="item-owner" ><?php echo "Creator:   " . $doc->owner;?></span>
			<span class="item-location" ><?php echo "Location:   " . $doc->location;?></span>
			</div>
			<div>
			<span class="item11" ><?php echo "Funds:   " . $doc->fund;?></span>
			<span class="item11" ><?php echo "Volunteers:   " . $doc->N_volunteer;?></span>
			<span class="item11" ><?php echo "Supply:   " . "Sufficient"?></span>
			</div>
			<div class="detail">
				<?php echo "Detail:   " . "TBD"?>
			</div>
		
		</div>
		<p>&nbsp;</p>
		</div>
<?php
		}
?>	

<?php
		}
	}
?>
	
	</div>
	</div>
	<div class="recommendation">
	<H4 class="section-title">Recommendation</H3>	
	<div class="recommended_project">
		<img src="../img/PR.jpg" width="100%" height="100%"></img>
	</div>
		<P align="center">highest fund project</P>
<?php
	$params = array(
		'fq' => $filter,
		'sort' => 'fund desc',
		'fl' => 'title owner fund location'	
	);
	$results = $solr->search("*:*", 0, 1, $params);	
	foreach($results->response->docs as $doc){
?>
		<TABLE align = "center" style = "border: 1px solid black; text-align: left">	
			<TR>
				<TH><?php echo "PROJECT:";?></TH>
				<TD><?php echo $doc->title;?></TD>
			</TR>
			<TR>
				<TH><?php echo "FUND:";?></TH>
				<TD><?php echo $doc->fund;?></TD>
			</TR>
			<TR>
				<TH><?php echo "OWNER:";?></TH>
				<TD><?php echo $doc->owner;?></TD>
			</TR>
			<TR>
				<TH><?php echo "LOCATION:";?></TH>
				<TD><?php echo $doc->location;?></TD>
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
</body>
</html>


