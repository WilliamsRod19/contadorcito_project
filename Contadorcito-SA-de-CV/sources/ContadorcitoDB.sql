Create database ContadorcitoDB;
USE ContadorcitoDB;

-- Crear la tabla tbl_TipoEmpresa
CREATE TABLE tbl_TipoEmpresa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) Not null
);

-- Insertar los valores únicos para los tipos de empresa
INSERT INTO tbl_TipoEmpresa (tipo)
VALUES ('Natural'), ('Jurídica');

-- Crear la tabla tbl_Empresas con la relación a tbl_TipoEmpresa
CREATE TABLE tbl_Empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo_empresa_id INT NOT NULL,
    direccion TEXT,
    telefono VARCHAR(20),
    email VARCHAR(100),
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_empresa_id) REFERENCES tbl_TipoEmpresa(id)
);

INSERT INTO tbl_Empresas 
(nombre, tipo_empresa_id, direccion, telefono, email)
VALUES
('Empresa Alpha', 1, 'Av. Principal 123, Ciudad Central', '555-1234', 'contacto@empresaalpha.com'),
('Empresa Beta', 2, 'Calle Secundaria 456, Zona Industrial', '555-5678', 'info@empresabeta.com'),
('Empresa Gamma', 1, 'Blvd. Empresarial 789, Centro Corporativo', '555-9876', 'soporte@empresagamma.com'),
('Empresa Delta', 2, 'Parque Empresarial 321, Ciudad Nueva', '555-6543', 'ventas@empresadelta.com'),
('Empresa Epsilon', 1, 'Av. Tecnológica 111, Edificio 5', '555-7890', 'admin@empresaepsilon.com'),
('Empresa Zeta', 2, 'Calle Innovación 222, Torre Norte', '555-4321', 'gerencia@empresazeta.com'),
('Empresa Eta', 1, 'Zona Franca 333, Edificio Logístico', '555-3456', 'logistica@empresaeta.com'),
('Empresa Theta', 2, 'Parque Industrial 444, Planta Baja', '555-6789', 'contacto@empresatheta.com'),
('Empresa Iota', 1, 'Av. Comercial 555, Local 10', '555-9012', 'consultas@empresaiota.com'),
('Empresa Kappa', 2, 'Blvd. Tecnológico 666, Piso 2', '555-2345', 'info@empresakappa.com');



Create table tbl_Roles (
	id_rol int auto_increment primary key,
    nombre_rol varchar(50)
);

INSERT INTO tbl_Roles (nombre_rol) VALUES 
('Administrador'),
('Auxiliar');

CREATE TABLE tbl_Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    usuario varchar(50),
    clave VARCHAR(255) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_rol int,
    foreign key (id_rol) references tbl_Roles (id_rol)
);

INSERT INTO tbl_Usuarios (nombre, email, usuario, clave, id_rol) VALUES 
('Josue Montoya', 'admin@gmail.com', 'admin', '$2b$12$/DU5/JfI68JNrFcuY4kmI.kUu5v2tTlWfiCR6bfp7bN7hL0jOXgzy', 1),
('Williams Gei', 'auxiliar@gmail.com', 'auxiliar', '$2b$12$/DU5/JfI68JNrFcuY4kmI.kUu5v2tTlWfiCR6bfp7bN7hL0jOXgzy', 2),
('Carlos Gei', 'auxiliar2@gmail.com', 'auxiliar2', '$2b$12$/DU5/JfI68JNrFcuY4kmI.kUu5v2tTlWfiCR6bfp7bN7hL0jOXgzy', 2);

select * from tbl_Comprobantes_Compra;

-- Crear la tabla tbl_TipoComprobante
CREATE TABLE tbl_TipoComprobante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL
);

-- Insertar los valores únicos para los tipos de comprobantes
INSERT INTO tbl_TipoComprobante (nombre)
VALUES ('Crédito Fiscal'), ('Consumidor Final');

-- Crear la tabla tbl_Comprobantes_Compra sin ENUM y con relación a tbl_TipoComprobante
CREATE TABLE tbl_Comprobantes_Compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    tipo_comprobante_id INT NOT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    proveedor VARCHAR(100) NOT NULL,
    archivo_pdf VARCHAR(255),
    archivo_json VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES tbl_Empresas(id),
    FOREIGN KEY (tipo_comprobante_id) REFERENCES tbl_TipoComprobante(id)
);

-- Crear la tabla tbl_Comprobantes_Venta sin ENUM y con relación a tbl_TipoComprobante
CREATE TABLE tbl_Comprobantes_Venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    tipo_comprobante_id INT NOT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    cliente VARCHAR(100) NOT NULL,
    archivo_pdf VARCHAR(255),
    archivo_json VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES tbl_Empresas(id),
    FOREIGN KEY (tipo_comprobante_id) REFERENCES tbl_TipoComprobante(id)
);
