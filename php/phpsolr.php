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
<HTML>
	<HEAD>
		<TITLE>PHP Solr Client Example</TITLE>
	</HEAD>
	<BODY>
	<DIV style = "width:100%">
		<DIV style = "width:30%;float:left;">
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
			<INPUT type = "submit" />
		<FORM>
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
		<?php if($field != "_version_"){?>
		<TR>
			<TH><?php echo htmlspecialchars($field, ENT_NOQUOTES, 'utf-8');?></TH>
			<TD><?php echo htmlspecialchars($value, ENT_NOQUOTES, 'utf-8');?></TD>
		</TR>
		<?php }?>
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
	</DIV>
	<DIV style = "width:40%;float:left;">
	<H3 align="center">Data From MySQL </H3>
	
<?php
	// Create connection
	$con=mysql_connect("localhost","root","");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	$select = mysql_select_db("test", $con) or die("Could not select example");
	$result = mysql_query("SELECT * FROM projects");
	echo "<TABLE align=\"center\" border = \"1\" style = \"border: 3px solid black; text-align: left\"><TR><TH>PID</TH><TH>TITLE</TH><TH>OWNER</TH><TH>LOCATIOIN</TH><TH>FUND</TH></TR>";
	while($row = mysql_fetch_array($result)){
		echo "<TR>";	
		echo "<TD>" . $row{'pid'} . "</TD>" . "<TD>" . $row{'title'} . "</TD>" . "<TD>" . $row{'owner'} . "</TD>" . "<TD>" . $row{'location'} . "</TD>" . "<TD>" . $row{'fund'} . "</TD>";
		echo "</TR>";
	}
	echo "</TABLE>";
?>	
	</DIV>
	<DIV border="1" style = "width:30%;float:left">
		<H3 align="center">Recommendation</H3>
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
				?>
			<?php
				}
			?>
			</TABLE>
		<?php
			}
		?>
	</DIV>
	</DIV>
	</BODY>
</HTML>