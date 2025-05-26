<?php
require_once("../Classes/Imovel.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : "";
    $preco = isset($_POST['preco']) ? $_POST['preco'] : 0;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : "";
    $quartos = isset($_POST['quartos']) ? $_POST['quartos'] : 0;
    $banheiros = isset($_POST['banheiros']) ? $_POST['banheiros'] : 0;
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    $anexo = "";
    if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] == 0) {
        $anexo = PATH_UPLOAD . basename($_FILES['anexo']['name']);
        move_uploaded_file($_FILES['anexo']['tmp_name'], $anexo);
    }

    $imovel = new Imovel($id, $titulo, $endereco, $preco, $tipo, $quartos, $banheiros, $anexo);

    if ($acao == 'salvar') {
        if ($id > 0)
            $resultado = $imovel->alterar();
        else
            $resultado = $imovel->inserir();
    } elseif ($acao == 'excluir') {
        $resultado = $imovel->excluir();
    }

    if ($resultado)
        header("Location: index.php");
    else
        echo "Erro ao salvar dados: " . $imovel;

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $formulario = file_get_contents('form_cad_imovel.html');

    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $resultado = Imovel::listar(1, $id);

    if ($resultado) {
        $imovel = $resultado[0];
        $formulario = str_replace('{id}', $imovel->getId(), $formulario);
        $formulario = str_replace('{titulo}', $imovel->getTitulo(), $formulario);
        $formulario = str_replace('{endereco}', $imovel->getEndereco(), $formulario);
        $formulario = str_replace('{preco}', $imovel->getPreco(), $formulario);
        $formulario = str_replace('{tipo}', $imovel->getTipo(), $formulario);
        $formulario = str_replace('{quartos}', $imovel->getQuartos(), $formulario);
        $formulario = str_replace('{banheiros}', $imovel->getBanheiros(), $formulario);
        $formulario = str_replace('{anexo}', $imovel->getAnexo(), $formulario);
    } else {
        $formulario = str_replace('{id}', 0, $formulario);
        $formulario = str_replace('{titulo}', '', $formulario);
        $formulario = str_replace('{endereco}', '', $formulario);
        $formulario = str_replace('{preco}', '', $formulario);
        $formulario = str_replace('{tipo}', '', $formulario);
        $formulario = str_replace('{quartos}', '', $formulario);
        $formulario = str_replace('{banheiros}', '', $formulario);
        $formulario = str_replace('{anexo}', '', $formulario);
    }

    print($formulario);
    include_once('lista_imovel.php');
}
?>
