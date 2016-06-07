<?php

function rn_inclui_scripts() {
    if (get_post_type() == 'documento') {
        wp_enqueue_style('fullcalendar_style', get_template_directory_uri() . '/css/fullcalendar.min.css', array(), '20151112', true);
        wp_enqueue_style('cupertino', get_template_directory_uri() . '/css/cupertino/jquery-ui.min.css', array(), '20151112', true);
        wp_enqueue_script('moment', get_template_directory_uri() . '/js/moment.min.js', array(), '20151112', true);
        wp_enqueue_script('fullcalendar_script', get_template_directory_uri() . '/js/fullcalendar.js', array(), '20151112', true);
        wp_enqueue_script('lang_ptbr', get_template_directory_uri() . '/js/lang/pt-br.js', array(), '20151112', true);
        wp_enqueue_script('documento', get_template_directory_uri() . '/js/documento.js', array('jquery'), '20151112', true);
        
    }
    
}
add_action('wp_enqueue_scripts', 'rn_inclui_scripts');
//-----------------------Função para inclusão do Ajax
add_action('wp_footer', 'ajax_javascript');

function ajax_javascript() {
    $script = "<script type='text/javascript'>";
    $script .= "var ajaxUrl = '" . admin_url('admin-ajax.php') . "';";
    $script .= "</script>";
    echo $script;
    wp_enqueue_script('json2_ag', get_template_directory_uri() . '/js/json2.js', array(), '20160606', true);
    wp_enqueue_script('ajax_agenda', get_template_directory_uri() . '/js/ajax_agenda.js', array('json2_ag'), '', true);
}
//-------------------------------------------------------------------------
//---------------------Função para carregar o combo funcionarios (obsoleta).
function acao_ajax_meu() {
//    header('content-type: text/xml');
    global $wpdb;
    $query_b = "select wu.user_login, wu.ID
from wp_users wu
JOIN wp_usermeta wm ON wm.user_id = wu.ID
WHERE wm.meta_key = 'profissao' and wm.meta_value = {$_REQUEST['servico']}";
    $dataset = $wpdb->get_results($query_b);
    $json  = json_encode($dataset);
    echo $json;
}

add_action('wp_ajax_nopriv_acao_ajax_meu', 'acao_ajax_meu');
add_action('wp_ajax_acao_ajax_meu', 'acao_ajax_meu');
//------------------------------------------------------------------------------------------------
//--------------------Função para fazer update da agenda
function rn_insercao_agenda(){
    global $wpdb;
    $dados = json_decode(str_replace(array("\\"),"", $_GET['dados']), true);
    extract($dados);
//    var_dump($compromissos);
    
//    $values_operador = "values"; 
    $erro = 0;
    $sucesso = 0;
    foreach($compromissos as $compromisso){
//        var_dump($compromisso);
        if($wpdb->insert('wp_agenda', $compromisso, array('%s', '%d'))){
           $sucesso += 1;
        }else{
           $erro += 1;
        }
    }
        if($erro == 0){
           echo '{"opcao": "mensagem_box", "mensagem" :"sucesso",  "frase" : "Registro Inserido com sucesso"}';
        }elseif($erro > 0 and $sucesso > 0){
           echo '{"opcao": "mensagem_box", "mensagem": "alerta", "frase": "Falha na inserção de alguns registros, por favor verifique sua agenda"}';
        }else{
            echo '{"opcao": "mensagem_box", "mensagem": "erro", "frase": "Falha ao incluir registros, por favor tente novamente."}';
        }
}

add_action('wp_ajax_nopriv_rn_insercao_agenda', 'rn_insercao_agenda');
add_action('wp_ajax_rn_insercao_agenda', 'rn_insercao_agenda');


