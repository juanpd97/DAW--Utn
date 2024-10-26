<?php
session_start();
require_once __DIR__ . '/../model/ClienteModel.php';
require_once __DIR__ . '/../model/VentaModel.php';
require_once __DIR__ . '/../model/Database.php';

class ImportarCsvController {
    private $conexion;

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->getConnection();
    }

    public function importarCsv($archivoCsv) {
        // Validar archivo CSV
        if (!isset($archivoCsv) || $archivoCsv['type'] !== 'text/csv') {
            $_SESSION['mensaje'] = 'Archivo CSV no válido.';
            return false;
        }

        // Detectar tipo de archivo (Clientes o Ventas)
        $tipoArchivo = $this->detectarTipoArchivo($archivoCsv);
        if ($tipoArchivo === "clientes") {
            return $this->importarClientes($archivoCsv);
        } elseif ($tipoArchivo === "ventas") {
            return $this->importarVentas($archivoCsv);
        } else {
            $_SESSION['mensaje'] = 'Error: Tipo de archivo desconocido.';
            return false;
        }
    }

    private function detectarTipoArchivo($archivoCsv) {
        // Abrir el archivo y leer la primera línea para detectar la cabecera
        if (($handle = fopen($archivoCsv['tmp_name'], "r")) !== FALSE) {
            $cabecera = fgets($handle);
            fclose($handle);

            if (strpos($cabecera, "###clients-") !== false) {
                return "clientes";
            } elseif (strpos($cabecera, "###sales-") !== false) {
                return "ventas";
            }
        }
        return null;
    }

    private function importarClientes($archivoCsv) {
        if (($handle = fopen($archivoCsv['tmp_name'], "r")) !== FALSE) {
            fgetcsv($handle); // Omitir la cabecera
    
            try {
                $this->conexion->beginTransaction();
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    // Verificar que los campos obligatorios no estén vacíos
                    if (empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5])) {
                        throw new Exception("Campos obligatorios vacíos en la fila con CUIT: " . $data[0]);
                    }
    
                    $cliente = new ClienteModel();
                    $cliente->setCuit($data[0]);
                    $cliente->setCondicionIva($data[1]);
                    $cliente->setRazonSocial($data[2]);
                    $cliente->setAlta($data[3]);
                    $cliente->setDireccion($data[4]);
                    $cliente->setEmail($data[5]);
    
                    if (!$cliente->guardarCliente()) {
                        throw new Exception("No se pudo guardar el cliente con CUIT: " . $data[0]);
                    }
                }
                $this->conexion->commit();
                $_SESSION['mensaje'] = 'Importación de clientes exitosa.';
                fclose($handle);
                return true;
            } catch (Exception $e) {
                $this->conexion->rollBack();
                $_SESSION['mensaje'] = 'Error al importar clientes: ' . $e->getMessage();
                fclose($handle);
                return false;
            }
        }
    }
    
    

    private function importarVentas($archivoCsv) {
        if (($handle = fopen($archivoCsv['tmp_name'], "r")) !== FALSE) {
            fgetcsv($handle); // Omitir la cabecera
    
            try {
                $this->conexion->beginTransaction();
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) { // Usar ";" como delimitador si es necesario
                    // Mapear datos a `VentaModel`
                    $venta = new VentaModel();
                    $venta->setTipoComprobante($data[0]);
                    $venta->setPuntoVenta($data[1]);
                    $venta->setNumeroComprobante($data[2]);
                    $venta->setCuitCliente($data[3]);
                    $venta->setImporte($data[4]);
    
                    // Guardar la venta en la base de datos
                    if (!$venta->guardarVenta()) {
                        throw new Exception("Error al guardar la venta");
                    }
                }
                $this->conexion->commit();
                $_SESSION['mensaje'] = 'Importación de ventas exitosa.';
                fclose($handle);
                return true;
            } catch (Exception $e) {
                $this->conexion->rollBack();
                $_SESSION['mensaje'] = 'Error al importar ventas: ' . $e->getMessage();
                fclose($handle);
                return false;
            }
        }
    }
    

    
}






/*
require_once __DIR__ . "/../Model/ClienteModel.php";
require_once __DIR__ . "/../Model/VentaModel.php";
require_once __DIR__ . "/../Model/Database.php";

class ImportarCsvController {
    private $clienteModel;
    private $ventaModel;

    public function __construct() {
        $database = new Database();
        $this->clienteModel = new ClienteModel($database);
        $this->ventaModel = new VentaModel($database);
    }

    public function importar($filePath) {
        if (($handle = fopen($filePath, "r")) !== false) {
            // Leer la primera línea para detectar el tipo de archivo
            $headers = fgetcsv($handle, 1000, ",");
            
            if ($this->esArchivoClientes($headers)) {
                // Procesar el archivo como clientes
                $this->procesarClientes($handle);
            } elseif ($this->esArchivoVentas($headers)) {
                // Procesar el archivo como ventas
                $this->procesarVentas($handle);
            } else {
                echo "El archivo CSV no coincide con clientes ni ventas.";
            }
            fclose($handle);
        } else {
            echo "No se pudo abrir el archivo.";
        }
    }

    private function esArchivoClientes($headers) {
        // Ajusta los nombres de columnas según tu archivo de clientes
        return in_array("cuit", $headers) && in_array("razon_social", $headers);
    }

    private function esArchivoVentas($headers) {
        // Ajusta los nombres de columnas según tu archivo de ventas
        return in_array("tipo_comprobante", $headers) && in_array("importe", $headers);
    }

    private function procesarClientes($handle) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            // Convertir cada línea en un array asociativo
            $clienteData = [
                "cuit" => $data[0],
                "condicion_iva" => $data[1],
                "razon_social" => $data[2],
                "alta" => $data[3],
                "direccion" => $data[4],
                "email" => $data[5]
            ];

            // Verificar si el cliente existe y actualizarlo o insertarlo
            $clienteExistente = $this->clienteModel->buscarClientePorCUIT($clienteData['cuit']);
            if ($clienteExistente) {
                $this->clienteModel->actualizarCliente($clienteData);
                echo "Cliente con CUIT " . $clienteData['cuit'] . " actualizado.<br>";
            } else {
                $this->clienteModel->insertarCliente($clienteData);
                echo "Cliente con CUIT " . $clienteData['cuit'] . " insertado.<br>";
            }
        }
    }

    private function procesarVentas($handle) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            // Convertir cada línea en un array asociativo
            $ventaData = [
                "tipo_comprobante" => $data[0],
                "punto_venta" => $data[1],
                "numero_comprobante" => $data[2],
                "cuit_cliente" => $data[3],
                "importe" => $data[4]
            ];

            // Insertar la venta
            $this->ventaModel->insertarVenta($ventaData);
            echo "Venta con CUIT cliente " . $ventaData['cuit_cliente'] . " insertada.<br>";
        }
    }
}

*/



