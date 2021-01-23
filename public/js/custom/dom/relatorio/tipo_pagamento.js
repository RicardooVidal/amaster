import { ModalHandler } from '../ModalHandler/ModalHandler.js';
import { MessageHandler } from '../MessageHandler/MessageHandler.js';
import { RelatorioController } from '../../Controllers/RelatorioController.js';

const message = new MessageHandler();
const modal = new ModalHandler();
const relatorio = new RelatorioController();

let emitirByTipoPagamento = function() {
    let tipo_pagamento_id = document.querySelector('#tipo-pagamento').value;
    let data_inicial = document.querySelector('#data-inicial').value;
    let data_final = document.querySelector('#data-final').value;

    let data = {
        tipo_pagamento_id,
        data_inicial,
        data_final
    };

    let response = relatorio.byTipoPagamento(data);
    modal.closeConfirmModal();
}

let checkFieldsAndValidation = function() {
    let tipo_pagamento = document.querySelector('#tipo-pagamento').value;
    let data_inicial = document.querySelector('#data-inicial').value;
    let data_final = document.querySelector('#data-final').value;

    if (tipo_pagamento = 0) {
        modal.closeConfirmModal();
        message.createMessage('warning', 'Favor informe a tipo de pagamento!');
        return false;
    }

    if (data_inicial == '' || data_final == '') {
        modal.closeConfirmModal();
        message.createMessage('warning', 'Favor informe o período!');
        return false;
    }

    if (data_inicial > data_final) {
        modal.closeConfirmModal();
        message.createMessage('danger', 'Período inválido!');
        return false;
    }

    return true;
}

document.querySelector('#emitir-relatorio-tipo_pagamento').onclick = function(e) {
    e.preventDefault();
    if (checkFieldsAndValidation()) {
        emitirByTipoPagamento();
    }
}