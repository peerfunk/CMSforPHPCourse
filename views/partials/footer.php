<!--display error messages-->

<?php
use MyCms\Util;
if (isset($errors) && is_array($errors)): ?>
<script>
	$(document).ready(function(){
		console.log($("li.message").html());
		$("li.message").parent().parent().delay(2000).fadeOut(500);		
	})
</script>

    <div class="errors alert alert-danger">
        <ul style=" list-style-type: none;">
            <?php foreach ($errors as $errMsg): ?>
                <li class="message"><?php echo(Util::escape($errMsg)); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!--/display error messages-->

</div> <!-- container -->
</body>
</html>