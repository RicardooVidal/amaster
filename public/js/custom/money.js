// Formatar dinheiro

export class Money {

    // Usar quando pegar o valor de um input com o mask
    convertUnmaskedValue(value) {
        value = value.toString().replace(",","");
        value = value.toString().replace(".","");

        return (parseInt(value) / 100).toFixed(2);
    }

    // Pegar o valor sem mask
    getUnmaskedValue(value) {
        value = value.toString().replace(",","");
        value = value.toString().replace(".","");
        
        return value;
    }

    // Usar quando quiser transformar um valor já convertido para Reais
    convertToReaisWithSigla(value) {
        value = parseInt(value.toString().replace(".",""));
        value = value / 100;
        
        return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
    }

    // Usar quando querer converter o ponto da casa decimal para vírgula
    convertToReais(value) {
        value = value.toString().replace(".","");
        value = (value / 100).toFixed(2).replace(".", ",");

        return value;
    }
}