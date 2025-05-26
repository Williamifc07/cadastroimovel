<?php
    require_once("../Classes/Imovel.class.php");

    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = Imovel::listar($tipo, $busca);
    $itens = '';
    foreach($lista as $imovel){
        $item = file_get_contents('itens_listagem_imovel.html');
        $item = str_replace('{id}', $imovel->getId(), $item);
        $item = str_replace('{titulo}', $imovel->getTitulo(), $item);
        $item = str_replace('{endereco}', $imovel->getEndereco(), $item);
        $item = str_replace('{preco}', number_format($imovel->getPreco(), 2, ',', '.'), $item);
        $item = str_replace('{tipo}', $imovel->getTipo(), $item);
        $item = str_replace('{quartos}', $imovel->getQuartos(), $item);
        $item = str_replace('{banheiros}', $imovel->getBanheiros(), $item);
        $item = str_replace('{anexo}', $imovel->getAnexo(), $item);
        $itens .= $item;
    }

    $listagem = file_get_contents('listagem_imovel.html');
    $listagem = str_replace('{itens}', $itens, $listagem);
    print($listagem);
?>
