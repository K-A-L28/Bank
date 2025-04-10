CREATE DATABASE banco;

USE banco;

CREATE TABLE cuenta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    saldo DECIMAL(10, 2) NOT NULL DEFAULT 0
);

-- Creamos una cuenta base con saldo 0
INSERT INTO cuenta (saldo) VALUES (0.00);
