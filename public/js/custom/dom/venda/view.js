import { ModalHandler } from '../ModalHandler/ModalHandler.js';
import { ProdutoController } from '../../Controllers/ProdutoController.js';
import { MessageHandler } from '../MessageHandler/MessageHandler.js';
import { VendaController } from '../../Controllers/VendaController.js';
import { Paginator } from '../paginator/Paginator.js';
import { Money } from '../../money.js';


var page = document.querySelector('#pagina').textContent;
const produto = new ProdutoController();
const venda = new VendaController();
const message = new MessageHandler();
const modal = new ModalHandler();
const paginator = new Paginator();
const money = new Money();

page = page.split(/P.*gina\s+(.*)/);

let destroyVendasTable = function() {
  document.querySelector('#lista-vendas').innerHTML = '';
  fillVendasTable();
}

let deleteVenda = function(id) {
  let response = venda.deleteVenda(id);
  modal.closeConfirmModal();
  message.checkAndCreateMessageByStatus(response.status, response.msg);
  destroyVendasTable();
}

let constructCollapseProductsVenda = function(id) {
    let response = venda.getVenda(id);
    let div = document.querySelector('#collapse-id-' + id);
    let table_produto, thead_produto, thead_produto_tr, produto_th_quantidade, produto_th_descricao, produto_th_preco, produto_th_total;
    let text_th_produto_quantidade, text_th_produto_descricao, text_th_produto_preco, text_th_produto_total;
    let tbody_produto, tbody_produto_tr, tbody_th_quantidade, tbody_th_descricao, tbody_th_preco, tbody_th_total;
    let text_tbody_th_produto_quantidade, text_tbody_th_produto_descricao, text_tbody_th_produto_preco, text_tbody_th_produto_total;

    div.innerHTML = '';

    table_produto = document.createElement('table');
    table_produto.setAttribute('class', 'table');
    thead_produto = document.createElement('thead');
    thead_produto.setAttribute('class', 'subtable');
    thead_produto_tr = document.createElement('tr');

    produto_th_quantidade = document.createElement('th');
    produto_th_quantidade.setAttribute('scope', 'col');
    produto_th_quantidade.setAttribute('style', 'text-align: center;');
    text_th_produto_quantidade = document.createTextNode('Quantidade');
    produto_th_quantidade.appendChild(text_th_produto_quantidade);

    produto_th_descricao = document.createElement('th');
    produto_th_descricao.setAttribute('scope', 'col');
    text_th_produto_descricao = document.createTextNode('Descrição');
    produto_th_descricao.appendChild(text_th_produto_descricao);

    produto_th_preco = document.createElement('th');
    produto_th_preco.setAttribute('scope', 'col');
    produto_th_preco.setAttribute('style', 'text-align: center;');
    text_th_produto_preco = document.createTextNode('Preço Unitário');
    produto_th_preco.appendChild(text_th_produto_preco);

    produto_th_total = document.createElement('th');
    produto_th_total.setAttribute('scope', 'col');
    produto_th_total.setAttribute('style', 'text-align: center;');
    text_th_produto_total = document.createTextNode('Total');
    produto_th_total.appendChild(text_th_produto_total);

    tbody_produto = document.createElement('tbody');
    tbody_produto.setAttribute('id', 'products-data');

    thead_produto.appendChild(produto_th_quantidade);
    thead_produto.appendChild(produto_th_descricao);
    thead_produto.appendChild(produto_th_preco);
    thead_produto.appendChild(produto_th_total);

    table_produto.appendChild(thead_produto);
    table_produto.appendChild(thead_produto_tr);

    response.venda.forEach(function(venda, index) {
      tbody_produto_tr = document.createElement('tr');

      tbody_th_quantidade = document.createElement('th');
      tbody_th_quantidade.setAttribute('scope', 'col');
      tbody_th_quantidade.setAttribute('style', 'text-align: center;');
      text_tbody_th_produto_quantidade = document.createTextNode(venda.quantidade);
      tbody_th_quantidade.appendChild(text_tbody_th_produto_quantidade);
  
      tbody_th_descricao = document.createElement('th');
      tbody_th_descricao.setAttribute('scope', 'col');
      text_tbody_th_produto_descricao = document.createTextNode(venda.descricao);
      tbody_th_descricao.appendChild(text_tbody_th_produto_descricao);
  
      tbody_th_preco = document.createElement('th');
      tbody_th_preco.setAttribute('scope', 'col');
      tbody_th_preco.setAttribute('style', 'text-align: center;');
      text_tbody_th_produto_preco = document.createTextNode(money.convertToReaisWithSigla(venda.preco));
      tbody_th_preco.appendChild(text_tbody_th_produto_preco);
  
      tbody_th_total = document.createElement('th');
      tbody_th_total.setAttribute('scope', 'col');
      tbody_th_total.setAttribute('style', 'text-align: center;');
      text_tbody_th_produto_total = document.createTextNode(money.convertToReaisWithSigla(venda.valor_total));
      tbody_th_total.appendChild(text_tbody_th_produto_total);
  
      tbody_produto_tr.appendChild(tbody_th_quantidade);
      tbody_produto_tr.appendChild(tbody_th_descricao);
      tbody_produto_tr.appendChild(tbody_th_preco);
      tbody_produto_tr.appendChild(tbody_th_total);
  
      tbody_produto.appendChild(tbody_produto_tr);
      table_produto.appendChild(tbody_produto);  
    });

    div.appendChild(table_produto);
}

