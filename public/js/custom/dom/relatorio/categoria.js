import { ModalHandler } from '../ModalHandler/ModalHandler.js';
import { MessageHandler } from '../MessageHandler/MessageHandler.js';
import { RelatorioController } from '../../Controllers/RelatorioController.js';

const message = new MessageHandler();
const modal = new ModalHandler();
const relatorio = new RelatorioController();

let emitirByCategoria = function() {
    let categoria_id = document.querySelector('#categoria').value;
    let data_inicial = document.querySelector('#data-inicial').value;
    let data_final = document.querySelector('#data-final').value;

    let data = {
        categoria_id,
        data_inicial,
        data_final
    };

    let response = relatorio.byCategoria(data);
    modal.closeConfirmModal();
}

let checkFieldsAndValidation = function() {
    let categoria = document.querySelector('#categoria').value;
    let data_inicial = document.querySelector('#data-inicial').value;
    let data_final = document.querySelector('#data-final').value;

    if (categoria = 0) {
        modal.closeConfirmModal();
        message.createMessage('warning', 'Favor informe a categoria!');
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

document.querySelector('#emitir-relatorio-categoria').onclick = function(e) {
    e.preventDefault();
    if (checkFieldsAndValidation()) {
        emitirByCategoria();
    }
}