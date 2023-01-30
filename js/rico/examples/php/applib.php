<?
require "../../plugins/php/dbClass2.php";
$appName="Northwind";
$appDB="northwind";

function CreateDbClass() {
  global $oDB;
  $oDB = new dbClass();
  //$oDB->Dialect="Oracle";
  //$oDB->Dialect="TSQL";
  //$oDB->Dialect="Access";
}

function OpenDB() {
  $_retval=false;
  CreateDbClass();
  return $GLOBALS['oDB']->MySqlLogon($GLOBALS['appDB'], "userid", "password");
  //return $GLOBALS['oDB']->OdbcLogon("northwind2","Northwind","userid","password");
  //return $GLOBALS['oDB']->OracleLogon("XE","northwind","password");
}

function OpenApp($title) {
  $_retval=false;
  if (!OpenDB()) {
    return $_retval;
  }
  if (!empty($title)) {
    AppHeader($GLOBALS['appName']."-".$title);
  }
  $GLOBALS['accessRights']="rw";
  // CHECK APPLICATION SECURITY HERE  (in this example, "r" gives read-only access and "rw" gives read/write access)
  if (empty($GLOBALS['accessRights']) || !isset($GLOBALS['accessRights']) || substr($GLOBALS['accessRights'],0,1) != "r") {
    echo "<p class='error'>You do not have permission to access this application";
  }
  else {
    $_retval=true;
  }
  return $_retval;
}

function OpenTableEdit($tabname) {
  $obj= new TableEditClass();
  $obj->SetTableName($tabname);
  $obj->options["XMLprovider"]="ricoXMLquery.php";
  return $obj;
}

function OpenGridForm($title, $tabname) {
  $_retval=false;
  if (!OpenApp($title)) {
    return $_retval;
  }
  $GLOBALS['oForm']= OpenTableEdit($tabname);
  $CanModify=($GLOBALS['accessRights'] == "rw");
  $GLOBALS['oForm']->options["canAdd"]=$CanModify;
  $GLOBALS['oForm']->options["canEdit"]=$CanModify;
  $GLOBALS['oForm']->options["canDelete"]=$CanModify;
  session_set_cookie_params(60*60);
  $GLOBALS['sqltext']='.';
  return true;
}

function CloseApp() {
  global $oDB;
  if (is_object($oDB)) $oDB->dbClose();
  $oDB=NULL;
  $GLOBALS['oForm']=NULL;
}

function AppHeader($hdg) {
  echo "<h2 class='appHeader'>".str_replace("<dialect>",$GLOBALS['oDB']->Dialect,$hdg)."</h2>";
}
?>

