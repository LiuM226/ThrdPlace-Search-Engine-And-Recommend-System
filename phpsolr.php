<?php
header('Content-Type: text/html; charset=utf-8');
$limit = 10;
$query = isset($_REQUEST['q']) ? $_REQUEST['q'] : false;
$results = false;
  
if ($query)
{
  require_once( 'SolrPhpClient\Apache\Solr\Service.php' );   
  //
  //
  // Try to connect to the named server, port, and url
  //
  $solr = new Apache_Solr_Service( 'localhost', '8983', '/solr' );
  
  if ( ! $solr->ping() ) {
    echo 'Solr service not responding.';
    exit;
  }
  try
  {
    $results = $solr->search($query, 0, $limit);
  }
  catch (Exception $e)
  {
    // in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>SEARCH EXCEPTION</title><body><pre>{$e->__toString()}</pre></body></html>");
  }
  /* 
  //
  //
  // Create two documents
  //
  $docs = array(
    'doc_no1' => array(
      'id' => 1,
      'title' => 'Alphabet',
      'text' => 'The quick brown fox jumps over the lazy dog',
      'category' => array( 'orange', 'pear' ),
    ),
    'doc_no2' => array(
      'id' => 2,
      'title' => 'Letters',
      'text' => 'Jackdaws love my big Sphinx of Quartz',
      'category' => array( 'apple', 'pear' ),
    ),
  );
     
  $documents = array();
   
  foreach ( $docs as $item => $fields ) {
     
    $part = new Apache_Solr_Document();
     
    foreach ( $fields as $key => $value ) {
      if ( is_array( $value ) ) {
        foreach ( $value as $data ) {
          $part->setMultiValue( $key, $data );
        }
      }
      else {
        $part->$key = $value;
      }
    }
     
    $documents[] = $part;
  }
     
  //
  //
  // Load the documents into the index
  //
  try {
    $solr->addDocuments( $documents );
    $solr->commit();
    $solr->optimize();
  }
  catch ( Exception $e ) {
    echo $e->getMessage();
  }
   
  //
  //
  // Run some queries.
  //
  $offset = 0;
  $limit = 10;
   
  $queries = array(
    'id: 1 OR id: 2',
    'content: test1',
    'title: world'
  );
 
  foreach ( $queries as $query ) {
    $response = $solr->search( $query, $offset, $limit );
     
    if ( $response->getHttpStatus() == 200 ) {
      // print_r( $response->getRawResponse() );
       
      if ( $response->response->numFound > 0 ) {
        echo "$query <br />";
 
        foreach ( $response->response->docs as $doc ) {
          echo "$doc->id $doc->title <br />";
        }
         
        echo '<br />';
      }
    }
    else {
      echo $response->getHttpStatusMessage();
    }*/
  }
 
 
?>
<HTML>
	<HEAD>
		<TITLE>PHP Solr Client Example</TITLE>
	</HEAD>
	<BODY>
	<DIV style = "width:1100px">
		<DIV style = "width:600px;float:left;">
		<FORM accept-charset="utf-8" method="get">
			<LABEL for = "q">Search:</LABEL>
			<INPUT id = "q" name = "q" type = "text" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'utf-8');?>"/>
			<INPUT type = "submit" />
		<FORM>
<?php

if($results){

	$total = (int) $results->response->numFound;
	$start = min(1, $total);
	$end = min($limit, $total);
?>

	<DIV>Results <?php echo $start; ?> - <?php echo $end;?> of <?php echo $total; ?>:</DIV>
	<OL>
<?php
	foreach($results->response->docs as $doc){
?>
		<LI>
			<TABLE style = "border: 1px solid black; text-align: left">
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
		</LI>
<?php
	}
?>	
	</OL>
<?php
	}
?>
	</DIV>
	<DIV style = "width:500px;float:left;">
	<H3>Data From MySQL </H3>
	
<?php
	// Create connection
	$con=mysql_connect("localhost","root","");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	$select = mysql_select_db("test", $con) or die("Could not select example");
	$result = mysql_query("SELECT * FROM documents");
	echo "<TABLE border = \"1\" style = \"border: 3px solid black; text-align: left\"><TR><TH>ID</TH><TH>DATE_ADDED</TH><TH>TITLE</TH><TH>CONTENT</TH></TR>";
	while($row = mysql_fetch_array($result)){
		echo "<TR>";	
		echo "<TD>" . $row{'id'} . "</TD>" . "<TD>" . $row{'date_added'} . "</TD>" . "<TD>" . $row{'title'} . "</TD>" . "<TD>" . $row{'content'} . "</TD>";
		echo "</TR>";
	}
	echo "</TABLE>";
?>	
	</DIV>
	</DIV>
	</BODY>
</HTML>