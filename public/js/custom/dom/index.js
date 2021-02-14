import { ModalHandler } from './ModalHandler/ModalHandler.js';
import { MessageHandler } from './MessageHandler/MessageHandler.js';
import { VendaController } from './../Controllers/VendaController.js';
import { RelatorioController } from './../Controllers/RelatorioController.js';

const message = new MessageHandler();
const venda = new VendaController();
const modal = new ModalHandler();
const relatorio = new RelatorioController();

let setMaisVendido = function(response) {
    let div = document.querySelector('#dashboard-destaque');
    let h3_produto = document.createElement('h3');
    let h3_quantidade = document.createElement('h3');
    
    if (response.produtos.length != 0 ) {       
        div.innerHTML = '';
        
        let h3_text_quantidade = document.createTextNode('Quantidade: ' + response.produtos[0].quantidade_total);
        let h3_text_produto = document.createTextNode(response.produtos[0].produto + ' ' + response.produtos[0].un);
    
        h3_quantidade.appendChild(h3_text_quantidade);
        h3_produto.appendChild(h3_text_produto);

        div.appendChild(h3_quantidade);
        div.appendChild(h3_produto);
    }

}

let getMaisVendido = function() {
    let ultimoDiaDoMes = getLastDayOfMonth();
    let mes = getCurrentMonth();
    let ano = getCurrentYear();

    let data_inicial = ano + '-' + mes + '-' + '01'
    let data_final = ano + '-' + mes + '-' + ultimoDiaDoMes

    let data = {
        data_inicial,
        data_final
    };

    let response = relatorio.maisVendido(data);
    setMaisVendido(response);
}

venda.checkVendasPendentes();

getMaisVendido();