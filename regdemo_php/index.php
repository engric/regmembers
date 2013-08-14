<?php
define('TMSPATH_BASE', dirname(__file__));
require_once TMSPATH_BASE.'/ext/TMSDatabase.php';
require_once TMSPATH_BASE.'/ext/fileuploader.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
          <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-
       8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="comas_ui/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="css/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="css/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="css/ico/apple-touch-icon-72-precomposed.png">
     <link rel="apple-touch-icon-precomposed" href="css/ico/apple-touch-icon-57-precomposed.png">
     <link rel="shortcut icon" href="css/ico/favicon.png">
     <style>
         .round_border{
   padding: 3% 3% 3% 8%;
  background-color: #f5f5f5;
  border: 1px solid #ddd;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}
/* Sidenav for Docs
-------------------------------------------------- */

.bs-docs-sidenav {
  width: 228px;
  margin: 30px 0 0;
  padding: 0;
  background-color: #fff;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  -webkit-box-shadow: 0 1px 4px rgba(0,0,0,.065);
     -moz-box-shadow: 0 1px 4px rgba(0,0,0,.065);
          box-shadow: 0 1px 4px rgba(0,0,0,.065);
}
.bs-docs-sidenav > li > a {
  display: block;
  width: 150px;
  margin: 0 0 -1px;
  padding: 8px 14px;
  border: 1px solid #e5e5e5;
}
.bs-docs-sidenav > li:first-child > a {
  -webkit-border-radius: 6px 6px 0 0;
     -moz-border-radius: 6px 6px 0 0;
          border-radius: 6px 6px 0 0;
}
.bs-docs-sidenav > li:last-child > a {
  -webkit-border-radius: 0 0 6px 6px;
     -moz-border-radius: 0 0 6px 6px;
          border-radius: 0 0 6px 6px;
}
.bs-docs-sidenav > .active > a {
  position: relative;
  z-index: 2;
  padding: 9px 15px;
  border: 0;
  text-shadow: 0 1px 0 rgba(0,0,0,.15);
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
     -moz-box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
          box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
}
/* Chevrons */
.bs-docs-sidenav .icon-chevron-right {
  float: right;
  margin-top: 2px;
  margin-right: -6px;
  opacity: .25;
}
.bs-docs-sidenav > li > a:hover {
  background-color: #f5f5f5;
}
.bs-docs-sidenav a:hover .icon-chevron-right {
  opacity: .5;
}
.bs-docs-sidenav .active .icon-chevron-right,
.bs-docs-sidenav .active a:hover .icon-chevron-right {
  background-image: url(../img/glyphicons-halflings-white.png);
  opacity: 1;
}
.bs-docs-sidenav.affix {
  top: 0px;
}
.bs-docs-sidenav.affix-bottom {
  position: absolute;
  top: auto;
  bottom: 270px;
}
  </style>
    </head>
    <body>
        <!-- my nav -->
        <meta http-equiv=Refresh content=4;url=index.php>
        <div class="navbar">
              <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <a class="brand" href="#">Register Result Demo</a>
                  <div class="nav-collapse collapse navbar-responsive-collapse">

                    <ul class="nav pull-right">
                      <li><a href="#">Link</a></li>
                      <li class="divider-vertical"></li>
                       <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Add More<b class="caret"></b></a>
                           <ul class="dropdown-menu">
                               <li><a href="#">Account Books</a></li>
                               <li><a href="index.php">Business</a></li>
                              <li><a href="#">Users</a></li>
                           </ul>
                       </li>
                      <li class="divider-vertical"></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Business <b class="caret"></b></a>
                        <ul class="dropdown-menu busilist">


                            <!--
                          <li><a href="#">Action</a></li>
                          <li><a href="#">Another action</a></li>
                          <li><a href="#">Something else here</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Separated link</a></li>-->
                        </ul>
                      </li>
                      <li class="divider-vertical"></li>
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Setting<b class="setting"></b></a>
                      </li>
                    </ul>
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div><!-- /navbar -->
        <!-- my nav -->
        <div class="container">
            <div class="page-header"></div>
            <div class="row-fluid">
        <div class="span1">
            <ul class="nav nav-list bs-docs-sidenav accountlist">


            </ul>
        </div>
        <div class="span10 round_border">

            <div class="alert info_div" style="display:none; opacity:1;">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong class="sms_type">W</strong>&nbsp;|&nbsp;<span class="sms_holder"></span>
</div>
            <div class="action_pages">
        <?php
  $db=new TMSDatabase();
  $imagefetcher=new fileUploader();
 $status= $db->selectField("members",array("id,jina,mkoa,kikundi,mkopo,biashara,tarehemkopo"),"","","","id","desc","","30");
      //echo $forms->createAccountBooks();
      //echo $forms->addingAccountOption();
      // echo $forms->accountRelation(true);
      if($status){
      ?>
      <table class="table table-striped table-hover" >
      <tr><td>Sn</td><td>Jina</td><td>Mkoa</td><td>Kikundi</td><td>Mkopo</td><td>Biashara</td><td>TareheMkopo</td><td>Picha</td></tr>
      <?php
      $i=1;
      while($rec=$db->getResultSet()){
      $myimage=$imagefetcher->fetchImages("members",$rec['id']);
        ?>
    <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $rec['jina']; ?></td>
    <td><?php echo $rec['mkoa']; ?></td>
    <td><?php echo $rec['kikundi']; ?></td>
    <td><?php echo $rec['mkopo']; ?></td>
    <td><?php echo $rec['biashara']; ?></td>
    <td><?php echo $rec['tarehemkopo']; ?></td>
    <td><div class="thumbnail"><img src="<?php echo $myimage[0]; ?>" data-src="holder.js/60x60" width="60px" height="60px" /></div></td>
    </tr>
        <?php
        $i++;
        }
    echo "</table>";
      }
        ?>
        </div>
            <div class="myaccounts"></div>
       <div class="progress progress-striped active">
  <div class="bar newbusi_process" ></div>
</div>
        </div>
        <div class="span1"></div>
            </div>
        </div>
    </body>
    <!--javascript files placed at bottom for faster looding -->
      <script src="js/jquery-1.8.3.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-affix.js"></script>

    <script src="js/holder/holder.js"></script>
    <script src="js/google-code-prettify/prettify.js"></script>
    <script src="js/application.js"></script>
    <script src="js/comas_ajax.js"></script>
</html>
