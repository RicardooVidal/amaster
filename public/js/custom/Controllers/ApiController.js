import { RequestManager } from '../RequestManager.js';

export class ApiController extends RequestManager {
    constructor() {
        super();
        this._url = '/'
    }

    _getToken() {
        let response = super.request(this._url + 'get-token', 'GET', '', false);
        return JSON.parse(response);
    }

    getResponse(path, method = 'GET', parameters = '', async = false) {
        let token = this._getToken();

        let response = super.request(this._url+path, method, parameters, async);
        return JSON.parse(response);
    }
}