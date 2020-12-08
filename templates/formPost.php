<?php
$formTarget = isset($post) && $post->getId() ? 'refreshOnePost&id='.$post->getId() : 'createOnePost';
$author = isset($post) && $post->getPostAuthor() ? htmlspecialchars($post->getPostAuthor()) : '';
$title = isset($post) && $post->getPostTitle() ? htmlspecialchars($post->getPostTitle()) : '';
$content = isset($post) && $post->getPostContent() ? htmlspecialchars($post->getPostContent()) : '';
$submit = $formTarget === 'createOnePost' ? 'Créer' : 'Modifier';
?>

<form method="post" action="index.php?action=<?= $formTarget; ?>">
    <label for="author">Auteur</label>
    <br>
    <input type="text" id="author" name="author" value="<?= $author; ?>">
    <br>
    <label for="title">Titre</label>
    <br>
    <input type="text" id="title" name="title" value="<?= $title; ?>">
    <br>
    <label for="content">Contenu</label>
    <br>
    <textarea id="content" name="content"><?= $content; ?></textarea>
    <br>
    <input type="submit" value="<?= $submit; ?>" id="submit" name="submit">
</form>