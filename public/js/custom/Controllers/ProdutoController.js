import { ApiController } from './ApiController.js';

export class ProdutoController extends ApiController {
    constructor() {
        super();
    }

    getProductById(id) {
        let response = super.getResponse('produto/' + id, 'GET');
        return response;
    }

    getProductList(page) {
        let response = super.getResponse('produto/byPage/'+page, 'GET');
        return response;
    }

    saveProduct(data) {
        let response = super.getResponse('produto/', 'POST', data);
        return response;
    }

    updateProduct(data) {
        let response = super.getResponse('produto/' + data.id, 'PUT', data);
        return response;
    }

    deleteProduct(id) {
        let response = super.getResponse('produto/' + id, 'DELETE');
        return response;
    }

    searchByField(field, string) {
        let response = super.getResponse('produto/search?field=' + field + '&string=' + string, 'GET');
        return response;
    }

    searchExact(field, string) {
        let response = super.getResponse('produto/search_exact?field=' + field + '&string=' + string, 'GET');
        return response;
    }
}