import { ModalHandler } from '../ModalHandler/ModalHandler.js';
import { ProdutoController } from '../../Controllers/ProdutoController.js';
import { MessageHandler } from '../MessageHandler/MessageHandler.js';
import { VendaController } from '../../Controllers/VendaController.js';
import { Money } from '../../money.js';

const produto = new ProdutoController();
const venda = new VendaController();
const message = new MessageHandler();
const modal = new ModalHandler();
const money = new Money();

var produtos = [];

let checkVendasPendentes = function() {
    venda.checkVendasPendentes();
}

let resetVendaPage = function() {
    produtos = [];
    document.querySelector('#lista-produtos-body').innerHTML = '';
    document.querySelector('#tipo-pagamento').value = 1;
    document.querySelector('#conceder-desconto').value = '0,00';
    document.querySelector('#observacao').value = '';
    document.querySelector('#valor-pago').value = '0,00';
    document.querySelector('#venda-valor-total').textContent = '0,00';
    document.querySelector('#venda-troco').textContent = '0,00';
    document.querySelector('#alerta-venda-pendente').textContent = '';

    noProductsMessage();
}

let finishVenda = function() {
    let tipo_pagamento_id = document.querySelector('#tipo-pagamento').value;
    let valor_total = money.getUnmaskedValue(document.querySelector('#venda-valor-total').textContent);
    let desconto = money.getUnmaskedValue(document.querySelector('#conceder-desconto').value);
    let troco = money.getUnmaskedValue(document.querySelector('#venda-troco').textContent);
    let observacao = document.querySelector('#observacao').value

    let data = {
            tipo_pagamento_id,
            valor_total,
            desconto,
            troco,
            observacao,
            produtos: JSON.stringify(produtos)
        };

    if (produtos.length == 0) {
        message.createMessage('danger', 'Não há produtos na venda!');
        return;
    }
    showLoading();
    let response = venda.finish(data);
    stopLoading();
    resetVendaPage();
    message.checkAndCreateMessageByStatus(response.status, response.msg);
    checkVendasPendentes();
    $("html, body").animate({ scrollTop: 1.5 }, "slow");
}

let calculateTroco = function() {
    let valor_pago = document.querySelector('#valor-pago');
    let total = parseInt(money.getUnmaskedValue(document.querySelector('#venda-valor-total').textContent));
    let pago = parseInt(money.getUnmaskedValue(valor_pago.value));
    let troco = 0;
    let tipo_pagamento = document.querySelector('#tipo-pagamento').value;
    
        if (pago < total) {
            valor_pago.value = money.convertToReais(total);
            message.createMessage('warning', 'Valor recebido é menor!');
            return;
        }

        // TODO: Analizar melhor este IF
        if (tipo_pagamento != 1) {
            if (pago > total) {
                valor_pago.value = money.convertToReais(total);
                message.createMessage('warning' , 'Valor recebido é maior e o tipo de pagamento é diferente de DINHEIRO!');
                troco = 0;
            }
        } else {
            troco = pago - total;
        }

        // if (money.convertUnmaskedValue(pago) > money.convertUnmaskedValue(total)) {
        //     console.log('entrei');
        //     valor_pago.value = money.convertToReais(total);
        //     message.createMessage('warning' , 'Valor recebido é maior e o tipo de pagamento é diferente de DINHEIRO!');
        //     troco = 0;
        // } else  if(tipo_pagamento == 1 || tipo_pagamento == 6) {
        //     troco = pago - total;
        // }

    document.querySelector('#venda-troco').textContent = money.convertToReais(troco);
}

let calculateTotal = function() {
    let h1Total = document.querySelector('#venda-valor-total');
    let totalValue;
    let total = 0;
    let preco = 0;
    let valor_pago = document.querySelector('#valor-pago');

    produtos.forEach(function(produto, index) {
        preco = produto.preco;
        total += produto.quantidade * preco
    });
    
    let desconto = money.getUnmaskedValue(document.querySelector('#conceder-desconto').value);

    if (desconto > total) {
        document.querySelector('#conceder-desconto').value = 0;
        message.createMessage('danger', 'Desconto maior que valor total da venda!');
        return;
    }

    total -= desconto;
    total = money.getUnmaskedValue(total);
    
    h1Total.innerHTML = '';
    if (total < 0) {
        total = 0;
    }

    total = money.convertToReais(total);
    totalValue = document.createTextNode(total);
    h1Total.appendChild(totalValue);
    valor_pago.value =  total
}

