<?php

// (action : createOneComment*)
if (isset($comments)) {
    // Création d'un nouveau commentaire (pas de form)
    if(!isset($commentForm)) {
        //$formTarget = 'createOneComment&postId='.$comment->getCommentPostId();
        $formTarget = 'createOneComment&postId='.$post->getId();
        $author = '';
        $content = '';
        $submit = 'Ajouter';
    }
    // Validation form
    else {
        // validation erreur
        if(isset($errors)) {
            $formTarget = 'createOneComment&postId='.$comment->getCommentPostId();
            $author = $commentForm->get('author');
            $content = $commentForm->get('content');
            $submit = 'Ajouter';
        }
        // validation OK
        else {
            $formTarget = 'createOneComment&postId='.$comment->getCommentPostId();
            $author = '';
            $content = '';
            $submit = 'Ajouter';
        }
    }
}
// (action : editOneComment&commentId*)
else {
    // Edition d'un commentaire après validation
    if (isset($commentForm)) {
        $formTarget = 'refreshOneComment&commentId='.$comment->getId();
        $author = htmlspecialchars($commentForm->get('author'));
        $content = htmlspecialchars($commentForm->get('content'));
        $submit = 'Modifier';
    }
    // Edition d'un commentaire déjà enregistré
    else {
        $formTarget = 'refreshOneComment&commentId='.$comment->getId();
        $author = htmlspecialchars($comment->getCommentAuthor());
        $content = htmlspecialchars($comment->getCommentContent());
        $submit = 'Modifier';
    }
}
?>

<form method="post" action="index.php?action=<?= $formTarget; ?>">
    <label for="author">Auteur</label>
    <br>
    <input type="text" id="author" name="author" value="<?= $this->session->get('pseudo'); ?>" readonly>
    <br>
    <?= isset($errors['author']) ? $errors['author'] : ''; ?>
    <br>
    <label for="content">Contenu</label>
    <br>
    <textarea id="content" name="content"><?= $content; ?></textarea>
    <br>
    <?= isset($errors['content']) ? $errors['content'] : ''; ?>
    <br>
    <input type="submit" value="<?= $submit; ?>" id="submit" name="submit">
</form>
