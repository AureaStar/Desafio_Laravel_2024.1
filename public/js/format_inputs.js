
    function formatarCpf(campo) {
        let valor = campo.value.replace(/\D/g, '');
        if (valor.length > 3) {
            valor = valor.substring(0, 3) + '.' + valor.substring(3);
        }
        if (valor.length > 7) {
            valor = valor.substring(0, 7) + '.' + valor.substring(7);
        }
        if (valor.length > 11) {
            valor = valor.substring(0, 11) + '-' + valor.substring(11);
        }
        if (valor.length > 14) {
            campo.style = 'border-color: red;';
        } else {
            campo.style = 'border-color: #d2d6de;';
        }

        campo.value = valor;
    }

    function formatarTelefone(campo) {
        let valor = campo.value.replace(/\D/g, '');
        if (valor.length > 2) {
            valor = '(' + valor.substring(0, 2) + ') ' + valor.substring(2);
        }
        if (valor.length > 10) {
            valor = valor.substring(0, 10) + '-' + valor.substring(10);
        }
        campo.value = valor;
    }

  function formatCurrency(input) {
    let value = input.value.replace(/\D/g, '');

    value = (parseFloat(value) / 100).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

    input.value = value;
  }

  function formatPercentage(input) {
    let value = input.value.replace(/\D/g, '');

    value =  

    input.value = value;
  }
