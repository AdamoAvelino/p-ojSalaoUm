<?php
// Template Name: Area de Registro
/* Carrega o arquivo de registro. */
require_once( ABSPATH . WPINC . '/registration.php' );

/* Checa se o registro está ativado. */
$registration = get_option('users_can_register');

/* Se o usuário se registrar, incui as informações padrão. */
if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'adduser') {
    $user_pass = wp_generate_password();
    $userdata = array(
        'user_pass' => $user_pass,
        'user_login' => esc_attr($_POST['user_name']),
        'first_name' => esc_attr($_POST['first_name']),
        'last_name' => esc_attr($_POST['last_name']),
        'nickname' => esc_attr($_POST['nickname']),
        'user_email' => esc_attr($_POST['email']),
        'user_url' => esc_attr($_POST['website']),
        'description' => esc_attr($_POST['description']),
        'role' => get_option('default_role'),
    );

    if (!$userdata['user_login'])
        $error = __('Você precisa escolher um nome de usuário para se registrar.', 'frontendprofile');
    elseif (username_exists($userdata['user_login']))
        $error = __('Esse nome de usuário já existe!', 'frontendprofile');

    elseif (!is_email($userdata['user_email'], true))
        $error = __('Você deve digitar um email válido.', 'frontendprofile');
    elseif (email_exists($userdata['user_email']))
        $error = __('Esse email já está sendo usado!', 'frontendprofile');

    else { /* Inclui as informações dos novos campos personalizados */
        $new_user = wp_insert_user($userdata);
        wp_new_user_notification($new_user, $user_pass);
        update_usermeta($new_user, 'residenciatelefone', esc_attr($_POST['residenciatelefone']));
        update_usermeta($new_user, 'comercialtelefone', esc_attr($_POST['comercialtelefone']));
        update_usermeta($new_user, 'celulartelefone', esc_attr($_POST['celulartelefone']));
        update_usermeta($new_user, 'celulartelefone', esc_attr($_POST['celulartelefone']));
        update_usermeta($new_user, 'endereco', esc_attr($_POST['endereco']));
        update_usermeta($new_user, 'cidade', esc_attr($_POST['cidade']));
        update_usermeta($new_user, 'estado', esc_attr($_POST['estado']));
        update_usermeta($new_user, 'cep', esc_attr($_POST['cep']));
        update_usermeta($new_user, 'empresa', esc_attr($_POST['empresa']));
        update_usermeta($new_user, 'cargo', esc_attr($_POST['cargo']));
        update_usermeta($new_user, 'emailcomercial', esc_attr($_POST['emailcomercial']));
    }
}
get_header()
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->



    <div class="entry-content">
        <?php
        the_content();
        ?>
    </div><!-- .entry-content -->
</article>
<?php if (is_user_logged_in() && !current_user_can('create_users')) : ?>
    <div class='log-in-out alerta'>
        <p><?php printf(__('Você já está logado como: <a href="%1$s">%2$s</a>, Não é necessário o registro', 'paginalogin'), get_author_posts_url(get_the_author_meta('id')), get_the_author()) ?></p>
        <p>O que Deseja Fazer</p>
        <ul>
            <li><a href="<?php echo home_url('/') ?>">Ir para home</a></li>
            <li><a href='<?php echo wp_logout_url(get_permalink()) ?>'> <?php echo __('Sair desta conta', 'paginalogin') ?></a></li>
            <li><a href="<?php echo admin_url() . 'profile.php' ?>"><?php echo __('Alerar meudados', 'paginalogin') ?></a></li>
        </ul>
    </div>
<?php elseif ($newuser) : ?>
    <div class='alerta'>
        <p>
            <?php
            if (current_user_can('create_users')) {
                printf('Uma conta de usuário para %1$s foi criada com sucesso', $_POST['user-name']);
            } else {
                printf('Obrigado por se registrar em nosso site %1$s', $_POST['user-name']);
                printf('Por Favor, verifique se um e-mail foi enviado para sua caixa de entrada(%1$s).  Caso não encontre verifique a caixa de span' . $_POST['email']);
            }
            ?>
        </p>
    </div>
    <?php
else :
    if ($error) :
        ?>
        <p><?php echo $error ?></p> 
        <?php
    endif;
endif;
?>
<?php if (current_user_can('create_user') && $registration) : ?>
    <div class="alerta">
        <p><?php echo __('Você pode registrar um usuairio ou pedir para que se registre nesta pagina de login'); ?></p>
    </div>
<?php endif; ?>

