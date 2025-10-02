CREATE DATABASE IF NOT EXISTS sistema_compras;
USE sistema_compras;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO roles (name) VALUES
  ('requisitante'),
  ('pricing'),
  ('compras'),
  ('gerente'),
  ('admin');

CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE categorias (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO categorias (nome) VALUES
  ('Matérias-Primas'),
  ('Equipamentos'),
  ('Embalagens'),
  ('Produtos Químicos'),
  ('Serviços');


CREATE TABLE produtos (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(7,2) NOT NULL,
    categoria_id BIGINT NOT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_produtos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO produtos (nome, preco, categoria_id) VALUES
  ('Lúpulo', 50.00, 1),
  ('Malte', 30.00, 1),
  ('Levedura', 20.00, 1),
  ('Tanque de Fermentação', 5000.00, 2),
  ('Máquina de Envase', 15000.00, 2),
  ('Garrafas de Vidro', 0.50, 3),
  ('Tampas Metálicas', 0.10, 3),
  ('Detergente Alcalino', 100.00, 4),
  ('Serviço de Transporte', 500.00, 5),
  ('Empilhadeira', 20000.00, 2),
  ('Palete de Madeira', 50.00, 3),
  ('Caixa Plástica', 30.00, 3),
  ('Cinta de Amarração', 15.00, 3),
  ('Serviço de Transporte', 500.00, 5),
  ('Cadeira de Escritório', 300.00, 2),
  ('Mesa de Escritório', 500.00, 2),
  ('Papel A4', 20.00, 3),
  ('Toner para Impressora', 150.00, 4),
  ('Serviço de Limpeza', 200.00, 5),
  ('Teclado', 100.00, 2),
  ('Mouse', 50.00, 2),
  ('Monitor', 800.00, 2),
  ('Notebook', 5000.00, 2),
  ('Roteador', 300.00, 2);

CREATE TABLE setores (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO setores (nome) VALUES
  ('Produção'),
  ('Logística'),
  ('Administrativo'),
  ('TI');


CREATE TABLE requisicao (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    requestor_id BIGINT,
    pricing_id BIGINT NULL,
    buyer_id BIGINT NULL,
    manager_id BIGINT NULL,
    total_cost DECIMAL(7,2),
    setor_id BIGINT NOT NULL,
    status_id INT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_requisicao_setor FOREIGN KEY (setor_id) REFERENCES setores(id),
    CONSTRAINT fk_requisicao_requestor FOREIGN KEY (requestor_id) REFERENCES users(id),
    CONSTRAINT fk_requisicao_pricing FOREIGN KEY (pricing_id) REFERENCES users(id),
    CONSTRAINT fk_requisicao_buyer FOREIGN KEY (buyer_id) REFERENCES users(id),
    CONSTRAINT fk_requisicao_manager FOREIGN KEY (manager_id) REFERENCES users(id)
);

INSERT INTO requisicao (requestor_id, total_cost, setor_id, status_id)
VALUES
  (1, 1000.00, 1, 1),
  (1, 500.00, 2, 1),
  (1, 2000.00, 3, 1);


CREATE TABLE requisicao_produtos (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    requisicao_id BIGINT,
    produto_id BIGINT,
    quantidade INT,
    subtotal DECIMAL(7,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (requisicao_id) REFERENCES requisicao(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

INSERT INTO requisicao_produtos (requisicao_id, produto_id, quantidade, subtotal)
VALUES
  (1, 1, 10, 500.00),
  (1, 2, 5, 150.00),
  (2, 3, 20, 400.00),
  (2, 4, 1, 500.00),
  (3, 5, 2, 1000.00),
  (3, 6, 50, 25.00);


-- A SER IMPLEMENTADO RELAÇAO DE CONDIÇAO DE PAGAMENTOS E FORNECEDORES--
CREATE TABLE condicao_pagamentos (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    prazo INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE fornecedores (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(255) NOT NULL,
    cnpj VARCHAR(20) NOT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);











