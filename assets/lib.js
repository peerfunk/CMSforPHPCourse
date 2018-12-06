function load(type,data, callback){
		var typ = {}
		typ["data"] = JSON.stringify(data);
		typ["ajax"] = type;
		console.log(typ);
		var request = $.ajax({
			method: "POST",
			data: typ,
			dataType: "html"
		});
		request.done(callback);
		request.fail(function( jqXHR, textStatus ) {
			alert( "Request failed: " + textStatus );
			console.log(jqXHR )
		});
}
