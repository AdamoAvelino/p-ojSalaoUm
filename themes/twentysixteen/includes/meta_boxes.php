<?php
//-----------------------------------------------------------------------------------------------------------------------------------------
//Criando Metabox Campo Nome de Usuario

function meta_boxe_documento(){
    add_meta_box('campo_nome_cliente',
          'Digite os dados do cliente',
          'funcao_metabox_cliente', //Função para carregar os campos do metabox
          'documento',
          'normal',
          'default'
        );
}
//@Função pra montar os campos do metabox
function funcao_metabox_cliente($objeto, $campo){
//    wp_nonce_field(basename(__FILE__), 'nome_cliente_nonce');
	?>
	<p>
    	<label for="nome-cliente">
        	Nome do Cliente
        </label>
    </p>
    <p>
    	<input type="text" name="nome_cliente"  value="<?php echo esc_attr(get_post_meta($objeto->ID, '_nome_cliente', true)); ?>" size="30">
    </p>
    <?php  
}
add_action('add_meta_boxes', 'meta_boxe_documento');

//@Função para salvar os valores do Metabox
function salvar_documento_cliente($filme_id, $film){
//    var_dump($_POST);
    if ( ! $_POST['nome_cliente'] ) return;
    update_post_meta($filme_id, '_nome_cliente', strip_tags($_POST['nome_cliente']));
    return true;
    
}
add_action('save_post', 'salvar_documento_cliente', 10, 2);

//-----------------------------------------------------------------------------------------------------------------------------------------
//Criando Metabox de listagem de permissões
function metabox_permissao_usuario(){
    add_meta_box(
                'campo_restrito_usuario',
                'Selecione Quem pode acessar este post',
                'funcao_meta_box_restrito',
                'documento',
                'side',
                'default'
            );
}

function funcao_meta_box_restrito($objeto, $campo){
    ?>
    <label for='usuario_restrito'>Selecione Um Grupo de Usuarios</label>
    <select name='usuario_restrito'>
        <option>Selecione...</option>
        <?php
            $roles = new WP_Roles();
            foreach($roles->role_names as $role => $name){
                ?>
                    <option value="<?php echo $role ?>" <?php echo ((esc_attr(get_post_meta($objeto->ID, '_usuario_restrito', true)) == $role) ? 'selected' : '') ?>> <?php echo $role ?> </option>
                <?php 
            }
        ?>
    
    </select>
    <?php
}
add_action('add_meta_boxes', 'metabox_permissao_usuario');

function salvar_restricao_acesso($restricao_id, $restricao){
//    var_dump($_POST);
    update_post_meta($restricao_id, '_usuario_restrito', strip_tags($_POST['usuario_restrito']));
    return true;
}

add_action('save_post', 'salvar_restricao_acesso', 10, 2);


?>

