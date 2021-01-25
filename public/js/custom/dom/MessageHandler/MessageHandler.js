export class MessageHandler {
    createModalMessage(type, text) {
        let div = document.querySelector('#modal-message-handler');
        let divMessage = document.createElement('div');
        let textContent = document.createTextNode(text);
        let id = getRandomNumber();
        divMessage.setAttribute('class','alert alert-' + type + ' mt-3 fade-in');
        divMessage.setAttribute('id', id);
        divMessage.setAttribute('role','alert');
        divMessage.appendChild(textContent);
        div.appendChild(divMessage);

        setTimeout(this.closeMessage, 10000, id);
    }

    createMessage(type, text) {
        let div = document.querySelector('#message-handler');
        let divMessage = document.createElement('div');
        let textContent = document.createTextNode(text);
        let id = getRandomNumber();
        divMessage.setAttribute('class','alert alert-' + type + ' mt-3');
        divMessage.setAttribute('id', id);
        divMessage.setAttribute('role','alert');
        divMessage.appendChild(textContent);
        div.appendChild(divMessage);

        if (type == 'danger' || type == 'warning') {
            // window.scrollTo(0, 0);
            $("html, body").animate({ scrollTop: 1.5 }, "slow");
        }

        setTimeout(this.closeMessage, 5000, id);
    }

    closeMessage(id) {
        document.getElementById(id).outerHTML = '';
    }

    checkAndCreateMessageByStatus(status, text = null) {
        if ( status > 400) {
            this.createMessage('danger', 'Não foi possível processar a requisição');
            return;
        } 

        this.createMessage('success', text);
        return;
    }
}