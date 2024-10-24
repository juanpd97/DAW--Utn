CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL    
);

CREATE TABLE Cliente (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cuit BIGINT NOT NULL,
  condicionIva INT NOT NULL,
  razonSocial VARCHAR(255) NOT NULL,
  alta DATE NOT NULL,
  direccion VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  UNIQUE (cuit)
);

CREATE TABLE Venta (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tipoComprobante CHAR(3) NOT NULL,
  puntoVenta VARCHAR(4) NOT NULL,
  numeroComprobante VARCHAR(8) NOT NULL,
  cuitCliente BIGINT NOT NULL,
  importe DOUBLE NOT NULL,
  FOREIGN KEY (cuitCliente) REFERENCES clientes(cuit)
);
