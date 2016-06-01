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
                    <?php 
                        global $wpdb;
                        
                        $lista_profissao = $wpdb->get_results("Select meta_value, meta_key from wp_usermeta where meta_key like '%profissao%' group by meta_value");
                    ?>
                        <div>
                    <?php
                        foreach($lista_profissao as $profissao):
                            $titulo = explode('-',$profissao->meta_key);
                            $legenda = $titulo[1];
                            echo "<div style='width:32%; float:left; margin-left: 10px'>"
                            . "<fieldset style='height: 100%'>"
                                . "<legend>$legenda</legend>";
                            $lista_servicos = $wpdb->get_results("SELECT classe, nome FROM wp_servicos where classe='{$profissao->meta_value}'");
                            foreach($lista_servicos as $servico) :
                                echo "<div style='width: 50%;  float:left;'>"
                                . "<input type='checkbox' name='{$servico->nome}'>"
                                . "<label style='font-size:12px; line-height: 1;' for='{$servico->nome}'>{$servico->nome}</label>"
                                . "</div>";
                           endforeach;
                            echo "<select id='profissional'>
                                    <option>Selecione Um Profissional</option>
                                </select></fieldset>" 
                           
                           . "</div>";
                        endforeach;
                        ?>
                            
                </p>
                <div class="clear"></div>
                <p style="width: 45%; float: left; margin-left: 15px"><label for='data-agenda'>Data</label> <input name='data-agenda' class='text-input' type="date"></p>
                <p style="width: 45%; float: left; margin-left: 15px"><label for='hora-agenda'>Hora</label> <input name='hora-agenda' type="datetime" class='text-input'/></p>
            </form>
        </div>
<?php endif; ?>
       

</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>