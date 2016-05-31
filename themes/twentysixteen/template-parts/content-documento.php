<article id='content' role='main'>
    <?php global $user_ID, $user_identity;
    get_currentuserinfo();
    if (!$user_ID) :
        ?>
        <div class='nao-logado'>
            <p>Faça o login para ver sua pagina</p>
    <?php $args = array('label_username' => 'Usuario', 'redirect' => site_url('/documentos/')); ?>
    <?php wp_login_form($args); ?>
            <div class="clear"></div>
            <p>Ainda não possui registro?</p>
            <a href='<?php echo home_url('/registro/'); ?>'>Registre-se</a>
            <div class="clear"></div>
        </div> <!--Fim da classe não logado-->
<?php else : ?>
        <div class='logado'>
            <p>Você Está logado como: <?php echo $user_identity ?></p>
            <p>O que deseja Fazer?</p>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Ir para a Página Inicial</a></li>
                <?php if (current_user_can('edit_posts')) { ?>
                <li><?php echo'<a href="' . admin_url() . '">' . __('Ir para Administração do Site') . '</a>'; ?>
                <?php } else { ?>
                <li><?php echo '<a href="' . admin_url() . 'profile.php">' . __('Alterar meus dados') . '</a>'; ?></li>
    <?php } ?>
                <li><a href="<?php echo wp_logout_url('documentos'); // ao fazer logout, volta para a página documentos  ?>">Logout</a></li>
            </ul>
            <br />
            <div class="clear"></div>
            <?php if(current_user_can('edit_posts')) :?>
            <div class='lista-admin'>
                <p>Esta é uma lista de todos os documentos restritos, apenas usuaios com permisões avançadas podem acessa-las</p>
                <?php if(have_posts()) : while(have_posts) : the_post(); 
                echo the_title();
                ?>
                
                <?php endwhile; endif;?>
            </div>
            
            <?php endif; ?>
        </div>
<?php endif; ?>

</article>