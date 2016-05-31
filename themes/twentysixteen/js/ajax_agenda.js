var ajax;

window.onload = function(){
    document.getElementById('servico').onchange = function(){
//        alert('é nois')
        aciona_ajax();
    }
}

function ajaxRequest(){
    ajax = null;
    if(window.XMLHttpRequest){
       ajax = new XMLHttpRequest(); 
    }else if(window.ActiveXObject){
        try{
            ajax = ActiveXObject('Microsoft2.XMLHTTP');
        }catch(e){
            ajax = ActiveXObject('Microsoft.XMLHTTP');
        }
    }
}

function requisicao(){
    if(ajax.readyState == 4){
        if(ajax.status == 200){
            var resposta = ajax.responseText;
//var resposta = 'No script';
            monta_opcao(resposta);
        }
    }
}

function aciona_ajax(){
    ajaxRequest();
    ajax.onreadystatechange = function(){
        requisicao();
    }
    ajax.open('GET', 'http://treinamento/wp-content/themes/twentysixteen/includes/ajax_profissional.php');
    ajax.send(null);
}

function monta_opcao(resposta){
    document.write(resposta);
//    
//    var elementos = resposta.getElementsByTagName('servico')[0].childNodes;
//    var contador = elementos.length;
//   for(var i = 0; i < contador; i++){
//        document.getElementById('profissional').options[i] = new Option(elemntos[i].getAttribute('tag'), elementos[i].getAttribute('value'));
//    }
}


