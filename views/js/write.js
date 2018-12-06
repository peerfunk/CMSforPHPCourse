$(document).ready(function() {
    var editor = $("#txtEditor").Editor();
<?php if(isset($article)){ ?>
	$('#txtEditor').Editor("setText", <?php echo json_encode($article->getTxt());?>);
<?php } ?>  
});

function save() {
    var text = $('.Editor-editor').html();
	var title = $('input[type="text"]#title').val();
	var subtitle = $('input[type="text"]#subtitle').val();
    var category = $("select option:selected").val();
    var user_id = <?php echo $user_id;?>;
    var article_id = <?php if(isset($article))echo $article->getId(); else echo '-1'; ?>;
    if (text == "")
        alert("No text!");
    else if (category == "")
        alert("No category!");
    else if (title == "")
        alert("No title!");
	else if (subtitle == "")
        alert("No subtitle!");
    else {
        load(<?php echo isset($article)?'"updateArticle"':'"newArticle"' ?>, {
            user_id,
            text,
            category,
            title,
            article_id,
			subtitle
        }, function(msg) {
			//console.log(msg);
			$(location).attr('href', 'index.php?view=article&id=' + msg);
        });
    }
}