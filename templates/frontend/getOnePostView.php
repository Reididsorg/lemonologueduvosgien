<?php 
	$title = 'LE MONOLOGUE DU VOSGIEN'; 
	$onePost = $post->fetch();
?>

<?php ob_start(); ?>

<h1>BILLET DE BLOG</h1>
<p><a href="/index.php">Retour à la liste des billets</a></p>	
	
<!-- Wrapper  -->	
<div id="wrapper">			
	<!-- Billets de blog  -->
	<div id="blog-post">
	
		<div class="news">
			<h3>
				<?= htmlspecialchars($onePost->post_title) ?>
				<em>le <?= $onePost->creation_date_fr ?></em>
			</h3>
			
			<p>
				<?= nl2br(htmlspecialchars($onePost->post_content)) ?>
			</p>
		</div>

		<h2>Commentaires</h2>

		<form action="index.php?action=addOneComment&amp;id=<?= $onePost->id ?>" method="post">
			<div>
				<label for="author">Auteur</label><br />
				<input type="text" id="author" name="author" />
			</div>
			<div>
				<label for="comment">Commentaire</label><br />
				<textarea id="comment" name="comment"></textarea>
			</div>
			<div>
				<input type="submit" />
			</div>
		</form>	

		<?php
		while ($comment = $comments->fetch())
		{
			?>
				<p><strong><?= htmlspecialchars($comment->comment_author) ?></strong> le <?= $comment->comment_date_fr ?> <a href="index.php?action=editOneComment&amp;commentId=<?= $comment->id ?>&amp;postId=<?= $onePost->id ?>">(modifier)</a></p>
				<p><?= nl2br(htmlspecialchars($comment->comment_content)) ?></p>
			<?php
		}
		?>	
		
	</div>
</div>			
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>