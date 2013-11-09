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
<link rel="stylesheet" type="text/css" href="../css/screen.css" /> 
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
		<FORM accept-charset="utf-8" method="get">
			<LABEL for = "q">Search:</LABEL>
			<INPUT id = "q" name = "q" type = "text" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'utf-8');?>"/>
			<INPUT type = "submit" value="search"/>
			<BR>
			<LABEL for = "s">Sort By:</LABEL>
			<SELECT name=s>
				<OPTION selected >pid</OPTION>
				<OPTION>title</OPTION>
				<OPTION>fund</OPTION>
			</SELECT>
			<INPUT type=radio name=order value="ASC"> ASC
			<INPUT type=radio name=order value="DESC" checked> DESC
		<FORM>
	</div>
    
	
	<!-- end .header --></div>
	<div class="sidebar1">
		<h4 class="section-title">TYPE</h3>
		<div class="type-tag">
			<ul class="nav">
			<li><a href="#">General</a></li>
			<li><a href="#">Government</a></li>
			<li><a href="#">Individual</a></li>
			<li><a href="#">Non-profit</a></li>
			<li><a href="#">Profit</a></li>
			</ul>
		</div>
		<h4 class="section-title">CAPITAL</h3>
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
    <div class="results">
<?php
	if($results){
		$total = (int) $results->response->numFound;
		$start = min(1, $total);
		$end = min($limit, $total);
?>
	<DIV>Results <?php echo $start; ?> - <?php echo $end;?> of <?php echo $total; ?>:</DIV>
	<TABLE border="1">
<?php
		foreach($results->response->docs as $doc){
?>
		<TR>
		<TD>
			<TABLE style = "text-align: left">
<?php
			foreach($doc as $field => $value){
?>		
<?php
				if($field != "_version_"){
?>
		<TR>
			<TH><?php echo htmlspecialchars($field, ENT_NOQUOTES, 'utf-8');?></TH>
			<TD><?php echo htmlspecialchars($value, ENT_NOQUOTES, 'utf-8');?></TD>
		</TR>
		
<?php 
				}
?>
<?php
			}
?>
			</TABLE>
		</TD>
		</TR>
<?php
		}
?>	
	</TABLE>
<?php
	}
?>

	</div>
	<div class="recommendation">
	<H4 class="section-title">Recommendation</H3>
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
<?php
		foreach($doc as $field => $value){
			if($field != "_version_"){
?>		
			<TR>
				<TH><?php echo htmlspecialchars($field, ENT_NOQUOTES, 'utf-8');?></TH>
				<TD><?php echo htmlspecialchars($value, ENT_NOQUOTES, 'utf-8');?></TD>
			</TR>
<?php   
			}
		}
?>

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


