function arrayToJson(data){return JSON.stringify(data);}
function JsonToArray(data){return JSON.parse(data);}
function removeA(arr){var what,a=arguments,L=a.length,ax;while(L>1&&arr.length){what=a[--L];while((ax=arr.indexOf(what))!==-1){arr.splice(ax,1);}}
return arr;}
function msieversion(){var ua=window.navigator.userAgent;var msie=ua.indexOf("MSIE ");if(msie>0){return true;}else{return false;}}
function RegSuccMsg(data){swal({title:'Success Message',html:data.message,type:'success'}).then(function(){window.location=data.path;});}
function SuccMsgNoRefresh(data){swal({title:'Success Message',text:data.message,type:'success'})}
function recRegSuccMsg(data){swal({title:'Success Message',text:data.message,type:'success'}).then(function(){window.location=data.redirect_to;});}
function ActMsg(data){swal({title:'Success Message',text:data,type:'success'}).then(function(){window.location="index";});}
function ActErrMsg(data){swal({title:'',text:data,type:'error'}).then(function(){window.location="index";});}
function Newsletter(data){swal({title:'Newsletter',text:data.message,type:data.type}).then(function(){$('#emailfoot').val('');});}
function RegErrorMsg(data){swal({title:'Error Message',html:data.message,type:'error'});}
function loginErrorMsg(data){swal({title:'Error Message',type:'error',html:data.message});}
function errMsg(data){swal({title:'Error Message',html:data.message,type:'error'}).then(function(){history.pushState({message:'New State!'},'New Title',window.location.pathname);});}
function verifyemail(status,message){var type="error";var title="Error Message";if($status==1){type=success;title="Success Message";}
swal({title:title,html:message,type:type});}
function reload(){window.location.reload();}
function recRegisterSuccMsg(e){swal({title:e.title,html:e.message,type:"success"}).then(function(){window.location=e.redirect_to});}