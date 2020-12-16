<?php

$formTarget = isset($post) && $post->getId() ? 'refreshOnePost&postId='.$post->getId() : 'createOnePost';
$submit = $formTarget === 'createOnePost' ? 'Créer' : 'Modifier';
?>

<form method="post" action="index.php?action=<?= $formTarget; ?>">
    <label for="title">Titre</label>
    <br>
    <input type="text" id="title" name="title" value="<?= isset($post) ? htmlspecialchars($post->getPostTitle()): ''; ?>">
    <br>
    <?= isset($errors['title']) ? $errors['title'] : ''; ?>
    <br>
    <label for="content">Contenu</label>
    <br>
    <textarea id="content" name="content"><?= isset($post) ? htmlspecialchars($post->getPostContent()): ''; ?></textarea>
    <br>
    <?= isset($errors['content']) ? $errors['content'] : ''; ?>
    <br>
    <input type="submit" value="<?= $submit; ?>" id="submit" name="submit">
</form>
