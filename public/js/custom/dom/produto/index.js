import { ModalHandler } from '../ModalHandler/ModalHandler.js';
import { ProdutoController } from '../../Controllers/ProdutoController.js';
import { MessageHandler } from '../MessageHandler/MessageHandler.js';
import { Paginator } from '../paginator/Paginator.js';
import { Money } from '../../money.js';


var page = document.querySelector('#pagina').textContent;
const produto = new ProdutoController();
const message = new MessageHandler();
const modal = new ModalHandler();
const paginator = new Paginator();
const money = new Money();

page = page.split(/P.*gina\s+(.*)/);

let getProductList = function(page) {
  return produto.getProductList(page[1]);
}

let destroyProductTable = function() {
  document.querySelector('#lista-produtos-body').innerHTML = '';
  fillProductTable(page);
}

let searchProductAndShowTable = function() {
  let busca = document.querySelector("#buscar").value;
  let response = produto.searchExact('descricao', busca);
  let data = produto.getProductById(response.hits.hits[0]._id);

  var tbody = document.querySelector('#lista-produtos-body');
  var tr, th;
  var td_descricao, td_unidade_medida, td_preco, td_quantidade_atual, td_buttons;
  var id, descricao, unidade_medida, preco, quantidade_atual, editar, deletar;
  var button_editar, button_deletar;

  document.querySelector('#lista-produtos-body').innerHTML = '';

  tr = document.createElement('tr');
  tr.setAttribute('class', 'fade-in');
  th = document.createElement('th');
  th.setAttribute('id', 'produto');
  th.setAttribute('scope', 'row');
  id = document.createTextNode(data.produto.id);
  th.appendChild(id);

  td_descricao = document.createElement('td');
  descricao = document.createTextNode(data.produto.descricao);
  td_descricao.appendChild(descricao);

  td_unidade_medida = document.createElement('td');
  td_unidade_medida.setAttribute('style', 'text-align: center');
  unidade_medida = document.createTextNode(data.produto.unidade_medida);
  td_unidade_medida.appendChild(unidade_medida);

  td_preco = document.createElement('td');
  td_preco.setAttribute('style', 'text-align: center');
  preco = document.createTextNode(money.convertToReaisWithSigla((data.estoque.preco)));
  td_preco.appendChild(preco);

  td_quantidade_atual = document.createElement('td');
  td_quantidade_atual.setAttribute('style', 'text-align: center');
  quantidade_atual = document.createTextNode(data.estoque.quantidade_atual);
  td_quantidade_atual.appendChild(quantidade_atual);

  td_buttons = document.createElement('td');
  button_editar = document.createElement('button');
  button_editar.setAttribute('id', "btn-editar-produto-" + data.produto.id);
  button_editar.setAttribute('name', "editar-produto");
  button_editar.setAttribute('class', "btn btn-warning mr-1");
  button_editar.setAttribute('data-toggle', "modal");
  button_editar.setAttribute('data-target', "#generic-modal");
  button_editar.setAttribute('value', data.produto.id);
  editar = document.createTextNode('Editar');
  button_editar.appendChild(editar);

  button_deletar = document.createElement('button');
  button_deletar.setAttribute('id', "btn-deletar-produto-" + data.produto.id);
  button_deletar.setAttribute('name', "deletar-produto");
  button_deletar.setAttribute('class', "btn btn-danger");
  button_deletar.setAttribute('data-toggle', "modal");
  button_deletar.setAttribute('data-target', "#generic-modal-confirm");
  button_deletar.setAttribute('value', data.produto.id);
  deletar = document.createTextNode('Deletar');
  button_deletar.appendChild(deletar);

  td_buttons.appendChild(button_editar);
  td_buttons.appendChild(button_deletar);

  tr.appendChild(th);
  tr.appendChild(td_descricao);
  tr.appendChild(td_unidade_medida);
  tr.appendChild(td_preco);
  tr.appendChild(td_quantidade_atual);
  tr.appendChild(td_buttons);

  tbody.appendChild(tr);

  setButtonAndFields(data.produto.id);
}

let checkForRequiredProductFields = function() {
  let aFields = [
    {
      field: "Descrição",
      element: document.querySelector('#produto-descricao')
    },
    {
      field: "Categoria",
      element: document.querySelector('#produto-categoria')
    },
    {
      field: 'Preço de Venda',
      element: document.querySelector('#produto-preco-venda')
    }
  ];

  let returnFields = requiredFields(aFields);

  if (returnFields.length > 0) {
    returnFields.forEach(function(field, index) {
      message.createModalMessage('danger', 'O campo ' + field + ' deve ser preenchido!');
    });
    return false;
  }
  
  return true;
}

