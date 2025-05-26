create database imovel;
use imovel;

CREATE TABLE imovel(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),             
    endereco VARCHAR(200),          
    preco DECIMAL(16,2),           
    tipo VARCHAR(50),                
    quartos INT,          
    banheiros INT,
    area INT,                     
    anexo VARCHAR(250)
);