let noProductsMessage = function() {
    let p = document.querySelector('#nenhum-produto-inserido');
    let textContent = document.createTextNode('Nenhum produto inserido');

    p.appendChild(textContent);
}

let vendaPendenteAlert = function() {
    let p = document.querySelector('#alerta-venda-pendente');
    let textContent = document.createTextNode('VENDA PENDENTE!');

    p.appendChild(textContent);
}

let deleteProductVendaArray = function(id) {
    produtos = removeIndexFromArray(produtos, id);

    if (produtos.length == 0) {
        noProductsMessage();
    }

    calculateTotal();
}

let deleteProductVendaTable = function(id) {
    deleteProductVendaArray(id);
    let tr = document.querySelector('#id-' + id);
    tr.outerHTML = '';
    calculateTotal();
    calculateTroco();
    message.createMessage('success', 'Produto removido com sucesso.');
}

let insertProductVendaArray = function() {
    let id = document.querySelector('#produto-id').value;
    let descricao = document.querySelector('#produto-descricao').value;
    let unidade_medida = document.querySelector('#produto-unidade_medida').value;
    let categoria = document.querySelector('#produto-categoria').value;
    let quantidade_atual = document.querySelector('#produto-quantidade-atual-estoque').value;
    let quantidade_vender = document.querySelector('#produto-quantidade-vender').value;
    let preco = document.querySelector('#produto-preco-venda').value;
    preco = money.getUnmaskedValue(preco);    // console.log(preco);
    
    produtos.push(
        {
            id: id,
            descricao: descricao + ' ' + unidade_medida,
            quantidade: quantidade_vender,
            preco,
            categoria
        }
    )

    calculateTotal();

    document.querySelector('#nenhum-produto-inserido').innerHTML = '';

    document.querySelector('#btn-deletar-produto-' + id).onclick = function() {
        deleteProductVendaTable(id);
    }
}

