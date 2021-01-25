import { ModalHandler } from './ModalHandler/ModalHandler.js';
import { MessageHandler } from './MessageHandler/MessageHandler.js';

const modal = new ModalHandler();
const message = new MessageHandler();

let checkForRequiredFieldsCadastro = function() {
    let aFields = [
        {
          field: "Razão Social",
          element: document.querySelector('input[name=razao_social]')
        },
        {
          field: "Nome",
          element: document.querySelector('input[name=nome]')
        },
        {
          field: 'Senha',
          element: document.querySelector('input[name=password]')
        }
      ];
    
      let returnFields = requiredFields(aFields);
    
      if (returnFields.length > 0) {
        returnFields.forEach(function(field, index) {
          message.createMessage('danger', 'O campo ' + field + ' deve ser preenchido!');
        });
        return false;
      }
    
    return true;
}

document.querySelector('#finalizar').onclick = function(e) {
    e.preventDefault();
    
}

document.querySelector('#confirmar-cadastro').onclick = function() {
    let form = document.querySelector('#form-cadastro');
    if (checkForRequiredFieldsCadastro()) {
        $('input[name=cnpj]').unmask();
        modal.closeConfirmModal();
        showLoading();
        form.submit();
        return;
    }

    modal.closeConfirmModal();
}