<?php

$formTarget = isset($postForm) && $postForm->get('id') ? 'refreshOnePost&postId='.$postForm->get('id') : 'createOnePost';
$submit = $formTarget === 'createOnePost' ? 'Créer' : 'Modifier';
?>

<form method="post" action="index.php?action=<?= $formTarget; ?>">
    <label for="author">Auteur</label>
    <br>
    <input type="text" id="author" name="author" value="<?= isset($postForm) ? htmlspecialchars($postForm->get('author')): ''; ?>">
    <br>
    <?= isset($errors['author']) ? $errors['author'] : ''; ?>
    <br>
    <label for="title">Titre</label>
    <br>
    <input type="text" id="title" name="title" value="<?= isset($postForm) ? htmlspecialchars($postForm->get('title')): ''; ?>">
    <br>
    <?= isset($errors['title']) ? $errors['title'] : ''; ?>
    <br>
    <label for="content">Contenu</label>
    <br>
    <textarea id="content" name="content"><?= isset($postForm) ? htmlspecialchars($postForm->get('content')): ''; ?></textarea>
    <br>
    <?= isset($errors['content']) ? $errors['content'] : ''; ?>
    <br>
    <input type="submit" value="<?= $submit; ?>" id="submit" name="submit">
</form>
