<?php

if (isset($comments)) {
    $currentAction = 'getOnePostAndHisComments&id='.$post->getId();
    $formTarget = 'createOneComment&postId='.$post->getId();
    $author = '';
    $content = '';
    $submit = 'Ajouter';
}
else {
    $currentAction = 'editOneComment&commentId='.$comment->getId().'&postId='.$post->getId();
    $formTarget = 'refreshOneComment&postId='.$post->getId().'&commentId='.$comment->getId();
    $author = htmlspecialchars($comment->getCommentAuthor());
    $content = htmlspecialchars($comment->getCommentContent());
    $submit = 'Modifier';
}
?>

<form method="post" action="index.php?action=<?= $formTarget; ?>">
    <label for="author">Auteur</label>
    <br>
    <input type="text" id="author" name="author" value="<?= $author; ?>">
    <br>
    <label for="content">Contenu</label>
    <br>
    <textarea id="content" name="content"><?= $content; ?></textarea>
    <br>
    <input type="submit" value="<?= $submit; ?>" id="submit" name="submit">
</form>