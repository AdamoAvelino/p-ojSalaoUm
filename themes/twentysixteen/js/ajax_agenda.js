var ajax;
var agendaSon = {compromissos : []};
window.onload = function () {
    
    document.getElementById('data-agenda').onblur = function () {
        if (this.value) {
            document.getElementById('hora-agenda').removeAttribute('disabled');
        } else{
            document.getElementById('hora-agenda').setAttribute('disabled', 'disabled');
        }
    }



    document.getElementById('agenda_inclusao').onclick = function () {
        
        var data_agenda = document.getElementById('data-agenda').value;
        var hora_agenda = document.getElementById('hora-agenda').value;
        var cliente = document.getElementById('usuario').value;
        var profissional_servico = document.getElementById('profissional-servico').childNodes.length;
//       Verifica se é Windows Explorer
//       Caso Seja Negado -> o contador deve ser dividido por dois 
        var i = /Trident/;
        if (!i.test(navigator.userAgent)) {
            profissional_servico = profissional_servico / 2;
        }
        var agenda_dados = new Array();                
        
        for (var p = 1; p <= profissional_servico; p++) {
            agenda_dados[p] = []
            var profissional = document.getElementById('profissional-' + p).value;
            var container_servicos = document.getElementsByClassName('container-servicos-' + p);
            var contador_container_servicos = container_servicos.length;
            var tempo_fim_servico = 0;
            
            for (var sc = 0; sc < contador_container_servicos; sc++) {
                var servicos = container_servicos[sc].childNodes;
                var serv_cont = servicos.length;
                for (var i = 0; i < serv_cont; i++) {
                    if (servicos[i].getAttribute('type') === 'checkbox') {
                        if (servicos[i].checked) {
                            var codigo_servico = servicos[i].value;
                            var nome_servico = servicos[i].getAttribute('name');
                            var tempo_servico = servicos[i].getAttribute('data-tempo');
                            var classe_servico = servicos[i].getAttribute('data-classe');
                            if (tempo_servico) {
                                var inicio = (tempo_fim_servico != '0') ? tempo_fim_servico : hora_agenda;
                                tempo_fim_servico = complementaHoras(inicio, parseInt(tempo_servico), data_agenda);
                            }else{
                                var inicio = hora_agenda;
                                tempo_fim_servico = complementaHoras(hora_agenda, 60, data_agenda);
                            }
                            agendaSon.compromissos.push({'profissional': profissional, 'cliente': cliente, 'data': data_agenda, 'servico' : classe_servico, 'hora_inicio' : inicio, 'hora_fim' : tempo_fim_servico});
                        }
                    }
                }
            }
        }
        var sons = JSON.stringify(agendaSon)
        aciona_ajax(sons, 'rn_insercao_agenda');
    }
}




function complementaHoras(horario, minutos, data) {
   var converte_data = data.split('-');
   for(var i =0;i < 3; i++){
       converte_data[i] = parseInt(converte_data[i])
   }
   var data_convertida = converte_data.join('-'); 
   var hora_separada = horario.split(':');
   var horas = new Date(data_convertida);
   var novo_horario = new Date(data_convertida);
   horas.setHours(hora_separada[0]);
   minutos = minutos + parseInt(hora_separada[1]);
   horas.setMinutes(minutos);
   var result = horas.getTime() - novo_horario.getTime();
   var horario_retorno = parseInt(result / 3600000) + ':' + ((result % 3600000) / 60000);
   return horario_retorno;
}

function ajaxRequest() {
    ajax = null;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
            ajax = ActiveXObject('Microsoft2.XMLHTTP');
        } catch (e) {
            ajax = ActiveXObject('Microsoft.XMLHTTP');
        }
    }
}

function requisicao() {
    if (ajax.readyState == 4) {
        if (ajax.status == 200) {
            var resposta = JSON.parse(ajax.responseText);
//            var resposta = ajax.responseText;
//            alert(resposta);
            monta_opcao(resposta);
        }
    }
}

function aciona_ajax(dados, metodo) {
    ajaxRequest();
    ajax.onreadystatechange = function () {
        requisicao();
    }
    var urlVar = ajaxUrl+'?action='+metodo+'&dados='+dados;
//    alert(urlVar);
    ajax.open('get', urlVar);
    ajax.send(null);
}

function monta_opcao(resposta) {
    switch(resposta.opcao){
        case 'mensagem_box' : monta_mensagem_box(resposta);break;
    }
    

}

function monta_mensagem_box(objeto){
    alert(objeto.mensagem);
}


