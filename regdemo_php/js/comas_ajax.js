var url="http://localhost/~raphaelmartin/NetBeansProjects/comasi/comas_ajax/index.php";
var j=0,progress="0%",infois_on=false,totalacc=1,acc_created=0,k=0;
function comasajax(url,data,method,datatype){
    $.ajax({
    type: method,
    url: url,
    data: data,
    dataType: datatype,
    success: function(data) {
    ajaxResultHandler(data,datatype);
    },
    error: function(error, status, desc) {
        console.log(error);
        $("div.info_div").css("display","block");
       $("div.info_div").addClass("alert-error");
        $("strong.sms_type").html("Ooop system Error !"); 
        $("span.sms_holder").html("System is busy Please Try Again Later"); 
        return error+"@"+desc;
    }
});
}

/**
*Method used to handle ajax result;
*/
function ajaxResultHandler(data,datatype){
//here you can put any function to use the given data
var result=data.data;

if(result!="error" && result!="success"){
switch(j){
    case 1:
        
        if(k!=0){
            $("div.myaccounts").html("<strong>created accounts "+acc_created+"/"+totalacc+"</strong>");
        }
$("div.action_pages").html(result);
updateProcess(progress);
   k=0;
    break;
    case 2:
$("div.more_fields").append(result);
    break;
     case 3:
     $("div.addrelation").append(result);
    break;
     case 4:
     $("select.sourcefield").html(result);
    break;
     case 5:
     $("select.destfield").html(result);
    break;
    case 6:
        console.log(result);
     $("ul.accountlist").html(result);
    break;
 
  
}
}else if(result=="error"){
   console.log(result);
 $("div.info_div").css("display","block");
 $("div.info_div").addClass("alert-error");
 $("strong.sms_type").html(result+" !"); 
 $("span.sms_holder").html(data.msg); 
  infois_on=true;
  hideInfoBlock();
}else if(result=="success"){
 $("div.info_div").css("display","block");
 $("div.info_div").addClass("alert-success");
 $("strong.sms_type").html(result+" !"); 
 $("span.sms_holder").html(data.msg); 
  infois_on=true;
  hideInfoBlock();   
}
//console.log(result);
}

$(document).ready(function(){
     
 $("form>select").blur();
elementAddingActions();
submitActions();
onselectActions("sourceacc",4);
onselectActions("destacc",5);
menuClicked();
});

function splitFieldNames(names){
   var firstclean= names.replace(/\[/, " ");
   var lastclean=firstclean.replace(/\]/, " ").toString();
   var splits=lastclean.split(",");
   return splits;
}
/**
* This function is used to get values from form field with array behaviour
* And convert them to normal php arrays, format
 */
function createFormArray(inputname){
var datas=new Array();
var parts2="";
var params = $.param( $( '[name="'+inputname+'\[\]"]' ) );
var parts=params.split("&");
if(parts.length>0){
  for(var i=0; i<parts.length; i++){
  parts2=parts[i].split("=");
  if(parts2.length>0){
      if(parts2[1]!=""){
          
      datas[i]=parts2[1].replace(/\+/gi, " ");
   
     
      }
  }
  } 
}
return datas;
}

/**
 *This function can be used to create array from the list of data.
 */
function createListArray(inputList,separator){
  var datas=new Array();
  var parts=inputList.split(separator);
if(parts.length>0){
  for(var i=0; i<parts.length; i++){
 datas[i]=parts[i];
  
  } 
}
return datas;
}
/**
 * This function holds all form submition function
 */
