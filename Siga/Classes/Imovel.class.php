<?php
require_once("Database.class.php");

class Imovel {
    private $id;
    private $titulo;
    private $endereco;
    private $preco;
    private $tipo;
    private $quartos;
    private $banheiros;
    private $anexo;

    // Construtor
    public function __construct($id, $titulo, $endereco, $preco, $tipo, $quartos, $banheiros, $anexo) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->endereco = $endereco;
        $this->preco = $preco;
        $this->tipo = $tipo;
        $this->quartos = $quartos;
        $this->banheiros = $banheiros;
        $this->anexo = $anexo;
    }

    public function setId($id) {
        if ($id < 0) throw new Exception("Erro: ID inválido.");
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        if (empty($titulo)) throw new Exception("Erro: o título deve ser informado.");
        $this->titulo = $titulo;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setPreco($preco) {
        if ($preco < 0) throw new Exception("Erro: preço inválido.");
        $this->preco = $preco;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setQuartos($quartos) {
        $this->quartos = $quartos;
    }

    public function setBanheiros($banheiros) {
        $this->banheiros = $banheiros;
    }

    public function setAnexo($anexo = '') {
        $this->anexo = $anexo;
    }

    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getEndereco() { return $this->endereco; }
    public function getPreco() { return $this->preco; }
    public function getTipo() { return $this->tipo; }
    public function getQuartos() { return $this->quartos; }
    public function getBanheiros() { return $this->banheiros; }
    public function getAnexo() { return $this->anexo; }

    public function __toString(): string {
        return "Imóvel ID {$this->id}: {$this->titulo}, {$this->tipo}, R$ {$this->preco}, {$this->endereco}, Quartos: {$this->quartos}, Banheiros: {$this->banheiros}, Anexo: {$this->anexo}";
    }

    // Inserir imóvel no banco
    public function inserir(): bool {
        $sql = "INSERT INTO imovel (titulo, endereco, preco, tipo, quartos, banheiros, anexo)
                VALUES (:titulo, :endereco, :preco, :tipo, :quartos, :banheiros, :anexo)";
        $parametros = [
            ':titulo' => $this->getTitulo(),
            ':endereco' => $this->getEndereco(),
            ':preco' => $this->getPreco(),
            ':tipo' => $this->getTipo(),
            ':quartos' => $this->getQuartos(),
            ':banheiros' => $this->getBanheiros(),
            ':anexo' => $this->getAnexo()
        ];
        return Database::executar($sql, $parametros) == true;
    }

    // Listar imóveis
    public static function listar($tipo = 0, $info = ''): array {
        $sql = "SELECT * FROM imovel";
        switch ($tipo) {
            case 1:
                $sql .= " WHERE id = :info ORDER BY id";
                break;
            case 2:
                $sql .= " WHERE titulo LIKE :info ORDER BY titulo";
                $info = '%' . $info . '%';
                break;
        }

        $parametros = ($tipo > 0) ? [':info' => $info] : [];
        $comando = Database::executar($sql, $parametros);

        $imoveis = [];
        while ($registro = $comando->fetch()) {
            $imovel = new Imovel(
                $registro['id'],
                $registro['titulo'],
                $registro['endereco'],
                $registro['preco'],
                $registro['tipo'],
                $registro['quartos'],
                $registro['banheiros'],
                $registro['anexo']
            );
            $imoveis[] = $imovel;
        }

        return $imoveis;
    }

    // Alterar imóvel
    public function alterar(): bool {
        $sql = "UPDATE imovel SET 
                    titulo = :titulo,
                    endereco = :endereco,
                    preco = :preco,
                    tipo = :tipo,
                    quartos = :quartos,
                    banheiros = :banheiros,
                    anexo = :anexo
                WHERE id = :id";
        $parametros = [
            ':id' => $this->getId(),
            ':titulo' => $this->getTitulo(),
            ':endereco' => $this->getEndereco(),
            ':preco' => $this->getPreco(),
            ':tipo' => $this->getTipo(),
            ':quartos' => $this->getQuartos(),
            ':banheiros' => $this->getBanheiros(),
            ':anexo' => $this->getAnexo()
        ];
        return Database::executar($sql, $parametros) == true;
    }

    // Excluir imóvel
    public function excluir(): bool {
        $sql = "DELETE FROM imovel WHERE id = :id";
        $parametros = [':id' => $this->getId()];
        return Database::executar($sql, $parametros) == true;
    }
}
?>
