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
        if (!isset($archivoCsv) || $archivoCsv['type'] !== 'text/csv') {
            $_SESSION['mensaje'] = 'Archivo CSV no válido.';
            return false;
        }

        // Verificar si el archivo ya fue importado
        if ($this->archivoYaImportado($archivoCsv['name'])) {
            $_SESSION['mensaje'] = 'Este archivo ya fue importado.';
            return false;
        }

        // Detectar tipo de archivo y procesarlo
        $tipoArchivo = $this->detectarTipoArchivo($archivoCsv);
        $resultado = false;

        if ($tipoArchivo === "clientes") {
            $resultado = $this->importarClientes($archivoCsv);
        } elseif ($tipoArchivo === "ventas") {
            $resultado = $this->importarVentas($archivoCsv);
        } else {
            $_SESSION['mensaje'] = 'Error: Tipo de archivo desconocido.';
            return false;
        }

        // Registrar el archivo si la importación fue exitosa
        if ($resultado) {
            $this->registrarArchivo($archivoCsv['name']);
        }

        return $resultado;
    }


    private function detectarTipoArchivo($archivoCsv) {
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
            fgetcsv($handle); 
    
            try {
                $this->conexion->beginTransaction();
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    
                    if (empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4])) {
                        throw new Exception("Campos obligatorios vacíos en la fila del cliente con CUIT: " . $data[3]);
                    }

                    $venta = new VentaModel();
                    $venta->setTipoComprobante($data[0]);
                    $venta->setPuntoVenta($data[1]);
                    $venta->setNumeroComprobante($data[2]);
                    $venta->setCuitCliente($data[3]);
                    $venta->setImporte($data[4]);
    
                    
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
    


    private function archivoYaImportado($nombreArchivo) {
        $query = "SELECT COUNT(*) FROM archivosImportados WHERE nombre = :nombre";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombre', $nombreArchivo);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    private function registrarArchivo($nombreArchivo) {
        $query = "INSERT INTO archivosImportados (nombre, fecha_importacion) VALUES (:nombre, NOW())";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombre', $nombreArchivo);
        $stmt->execute();
    }
    
}

