var ajax;

window.onload = function(){
    document.getElementById('servico').onchange = function(){
        var id_serv = this.value;
//        alert('é nois')
        aciona_ajax(id_serv);
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
        
            var resposta = JSON.parse(ajax.responseText);
//            var resposta = ajax.responseText;
//var resposta = 'No script';
            monta_opcao(resposta, resposta.length);
        }
    }
}

function aciona_ajax(id_serv){
    ajaxRequest();
    ajax.onreadystatechange = function(){
        requisicao();
    }
    var urlVar = ajaxUrl+'?action=acao_ajax_meu&servico='+id_serv;
//    alert(urlVar);
    ajax.open('get', urlVar);
    ajax.send(null);
}

function monta_opcao(resposta, cont){
     var contador_option = document.getElementById('profissional').childNodes.length
     for(var s = 0; s < contador_option; s++){
         document.getElementById('profissional').remove(s);
     }
        document.getElementById('profissional').options[0] = new Option('Selecione Um Profissional', '');
    for(var i = 0; i < cont; i++){
        document.getElementById('profissional').options[i+1] = new Option(resposta[i].user_login, resposta[i].ID);
    }
   
}


