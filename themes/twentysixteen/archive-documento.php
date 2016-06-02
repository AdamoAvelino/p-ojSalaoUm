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
               
                    <?php 
                        global $wpdb;
                        
                        $lista_profissao = $wpdb->get_results("Select meta_value, meta_key from wp_usermeta where meta_key like '%profissao%' group by meta_value");
                    ?>
                    <div id='container-form'>
                    <div id='profissional-servico'>
                    <?php
                        $chave = 0;
                        foreach($lista_profissao as $profissao):
                            $chave++;
                            $titulo = explode('-',$profissao->meta_key);
                            $legenda = $titulo[1];
                            echo "<div style='width:32%; float:left; margin-left: 10px'>"
                            . "<fieldset style='height: 100%'>"
                                . "<legend>$legenda</legend>";
                             echo "<select id='profissional-{$chave}'>"
                           . "<option>Selecione Um Profissional</option>";
                                     $lista_profissionais = $wpdb->get_results("SELECT wu.display_name, wu.ID 
from wp_users wu
JOIN wp_usermeta wm ON wm.user_id = wu.ID
WHERE wm.meta_key like '%profissao%' AND wm.meta_value = {$profissao->meta_value} ");
                            foreach($lista_profissionais as $profissional){
                                echo "<option value='$profissional->ID'>{$profissional->display_name}</option>";
                            }
                           echo "</select>";
                            $lista_servicos = $wpdb->get_results("SELECT classe, nome, tempo_execucao FROM wp_servicos where classe='{$profissao->meta_value}'");
                            foreach($lista_servicos as $servico) :
                                echo "<div class='container-servicos-{$chave}' style='width: 50%;  float:left;'>"
                                . "<input type='checkbox' id='{$servico->nome}' name='{$servico->nome}' data-tempo='{$servico->tempo_execucao}' value='{$servico->classe}'>"
                                . "<label style='font-size:12px; line-height: 1;' for='{$servico->nome}'>{$servico->nome}</label>"
                                . "</div>";
                           endforeach;
                           echo "</fieldset>" 
                           . "</div>";
                        endforeach;
                        ?>
                </div>
                <div class="clear"></div>
                <p style="width: 45%; float: left; margin-left: 15px"><label for='data-agenda'>Data</label> <input name='data-agenda' id="data-agenda" class='text-input' type="date"></p>
                <p style="width: 45%; float: left; margin-left: 15px"><label for='hora-agenda'>Hora</label> <input name='hora-agenda' id="hora-agenda" type="time" disabled="disabled" step='1800'/></p>
                <p><button type='button' id='agenda_inclusao'>Incluir Agenda</button></p>
            </form>
        </div>
<?php endif; ?>
       

</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>