let insertProductVendaTable = function() {
    var tbody = document.querySelector('#lista-produtos-body');
    let id = document.querySelector('#produto-id').value;
    let descricao = document.querySelector('#produto-descricao').value;
    let unidade_medida = document.querySelector('#produto-unidade_medida').value;
    let quantidade_atual = document.querySelector('#produto-quantidade-atual-estoque').value;
    let quantidade_vender = document.querySelector('#produto-quantidade-vender').value;
    let preco = document.querySelector('#produto-preco-venda').value;
    let total = document.querySelector('#produto-total-venda').value;

    let tr, th, td_descricao, td_preco, td_quantidade, td_total, td_buttons, button_deletar;
    let textContent_th, textContent_descricao, textContent_preco, textContent_quantidade, textContent_total, textContent_button_deletar;
    let index = produtos.findIndex(produto => produto.id == id);

    if (index != -1) {
        message.createModalMessage('warning', 'Produto já inserido nesta venda!');
        return;
    }

    if (id == 0 || id == '') {
        message.createModalMessage('danger', 'Favor inserir um produto');
        return;
    }

    if (quantidade_vender == 0 || quantidade_vender == '') {
        message.createModalMessage('warning', 'Quantidade a vender zerada');
        return;
    }

    if (preco < 1 || preco == '' || preco == '0,00') {
        message.createModalMessage('warning', 'Favor informar um preço válido');
        return;
    }

    tr = document.createElement('tr');
    tr.setAttribute('id', 'id-' + id);
    tr.setAttribute('class', 'fade-in');

    th = document.createElement('th');
    th.setAttribute('id', 'produto');
    th.setAttribute('scope', 'row');
    textContent_th = document.createTextNode(2);
    th.appendChild(textContent_th);

    td_descricao = document.createElement('td');
    textContent_descricao = document.createTextNode(descricao + ' ' + unidade_medida);
    td_descricao.appendChild(textContent_descricao);

    td_quantidade = document.createElement('td');
    td_quantidade.setAttribute('style', 'text-align: center');
    textContent_quantidade = document.createTextNode(quantidade_vender);
    td_quantidade.appendChild(textContent_quantidade);

    td_preco = document.createElement('td');
    td_preco.setAttribute('style', 'text-align: center');
    td_preco.setAttribute('class', 'money');
    textContent_preco = document.createTextNode(preco);
    td_preco.appendChild(textContent_preco);

    td_total = document.createElement('td');
    td_total.setAttribute('style', 'text-align: center');
    td_total.setAttribute('class', 'money');
    textContent_total = document.createTextNode(total);
    td_total.appendChild(textContent_total);

    td_buttons = document.createElement('td');
    button_deletar = document.createElement('button');
    button_deletar.setAttribute('id', 'btn-deletar-produto-' + id);
    button_deletar.setAttribute('name', 'editar-produto');
    button_deletar.setAttribute('class', 'btn btn-danger mr-1');
    button_deletar.setAttribute('data-toggle', 'modal');
    button_deletar.setAttribute('data-target', '#generic-modal-confirm');
    button_deletar.setAttribute('value', id);
    textContent_button_deletar = document.createTextNode('Deletar');
    button_deletar.appendChild(textContent_button_deletar);

    td_buttons.appendChild(button_deletar);

    // tr.appendChild(th); // ID
    tr.appendChild(td_descricao);
    tr.appendChild(td_quantidade);
    tr.appendChild(td_preco);
    tr.appendChild(td_total);
    tr.appendChild(td_buttons);
    
    tbody.appendChild(tr);

    insertProductVendaArray();

    modal.closeModal();
    message.createMessage('success', 'Produto inserido com sucesso.');
}

let searchById = function(id) {
    let data = produto.searchExact('_id', id);
    produtoVendaFillFields(data);
}

let searchByCodigoBarra = function (codigo_barra) {
    let data = produto.searchByField('codigo_barra', codigo_barra);
    produtoVendaFillFields(data);
}

let searchByDescricao = function (descricao) {
    let data = produto.searchExact('descricao', descricao);
    try {
        produtoVendaFillFields(data);
    } catch (erro) {
        data = produto.searchByField('descricao', descricao);
        produtoVendaFillFields(data);
    }
}

let produtoVendaFillFields = function(data) {
    data = data.hits.hits[0];
    let ativo = data._source.ativo;
    if (ativo == 0) {
        message.createModalMessage('warning', 'Produto desativado!');
        return;
    }

    document.querySelector('#produto-id').value = data._id;
    document.querySelector('#produto-codigo-barra').value = data._source.codigo_barra;
    document.querySelector('#produto-descricao').value = data._source.descricao;
    document.querySelector('#produto-unidade_medida').value = data._source.unidade_medida;
    document.querySelector('#produto-categoria').value = data._source.categoria;
    document.querySelector('#produto-quantidade-atual-estoque').value = data._source.quantidade_atual;
    document.querySelector('#produto-preco-venda').value = money.convertToReais(data._source.preco);

    document.querySelector('#produto-quantidade-vender').focus();
}

let clearProdutoVendaFields = function() {
    document.querySelector('#produto-id').value = 0;
    document.querySelector('#produto-codigo-barra').value = '';
    document.querySelector('#produto-descricao').value = '';
    document.querySelector('#produto-unidade_medida').value = '';
    document.querySelector('#produto-categoria').value = '';
    document.querySelector('#produto-quantidade-atual-estoque').value = 0;
    document.querySelector('#produto-preco-venda').value = '0';
    document.querySelector('#produto-quantidade-vender').value = 0;
    document.querySelector('#produto-total-venda').value = '0';
}

