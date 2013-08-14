<?php
require_once 'connect.php';
/**
 * This tamplate contains all neccessary method required to do operation on the database
 * @author Raphael martin <rafakingazi@gmail.com>
 */

class TMSDatabase{
    private static $sqlerror=false;
    private $sql_result;
    /**
     * This method is used to insert data into the database using the given table name
     * and array of data.
     * note the $data must much number of columns in the given database.
     * @param type $tablename
     * @param array $data
     */
	public static function escapeString($content){
		 if (PHP_VERSION < 5) {
    $content = get_magic_quotes_gpc() ? stripslashes($content) : $content;
  }
  $content = function_exists("mysql_real_escape_string") ? @mysql_real_escape_string($content) : @mysql_escape_string($content);
  return $content;
	 }
         
         /**
          * This method is used to insert new data into given database table
          * @param type $tablename
          * @param array $data
          * @return boolean
          */

    public static function insertField($tablename,array $data){
        $datalength=count($data);
        $last=$datalength-1;
        if($datalength>0){
        $insert="insert into $tablename values(";
        for($i=0; $i<$datalength; $i++){
            if($i!=$last){
                $insert.=" '$data[$i]',";
            }else{
                $insert.=" '$data[$i]'";
            }
        }
		$insert.=" )";
        }

        $status=  self::executeQuery($insert);
     if($status){
         return true;
     }else{
         return false;
     }
    }
    /**
     * This method is used to select all or some of selected fields from the database;
     * default value of $field is * for all fields;
     * @param type $tablename
     * @param array $field
     * @param type $conditionfield
     * @param type $conditionvalue
     * @param type $orderbyfield
     * @param type $asc_descvalue
     * @param type $offset
     * @param type $limit
     */
    public function selectField($tablename,array $field,$condition,$conditionfield,$conditionvalue,$orderbyfield,$asc_descvalue,$offset,$limit){
        $fieldlength=count($field);

        $lastfield=$fieldlength-1;
        if($fieldlength>0){
        $select="select ";
        for($i=0; $i<$fieldlength; $i++){
            if($i!=$lastfield){
         $select.=" $field[$i],";
            }else{
           $select.="$field[$i] ";
            }
        }
        }
        $select.=" from $tablename ";
        if($conditionfield!="" && $conditionvalue!=""){
            $select.=" where $conditionfield  $condition '$conditionvalue'";
        }
        if($orderbyfield!=""){
            $select.=" order by $orderbyfield ";
        }
        if($asc_descvalue!=""){
            $select.=" $asc_descvalue";

        }
		if($limit!=""){
            $select.=" limit $limit";

        }
        if($offset!=""){
           $select.=" offset $offset";
        }

        $status=  self::executeQuery($select);

     if(@mysql_num_rows($status)>0){
		 $this->sql_result=$status;
         return $status;
     }else{
         return self::$sqlerror;
     }


    }
	 /**
     * This method is used to select login info from the database;
     * default value of $field is * for all fields;
     * @param type $tablename
     * @param array $field
     * @param type $usernamefield
     * @param type $usernamevalue
	 * @param type $passwordfield
     * @param type $passwordvalue
     */
    public function selectUser($tablename,array $fieldtoselect,$usernamefield,$usernamevalue,$passwordfield,$passwordvalue){
        $fieldlength=count($fieldtoselect);

        $lastfield=$fieldlength-1;
        if($fieldlength>0){
        $select="select ";
        for($i=0; $i<$fieldlength; $i++){
            if($i!=$lastfield){
         $select.=" $fieldtoselect[$i], ";
            }else{
           $select.="$fieldtoselect[$i] ";
            }
        }
        }
        $select.=" from $tablename  where $usernamefield='$usernamevalue' and $passwordfield='$passwordvalue'";

        $status=  self::executeQuery($select);

     if(@mysql_num_rows($status)>0){
		  $this->sql_result=$status;
         return $status;
     }else{
         return false;
     }

    }
/**
 * This method is used to delete values from the database using the condition field given
 * note if no condition field given all the rows will be deleted from the giventable.
 * @param type $tablename
 * @param type $conditionfield
 * @param type $conditionvalue
 */
    public static function deleteField($tablename,$conditionfield,$conditionvalue){

       $delete="delete from $tablename ";
       if($conditionfield!="" && $conditionvalue!=""){

       $delete.=" where $conditionfield='$conditionvalue'";
       }
        $status=  self::executeQuery($delete);
     if($status){
         //delete successed
		 return true;
     }else{
         return self::$sqlerror;
     }
    }

  /**
   * This method is used to update the field value pair in the database
   * note array $fieldasKEY_valueasVALUE should contain a field as key and data to update as value
   * eg.  $fieldasKEY_valueasVALUE =array('username'=>'ramaki','password'=>'12we#');
   * @param type $tablename
   * @param array $fieldasKEY_valueasVALUE
   * @param type $conditionfield
   * @param type $conditionvalue
   */

  public static function updateField($tablename,array $fieldasKEY_valueasVALUE,$conditionfield,$conditionvalue){

      $lengths=count($fieldasKEY_valueasVALUE);
      $last=$lengths-1;
      $i=0;
        reset($fieldasKEY_valueasVALUE);
        $update=" update $tablename set ";
      while($data=each($fieldasKEY_valueasVALUE)){
        $field=$data['key'];
        $fieldvalue=$data['value'];
        if($i!=$last){
          $update.=" $field='$fieldvalue',";
        }else{
          $update.=" $field='$fieldvalue' ";
        }
          $i++;
      }
      $update.=" where $conditionfield='$conditionvalue'";
     $status=  self::executeQuery($update);

     if($status){
         //update successed
		 return true;
     }else{
         return self::$sqlerror;
     }
  }
  /**
   * This is the method used to execute all given queries.
   * @param type $query
   * @return type
   */
  private static function executeQuery($query){
      $result="";

      if($query!=""){
          $result=@mysql_query($query) or die(mysql_error()) ;
      }
      if($result!=""){

          return $result;
      }else{
          return NULL;
      }
  }


  /**
   * This method is used to count total number of rows in the given table
   * @param type $tablename
   * @param type $condition
   * @param type $conditionfield
   * @param type $conditionvalue
   * @return boolean
   */
  static function countrows($tablename,$condition,$conditionfield,$conditionvalue){
	  $query="select count(*) from $tablename ";
	  if($conditionfield !="" && $conditionvalue !=""){
		 $query.=" where $conditionfield $condition '$conditionvalue'";
	  }
	  $result=self::executeQuery($query);
	  if($result){
	  $found=@mysql_fetch_array($result);
           return @array_shift($found);
	  }else{
		  return false;
	  }
  }


  /**
   * This method is used to return an array holding required data fetched
   *  from given table by either of above select method
   * @return type resultset array
   */
public function getResultSet(){
return @mysql_fetch_array($this->sql_result);
}

}
?>
