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
            
            var servicos_horas = new Array();
            var hora_fechamento = 0;
            for (var sc = 0; sc < contador_container_servicos; sc++) {
                var tempo_fim_servico;
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
                                var inicio = ((i > 0) ? tempo_fim_servico : hora_agenda);
                                hora_fechamento = hora_fechamento + parseInt(tempo_servico);
                                tempo_fim_servico = complementaHoras(inicio, hora_fechamento, data_agenda);
                            }else{
                                var inicio = hora_agenda;
                                tempo_fim_servico = complementaHoras(hora_agenda, 60, data_agenda);
                            }
                            
//                            var inicio = (i > 0) ? hora_fechamento : hora_agenda;
                            
                            agendaSon.compromissos.push({'profissional': profissional, 'data': data_agenda, 'servico' : classe_servico, 'inicio' : inicio, 'fim' : tempo_fim_servico});
                        }
                    }
                }
            }
        }
        
//        console.log(agendaSon);
        var sons = JSON.stringify(agendaSon)
//        console.log(sons);
       
        
        aciona_ajax(sons);
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
//var resposta = 'No script';
            monta_opcao(resposta, resposta.length);
        }
    }
}

function aciona_ajax(dados) {
    ajaxRequest();
    ajax.onreadystatechange = function () {
        requisicao();
    }
    var urlVar = ajaxUrl + '?action=acao_ajax_meu&dados=' + dados;
//    alert(urlVar);
    ajax.open('get', urlVar);
    ajax.send(null);
}

function monta_opcao(resposta, cont) {
    var contador_option = document.getElementById('profissional').childNodes.length
    for (var s = 0; s < contador_option; s++) {
        document.getElementById('profissional').remove(s);
    }
    document.getElementById('profissional').options[0] = new Option('Selecione Um Profissional', '');
    for (var i = 0; i < cont; i++) {
        document.getElementById('profissional').options[i + 1] = new Option(resposta[i].user_login, resposta[i].ID);
    }

}