let setButtonAndFields = function (id) {
  let data = produto.getProductById(id);
    document.querySelector("#btn-deletar-produto-" + data.produto.id).onclick = function() {
      document.querySelector('#deletar-id').value = data.produto.id;
      document.querySelector('#deletar-descricao').value = data.produto.descricao;
      createConfirmActionButton('excluir');
      document.querySelector('#btn-excluir-produto').onclick = function() {
        deleteProduct()
      }
    }
    document.querySelector("#btn-editar-produto-" + data.produto.id).onclick = function() {
      setAllProductsFields(
        data.produto.id, data.produto.codigo_barra, data.produto.descricao, data.produto.unidade_medida, data.produto.categoria_id, data.produto.ativo,
        data.estoque.quantidade_atual, money.convertToReais(data.estoque.preco), money.convertToReais(data.estoque.preco_custo)
      );
      createActionButton('atualizar');
      document.querySelector('#btn-atualizar-produto').onclick = function() {
        updateProduct()
      }
    }
}

let fillProductTable = function() {
  var list = getProductList(page);
  var div = document.querySelector('#no-products');
  
  var tbody = document.querySelector('#lista-produtos-body');
  var tr, th;
  var td_descricao, td_unidade_medida, td_preco, td_quantidade_atual, td_buttons;
  var id, descricao, unidade_medida, preco, quantidade_atual, editar, deletar;
  var button_editar, button_deletar;

  paginator.mountPaginatorByData(list, paginator)
    .then(function() {
      return;
    })
    .catch(function(error) {
      message.createMessage('danger', error);
    });

  div.innerHTML = '';

  if (list.data.length > 0) {
    list.data.forEach(function(produto, index) {
      tr = document.createElement('tr');
      tr.setAttribute('class', 'fade-in');
      th = document.createElement('th');
      th.setAttribute('id', 'produto');
      th.setAttribute('scope', 'row');
      id = document.createTextNode(produto.id);
      th.appendChild(id);
  
      td_descricao = document.createElement('td');
      descricao = document.createTextNode(produto.descricao);
      td_descricao.appendChild(descricao);
  
      td_unidade_medida = document.createElement('td');
      td_unidade_medida.setAttribute('style', 'text-align: center');
      unidade_medida = document.createTextNode(produto.unidade_medida);
      td_unidade_medida.appendChild(unidade_medida);
  
      td_preco = document.createElement('td');
      td_preco.setAttribute('style', 'text-align: center');
      preco = document.createTextNode(money.convertToReaisWithSigla(produto.preco));
      td_preco.appendChild(preco);
  
      td_quantidade_atual = document.createElement('td');
      td_quantidade_atual.setAttribute('style', 'text-align: center');
      quantidade_atual = document.createTextNode(produto.quantidade_atual);
      td_quantidade_atual.appendChild(quantidade_atual);
  
      td_buttons = document.createElement('td');
      button_editar = document.createElement('button');
      button_editar.setAttribute('id', "btn-editar-produto-" + produto.id);
      button_editar.setAttribute('name', "editar-produto");
      button_editar.setAttribute('class', "btn btn-warning mr-1");
      button_editar.setAttribute('data-toggle', "modal");
      button_editar.setAttribute('data-target', "#generic-modal");
      button_editar.setAttribute('value', produto.id);
      editar = document.createTextNode('Editar');
      button_editar.appendChild(editar);
  
      button_deletar = document.createElement('button');
      button_deletar.setAttribute('id', "btn-deletar-produto-" + produto.id);
      button_deletar.setAttribute('name', "deletar-produto");
      button_deletar.setAttribute('class', "btn btn-danger");
      button_deletar.setAttribute('data-toggle', "modal");
      button_deletar.setAttribute('data-target', "#generic-modal-confirm");
      button_deletar.setAttribute('value', produto.id);
      deletar = document.createTextNode('Deletar');
      button_deletar.appendChild(deletar);
  
      td_buttons.appendChild(button_editar);
      td_buttons.appendChild(button_deletar);
  
      tr.appendChild(th);
      tr.appendChild(td_descricao);
      tr.appendChild(td_unidade_medida);
      tr.appendChild(td_preco);
      tr.appendChild(td_quantidade_atual);
      tr.appendChild(td_buttons);
    
      tbody.appendChild(tr);
    });
  
    let tableProducts = document.querySelector('#lista-produtos');
    
    for (let i = 0; i < tableProducts.rows.length-1; i++){
      setButtonAndFields(list.data[i].id);
    }  
  } else {
    let newDiv = document.createElement('div');
    let text = document.createTextNode('Nenhum registro encontrado');
    newDiv.setAttribute('class', 'alert alert-warning mt-3 fade-in');
    newDiv.appendChild(text);
    div.appendChild(newDiv);
  }
}

fillProductTable();

let getAllProductsFields = function() {
  return {
    id: document.querySelector('#produto-id').value,
    codigo_barra: document.querySelector('#produto-codigo-barra').value,
    descricao: document.querySelector('#produto-descricao').value,
    unidade_medida: document.querySelector('#produto-unidade-medida').value,
    categoria_id: document.querySelector('#produto-categoria').value,
    quantidade_estoque: document.querySelector('#produto-nova-quantidade-estoque').value,
    preco_custo: money.convertUnmaskedValue(document.querySelector('#produto-preco-custo').value),
    preco_venda: money.convertUnmaskedValue(document.querySelector('#produto-preco-venda').value),
    ativo: document.querySelector('#produto-ativo').value
  }
}