let calculateAndSetTotalVenda = function() {
    let quantidade = document.querySelector('#produto-quantidade-vender').value;
    // let preco = $('#produto-preco-venda').cleanVal();
    let preco = document.querySelector('#produto-preco-venda').value;
    preco = money.getUnmaskedValue(preco);
    
    if (preco == 0 || preco == undefined) {
        preco = 0;
    }

    let total = quantidade * preco;
    
    total = money.convertToReaisWithSigla(total);

    document.querySelector('#produto-total-venda').value = total;
}

let productNotFound = function() {
    clearProdutoVendaFields();
    message.createModalMessage('danger', 'Produto não encontrado!');
}

checkVendasPendentes()

setInterval(checkVendasPendentes, 10000);

clearProdutoVendaFields();

resetVendaPage();

document.querySelector('#produto-quantidade-vender').oninput = function() {
    let quantidade_atual = document.querySelector('#produto-quantidade-atual-estoque').value;
    quantidade_atual = parseInt(quantidade_atual);

    if (quantidade_atual < this.value) {
        message.createModalMessage('danger', 'ATENÇÃO: Quantidade a vender é maior que quantidade a atual! Risco de estoque negativo.');
    }

    if (this.value < 0) {
        this.value = 0;
    }
    calculateAndSetTotalVenda();
}

document.querySelector('#produto-preco-venda').oninput = function() {
    calculateAndSetTotalVenda();
}

document.querySelector('#generic-modal').onhide = function() {
    clearProdutoVendaFields();
  }

document.querySelector("#produto-descricao").oninput = function() {
    if (this.value == '' || this.value == undefined) {
      return;
    }
  
    if (hasWhiteSpace(this.value)) {
      return;
    }
  
    try {
      let response = produto.searchByField('descricao', this.value);
      let search = [];
      response.hits.hits.forEach(function(produto, index) {
        search.push(produto._source.descricao);
      });
      autocomplete(this, search);
    
    } catch (erro) {
      return ;
    }
}

document.querySelector('#produto-id').addEventListener("change", function() {
    let id = this.value;

    if (id == '' || id == undefined) {
        clearProdutoVendaFields();
        return;
    }

    try {
        searchById(id);
    } catch(erro) {
        productNotFound();
        return ;
    }
});

document.querySelector('#produto-codigo-barra').addEventListener("change", function() {
    let codigo_barra = this.value;

    if (codigo_barra == '' || codigo_barra == undefined) {
        clearProdutoVendaFields();
        return;
    }

    try {
        searchByCodigoBarra(codigo_barra);
    } catch (erro) {
        productNotFound();
        return;
    }
});

document.querySelector('#produto-descricao').addEventListener("change", function() {
    let descricao = this.value;

    if (descricao == '' || descricao == undefined) {
        clearProdutoVendaFields();
        return;
    }

    try {
        searchByDescricao(descricao);
    } catch (erro) {
        productNotFound();
        return;
    }
});

document.querySelector('#produto-descricao').addEventListener("focus", function() {
    let descricao = this.value;

    if (descricao == '' || descricao == undefined) {
        clearProdutoVendaFields();
        return;
    }

    try {
        searchByDescricao(descricao);
    } catch (erro) {
        productNotFound();
        return;
    }
});

document.querySelector('#produto-descricao').onclick = function() {
    this.value = '';
};

document.querySelector('#btn-inserir-venda').onclick = function() {
    insertProductVendaTable();
}

document.querySelector('#conceder-desconto').addEventListener("change", function() {
    if (this.value == '' || this.value == undefined) {
        this.value = 0;
    }
    calculateTotal();
    calculateTroco();
});

document.querySelector('#valor-pago').addEventListener("change", function() {
    calculateTroco();
    // total.toFixed(2).toString().replace(".",",");
});

document.querySelector('#tipo-pagamento').addEventListener("change", function() {
    if (this.value == 6) {
        vendaPendenteAlert();
    } else {
        document.querySelector('#alerta-venda-pendente').textContent = '';
    }

    calculateTroco();
    // calculateTotal();
});

document.querySelector('#finalizar-venda').onclick = function() {
    finishVenda();
}