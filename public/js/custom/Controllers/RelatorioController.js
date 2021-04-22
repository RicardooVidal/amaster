import { ApiController } from './ApiController.js';

export class RelatorioController extends ApiController {
    constructor() {
        super();
    }

    openLink(url) {
        window.open(url);
        return;
    }

    maisVendido(data) {
        let response = super.getResponse('relatorio/mais_vendido?data_inicial=' + data.data_inicial + '&data_final=' + data.data_final, 'GET');
        return response;
    }

    async byTipoPagamento(data) {
        showLoading();
        this.openLink(this._url + 'relatorio/tipo_pagamento/emitir?tipo_pagamento_id=' + data.tipo_pagamento_id +'&data_inicial=' + data.data_inicial + '&data_final=' + data.data_final,'_blank');
        stopLoading();
        return response;
    }

    async byCategoria(data) {
        showLoading();
        this.openLink(this._url + 'relatorio/categoria/emitir?categoria_id=' + data.categoria_id +'&data_inicial=' + data.data_inicial + '&data_final=' + data.data_final,'_blank');
        stopLoading();
        return response;
    }

    async byPeriodo(data) {
        showLoading();
        this.openLink(this._url + 'relatorio/periodo/emitir?data_inicial=' + data.data_inicial + '&data_final=' + data.data_final + '&margem_lucro=' + data.margem_lucro + '&valor_lucro=' + data.valor_lucro,'_blank');
        stopLoading();
        return response;
    }
}