function changeStatusArticle(obj){
	var articleId= obj.val();
	load("updateArticleStatus",{articleId},function( msg ) {
		if($(obj).find("i").attr("class")=="fa circle fa-check"){
			$(obj).find("i").attr("class","fa circle fa-times").attr("style","color:red");
		}else{
			$(obj).find("i").attr("class","fa circle fa-check").attr("style","color:green");
			
		}
	 });
	
}
function changeStatusComment(obj){
	var cid= obj.val();
	console.log(cid);
	load("delComment",{cid},function( msg ) {
		if($(obj).find("i").attr("class")=="fa circle fa-check"){
			$(obj).find("i").attr("class","fa circle fa-times").attr("style","color:red");
		}else{
			$(obj).find("i").attr("class","fa circle fa-check").attr("style","color:green");
			
		}
	 });
	
}