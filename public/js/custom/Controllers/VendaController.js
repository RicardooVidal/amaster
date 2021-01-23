import { ApiController } from './ApiController.js';

export class VendaController extends ApiController {
    constructor() {
        super();
    }

    async checkVendasPendentes() {
        let response = await this.searchExact('tipo_pagamento', 'PENDENTE');
        let button = document.querySelector('#btn-vendas-pendentes');
        let textPendentes;
        
        try {
            if (response.hits.total.value == 0 ) {
                textPendentes = 'Nenhuma venda pendente';
            } else {
                if (response.hits.total.value == 1) {
                    textPendentes = response.hits.total.value + ' venda pendente';
                } else {
                    textPendentes = response.hits.total.value + ' vendas pendentes';
                }
            }
        } catch (erro) {
            textPendentes = 'Nenhuma venda pendente';
        }
        
        button.textContent = textPendentes;

        return response;
    }

    getVendasList(page) {
        let response = super.getResponse('venda/list/byPage/' + page, 'GET');
        return response;
    }

    getVendasPendentesList(page) {
        let response = super.getResponse('venda/pendente/' + page, 'GET');
        return response;
    }

    getVenda(id) {
        let response = super.getResponse('venda/' + id, 'GET');
        return response;
    }

    getTipoPagamento(id) {
        let response = super.getResponse('venda/tipo_pagamento/' + id, 'GET');
        return response;
    }

    deleteVenda(id) {
        let response = super.getResponse('venda/' + id, 'DELETE');
        return response;
    }

    finish(data) {
        let response = super.getResponse('venda/', 'POST', data);
        return response;
    }

    finishPendente(data) {
        let response = super.getResponse('venda/' + data.id, 'PUT', data);
        return response;
    }

    searchExact(field, string) {
        let response = super.getResponse('venda/search_exact?field=' + field + '&string=' + string, 'GET');
        return response;
    }
}