<?php 


function api_usuario_post($request){


    $nome =sanitize_text_field($request['nome']);
    $email =sanitize_email($request['email']);
    $senha =sanitize_text_field($request['senha']);

    $user_exists = username_exists($email);
    $email_exists = email_exists($email);

    if(!(!$user_exists && !$email_exists && $senha) ){
       return new WP_Error('email', 'Email já cadastrado.', array('status' => 403));
    }

    wp_create_user($nome, $senha,$email);  

    return rest_ensure_response($response);
}


function registrar_api_usuario_post(){
    register_rest_route('api/v1','/usuario',array(
        array(
            'methods'=>WP_REST_Server::CREATABLE,
            'callback'=>'api_usuario_post',
        )
        )); 
}


add_action('rest_api_init','registrar_api_usuario_post')

?>