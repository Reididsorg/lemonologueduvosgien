<?php $title = 'LE MONOLOGUE DU VOSGIEN'; ?>


<?php ob_start(); ?>

<h1>Modification du commentaire de <?= htmlspecialchars($comment['comment_author']) ?>, le <?= htmlspecialchars($comment['comment_date_fr']) ?></h1>
<p><a href="/index.php">Retour à la liste des billets</a></p>	
	
<!-- Wrapper  -->	
<div id="wrapper">			
	<!-- Commentaire du billet de blog  -->
	<div id="blog-post-comment">

		<form action="index.php?action=refreshOneComment&amp;commentId=<?= $comment['id'] ?>&amp;postId=<?= $post['id'] ?>" method="post">
			<div>
				<label for="commentText">Commentaire</label><br />
				<textarea id="commentText" name="commentText"><?= htmlspecialchars($comment['comment_content']) ?></textarea>
			</div>
			<div>
				<input type="submit" />
			</div>
		</form>		
		
	</div>
</div>			
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
