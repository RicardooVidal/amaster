// const { ajax } = require("../jquery.mask.min");

export class RequestManager {
    constructor() {
        this.ajax = new XMLHttpRequest();
    }
    
    request(url, method = 'GET', params = '', async = false) {
        var response;
        params = this.encodeUrl(params);
        if (async) {
            this.ajax.open(method, url, true);
        } else {
            this.ajax.open(method, url, false);
        }
        // this.ajax.setRequestHeader("Connection", "close");
        this.ajax.setRequestHeader("Access-Control-Allow-Origin", '*');
        // this.ajax.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        if (method != 'GET') {
            this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            this.ajax.send(params);
        } else {
            this.ajax.setRequestHeader("Content-type", "application/json");
            this.ajax.send();
        }

        if (async) {
            showLoading();
            this.ajax.onreadystatechange = function() {
                stopLoading();
                response = this.ajax.responseText;

                // console.log('Request to '+ url + ' done!');
                return response;
            }
        } else {
            response = this.ajax.responseText;
            // console.log('Request to '+ url + ' done!');
            return response;
        }

    }

    encodeUrl(data) {
        let encodeDataToURL = (data) => {
            return Object
              .keys(data)
              .map(value => `${value}=${encodeURIComponent(data[value])}`)
              .join('&');
        }

        let url = encodeDataToURL(data);

        return url;
    }
}