function cat(obj){
	var cat = $(obj).find(":selected").text();
	console.log(cat);
	$('div #category').show();
	console.log($('div #category').not("." + cat).hide());
}
function res(){
	$('div#category').show();
}