let noVendasMessage = function() {
  let p = document.querySelector('#nenhuma-venda-encontrada');
  let textContent = document.createTextNode('Nada Consta');

  p.appendChild(textContent);
}

let fillVendasTable = function() {
  let response = venda.getVendasList(page[1]);
  
  document.querySelector('#nenhuma-venda-encontrada').textContent = '';

  if (response.data.length == 0) {
    noVendasMessage();
    return;
  }

  paginator.mountPaginatorByData(response, paginator)
    .then(function() {
      return;
    })
    .catch(function(error) {
      message.createMessage('danger', error);
    });

  let tbody = document.querySelector('#lista-vendas');
  let tipo_pagamento, tr_venda, tr_produto, td_generic, div_collapse
  let td_venda_id, td_venda_observacao, td_venda_tipo_pagamento, td_venda_pago, td_venda_troco, td_venda_desconto, td_venda_total, td_actions;
  let text_venda_id, text_venda_observacao, text_tipo_pagamento, text_venda_pago, text_venda_troco, text_venda_desconto, text_venda_total, text_produtos, text_remover, button_produtos, button_remover;
  
  response.data.forEach(function(v, index) {
    tipo_pagamento = venda.getTipoPagamento(v.tipo_pagamento_id);
    
    if (tipo_pagamento.id != 6) {
      tr_venda = document.createElement('tr');

      td_venda_id = document.createElement('td');
      text_venda_id = document.createTextNode(v.id);
      td_venda_id.appendChild(text_venda_id);
  
      td_venda_observacao = document.createElement('td');
      if (v.observacao == null) {
        v.observacao = 'Nada consta'
      }
      td_venda_observacao.setAttribute('title', v.observacao);
      text_venda_observacao = document.createTextNode(stripStringBiggerThan55(v.observacao));
      td_venda_observacao.appendChild(text_venda_observacao);
  
      td_venda_tipo_pagamento = document.createElement('td');
      td_venda_tipo_pagamento.setAttribute('style','text-align: center;');
      text_tipo_pagamento = document.createTextNode(tipo_pagamento.descricao);
      td_venda_tipo_pagamento.appendChild(text_tipo_pagamento);

      td_venda_pago = document.createElement('td');
      td_venda_pago.setAttribute('style','text-align: center;');
      text_venda_pago = document.createTextNode(money.convertToReaisWithSigla(v.troco + v.valor_total));
      td_venda_pago.appendChild(text_venda_pago);

      td_venda_troco = document.createElement('td');
      td_venda_troco.setAttribute('style','text-align: center;');
      text_venda_troco = document.createTextNode(money.convertToReaisWithSigla(v.troco));
      td_venda_troco.appendChild(text_venda_troco);
  
      td_venda_desconto = document.createElement('td');
      td_venda_desconto.setAttribute('style','text-align: center;');
      text_venda_desconto = document.createTextNode(money.convertToReaisWithSigla(v.desconto));
      td_venda_desconto.appendChild(text_venda_desconto);
  
      td_venda_total = document.createElement('td');
      td_venda_total.setAttribute('style','text-align: center;');
      text_venda_total = document.createTextNode(money.convertToReaisWithSigla(v.valor_total));
      td_venda_total.appendChild(text_venda_total);
  
      td_actions = document.createElement('td');
      // button_finalizar = document.createElement('button');
      // button_finalizar.setAttribute('id', 'btn-finalizar-venda-' + v.id);
      // button_finalizar.setAttribute('name', 'finalizar-venda');
      // button_finalizar.setAttribute('class', 'btn btn-primary mr-1');
      // button_finalizar.setAttribute('data-toggle', 'modal');
      // button_finalizar.setAttribute('data-target', '#generic-modal');
      // text_finalizar = document.createTextNode('Finalizar');
      // button_finalizar.appendChild(text_finalizar);
  
      button_produtos = document.createElement('button');
      button_produtos.setAttribute('id', 'btn-produtos-' + v.id);
      button_produtos.setAttribute('name', 'visualizar-venda');
      button_produtos.setAttribute('class', 'btn btn-warning mr-1');
      button_produtos.setAttribute('data-toggle', 'collapse');
      button_produtos.setAttribute('href', '#collapse-id-' + v.id);
      text_produtos = document.createTextNode('Produtos');
      button_produtos.appendChild(text_produtos);
  
      button_remover = document.createElement('button');
      button_remover.setAttribute('id', 'btn-remover-venda-' + v.id);
      button_remover.setAttribute('name', 'remover-venda');
      button_remover.setAttribute('class', 'btn btn-danger mr-1');
      button_remover.setAttribute('data-toggle', 'modal');
      button_remover.setAttribute('data-target', '#generic-modal-confirm');
      text_remover = document.createTextNode('Remover');
      button_remover.appendChild(text_remover);
  
      // td_actions.appendChild(button_finalizar);
      td_actions.appendChild(button_produtos);
      td_actions.appendChild(button_remover);
  
      tr_venda.appendChild(td_venda_id);
      tr_venda.appendChild(td_venda_observacao);
      tr_venda.appendChild(td_venda_tipo_pagamento);
      tr_venda.appendChild(td_venda_pago);
      tr_venda.appendChild(td_venda_troco);
      tr_venda.appendChild(td_venda_desconto);
      tr_venda.appendChild(td_venda_total);
      tr_venda.appendChild(td_actions);
  
      // Collapse com a table produtos
      tr_produto = document.createElement('tr');
      tr_produto.setAttribute('class', 'hide-table-padding');
      td_generic = document.createElement('td');
      tr_produto.appendChild(td_generic);
  
      td_generic = document.createElement('td');
      td_generic.setAttribute('colspan', '7');
      div_collapse = document.createElement('div');
      div_collapse.setAttribute('id', 'collapse-id-' + v.id);
      div_collapse.setAttribute('class', 'collapse in p-3');
  
      td_generic.appendChild(div_collapse);
  
      tr_produto.appendChild(td_generic);
  
      tbody.appendChild(tr_venda);
  
      tbody.appendChild(tr_produto);

      document.querySelector('#btn-remover-venda-' + v.id).onclick = function() {
        document.querySelector('#btn-remover-venda').onclick = function() {
          deleteVenda(v.id);
        }
      }
  
      document.querySelector('#btn-produtos-' + v.id).onclick = function() {
        constructCollapseProductsVenda(v.id);
      }  
    }
  });
}

fillVendasTable();