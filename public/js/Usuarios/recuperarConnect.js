var activeTab = window.location.href.substring(window.location.href.indexOf("#") + 1);
if(window.location.href.indexOf("#") != -1){
	$(".tab-pane").removeClass("active in");
	$('a[href="#'+ activeTab +'"]').tab('show');
}