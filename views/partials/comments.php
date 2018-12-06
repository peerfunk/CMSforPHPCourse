<!--display error messages-->

<?php
use MyCms\Util;
use Data\DataManager;
use MyCms\Comment;

echo "<script>";
require_once('views/js/comments.js');
echo "</script>";
?>

<div class="footer">
	<div id="comments">
	<?php if ($user != null): ?>
	
			<div class="comInp">
				<div class="form-group">
					<div class="row">		
						<label for="comment">New Comment:</label>
					</div>
					<div class="col-md-12">	
						<textarea class="form-control" rows="5" id="comment"></textarea>
					</div>  
					<div class="col-md-12 text-center"> 
						<div style="margin-top:20px;">
							<p>
								<button name="submit" onclick="createcomment($(this).parent().parent().parent().parent())" class="btn btn-primary btn-lg ">Comment</button>
							</p>
						</div>
					</div>
				 </div>
			</div>
		
		<?php else:?>
		
			<div class="col-md-12 text-center"> 
			<div class="row">		
				<a href="index.php?view=login" class="btn btn-info ">Login to Comment!</a> 
			</div>
		</div>
		<?php endif;?>
		<div class="row">
			<div class="comlist">
				<?php echo Comment::getAllComments($comments,$user_id, $article->getauthorId()); ?>
			</div>
		</div>
	</div>
</div>
</div> <!-- container -->

</body>
</html>