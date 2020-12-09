<?php

// (action : createOneComment*)
if (isset($comments)) {
    if (isset($post)) {
        // Création d'un nouveau commentaire (pas de form)
        if(!isset($formData)) {
            $formTarget = 'createOneComment&postId='.$post->getId();
            $author = '';
            $content = '';
            $submit = 'Ajouter';
        }
        // Validation form
        else {
            // validation erreur
            if(isset($errors)) {
                $formTarget = 'createOneComment&postId='.$post->getId();
                $author = $formData->get('author');
                $content = $formData->get('content');
                $submit = 'Ajouter';
            }
            // validation OK
            else {
                $formTarget = 'createOneComment&postId='.$post->getId();
                $author = '';
                $content = '';
                $submit = 'Ajouter';
            }
        }
    }
}
// (action : editOneComment&commentId*)
else {
    // Edition d'un commentaire après validation
    if (isset($formData)) {
        $formTarget = 'refreshOneComment&postId='.$post->getId().'&commentId='.$comment->getId();
        $author = htmlspecialchars($formData->get('author'));
        $content = htmlspecialchars($formData->get('content'));
        $submit = 'Modifier';
    }
    // Edition d'un commentaire déjà enregistré
    else {
        $formTarget = 'refreshOneComment&postId='.$post->getId().'&commentId='.$comment->getId();
        $author = htmlspecialchars($comment->getCommentAuthor());
        $content = htmlspecialchars($comment->getCommentContent());
        $submit = 'Modifier';
    }
}
?>

<form method="post" action="index.php?action=<?= $formTarget; ?>">
    <label for="author">Auteur</label>
    <br>
    <input type="text" id="author" name="author" value="<?= $author; ?>">
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
