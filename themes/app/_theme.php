<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= !empty($head) ?$head : null; ?>

    <link rel="stylesheet" href="<?= theme("/assets/style.css", CONF_VIEW_APP); ?>"/>
    <link rel="" type="image/png" href="<?= theme("/assets/images/favicon.png", CONF_VIEW_APP); ?>"/>
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
    </div>
</div>

<div class="app">
    <header class="app_header">
        <h1><a class="icon-cog transition" href="<?= url("/app"); ?>" title="IH">challenge</a></h1>
        <ul class="app_header_widget">
            <li  class="radius transition ">Bem vindo</li>
        </ul>
    </header>

    <div class="app_box">
        <nav class="app_sidebar radius box-shadow">
            <div data-mobilemenu="close"
                 class="app_sidebar_widget_mobile radius transition icon-error "></div>
            <?= $this->insert("views/sidebar"); ?>
        </nav>

        <main class="app_main">
            <?= $this->section("content"); ?>
        </main>
    </div>

    <footer class="app_footer">
        <span class="">
            Luiz Paulo Escobal<br>
            &copy; Luiz - Todos os direitos reservados
        </span>
    </footer>
    <?= $this->insert("views/modals"); ?>
</div>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-53658515-18"></script>
<script src="<?= theme("/assets/js/scripts.js", CONF_VIEW_APP); ?>"></script>
<script src="<?= theme("/assets/js/ajax.js", CONF_VIEW_APP); ?>"></script>

<?= $this->section("scripts"); ?>

</body>
</html>