<?php if ($registration || current_user_can('create_user')) : ?>
    <form method='post' action='http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>' id="adduser" class='user-forms'>
        <p class="form-username">
            <label for="user_name"><?php _e('Login de Usuário (obrigatório)', 'frontendprofile'); ?></label>
            <input class="text-input" name="user_name" type="text" id="user_name" value="<?php if ($error) echo wp_specialchars($_POST['user_name'], 1); ?>" />
        </p><!-- .form-username -->

        <p class="first_name">
            <label for="first_name"><?php _e('Primeiro Nome', 'frontendprofile'); ?></label>
            <input class="text-input" name="first_name" type="text" id="first_name" value="<?php if ($error) echo wp_specialchars($_POST['first_name'], 1); ?>" />
        </p><!-- .first_name -->

        <p class="last_name">
            <label for="last_name"><?php _e('Sobrenome', 'frontendprofile'); ?></label>
            <input class="text-input" name="last_name" type="text" id="last_name" value="<?php if ($error) echo wp_specialchars($_POST['last_name'], 1); ?>" />
        </p><!-- .last_name -->

        <p class="nickname">
            <label for="nickname"><?php _e('Apelido', 'frontendprofile'); ?></label>
            <input class="text-input" name="nickname" type="text" id="nickname" value="<?php if ($error) echo wp_specialchars($_POST['nickname'], 1); ?>" />
        </p><!-- .nickname -->

        <strong>Informações de Contato</strong>

        <p class="form-email">
            <label for="email"><?php _e('E-mail (obrigatório)', 'frontendprofile'); ?></label>
            <input class="text-input" name="email" type="text" id="email" value="<?php if ($error) echo wp_specialchars($_POST['email'], 1); ?>" />
        </p><!-- .form-email -->

        <p class="form-website">
            <label for="website"><?php _e('Endereço de seu site', 'frontendprofile'); ?></label>
            <input class="text-input" name="website" type="text" id="website" value="<?php if ($error) echo wp_specialchars($_POST['website'], 1); ?>" />
        </p><!-- .form-website -->

        <p class="form-residenciatelefone">
            <label for="residenciatelefone"><?php _e('Telefone Residencial', 'frontendprofile'); ?></label>
            <input class="text-input" name="residenciatelefone" type="text" id="residenciatelefone" value="<?php if ($error) echo wp_specialchars($_POST['residenciatelefone'], 1); ?>" />
        </p><!-- .form-residenciatelefone -->

        <p class="form-comercialtelefone">
            <label for="comercialtelefone"><?php _e('Telefone Comercial', 'frontendprofile'); ?></label>
            <input class="text-input" name="comercialtelefone" type="text" id="comercialtelefone" value="<?php if ($error) echo wp_specialchars($_POST['comercialtelefone'], 1); ?>" />
        </p><!-- .form-comercialtelefone -->

        <p class="form-celulartelefone">
            <label for="celulartelefone"><?php _e('Telefone Celular', 'frontendprofile'); ?></label>
            <input class="text-input" name="celulartelefone" type="text" id="celulartelefone" value="<?php if ($error) echo wp_specialchars($_POST['celulartelefone'], 1); ?>" />
        </p><!-- .form-celulartelefone -->

        <strong>Sobre Você</strong>

        <p class="form-description">
            <label for="description"><?php _e('Algumas informações a seu respeito', 'frontendprofile'); ?></label>
            <textarea class="text-input" name="description" id="description" rows="5" cols="30"><?php if ($error) echo wp_specialchars($_POST['description'], 1); ?></textarea>
        </p><!-- .form-description -->

        <strong>Endereço</strong>

        <p class="form-endereco">
            <label for="endereco"><?php _e('Rua, nº', 'frontendprofile'); ?></label>
            <input class="text-input" name="endereco" type="text" id="endereco" value="<?php if ($error) echo wp_specialchars($_POST['endereco'], 1); ?>" />
        </p><!-- .form-endereco -->

        <p class="form-cidade">
            <label for="cidade"><?php _e('Cidade', 'frontendprofile'); ?></label>
            <input class="text-input" name="cidade" type="text" id="cidade" value="<?php if ($error) echo wp_specialchars($_POST['cidade'], 1); ?>" />
        </p><!-- .form-cidade -->

        <p class="form-estado">
            <label for="estado"><?php _e('Estado', 'frontendprofile'); ?></label>
            <input class="text-input" name="estado" type="text" id="estado" value="<?php if ($error) echo wp_specialchars($_POST['estado'], 1); ?>" />
        </p><!-- .form-estado -->

        <p class="form-cep">
            <label for="cep"><?php _e('CEP', 'frontendprofile'); ?></label>
            <input class="text-input" name="cep" type="text" id="cep" value="<?php if ($error) echo wp_specialchars($_POST['cep'], 1); ?>" />
        </p><!-- .form-cep -->

        <strong>Informações Comerciais</strong>
        <p class="form-empresa">
            <label for="empresa"><?php _e('Empresa', 'frontendprofile'); ?></label>
            <input class="text-input" name="empresa" type="text" id="empresa" value="<?php if ($error) echo wp_specialchars($_POST['empresa'], 1); ?>" />
        </p><!-- .form-empresa -->

        <p class="form-cargo">
            <label for="cargo"><?php _e('Cargo', 'frontendprofile'); ?></label>
            <input class="text-input" name="cargo" type="text" id="cargo" value="<?php if ($error) echo wp_specialchars($_POST['cargo'], 1); ?>" />
        </p><!-- .form-cargo -->

        <p class="form-emailcomercial">
            <label for="emailcomercial"><?php _e('Email Comercial', 'frontendprofile'); ?></label>
            <input class="text-input" name="emailcomercial" type="text" id="emailcomercial" value="<?php if ($error) echo wp_specialchars($_POST['emailcomercial'], 1); ?>" />
        </p><!-- .form-emailcomercial -->


        <p class="form-submit">
            <?php echo $referer; ?>
            <!-- Condicionais dentro do "input" - quando um administrador estiver criando um usuário, mostra "Adicionar Usuário", quando um usuário estiver se registrando mostra "Registrar-se" -->
            <input name="adduser" type="submit" id="addusersub" class="submit button" value="<?php if (current_user_can('create_users'))
            _e('Adicionar Usuário', 'frontendprofile');
        else
            _e('Registrar', 'frontendprofile');
        ?>" />
    <?php wp_nonce_field('add-user') ?>
            <input name="action" type="hidden" id="action" value="adduser" />
        </p><!-- .form-submit -->

    </form><!-- #adduser -->
    <!-- FINALIZA O HTML DO FORMULÁRIO -->

<?php endif; ?>

<?php
global $user_ID, $user_identity;
//        get_currentuserinfo(); 
echo $user_ID . '-' . $user_identity;


get_sidebar();
get_footer();
?>








