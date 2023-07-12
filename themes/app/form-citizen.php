<?php $this->layout("_theme"); ?>
<div class="app_invoice app_widget">
    <form class="app_launch_form_filter app_form" action="<?= url('/cidadao/search') ?>" method="post">
    <?= $csrf = csrf_input(); ?>
        <input type="searchNIS" name="searchNIS" alt="pesquise por NIS" value=""
            placeholder="Ex: 1234567890" autocomplete="off"/>

        <button class="filter radius transition icon-search icon-notext">Search</button>

    </form>
</div>
<div class="app_invoice app_widget">
    <form class="app_form" action="<?= url('/cidadao'); ?>" method="post">
        <?= $csrf; ?>
        <div class="ajax_response"></div>
        <div class="label_group">
            <label>
                <span class="field icon-user">Nome do Cidadão:</span>
                <input class="radius" type="text" name="citizenName" placeholder="Ex: Maximus Costa"/>
            </label>
        </div>

        <div class="al-center">
            <div>
                <button class="btn btn_inline radius transition icon-pencil-square-o">Cadastrar Cidadão</button>
            </div>
        </div>
    </form>
</div>