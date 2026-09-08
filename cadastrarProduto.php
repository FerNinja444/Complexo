<?php 
// 1. Carrega os dados, cabeçalho e menu
include 'dados.php';
include 'cabecalho.php';
include 'menu.php';

// 2. Lógica de cadastro e atualização de estoque via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = (float) ($_POST['preco'] ?? 0);
    $quantidade = (int) ($_POST['quantidade'] ?? 0);
    $categoria = $_POST['categoria'] ?? '';

    $encontrado = false;
    $estoque = $estoque ?? [];
    
    // Verifica se o produto já existe para somar a quantidade
    foreach ($estoque as &$produto) {
        if (strtolower($produto['nome']) === strtolower($nome)) {
            $produto['quantidade'] += $quantidade;
            // Atualiza o preço e categoria para o mais recente digitado (opcional)
            $produto['preco'] = $preco; 
            $produto['categoria'] = $categoria;
            $encontrado = true;
            break;  
        }
    }
    
    // Se não encontrou, cadastra um novo item
    if (!$encontrado) {
        $estoque[] = [
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade,
            'categoria' => $categoria
        ];
    }

    // Salva o array atualizado de volta no arquivo dados.php
    
    $textoArray = var_export($estoque, true);
    $conteudoArquivo = "<?php\n\n\$estoque = " . $textoArray . ";\n\n?>";
    
    // Tenta salvar e avisa na tela se for bloqueado
    if (file_put_contents('dados.php', $conteudoArquivo) === false) {
        die("<h2 style='color:red; text-align:center;'>ERRO DE PERMISSÃO: O PHP foi bloqueado pelo Linux e não conseguiu salvar no arquivo dados.php. Rode 'chmod 777 dados.php' no terminal.</h2>");
    }

    // REDIRECIONAMENTO AUTOMÁTICO
    header("Location: produtos.php");
    exit; // Interrompe a execução para o redirecionamento funcionar limpo
}
?>

<main style="max-width: 800px; margin: 30px auto; background: #fff; padding: 50px; border-radius: 8px; border: 1px solid #ccc;">
    <h1><strong>Cadastrar Produto</strong></h1>
    
    <form method="POST" action="">
        <div style="margin-bottom: 15px;">
            <label for="nome">Nome do Produto:</label><br>
            <input type="text" id="nome" name="nome" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="preco">Preço:</label><br>
            <input type="number" id="preco" name="preco" step="0.01" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="quantidade">Quantidade:</label><br>
            <input type="number" id="quantidade" name="quantidade" min="0" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="categoria">Categoria:</label><br>
            <input type="text" id="categoria" name="categoria" required style="width: 100%; padding: 8px;">
        </div>
        
        <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Cadastrar</button>
    </form>
</main>

<?php include 'rodape.php'; ?>