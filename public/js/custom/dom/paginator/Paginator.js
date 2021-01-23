
export class Paginator {
    constructor(data) {
        this.data = data;
    }

    mountPaginatorByData(data, paginator) {
        return new Promise(function(resolve, reject) {
            paginator.clearPaginator();
            let divPaginator = document.querySelector('.pagination-container');
            let div = document.createElement('div');
            let a_previous = document.createElement('a');
            let a_next = document.createElement('a');
            let previous = document.createTextNode(htmlDecode('&laquo;'));
            let next = document.createTextNode(htmlDecode('&raquo;'));
            let numberPage;
            let link;
    
            div.setAttribute('class', 'pagination');
    
            link = paginator.getNumberPageByLink(data.prev_page_url);
    
            a_previous.setAttribute('href', link);
            a_previous.appendChild(previous);
    
            link = paginator.getNumberPageByLink(data.next_page_url);
            a_next.setAttribute('href', link);
            a_next.appendChild(next);
    
            div.appendChild(a_previous);
            
            if (data.links != undefined) {
                for (var i = 1; i < data.links.length-1; i++) {
                    var a = i;
                    a = document.createElement('a');
                    numberPage = document.createTextNode(i);
                    link = paginator.getNumberPageByLink(data.links[i].url);
                    a.setAttribute('href', link);
                    if (data.current_page == data.links[i].label) {
                        a.setAttribute('class', 'active');
                    }
                    a.appendChild(numberPage);
                    div.appendChild(a);
                }

                div.appendChild(a_next);
    
                divPaginator.appendChild(div);   
            } else {
                reject('Houve um problema ao processar os dados');
            }
        });
    }

    clearPaginator() {
        document.querySelector('.pagination-container').innerHTML = '';
    }

    getNumberPageByLink(link) {
        if (link == null) {
            return '#';
        }
        return link.split(/.*\=(.*)/)[1];
    }
}