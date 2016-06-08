<?php

function rn_inclui_scripts() {
    if (get_post_type() == 'documento') {
        wp_enqueue_style('fullcalendar_style', get_template_directory_uri() . '/css/fullcalendar.min.css', array(), '20151112');
        wp_enqueue_style('cupertino', get_template_directory_uri() . '/css/cupertino/jquery-ui.min.css', array(), '20151112');
//        wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '20160608');
        wp_enqueue_script('moment', get_template_directory_uri() . '/js/moment.min.js', array('jquery'), '20151112');
        wp_enqueue_script('fullcalendar_script', get_template_directory_uri() . '/js/fullcalendar.js', array('jquery'), '20151112');
        wp_enqueue_script('lang_ptbr', get_template_directory_uri() . '/js/lang/pt-br.js', array('fullcalendar_script'), '20151112');
        wp_enqueue_script('documento', get_template_directory_uri() . '/js/documento.js', array('jquery', 'ajax_agenda'), '20151112');
        
    }
    
}
add_action('wp_head', 'rn_inclui_scripts');
//-----------------------Função para inclusão do Ajax
add_action('wp_footer', 'ajax_javascript');

function ajax_javascript() {
    $script = "<script type='text/javascript'>";
    $script .= "var tentar;";
    $script .= "var ajaxUrl = '" . admin_url('admin-ajax.php') . "';";
    $script .= "</script>";
    echo $script;
    wp_enqueue_script('json2_ag', get_template_directory_uri() . '/js/json2.js', array(), '20160606', true);
    wp_enqueue_script('ajax_agenda', get_template_directory_uri() . '/js/ajax_agenda.js', array('json2_ag'), '', true);
}
//-------------------------------------------------------------------------
//---------------------Função para carregar o combo funcionarios (obsoleta).
function rn_lista_compromisso() {
//    header('content-type: text/xml');
    global $wpdb;
    $usuario = json_decode(str_replace(array("\\"),"",$_REQUEST['dados']));
    $query_b = "SELECT ag.cliente title, CONCAT_WS('T',ag.data,ag.hora_inicio) `start`, CONCAT_WS('T',ag.data,ag.hora_fim) `end` 
FROM wp_agenda ag
JOIN wp_users au ON ag.cliente = au.ID
JOIN wp_usermeta wm ON wm.user_id = au.ID
WHERE wm.meta_key like '%profissao%' and au.ID = {$usuario->usuario}";
    $dataset = $wpdb->get_results($query_b);
    $json  = json_encode($dataset);
    echo  $json;
//    var_dump($dataset);
}

add_action('wp_ajax_nopriv_rn_lista_compromisso', 'rn_lista_compromisso');
add_action('wp_ajax_rn_lista_compromisso', 'rn_lista_compromisso');
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


