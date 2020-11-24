<?php $title = 'LE MONOLOGUE DU VOSGIEN'; ?>

<?php ob_start(); ?>

<h1>ACCUEIL</h1>	
	
<!-- Wrapper  -->	
<div id="wrapper">			
	<!-- Billets de blog  -->
	<div id="blog-posts">
		<h2>Derniers billets du blog</h2>
		<?php
		while ($data = $posts->fetch())
		{
			if (!empty($data)) {					
			?>
			<div class="news">
				<h3><?= $data->post_title ?><em> le <?= $data->creation_date_fr ?></em></h3>
				<p><?= $data->post_content ?>
					<br />
					<em><a href="index.php?action=getOnePost&amp;id=<?= $data->id ?>">Commentaires</a></em>
				</p>
			</div>
			<?php
			}
		} // Fin de la boucle des billets
		$posts->closeCursor();
		?>				
	</div>
</div>			
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>			
