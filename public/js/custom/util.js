$(document).ready(function(){
    $('.money').mask('000.000.000.000.000,00' , { reverse : true});
    $('.cnpj').mask('00.000.000/0000-00' , { reverse : true});
    $('.bar-code').mask('0000000000000000' , { reverse : true});
});

var modalConfirm = function(callback){
  
    $("#btn-confirm").on("click", function(){
      $("#generic-modal-confirm").modal('show');
    });
  
    $("#generic-modal-confirm").on("click", function(){
      callback(true);
      $("#generic-modal-confirm").modal('hide');
    });
    
    $("#modal-btn-no").on("click", function(){
      callback(false);
      $("#generic-modal-confirm").modal('hide');
    });
  };

function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function htmlDecode(input){
  var e = document.createElement('textarea');
  e.innerHTML = input;
  // handle case of empty input
  return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}

function getRandomNumber() {
  return Math.random();
}

function requiredFields(fields) {
  let requiredFields = [];
  fields.forEach(function(field, index) {
    if (field.element.hasAttribute('required') && field.element.value == '' || field.element.value == '0,00' || field.element.value == 0) {
      requiredFields.push(field.field);
    }
  });

  return requiredFields;
}

function hasWhiteSpace(s) {
  return s.indexOf(' ') >= 0;
}

function formatMoney(number) {
  return number.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

Array.prototype.remove = function() {
  var what, a = arguments, L = a.length, ax;
  while (L && this.length) {
      what = a[--L];
      while ((ax = this.indexOf(what)) !== -1) {
          this.splice(ax, 1);
      }
  }
  return this;
};

function toDecimal(string) {
  if (typeof string == "number") {
    return string.toFixed(2);
  }
  string = string.replace(",", ".");
  string = string.replace(".", "");
  string = parseFloat(string) / 100;

  return string;
}

function toReais(number) {
  return number.toFixed(2).toString().replace(".",",")
}

function moneyAsFloat(number) {
  return parseFloat(number.replace(/[^0-9-.]/g, '')); 
}

function removeIndexFromArray(array, id) {
  return array.filter((array) => array.id !== id);
}

function stopLoading() {
  $('#loading').hide();
}

function showLoading() {
  $('#loading').show();
}

function clearConsole() {
  console.clear();
}

function parseDate(date) {
  let dateObj = new Date(date)

  let dateString = dateObj.toLocaleString('en-US', {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
  }).replace(/\//g, '-');

  return dateString;
}

function getCurrentMonth() {
  var d = new Date();
  return d.getMonth() + 1;
}

function getCurrentYear() {
  var d = new Date();
  return d.getFullYear();
}

function getCurrentDay() {
  var d = new Date();
  return d.getDay();
}

function getLastDayOfMonth() {
  var d = new Date(2021, 01 + 1, 0);
  return d.getUTCDate();
}

function stripStringBiggerThan55(string)
{
  if (string.length > 55) {
    return string.substr(0, 55) + '...';
  }

  return string
}

// setInterval(clearConsole, 30000)

stopLoading();

