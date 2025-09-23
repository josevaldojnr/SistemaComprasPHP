CREATE DATABASE IF NOT EXISTS sistema_compras;
USE sistema_compras;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE requisicao (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    requestor_id BIGINT,
    pricing_id BIGINT NULL,
    buyer_id BIGINT NULL,
    manager_id BIGINT NULL,
    total_cost DECIMAL(12,2),
    status_id INT,
    FOREIGN KEY (requestor_id) REFERENCES users(id),
    FOREIGN KEY (pricing_id) REFERENCES users(id),
    FOREIGN KEY (buyer_id) REFERENCES users(id),
    FOREIGN KEY (manager_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE condicao_pagamentos (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    prazo INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE fornecedores (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(255) NOT NULL,
    fantasia VARCHAR(255) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    cidade VARCHAR(150) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    cnpj VARCHAR(20) NOT NULL,
    telefone VARCHAR(50) NOT NULL,
    contato VARCHAR(120) NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    email VARCHAR(160) NOT NULL,
    condicao_pagamento_id BIGINT NOT NULL,
    created_by VARCHAR(120) NOT NULL,
    updated_by VARCHAR(120) NULL,
    deleted_by VARCHAR(120) NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_fornecedores_condicao_pagamento FOREIGN KEY (condicao_pagamento_id) REFERENCES condicao_pagamentos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categorias (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    deleted_at TIMESTAMP NULL,
    created_by VARCHAR(120) NOT NULL,
    updated_by VARCHAR(120) NULL,
    deleted_by VARCHAR(120) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE setores (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email_responsavel VARCHAR(160) NOT NULL,
    teto_gestor DECIMAL(18,2) NOT NULL,
    teto_diretoria DECIMAL(18,2) NOT NULL,
    created_by VARCHAR(120) NOT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pedidos_compra (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    solicitacao_id BIGINT NOT NULL,
    setor_id BIGINT NOT NULL,
    fornecedor_id BIGINT NULL,
    condicao_pagamento_id BIGINT NULL,
    frete VARCHAR(50) NOT NULL,
    link VARCHAR(255) NULL,
    nivel_impacto VARCHAR(100) NOT NULL,
    prazo_estimado TIMESTAMP NULL,
    mes_pagamento TIMESTAMP NULL,
    fornecedor_unico TINYINT(1) NULL,
    descricao TEXT NULL,
    observacao TEXT NULL,
    observacao_comprador TEXT NULL,
    observacao_fornecedor TEXT NULL,
    valor_frete DECIMAL(18,4) DEFAULT 0,
    imobilizado TINYINT(1) NULL,
    compra_emergencial TINYINT(1) NULL,
    status VARCHAR(50) NULL,
    deleted_at TIMESTAMP NULL,
    created_by BIGINT NOT NULL,
    updated_by BIGINT NULL,
    deleted_by BIGINT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pedidos_compra_solicitacao FOREIGN KEY (solicitacao_id) REFERENCES requisicao(id),
    CONSTRAINT fk_pedidos_compra_setor FOREIGN KEY (setor_id) REFERENCES setores(id),
    CONSTRAINT fk_pedidos_compra_fornecedor FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id),
    CONSTRAINT fk_pedidos_compra_condicao_pagamento FOREIGN KEY (condicao_pagamento_id) REFERENCES condicao_pagamentos(id),
    CONSTRAINT fk_pedidos_compra_created_by FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT fk_pedidos_compra_updated_by FOREIGN KEY (updated_by) REFERENCES users(id),
    CONSTRAINT fk_pedidos_compra_deleted_by FOREIGN KEY (deleted_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO roles (name) VALUES
  ('requisitante'),
  ('pricing'),
  ('compras'),
  ('gerente'),
  ('admin');


