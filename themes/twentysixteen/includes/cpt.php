<?php

add_action('init', register_cpt_doc);
//Incluindo Pagina Admin de formatação de post_type documentos
function register_cpt_doc(){
    $label = array(
      'name' => __('Documentos', 'documento'),
      'singular_name' => __('Documento', 'documento'),
      'add_new' => __('Adicionar Novo Documento','documentos'),
      'add_new_item' => __('Adicionar Novo Documento', 'documento'),
      'edit_item' => __('Editar Documento', 'documento'),
      'view_item' => __('Ver Documento', 'documento'),
      'search_items' => __('Localizar Documentos', 'documento'),
      'not_found' => __('Nenhum Documento Encontrado', 'documento'),
      'not_found_in_trash' => __('Nenhum Documento na Lixeira', 'documento'),
      'prent_item_colon' => __('Documento Pai', 'documento'),
      'menu_name' => __('Documento Cliente', 'documento'),
    );
    $args = array(
        'labels' => $label,
        'supports' => array('title', 'thumbnail', 'post-formats'),
        'taxonomies' => array('clientes'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'http://treinamento/wp-content/themes/twentysixteen/imagens/icon-clientes.png',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_form_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
    );
    register_post_type('documento', $args);
}
// Incluindo Categoria para o post Type Documentos
add_action('init', 'register_taxonomy_cliente');

function register_taxonomy_cliente() {
    $labels = array(
        'name' => __('Clientes', 'cliente'),
        'singular_name' => __('Cliente', 'cliente'),
        'search_items' => __('Localizar Cliente', 'cliente'),
        'popular_items' => __('Clientes Populares', 'cliente'),
        'all_items' => __('Todos Clientes', 'cliente'),
        'parent_item' => __('Cliente Pai', 'cliente'),
        'parent_item_colon' => __('Cliente Pai', 'cliente'),
        'edit_item' => __('Editar Cliente', 'cliente'),
        'update_item' => __('Editar Cliente' , 'cliente'),
        'add_new_item' => __('Adicionar Novo Cliente', 'cliente'),
        'new_item_name' => __('Novo Nome de Cliente', 'cliente'),
        'saparate_items_with_commas' => __('Separe Cliente Por Virgula', 'cliente'),
        'add_or_remove_items' => __('Adicionar ou Remover Items', 'cliente'),
        'choose_from_most_used' => __('Escolha entre os mais usados', 'cliente'),
        'menu_name' => __('Clientes', 'cliente')
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true,
    );
    
    register_taxonomy('register_taxonomy_cliente', array('documento'), $args);
    
}

add_filter('manage_edit-documento_columns', 'treinamento_edit_documentos_coluna');

function treinamento_edit_documentos_coluna($colunas){
   
    $colunas = array(
        'cp' => "<input type='checkbox'>",
        'title' => __('Documentos'),
        'author' => __('Autor'),
        'cliente' => __('Cliente'),
        'restrito' => __('Restrito para'),
        'comments' => __('Comentarios'),
        'date' => __('Data')
        
    );
    return $colunas;
}

add_action('manage_documento_posts_custom_column', 'treinamento_manage_documentos_coluna', 10, 2);

function treinamento_manage_documentos_coluna($colunas){
        
    global $post;
    switch($colunas){
        case 'restrito' : echo get_post_meta($post->ID, '_usuario_restrito', true); break;
        case 'cliente' :
        $terms = get_the_terms($post->ID, 'register_taxonomy_cliente');
        if(!empty($terms)){
//            var_dump($terms);
//            echo "<script>alert('Entrei Aqui')</script>";
        $out = array();
        foreach($terms as $term){
            $out[] = sprintf("<a href='%s'>%s</a>",
                    esc_url(add_query_arg(array('post_type' => $post->post_type, 'cliente' => $term->slug), 'edit.php')),
                    esc_html(sanitize_term_field('name', $term->name, $term->id, 'cliente', 'display' ))
                    );
        }
        echo join(',', $out);
        }  else {
            __('Nenhum Cliente');
        }
        break;
        default :
            break;
    }
    
}

