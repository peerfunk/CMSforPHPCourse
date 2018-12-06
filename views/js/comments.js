	function delComment(cid, uid, obj) {
	    load("delComment", {
	        cid,
	        uid,
	        "aid": <?php echo $article->getId();?>
	    }, function(msg) {
	        console.log(msg);
	    });
	    obj.fadeOut(500, function() {
	        $(this).remove();
	        $("a[href='#comments']").text((parseInt($("a[href='#comments']").text()) - 1) + " Comments");
	    });
	}

	function editComment(cid, uid, obj) {
	    var comment = obj.find(".text.col-md-12.text-left");
	    if ($(comment).find("textarea").length) {
	        var comment = ($(comment).find("textarea").val());
	        updateComment(comment, cid, uid, <?php echo $article->getId();?>);
	    } else {
	        var box = $(comment).html($("<textarea></textarea>").html($(comment).text())); //
	    }
	}

	function updateComment(comment, cid, uid, aid) {
	    load("updateComment", {
	        comment,
	        cid,
	        uid,
	        aid
	    }, function(msg) {
	        loadAllComments();
	    });
	}

	function loadAllComments() {
	    load("loadAllComments", {
	        'aid': <?php echo $article->getId(); ?>,
	        'uid': <?php echo $user_id; ?>,
	        'autid': <?php echo $article->getauthorId(); ?>
	    }, function(msg) {
	        $(".comlist").html(msg);
	    });
	}

	function createcomment(obj) {
	    var comment = obj.find('.col-md-12 textarea').val();
	    var article_id = <?php echo $article_id;?>;
	    var user_id = <?php echo $user_id;?>;
	    if (comment != "") {
	        load("createComment", {
	            comment,
	            article_id,
	            user_id
	        }, function(msg) {
	            var JSONObject = JSON.parse(msg);
	            $(".footer #comments .col-md-12 textarea").val("");
	            $(".footer #comments .row .comlist").html(JSONObject["content"]);
	            $("a[href='#comments']").html(JSONObject["count"] + " Comments");
	        });
	    } else {
	        alert("no comment!");
	    }
	}