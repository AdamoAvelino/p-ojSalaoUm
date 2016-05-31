<?php
 
add_role('profissionais', 'Profissionais', array('read' => true));
add_role('clientes', 'Clientes', array('read' => true));
//remove_role('grupo_filiado');
//remove_role('grupo_atacado');
//remove_role('grupo_varejo');
function add_remove_contactmethod($contactmethods){
    $contactmethods['telefoneresidencial'] = 'Telefone Residencial';
    $contactmethods['telefonecomercial'] = 'Telefone Comercial';
    $contactmethods['telefonecelular'] = 'Telefone Celular';
    
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    
    return $contactmethods;
}
add_filter('user_contactmethods', 'add_remove_contactmethod', 10, 1);

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
  
function extra_user_profile_fields( $user ) { ?>
<h3><?php _e("Profissão", "blank"); ?></h3>
<table class="form-table">
<tr>
<th><label for="profissao"><?php _e("Qual a atividade profissional"); ?></label></th>
<td>
    <select name="profissao" id="profissao_perigo" class="regular-text" >
        <option value=''>Selecione Uma Atividade</option>
        <option value='1' <?php echo ((esc_attr( get_the_author_meta( 'profissao', $user->ID ) ) == 1) ? 'selected' : ''); ?>>Cabelereiro</option>
        <option value='2' <?php echo ((esc_attr( get_the_author_meta( 'profissao', $user->ID ) ) == 2) ? 'selected' : ''); ?>>Manicure/Pedicure</option>
        <option value="3" <?php echo ((esc_attr( get_the_author_meta( 'profissao', $user->ID ) ) == 3) ? 'selected' : ''); ?>>Esteticista</option>
        <option value='4' <?php echo ((esc_attr( get_the_author_meta( 'profissao', $user->ID ) ) == 4) ? 'selected' : ''); ?>>Podologo</option>
    </select>
</td>
</tr>

</table>
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
 
/* Salva os novos campos */
function save_extra_user_profile_fields( $user_id ) {
 
if (!current_user_can( 'edit_user', $user_id ) ) { return false; }
update_usermeta($user_id, 'profissao', $_POST['profissao']);
//update_usermeta( $user_id, 'cidade', $_POST['cidade'] );
//update_usermeta( $user_id, 'estado', $_POST['estado'] );
//update_usermeta( $user_id, 'cep', $_POST['cep'] );
//update_usermeta( $user_id, 'empresa', $_POST['empresa'] );
//update_usermeta( $user_id, 'cargo', $_POST['cargo'] );
//update_usermeta( $user_id, 'emailcomercial', $_POST['emailcomercial'] );
}


function add_user_columns( $defaults ) {
$defaults['profissao'] = __('Profissional', 'user-column');
//$defaults['telefonecelular'] = __('Celular', 'user-column');
return $defaults;
}
//   Adiciona Nova
function add_custom_user_columns($value, $column_name, $id) {
    $lista_profissional = array(1 => 'Cabelereiro', 2 => 'Manicure/Pedicure', 3 => 'Esteticista', 4 => 'Podologa' );
if( $column_name == 'profissao' ) {
return $lista_profissional[get_the_author_meta( 'profissao', $id )];
}
//if( $column_name == 'empresa' ) {
//return get_the_author_meta( 'empresa', $id );
//}
}
add_action('manage_users_custom_column', 'add_custom_user_columns', 15, 3);
add_filter('manage_users_columns', 'add_user_columns', 15, 1);
  // Remove
add_action('manage_users_columns','remove_user_posts_column');
function remove_user_posts_column($column_headers) {
unset($column_headers['posts']);
return $column_headers;
}