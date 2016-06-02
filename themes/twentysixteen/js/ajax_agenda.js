var ajax;

window.onload = function () {
    document.getElementById('agenda_inclusao').onclick = function () {

        var profissional_servico = document.getElementById('profissional-servico').childNodes.length;
//       Verifica se é Windows Explorer
//       Caso Seja Negado -> o contador deve ser dividido por dois 
        var i = /Trident/;
        if (!i.test(navigator.userAgent)) {
            profissional_servico = profissional_servico / 2;
        }

        for (var p = 1; p <= profissional_servico; p++) {
            var profissional = document.getElementById('profissional-' + p).value;
        
            var container_servicos = document.getElementsByClassName('container-servicos-' + p);
            var contador_container_servicos = container_servicos.length;
            for (var sc = 0; sc < contador_container_servicos; sc++) {

                var servicos = container_servicos[sc].childNodes;
                var serv_cont = servicos.length;

                for (var i = 0; i < serv_cont; i++) {
                    if (servicos[i].getAttribute('type') === 'checkbox') {
                        if (servicos[i].checked) {
                            alert(servicos[i].value + servicos[i].getAttribute('name'));
                        }
                    }
                }
            }
        }
//        aciona_ajax(id_serv);
    }
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

function aciona_ajax(id_serv) {
    ajaxRequest();
    ajax.onreadystatechange = function () {
        requisicao();
    }
    var urlVar = ajaxUrl + '?action=acao_ajax_meu&servico=' + id_serv;
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


