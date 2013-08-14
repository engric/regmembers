<?php
class fileUploader{

	static function fileProcessor($originalfile,$tempfile,$uploaderid,$filename,$destpath,$error){

      $parts=explode(".",$originalfile);
       $extension=strtolower(array_pop($parts));
	   $file=$filename."_".$uploaderid;
       $filetosave=$file.'.'.$extension;
       $filepath=trim($destpath."/".$filetosave);
	  // if($extension=='csv' || $extension=='txt' || $extension=='xls' || $extension=='xlsx' ){
		 //  echo "file is so good to handle here";
		//  self::readFileContent($tempfile,$extension);
       if( move_uploaded_file(trim($tempfile), TMSPATH_BASE."/".$filepath)){
		   return array("",$filepath,trim($filename),trim($file),trim($extension));
	   }else{
		   return $error;
	   }

	  // }else{
		 //  return 1;
	  // }
	}

         function insertImageNormal($tabletoinsert,$tablename,$field_id,$userid,$dates,$image_path){

      $toimages=new TMSDatabase();
            $images=@explode("/", $image_path);
            $imagename="";
            $counts=count($images);
            if($counts>3){
            $imagename=$images[$counts-5]."/".$images[$counts-4]."/".$images[$counts-3]."/".$images[$counts-2]."/".$images[$counts-1];
            }else{
             $imagename=$image_path;
            }
            $data_to_insert=array("",$tablename,$field_id,$imagename,$image_path,$userid,$dates);
           $status= $toimages->insertField($tabletoinsert, $data_to_insert);
           return $status;

    }
       function insertImage($tablename,$field_id,$userid,$dates){
      $imagez=isset($_SESSION['myimage'])?$_SESSION['myimage']:"";
      $toimages=new TMSDatabase();
      if(is_array($imagez)){

        foreach($imagez as $image_path){
                 $images=@explode("/", $image_path);
            $imagename="";
            $counts=count($images);
           /// echo "<script> alert('".$counts."".$images[0]."'); </script>";
            if($counts>3){
            $imagename=$images[$counts-5]."/".$images[$counts-4]."/".$images[$counts-3]."/".$images[$counts-2]."/".$images[$counts-1];
            }else{
             $imagename=$image_path;
            }
            $data_to_insert=array("",$tablename,$field_id,$imagename,$image_path,$userid,$dates);
           $status= $toimages->insertField("tze_image", $data_to_insert);
           if($status){
             unset($_SESSION['myimage']);
           }else{
          unset($_SESSION['myimage']);
           }
        }
      }else{
          unset($_SESSION['myimage']);
      }
    }

	function delImages($tablename,$id,$imagepath){
    $dimages=new TMSDatabase();
    $delimages=new TMSDatabase();
    $delfile=new fileUploader();
    $status=false;
    $state=false;
    if($imagepath!=""){
      $status=$dimages->selectField("tze_image",array("table_id,table_name,img_path,image_path"),"=","table_id",$id."' and  (img_path='".$imagepath."' or image_path='".$imagepath."') and table_name='".$tablename,"","","","");

      }else{
      $status=$dimages->selectField("tze_image",array("table_id,table_name,img_path,image_path"),"=","table_id",$id."' and table_name='".$tablename,"","","","");

    }
    if($tablename!="" && $id!=""){
      if($status){
       while($rec=$dimages->getResultSet()){
     $del=$delfile->delFiles($rec['image_path']);
     if($del){
       $state=$delimages->deleteField("tze_image","table_id",$rec['table_id']."' and table_name='".$rec['table_name']."' and img_path='".$rec['img_path']);
     }else{
      $state=$delimages->deleteField("tze_image","table_id",$rec['table_id']."' and table_name='".$rec['table_name']."' and img_path='".$rec['img_path']);
     }
       }
   }
    }
  return $state;
}

	  function fetchImages($tablename,$id){
      $exp_fetch=new TMSDatabase();
      $image_path=array();
      $status=$exp_fetch->selectField("tze_image",array("image_path"),"=","table_id",$id."' and table_name='".$tablename,"img_id","asc", "","4");
      if($status){
        while($rec=$exp_fetch->getResultSet()){
            //build a data format
         $image_path[].=$rec['image_path'];
        }
      }else{
         $image_path="";
      }
      return $image_path;
    }

	static function readFileContent($file, $extension,$input_number){
		$content="";
		$file_data="";
		$from_user=$input_number;
		if($extension!= 'xls' && $extension!='xlsx'){
		$content=file_get_contents($file);
		if($extension=='csv'){
		$file_data=@explode("\r",$content);
		}else if($extension=='txt'){
			$file_data=@explode("\n",$content);
		}
		if(is_array($file_data)){
			foreach($file_data as $value){
				//echo "value is".$value;
				$number=trim($value);
				$len=strlen($number);
				if($len>=9){
					$pos=$len-9;
					$new_number="255".strpos($number,$pos);
					$from_user[].=$value;


			}
			}
		}
		}else{
			$content=file($file);
		if(is_array($content)){
			foreach($content as $value){
				echo "value are".$value."<br /><span color='blue'>Mimi</span>";
			}
		}else{
			echo $content;
		}
		}
		return $from_user;
	}
	//file downloader
	 static function downloads($submit,$keys,$filetype){
      if(isset($_POST[$submit])){
          $file=trim($_POST[$keys]);
		   $type=trim($_POST[$filetype]);

          $fp=  fopen($file,'r');
         header("Location:".$file);

             header("Content-Type:application/pdf");
             header("Content-Length:".filesize($file));
             header("Content-Disposition-attachment;filename=".$filename.".".$type);
             header("Content-Transer-Encoding:binary");
             fpassthru($fp);
      }
	 }
	 static function downloads_nosubmit($key,$filetype){
		  $filename=md5($key);
          $fp=  fopen($key,'r');
         header("Location:".trim($key));

             header("Content-Type:application/pdf");
             header("Content-Length:".filesize($key));
             header("Content-Disposition-attachment;filename=".$filename.".".$filetype);
             header("Content-Transer-Encoding:binary");
             fpassthru($fp);
	 }

	static function  setDates(){
      return @date('Y/m/d/ H:i:s');
   }

   function delFiles($filename){
       $deleted=false;
       if(is_file($filename)){
           $deleted=unlink($filename);

       }
       return $deleted;
   }

   function imageUploader(){
    $uploader=<<<UPLOADER
   <!--<div class="container">-->
    <!--Start of image Uploader-->
    <!-- The file upload form used as target for the file upload widget -->
    <!--<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">-->
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class=" fileupload-buttonbar">
            <div class="span10">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The loading indicator is shown during file processing -->
                <span class="fileupload-loading"></span>
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    <!--</form>-->
    <br>
    <!--end of image upload function -->
</div>
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>

<!-- </div>The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <p class="size">{%=o.formatFileSize(file.size)%}</p>
            {% if (!o.files.error) { %}
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            {% } %}
        </td>
        <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnail_url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            <button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
        </td>
    </tr>
{% } %}
</script>
UPLOADER;
return $uploader;
}

}
?>
