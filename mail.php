<?php

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os campos do formulário e remove espaços em branco
    $name = sanitize_input($_POST["cf_name"]);
    $email = sanitize_input($_POST["cf_email"]);
    $message = sanitize_input($_POST["cf_message"]);

    // Valida os campos do formulário
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Retorna um código de resposta 400 (Bad Request) e exibe uma mensagem de erro
        http_response_code(400);
        echo "Erro de validação. Por favor, preencha todos os campos corretamente e tente novamente.";
        exit;
    }

    // Endereço de e-mail do destinatário
    $recipient = "flaviosebastiao302@gmail.com";

    // Assunto do e-mail
    $subject = "Novo contato de $name";

    // Conteúdo do e-mail
    $email_content = "Nome: $name\n";
    $email_content .= "E-mail: $email\n\n";
    $email_content .= "Mensagem:\n$message\n";

    // Cabeçalhos do e-mail
    $email_headers = "From: $name <$email>";

    // Envia o e-mail
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Retorna um código de resposta 200 (OK) e exibe uma mensagem de sucesso
        http_response_code(200);
        echo "Obrigado! Sua mensagem foi enviada com sucesso.";
    } else {
        // Retorna um código de resposta 500 (Internal Server Error) e exibe uma mensagem de erro
        http_response_code(500);
        echo "Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente mais tarde.";
    }
} else {
    // Se a requisição não for do tipo POST, retorna um código de resposta 403 (Forbidden)
    http_response_code(403);
    echo "Houve um problema com o envio do formulário. Por favor, tente novamente.";
}

// Função para remover espaços em branco e caracteres perigosos
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
