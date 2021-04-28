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
        showLoading();
        let response = super.getResponse('produto/', 'POST', data);
        stopLoading();
        return response;
    }

    updateProduct(data) {
        showLoading();
        let response = super.getResponse('produto/' + data.id, 'PUT', data);
        stopLoading();
        return response;
    }

    deleteProduct(id) {
        showLoading();
        let response = super.getResponse('produto/' + id, 'DELETE');
        stopLoading();
        return response;
    }

    searchAll() {
        let response = super.getResponse('produto/all', 'GET');
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