<?php
define('TMSPATH_BASE', dirname(__dir__));

require_once TMSPATH_BASE.'/ext/TMSDatabase.php';
require_once TMSPATH_BASE.'/ext/fileuploader.php';
class Api{
private	$http_data="";

	public function Api(){
	//$this->mycurl("http://masokochallenge.jamaatech.com/api/1.0/category");
   $this->http_data=$_REQUEST;
   $this->memberRegister();
	}
     private function mycurl($urls){
     // The URL to POST to
     $result="";
  $url = $urls;

  // The value for the SOAPAction: header
  $action = "My.Soap.Action";

  // Get the SOAP data into a string, I am using HEREDOC syntax
  // but how you do this is irrelevant, the point is just get the
  // body of the request into a string
  $mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope>
  <!-- SOAP goes here, irrelevant so wont bother writing it out -->
</soap:Envelope>
EOD;

  // The HTTP headers for the request (based on image above)
  $headers = array(
    'Content-Type: text/xml; charset=utf-8',
    'Content-Length: '.strlen($mySOAP),
    'SOAPAction: '.$action
  );

  // Build the cURL session
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  ///curl_setopt($ch, CURLOPT_POST, TRUE);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $mySOAP);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  // Send the request and check the response
  if (($result = curl_exec($ch)) === FALSE) {
    die('cURL error: '.curl_error($ch)."<br />\n");
  } else {
    echo "Success!<br />\n";
  }

  curl_close($ch);
    echo $result;
     }

private function memberRegister(){
$users=$this->http_data;
$db=new TMSDatabase();
$uploader=new fileUploader();
$dates=@date("Y-m-d H:i:s");
if(isset($users['jina']) ){
$jina=$users['jina'];
$mkoa=$users['mkoa'];
$wilaya=$users['wilaya'];
$kata=$users['kata'];
$simu=$users['simu'];
$kikundi=$users['kikundi'];
$biashara=$users['biashara'];
$mkopo=$users['mkopo'];
$tarehemkopo=$users['tarehemkopo'];
$nenosiri=$users['nenosiri'];
$originalfile=$_FILES['picha']['name'];
$tempfile=$_FILES['picha']['tmp_name'];
$error=$_FILES['picha']['error'];
$id=$this->getLastId("members","id")+1;
$filename=$id."_".$jina;
$destpath="";
$myfiles=$uploader->fileProcessor($originalfile,$tempfile,$id,$filename,"images",$error);
if(is_array($myfiles)){
$datainsert=array($id,$jina,$mkoa,$wilaya,$kata,$simu,$kikundi,$biashara,$mkopo,$tarehemkopo,$nenosiri,$dates);
$status=$db->insertField("members",$datainsert);
if($status){
$state=$uploader->insertImageNormal("tze_image","members",$id,"20",$dates,$myfiles[1]);
if($state){
echo "success";
}else{
echo "no image";
}
}else{
echo "not saved";
}
}else{
echo "failed to save image";
}
}else{
echo "no data received";
}

}


    public function getLastId($tablename,$indexfield){
    	$last=new TMSDatabase();
    	$counts=0;
    	$status=$last->selectField($tablename,array($indexfield),"","","",$indexfield,"desc","","1");
    	if($status){
        $rec=$last->getResultSet();
        $counts=$rec[$indexfield];
    	}
    	return $counts;
    }



}

new Api();

?>