function submitActions(){
     //this method is used to create new business
     $('.send_data').live("click",function(e) {
   // j=1;
    e.preventDefault();
    var item={};
    var hist=$("input.fieldhists").val();
    var splited=splitFieldNames(hist);
   
    var lengths=splited.length;
    item["action"]="senddata";
    item["fieldname"]=createListArray(hist,",");
    item["transacc"]=createFormArray("transacc");
    for(var i=0; i<lengths; i++){
        item[$.trim(splited[i])]=createFormArray($.trim(splited[i]));
    }
    console.log(item);
    comasajax(url,item,"post","json");
    resetFields("accountdata"); //reset the fields
});

    //this method is used to create new business
     $('.create_biz').live("click",function(e) {
    j=1;
    e.preventDefault();
    var out0=createFormArray("bizname");
   var out=createFormArray("location");
    var out1=createFormArray("biztype");
     var out2=createFormArray("totalaccs");
     var out3=createFormArray("currency");
     totalacc=out2[0];
     k=1;
   comasajax(url,{"action":"createbiz","bizname":out0,"location":out,"biztype":out1,"totalaccs":out2,"currency":out3},"post","json");
   resetFields("newbusines"); //reset the fields
   progress="40%";
});

    //this method is used to create book of account
    $('.create_book').live("click",function(e) {
   j=0;
  
    e.preventDefault();
    var out0=createFormArray("bookname");
   var out=createFormArray("fieldname");
    var out1=createFormArray("datatype");
      var out2=createFormArray("acctype");
   comasajax(url,{"action":"createacc","bookname":out0,"fieldname":out,"datatype":out1,"acctype":out2},"post","json");
   acc_created++;
    resetFields("accbooks"); //clear the fields
    $("div.more_fields").html(""); //remove the extra fields
   k=1;
     if(k!=0){
            $("div.myaccounts").html("<strong>created accounts "+acc_created+"/"+totalacc+"</strong>");
        }
   if(acc_created==totalacc){
       $("div.myaccounts").html("");
       console.log(totalacc);
       acc_created=0;
       totalacc=1;
          k=0;
    j=1;
   }
 progress="60%";
});

//this method is used to create book of account
    $('.create_rel').live("click",function(e) {
    j=0;
    e.preventDefault();
    var out0=createFormArray("sourceacc");
   var out=createFormArray("sourcefield");
    var out1=createFormArray("destacc");
      var out2=createFormArray("destfield");
        var out3=createFormArray("relation");
   comasajax(url,{"action":"createrel","sourceacc":out0,"sourcefield":out,"destacc":out1,"destfield":out2,"relation":out3},"post","json");
   
   resetFields("accountsrelate"); //clear the fields
   $("div.addrelation").html(""); //remove the extra fields added
 j=1;
progress="80%";
});

//this method is used to save relations
  $('.create_rel').live("click",function(e) {
    j=1;
    e.preventDefault();
    var out0=createFormArray("sourceacc");
   var out=createFormArray("sourcefield");
    var out1=createFormArray("destacc");
     var out2=createFormArray("destfield");
     var out3=createFormArray("relation");

   comasajax(url,{"action":"saverelation","sourceacc":out0,"sourcefield":out,"destacc":out1,"destfield":out2,"relation":out3},"post","json");
   resetFields("accountsrelate"); //reset the fields input.
   $("div.addrelation").html(""); //remove the extra field addedd
   progress="86%";
});

//this method is used to Add Bank Accounts
     $('.create_bank').live("click",function(e) {
    j=1;
    e.preventDefault();
    var out0=createFormArray("bankname");
   var out=createFormArray("accname");
    var out1=createFormArray("accnumber");
     var out2=createFormArray("currency");
     var out3=createFormArray("currbalance");
     console.log(out0+out+out1+out2+out3);
   comasajax(url,{"action":"createbank","bankname":out0,"accname":out,"accnumber":out1,"currency":out2,"currbalance":out3},"post","json");
   resetFields("newbank"); //reset the fields
   progress="95%";
});
}

/**
*Method used for adding new fields to the form.
*/
function elementAddingActions(){

$('.bookfields').live("click",function() {
    j=0;
    comasajax(url,{"action":"addfields"},"post","json");
    j=2;
});

$('.addmorefields').live("click",function() {
    console.log("problem");
    j=0;
    comasajax(url,{"action":"addmorefields"},"post","json");
    j=2;
});

$('.more_accounts').live("click",function() {
    j=0;
    comasajax(url,{"action":"addaccounts"},"post","json");
   totalacc++;
    j=1;
    progress="59%";
});

$('.more_relation').live("click",function() {
    j=0;
    comasajax(url,{"action":"addrelation"},"post","json");
    j=3;
});

$('.goto_relation').live("click",function() {
    j=0;
    comasajax(url,{"action":"createrelation"},"post","json");
    j=1;
    progress="79%";
});
$('.last_steps').live("click",function() {
    j=0;
    comasajax(url,{"action":"last_steps"},"post","json");
    j=1;
   
});
$('.addbanks').live("click",function() {
    j=0;
    comasajax(url,{"action":"addbanks"},"post","json");
    j=1;
   
});
$('.newbusiness').live("click",function() {
    j=0;
    comasajax(url,{"action":"newbusiness"},"post","json");
    j=1;
  progress="0%";
});
}

/**
*Method used to update the progres bar of the system.
*/
function updateProcess(value){
$(".newbusi_process").css("width", value);
}

/**
 *This method is used to hide the info block after 5000 mil second
 */
function  hideInfoBlock(){
    if(infois_on){
      $("div.info_div").animate({ opacity: .9
     }, 5000, "linear", function(){$("div.info_div").css({display:"none",opacity:1})} );
    
     infos_on=false;
    }
}

/**
*This method is used to control select actions.
*/
function onselectActions(account,jvalue){

$('select.'+account).live("change",function() {
    j=0;
    var values=$('select.'+account).val();
    console.log(values);
    comasajax(url,{"action":"getfields","accountid":values,"source":account},"post","json");
    j=jvalue;
  $('select.'+account).blur();
});
}
/**
*This method is used to control the user menu
*/
function menuClicked(){
    $("ul.busilist>li>a").live("click",function(e){
        e.preventDefault();
       var myid=$(this).attr("id");
    j=0;
    comasajax(url,{"action":"currbusiness","busi_id":myid},"post","json");
    j=6;
    });


    $("ul.accountlist>li>a").live("click",function(e){
        e.preventDefault();
       var myid=$(this).attr("id");
    j=0;
    comasajax(url,{"action":"currfields","acc_id":myid},"post","json");
    j=1;
    });
}

/**
 * This method is used to clear fields of the given form
 */
function resetFields(formclass){
    $('.'+formclass).each(function(){
    this.reset();
});
}