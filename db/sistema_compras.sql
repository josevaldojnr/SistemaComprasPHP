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
    total_cost DECIMAL(6,2),
    status_id INT,
    FOREIGN KEY (requestor_id) REFERENCES users(id),
    FOREIGN KEY (pricing_id) REFERENCES users(id),
    FOREIGN KEY (buyer_id) REFERENCES users(id),
    FOREIGN KEY (manager_id) REFERENCES users(id)
);


INSERT INTO roles (name) VALUES
  ('requisitante'),
  ('pricing'),
  ('compras'),
  ('gerente'),
  ('admin');