<?php

//==========INITIALIZING PATH CONSTANTS AND OTHER CONSTANTS======================//
$base_path = dirname(dirname(realpath(__FILE__)));
defined('DS')?null:define('DS',DIRECTORY_SEPARATOR);
 defined("SITE_ROOT")?null:define('SITE_ROOT',$base_path);
 defined("LIB_PATH")?null:define('LIB_PATH',SITE_ROOT.DS.'comas_core_lib'.DS.'controller');

 /**
  * make database connection setup 
  */
include(SITE_ROOT.DS."comas_core_lib".DS."comas_data_engine".DS."ComasMysqlConnector.php");


 ComasMysqlConnector::setServer("comasico_tzee","comasi100base","127.0.0.1"); //username ,passowrd, servername.
function databaseConnect(){
$connectAp=new  ComasMysqlConnector();
$connectAp->setApplicant("comasico_tzeetravel");   //database name.
 $connectAp->connectApl();
}
databaseConnect();

//include ohter import files/common files
require_once(SITE_ROOT.DS."comas_core_lib".DS."comas_data_engine".DS."ComasDatabase.php");

 
?>