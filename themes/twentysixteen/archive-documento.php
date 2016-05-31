<?php get_header(); ?>
<article id='content' role='main' class="content-area">
    <?php global $user_ID, $user_identity;
//    echo admin_url('admin-ajax.php');
    get_currentuserinfo();
    if (!$user_ID) :
        ?>
        <div class='nao-logado'>
            <p>Faça o login para ver sua pagina</p>
    <?php $args = array('label_username' => 'Usuario', 'redirect' => site_url('/documento/')); ?>
    <?php wp_login_form($args); ?>
            <div class="clear"></div>
            <p>Ainda não possui registro?</p>
            <a href='<?php echo home_url('/registro/'); ?>'>Registre-se</a>
            <div class="clear"></div>
        </div> <!--Fim da classe não logado-->
<?php else : ?>
        <div class='logado'>
            <p>Olá <?php echo $user_identity ?></p>
            <p><blockquote>Vamos agendar uma hora para cuidar de você?</blockquote></p>
            <div class="clear"></div>
            <form class='user-forms' method="post">
                <p>
                <select name='servico' id='servico'>
                    <option>Selecione Um Servico</option>
                    <?php 
                        global $wpdb;
                        $lista_servicos = $wpdb->get_results('SELECT classe, nome FROM wp_servicos');
                        foreach($lista_servicos as $servico) :
                    ?>
                    <option value="<?php  echo $servico->classe ?>"><?php  echo $servico->nome ?></option>    
                    <?php endforeach; ?>
                </select>
                </p>
                <p>
                <select id='profissional'>
                    <option>Selecione Um Profissional</option>
                </select>
                </p>
                <p><label for='data-agenda'>Data</label> <input name='data-agenda' class='text-input' type="date"></p>
                <p><label for='hora-agenda'>Hora</label> <input name='hora-agenda' type="datetime" class='text-input'/></p>
            </form>
        </div>
<?php endif; ?>
       

</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>