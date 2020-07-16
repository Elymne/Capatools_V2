a<?php

    use app\widgets\TopTitle;

    $this->title = 'Erreur : ' . $errorName;
    $this->params['breadcrumbs'][] = $this->title;

    ?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="project-error">
        <div class="row">

            <div class="card">
                <div class="card-action">
                    <span>
                        <?php echo $errorDescription ?>
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>