<div class="container">
    <div class="row">
        <div class="col-4">
            <img class="img-fluid" src="<?php echo $pdfLogo;?>">
        </div>
        <div class="col-8">
            <div class="dropdown ms-1 topbar-head-dropdown header-item justify-content-end">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img id="header-lang-img" src="/intramedianet/includes/assets/images/flags/<?php echo $lang_adm; ?>.svg" alt="Header Language" height="20"
                        class="rounded">
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'en'); ?>" class="dropdown-item notify-item language py-2" data-lang="en"
                        title="English">
                        <img src="/intramedianet/includes/assets/images/flags/en.svg" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'es'); ?>" class="dropdown-item notify-item language py-2 language" data-lang="sp"
                        title="Spanish">
                        <img src="/intramedianet/includes/assets/images/flags/es.svg" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">Español</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>