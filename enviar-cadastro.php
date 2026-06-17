<?php
header('Content-Type: application/json; charset=utf-8');

$destino = 'runningbeatloja@gmail.com';

$nome  = isset($_POST['nome'])  ? trim($_POST['nome'])  : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if ($nome === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'erro' => 'Dados inválidos.']);
    exit;
}

$nome = str_replace(["\r", "\n"], '', $nome);

$assunto = 'Novo cadastro - Running Beat';
$corpo   = "Novo cadastro recebido pelo site:\n\nNome: {$nome}\nE-mail: {$email}\n";

$headers = "From: Running Beat <nao-responder@" . $_SERVER['HTTP_HOST'] . ">\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

$enviado = mail($destino, $assunto, $corpo, $headers);

if ($enviado) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'erro' => 'Falha ao enviar.']);
}
