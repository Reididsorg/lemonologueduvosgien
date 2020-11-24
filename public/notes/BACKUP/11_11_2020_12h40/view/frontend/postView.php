<?php $title = 'LE MONOLOGUE DU VOSGIEN'; ?>


<?php ob_start(); ?>

<h1>BILLET DE BLOG</h1>
<p><a href="/index.php">Retour à la liste des billets</a></p>	
	
<!-- Wrapper  -->	
<div id="wrapper">			
	<!-- Billets de blog  -->
	<div id="blog-post">
	
			<div class="news">
				<h3>
					<?= htmlspecialchars($post['post_title']) ?>
					<em>le <?= $post['creation_date_fr'] ?></em>
				</h3>
				
				<p>
					<?= nl2br(htmlspecialchars($post['post_content'])) ?>
				</p>
			</div>

			<h2>Commentaires</h2>

			<?php
			while ($comment = $comments->fetch())
			{
				?>
					<p><strong><?= htmlspecialchars($comment['comment_author']) ?></strong> le <?= $comment['comment_date_fr'] ?></p>
					<p><?= nl2br(htmlspecialchars($comment['comment_content'])) ?></p>
				<?php
			}
			?>	
		
	</div>
</div>			
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>