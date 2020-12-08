<?php

if(!isset($comments)) {
    if(isset($comment) && $comment->getId() && isset($post) && $post->getId()) {
        $formTarget = 'refreshOneComment&postId='.$post->getId().'&commentId='.$comment->getId();
        $currentAction = 'editOneComment&commentId='.$comment->getId().'&postId='.$post->getId();
    }
}
else {
    if(isset($post) && $post->getId()) {
        $formTarget = 'createOneComment&id='.$post->getId();
        $currentAction = 'getOnePostAndHisComments&id='.$post->getId();
    }
}

$author = isset($comment) && $comment->getCommentAuthor() && !isset($comments) ? htmlspecialchars($comment->getCommentAuthor()) : '';
$content = isset($comment) && $comment->getCommentContent() && !isset($comments) ? htmlspecialchars($comment->getCommentContent()) : '';
$submit = $currentAction === 'createOneComment' ? 'Ajouter' : 'Modifier';
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