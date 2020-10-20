<html>
<head>
<style type="text/css">
	body
{
 text-align:center;
 width:100%;
 margin:0 auto;
 padding:0px;
 font-family:helvetica;
 //background-color:rgba(0,0,0,0.5);
background: url(<?php echo base_url(); ?>/assets/images/bg.png) repeat;
}
#wrapper
{
 text-align:center;
 margin:0 auto;
 padding:0px;
 width:995px;
}
#effect
{
 background-color:#610B0B;
 position:relative;	
 width:100%;
 height:90%;
 //margin-left:300px;
 box-shadow:0px 0px 10px 0px #610B0B;
}
#effect p
{
 margin-top:10px;
 font-size:30px;
 color:#F79F81;
}
#curtain1
{
 top:0px;
 position:absolute;
 left:0px;
 height:220px;
}
#curtain2
{
 top:0px;
 position:absolute;
 height:220px;
 right:0px;
}
#curtain_buttons input[type="button"]
{
 margin-top:5px;
 width:220px;
 height:45px;
 border-radius:2px;
 color:white;
 background-color:#B43104;
 border:none;
 border-bottom:6px solid #8A2908;
}
</style>
<script src="<?php echo base_url('assets/');?>assets/jquery/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
function open_curtain()
{
 $("#curtain1").animate({width:50},1000);
 $("#curtain2").animate({width:45},1000);
 setTimeout(function(){ window.location="<?php echo base_url(); ?>/home"; }, 4000);
}
function close_curtain()
{
 $("#curtain1").animate({width:500},1000);
 $("#curtain2").animate({width:490},1000);
}
</script>
</head>
<body>
<div id="wrapper">

<div id="effect">
 <p style="padding-top:30%;left: 50%">GFSU Launches elearning programme in Forensic Accounting in collaboration with CDIMS, Mumbai </p>
 <img style="height:100%"  src="<?php echo base_url('assets/img/splash/curtain1.jpg');?>" id="curtain1">
 <img style="height:100%" src="<?php echo base_url('assets/img/splash/curtain2.jpg');?>" id="curtain2">
</div>

<div id="curtain_buttons">
 <input type="button" value="LAUNCH eLEARNING COURSE" onclick="open_curtain();">
</div>

</div>
</body>
</html>