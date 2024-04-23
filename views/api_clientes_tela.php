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
                        <h4 class="no-margin"><?php echo 'Chave de Segurança'; ?></h4>

                        <!-- Painel de seleção de datas -->
                        <div class="panel_s">
                            <div class="panel-body">
                                <form method="GET" action="<?php echo admin_url('controle_bancario_ac/baixa_conta_despesa_ac'); ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_from"><?php echo _l('Chave de seurança:'); ?></label>
                                                <input type="text" class="form-control" id="key_from" name="key_from" value="<?php echo isset($_GET['key_from']) ? $_GET['key_from'] : ''; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary"><?php echo _l('Salvar'); ?></button>
                                            </div>
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




<div class="modal" id="myModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Pagar Conta</h4>
        </div>
        <div class="modal-body">
            Deseja realmente realizar esta ação para a transação ID: <span id="transactionId"></span>?<br><br>

            <!-- Formulário adicionado abaixo -->
            <form id="transactionForm">
                <div class="form-group form-modal">
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data" required>
                </div>
                <div class="form-group form-modal">
                    <label for="valor">Valor:</label>
                    <input type="number" id="valor" name="valor" step="0.01" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="closeModal">Fechar</button>
            <button id="confirmAction">Pagar</button>
        </div>
    </div>
</div>

<div class="modal" id="modal_estornar">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Estornar</h4>
        </div>
        <div class="modal-body">
            Deseja realmente realizar esta ação para a transação ID: <span id="transactionId-estornar"></span>?<br><br>

            <!-- Formulário adicionado abaixo -->
            <form id="transactionForm">
                <div class="form-group form-modal">
                    <label for="data">Data:</label>
                    <input type="date" id="data-estornar" name="data" required readonly>
                </div>
                <div class="form-group form-modal">
                    <label for="valor">Valor:</label>
                    <input type="number" id="valor-estornar" name="valor" step="0.01" readonly>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="closeModal_estornar">Fechar</button>
            <button id="confirmAction_estornar">Estornar</button>
        </div>
    </div>
</div>

<!-- Modal Pagar -->
<script>
    $(document).ready(function() {
        $('.btnPagar').on('click', function() {
            var transactionId = $(this).data('transaction-id');
            var transactionDate = $(this).data('transaction-date');
            var transactionAmount = $(this).data('transaction-amount');
            var actionType = $(this).data('action-type');

            // Atualiza o modal com o ID da transação e outros dados
            $('#transactionId').text(transactionId);
            $('#data').val(transactionDate);
            $('#valor').val(transactionAmount);

            $('#myModal').modal('show');
        });

        $('#confirmAction').on('click', function() {
            var transactionId = $('#transactionId').text();
            var dataPagamento = $('#data').val();
            var valor = $('#valor').val();
            var actionType = "pagar"; // Pega o tipo de ação

            $.ajax({
                url: "<?php echo admin_url('controle_bancario_ac/processar_pagamento_ac'); ?>",
                method: "POST",
                data: {
                    transaction_id: transactionId,
                    data: dataPagamento,
                    valor: valor,
                    action_type: actionType
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#myModal').modal('hide');


                        for (var i = 0; i < document.forms.length; i++) {
                            document.forms[i].reset();
                        }
                        location.reload(); // opcional, se você quiser atualizar a página após o processo


                    } else {
                        alert('Erro ao processar a ação.');
                    }
                },
                error: function() {
                    alert('Erro ao processar a ação.');
                }
            });
        });

        // Manipular clique do botão fechar no modal
        $('#closeModal').on('click', function() {
            $('#myModal').modal('hide');
        });
    });
</script>


<!-- Modal Estornar -->



<script>
    $(document).ready(function() {
        $('.btnEstornar').on('click', function() {
            var transactionId = $(this).data('transaction-id-estornar');
            var transactionDate = $(this).data('transaction-date-estornar');
            var transactionAmount = $(this).data('transaction-amount-estornar');
            var actionType = $(this).data('action-type');

            // Atualiza o modal com o ID da transação e outros dados
            $('#transactionId-estornar').text(transactionId);
            $('#data-estornar').val(transactionDate);
            $('#valor-estornar').val(transactionAmount);

            $('#modal_estornar').modal('show');
        });

        $('#confirmAction_estornar').on('click', function() {
            var transactionId = $('#transactionId-estornar').text();
            var dataPagamento = $('#data-estornar').val();
            var valor = $('#valor-estornar').val();
            var actionType = "estornar"; // Pega o tipo de ação

            $.ajax({
                url: "<?php echo admin_url('controle_bancario_ac/processar_pagamento_ac'); ?>",
                method: "POST",
                data: {
                    transaction_id: transactionId,
                    data: dataPagamento,
                    valor: valor,
                    action_type: actionType
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#modal_estornar').modal('hide');

                        for (var i = 0; i < document.forms.length; i++) {
                            document.forms[i].reset();
                        }
                        location.reload(); // opcional, se você quiser atualizar a página após o processo

                    } else {
                        alert('Erro ao processar a ação.');
                    }
                },
                error: function() {
                    alert('Erro ao processar a ação.');
                }
            });
        });

        // Manipular clique do botão fechar no modal
        $('#closeModal_estornar').on('click', function() {
            $('#modal_estornar').modal('hide');
        });
    });
</script>