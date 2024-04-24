<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 99999999999999999;
    }

    .modal_estornar {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 99999999999999999;
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #FFF;
        padding: 20px;
        width: 80%;
        max-width: 500px;
        border-radius: 5px;
    }

    input#data {
        width: 100%;
        padding: 5px;
        border-radius: 5px;
    }

    input#valor {
        width: 100%;
        padding: 5px;
        border-radius: 5px;
    }

    input#data-estornar {
        width: 100%;
        padding: 5px;
        border-radius: 5px;
        background-color: #acacac;
        border: 0px;
    }

    input#valor-estornar {
        width: 100%;
        padding: 5px;
        border-radius: 5px;
        background-color: #acacac;
        border: 0px;
    }

    .dataTables_paginate {
        display: none !important;
    }
    #DataTables_Table_0_length{
        display: none!important;
        
    }

    button.btn.btn-default.buttons-collection.btn-default-dt-options {
        display: none!important;
    }

    div#DataTables_Table_0_filter {
    display: none!important;
    }


</style>



<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class=""><?php echo 'Chave de Segurança'; ?></h4>

                        <!-- Painel de seleção de datas -->
                        <div class="panel_s">
                            <div class="panel-body">
                                <form method="GET" action="<?php echo admin_url('api_customers_ac/api_admin_customers_ac/set_option_key_ac'); ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_from"><?php echo _l('Informe a Chave de seurança:'); ?></label>
                                                <input type="text" class="form-control" id="key_value" name="key_value" value="<?php echo $key_value; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary"><?php echo _l('Salvar'); ?></button>
                                            </div>
                                            <?php
                                                if (isset($_GET['response']) && $_GET['response'] == 'Atualizado') {
                                                    echo '<div class="form-group">
                                                            <div class="alert alert-success">Atualizado com sucesso!</div>
                                                        </div>';
                                                }
                                                if (isset($_GET['response']) && $_GET['response'] == 'Erro'){
                                                    echo '<div class="form-group">
                                                            <div class="alert alert-danger">Ocorreu algum erro, tente mais tarde!</div>
                                                        </div>';

                                                }
                                                ?>
                                        </div>
                                    </div>

                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>