let setAllProductsFields = function (
    id = '', codigo_barra = '', descricao = '', unidade_medida = 'ML', categoria_id = 0, ativo = 1, quantidade_estoque = 0, preco_venda = '0,00', preco_custo = '0,00'
  ) {
    document.querySelector('#produto-id').value = id;
    document.querySelector('#produto-codigo-barra').value = codigo_barra;
    document.querySelector('#produto-descricao').value = descricao;
    document.querySelector('#produto-unidade-medida').value = unidade_medida;
    if (ativo == true) {
      ativo = 1;
    } else { 
      ativo = 0;
    }
    document.querySelector('#produto-categoria').value = categoria_id;
    document.querySelector('#produto-ativo').value = ativo;
    document.querySelector('#produto-quantidade-atual-estoque').value = quantidade_estoque;
    document.querySelector('#produto-quantidade-estoque').value = 0;
    document.querySelector('#produto-nova-quantidade-estoque').value = quantidade_estoque;
    document.querySelector('#produto-preco-venda').value = preco_venda;
    document.querySelector('#produto-preco-custo').value = preco_custo;
}

let destroyActionButtons = function() {
  document.querySelector('#produto-actions').innerHTML = '';
}

let destroyConfirmActionButtons = function() {
  document.querySelector('#confirm-actions').innerHTML = '';
}

let createActionButton = function(action) {
  destroyActionButtons();
  let div = document.querySelector('#produto-actions');
  let button = document.createElement('input');
  let textElement ;

  button.setAttribute('type', 'submit');

  if (action == 'salvar') {
    button.setAttribute('value','Salvar');
    button.setAttribute('id', 'btn-salvar-produto');
    button.setAttribute('class', 'btn btn-primary');
  } else {
    button.setAttribute('value','Atualizar');
    button.setAttribute('id', 'btn-atualizar-produto');
    button.setAttribute('class', 'btn btn-warning');
  }

  button.setAttribute('type', 'button');

  div.appendChild(button);
}

let createConfirmActionButton = function(action) {
  destroyConfirmActionButtons();
  let div = document.querySelector('#confirm-actions');
  let button = document.createElement('button');
  let textElement ;

  if (action == 'excluir') {
    textElement = document.createTextNode('Excluir');
    button.setAttribute('id', 'btn-excluir-produto');
    button.setAttribute('class', 'btn btn-danger');
  }

  button.setAttribute('type', 'button');

  button.appendChild(textElement);
  div.appendChild(button);
}

document.querySelector('#generic-modal').onhide = function() {
  destroyActionButtons();
}

document.querySelector('#btn-cadastrar-produto').onclick = function() {
  setAllProductsFields();
  createActionButton('salvar');
  document.querySelector('#btn-salvar-produto').onclick = function() {
    saveProduct()
  }
}

document.querySelector('#produto-quantidade-estoque').addEventListener("change", function() {
  let quantidade_atual = parseInt(document.querySelector('#produto-quantidade-atual-estoque').value);
  let quantidade_estoque = parseInt(document.querySelector('#produto-quantidade-estoque').value);
  let novaQuantidade = (quantidade_atual + (quantidade_estoque));

  if (novaQuantidade < 0) {
    message.createModalMessage('danger', 'Estoque Negativo!');
  }

  document.querySelector('#produto-nova-quantidade-estoque').value = novaQuantidade;
});

let saveProduct = function() {
  if (checkForRequiredProductFields()) {
    modal.closeModal();
    let data = getAllProductsFields();
    let response = produto.saveProduct(data);
    message.checkAndCreateMessageByStatus(response.status, response.msg);
    destroyProductTable();
  }
}

let updateProduct = function() {
  if (checkForRequiredProductFields()) {
    modal.closeModal();
    let data = getAllProductsFields();
    let response = produto.updateProduct(data);
    message.checkAndCreateMessageByStatus(response.status, response.msg);
    setButtonAndFields(data.id);
    destroyProductTable();
  }
}

let deleteProduct = function() {
  modal.closeConfirmModal();
  let id = document.querySelector('#deletar-id').value;
  let response = produto.deleteProduct(id);
  if (response.status == 500) {
    message.createMessage('danger', 'Não foi possível excluir o produto. Verifique se o mesmo possui venda.')
  } else {
    message.checkAndCreateMessageByStatus(response.status, response.msg);
  }
  destroyProductTable();
}

document.querySelector('#btn-buscar').onclick = function(e) {
  e.preventDefault();
  searchProductAndShowTable();
}

document.querySelector("#buscar").oninput = function() {
  if (this.value == '' || this.value == undefined) {
    destroyProductTable();
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


