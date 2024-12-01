Create database ContadorcitoDB;
USE ContadorcitoDB;

CREATE TABLE tbl_Empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo ENUM('Natural', 'Jurídica') NOT NULL,
    direccion TEXT,
    telefono VARCHAR(20),
    email VARCHAR(100),
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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
('Williams Rodriguez', 'auxiliar@gmail.com', 'auxiliar', '$2b$12$/DU5/JfI68JNrFcuY4kmI.kUu5v2tTlWfiCR6bfp7bN7hL0jOXgzy', 2),
('Carlos Guerrero', 'auxiliar2@gmail.com', 'auxiliar2', '$2b$12$/DU5/JfI68JNrFcuY4kmI.kUu5v2tTlWfiCR6bfp7bN7hL0jOXgzy', 2);

SELECT u.id AS id_usuario, u.nombre, u.usuario, u.clave, r.nombre_rol 
FROM tbl_Usuarios u 
INNER JOIN tbl_Roles r ON u.id_rol = r.id_rol 
WHERE u.usuario = 'admin';

CREATE TABLE tbl_Comprobantes_Compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    tipo ENUM('Crédito Fiscal', 'Consumidor Final') NOT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    proveedor VARCHAR(100) NOT NULL,
    archivo_pdf VARCHAR(255),
    archivo_json VARCHAR(255),
    usuario_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES tbl_Empresas(id),
    FOREIGN KEY (usuario_id) REFERENCES tbl_Usuarios(id)
);

CREATE TABLE tbl_Comprobantes_Venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    tipo ENUM('Crédito Fiscal', 'Consumidor Final') NOT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    cliente VARCHAR(100) NOT NULL,
    archivo_pdf VARCHAR(255),
    archivo_json VARCHAR(255),
    usuario_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES tbl_Empresas(id),
    FOREIGN KEY (usuario_id) REFERENCES tbl_Usuarios(id)
);