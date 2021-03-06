<?php
/*
 * Author : Christopher Pardo
 * Date : 22.01.2020
 * Project : Rent a snow
 */
ob_start();
$title = "RentASnow - Accueil";
?>

<!-- ________ SLIDER_____________-->
<div class="row-fluid">
    <div class="camera_full_width">
        <div id="camera_wrap">
            <div data-src="view/images/slider/5.jpg">
                <div class="camera_caption fadeFromBottom cap1">Les derniers modèles toujours à disposition.</div>
            </div>
            <div data-src="view/images/slider/1.jpg">
                <div class="camera_caption fadeFromBottom cap2">Découvrez des paysages fabuleux avec des sensations.
                </div>
            </div>
            <div data-src="view/images/slider/2.jpg"></div>
        </div>
        <br style="clear:both"/>
    </div>
</div>

<!-- ________ NEWS _____________-->
<div class="span12">
    <h1>Les news</h1>
    <?php foreach ($news as $onepieceofnews) { ?>
        <div class="row mt-4">
            <div class="col-2"><?= date('d.M.Y', strtotime($onepieceofnews['date'])) ?> <?= "{$onepieceofnews["firstname"]} {$onepieceofnews["lastname"]}" ?></div>
            <h4 class="col-4"><?= $onepieceofnews['title'] ?></h4>
        </div>
        <div class="row ml-5"><?= $onepieceofnews['text'] ?></div>
        <?php if ($onepieceofnews["user_id"] == $_SESSION["id"]) { ?>
            <form action="index.php?action=delNew&new=<?= $onepieceofnews["id"] ?>" method="post">
                <button type="submit">Supprimer</button>
            </form>
        <?php }
    } ?>
</div>
<?php if (isset($_SESSION["firstname"])) { ?>
    <br><br>
    <form action="index.php?action=addNew" method="post">
        <input type="text" placeholder="Titre" name="title" required><br>
        <textarea cols="100%" placeholder="Votre commentaire" name="text" required></textarea><br>
        <button type="submit">Envoyer votre commentaire</button>
    </form>
<?php } ?>


<script src="assets/carousel/jquery.carouFredSel-6.2.0-packed.js" type="text/javascript"></script>
<script src="assets/camera/scripts/camera.min.js" type="text/javascript"></script>
<script src="assets/easing/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="js/homeview.js" type="text/javascript"></script>

<?php
$content = ob_get_clean();
require "gabarit.php";
?>
