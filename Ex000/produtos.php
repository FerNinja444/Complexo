<?php
// 1. Puxa os dados e a estrutura padrão do layout
include 'dados.php';
include 'cabecalho.php';
include 'menu.php';

// 2. Processamento dos dados (cálculos e contagens) antes de exibir qualquer HTML
$quantidadeTotalItens = 0;
foreach ($estoque as $produto) {
    $quantidadeTotalItens += $produto['quantidade'];
}

$totalProdutosDiferentes = count($estoque);
?>

<main style="max-width: 800px; margin: 30px auto; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #ccc;">
    <h2>Lista de Produtos em Estoque</h2>
    <p>Total de produtos diferentes cadastrados: <strong><?php echo $totalProdutosDiferentes; ?></strong></p>

    <table>
        <tr>
            <th>Nome</th>
            <th>Preço (R$)</th>
            <th>Quantidade</th>
            <th>Categoria</th>
        </tr>

        <?php foreach ($estoque as $produto):
            $qtd = $produto['quantidade'];
            
            // Define a cor da linha conforme a quantidade em estoque
            if ($qtd < 5) {
                $estiloLinha = "background-color: #ffcccc; color: #900;"; 
            } elseif ($qtd >= 5 && $qtd < 10) {
                $estiloLinha = "background-color: #fff3cd; color: #856404;"; 
            } else {
                $estiloLinha = "background-color: #d4edda; color: #155724;"; 
            }
        ?>
            <tr style="<?php echo $estiloLinha; ?>">
                <td><?php echo $produto['nome']; ?></td>
                <td><?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                <td><?php echo $qtd; ?></td>
                <td><?php echo $produto['categoria']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <?php 
    if ($quantidadeTotalItens > 0):
        echo "<p>Total geral de itens em estoque: <strong>$quantidadeTotalItens</strong></p>";
    else:
        echo "<p>Não há produtos em estoque.</p>";
    endif;
    ?>
</main>

<?php 
// 3. Finaliza com o rodapé padrão
include 'rodape.php'; 
?>