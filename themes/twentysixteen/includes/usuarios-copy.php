<?php

add_role('profissionais', 'Profissionais', array('read' => true));
add_role('clientes', 'Clientes', array('read' => true));

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
<h3><?php _e("Endereço", "blank"); ?></h3>
<table class="form-table">
<tr>
<th><label for="endereco"><?php _e("Rua, nº"); ?></label></th>
<td><input type="text" name="endereco" id="endereco" value="<?php echo esc_attr( get_the_author_meta( 'endereco', $user->ID ) ); ?>" class="regular-text" /></td>
</tr>
<tr>
<th><label for="cidade"><?php _e("Cidade"); ?></label></th>
<td><input type="text" name="cidade" id="cidade" value="<?php echo esc_attr( get_the_author_meta( 'cidade', $user->ID ) ); ?>" class="regular-text" /></td>
</tr>
<tr>
<th><label for="estado"><?php _e("Estado"); ?></label></th>
<td><input type="text" name="estado" id="estado" value="<?php echo esc_attr( get_the_author_meta( 'estado', $user->ID ) ); ?>" class="regular-text" /></td>
</tr>
<tr>
<th><label for="cep"><?php _e("CEP"); ?></label></th>
<td><input type="text" name="cep" id="cep" value="<?php echo esc_attr( get_the_author_meta( 'cep', $user->ID ) ); ?>" class="regular-text" /></td>
</tr>
</table>
<h3><?php _e("Informações Comerciais", "blank"); ?></h3>
  
<table class="form-table">
<tr>
<th><label for="empresa"><?php _e("Empresa"); ?></label></th>
<td><input type="text" name="empresa" id="empresa" value="<?php echo esc_attr( get_the_author_meta( 'empresa', $user->ID ) ); ?>" class="regular-text" /></td>
</tr>
<tr>
<th><label for="cargo"><?php _e("Cargo"); ?></label></th>
<td><input type="text" name="cargo" id="cargo" value="<?php echo esc_attr( get_the_author_meta( 'cargo', $user->ID ) ); ?>" class="regular-text" /></td>
</tr>
<tr>
<th><label for="emailcomercial"><?php _e("Email Comercial"); ?></label></th>
<td><input type="text" name="emailcomercial" id="emailcomercial" value="<?php echo esc_attr( get_the_author_meta( 'emailcomercial', $user->ID ) ); ?>" class="regular-text" /></td>
</tr>
</table>
<?php }
  
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
 
/* Salva os novos campos */
function save_extra_user_profile_fields( $user_id ) {
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
update_usermeta( $user_id, 'endereco', $_POST['endereco'] );
update_usermeta( $user_id, 'cidade', $_POST['cidade'] );
update_usermeta( $user_id, 'estado', $_POST['estado'] );
update_usermeta( $user_id, 'cep', $_POST['cep'] );
update_usermeta( $user_id, 'empresa', $_POST['empresa'] );
update_usermeta( $user_id, 'cargo', $_POST['cargo'] );
update_usermeta( $user_id, 'emailcomercial', $_POST['emailcomercial'] );
}


function add_user_columns( $defaults ) {
$defaults['empresa'] = __('Empresa', 'user-column');
$defaults['telefonecelular'] = __('Celular', 'user-column');
return $defaults;
}
  // Adiciona Nova
function add_custom_user_columns($value, $column_name, $id) {
if( $column_name == 'telefonecelular' ) {
return get_the_author_meta( 'telefonecelular', $id );
}
if( $column_name == 'empresa' ) {
return get_the_author_meta( 'empresa', $id );
}
}
add_action('manage_users_custom_column', 'add_custom_user_columns', 15, 3);
add_filter('manage_users_columns', 'add_user_columns', 15, 1);
  // Remove
add_action('manage_users_columns','remove_user_posts_column');
function remove_user_posts_column($column_headers) {
unset($column_headers['posts']);
return $column_headers;
}