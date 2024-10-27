<?php
    require_once __DIR__ ."./Database.php";
    class ClienteModel{
        private $db;

        private $id;
        private $cuit;
        private $condicionIva;
        private $razonSocial;
        private $alta;
        private $direccion;
        private $email;

        public function __construct(){
            $bda = new Database();
            $this->db = $bda->getConnection();
        }


        //-----------------------
        // Getters
        public function getId() {
        return $this->id;
        }

        public function getCuit() {
        return $this->cuit;
        }

        public function getCondicionIva() {
        return $this->condicionIva;
        }

        public function getRazonSocial() {
        return $this->razonSocial;
        }

        public function getAlta() {
        return $this->alta;
        }

        public function getDireccion() {
        return $this->direccion;
        }

        public function getEmail() {
        return $this->email;
        }

// Setters
        //public function setId($id) {
        //$this->id = $id;
       // }

        public function setCuit($cuit) {
        $this->cuit = $cuit;
        }

        public function setCondicionIva($condicionIva) {
        $this->condicionIva = $condicionIva;
        }

        public function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
        }

        public function setAlta($alta) {
        $this->alta = $alta;
        }

        public function setDireccion($direccion) {
        $this->direccion = $direccion;
        }

        public function setEmail($email) {
        $this->email = $email;
        }
        
        

        public function guardarCliente() {
            try {
                $query = "INSERT INTO clientes (cuit, condicionIva, razonSocial, alta, direccion, email)
                          VALUES (:cuit, :condicionIva, :razonSocial, :alta, :direccion, :email)
                          ON DUPLICATE KEY UPDATE 
                              condicionIva = VALUES(condicionIva),
                              razonSocial = VALUES(razonSocial),
                              alta = VALUES(alta),
                              direccion = VALUES(direccion),
                              email = VALUES(email)";
    
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':cuit', $this->cuit);
                $stmt->bindParam(':condicionIva', $this->condicionIva);
                $stmt->bindParam(':razonSocial', $this->razonSocial);
                
                $stmt->bindParam(':direccion', $this->direccion);
                $stmt->bindParam(':email', $this->email);


                $fechaOriginal = $this->alta;
                $fechaConvertida = DateTime::createFromFormat('dmY', $fechaOriginal)->format('Y-m-d');

                $stmt->bindParam(':alta', $fechaConvertida);
    
                return $stmt->execute();
            } catch (PDOException $e) {
                throw new Exception("Error al guardar el cliente: " . $e->getMessage());
            }
        }


        

        
        /*
        public function guardarCliente($fileLink) {
            try {
                $query = "INSERT INTO cliente (cuit, condicion_iva, razon_social, alta, direccion, email) 
                          VALUES (:cuit, :condicion_iva, :razon_social, :alta, :direccion, :email)";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':cuit', $fileLink['cuit']);
                $stmt->bindParam(':condicion_iva', $fileLink['condicion_iva']);
                $stmt->bindParam(':razon_social', $fileLink['razon_social']);
                $stmt->bindParam(':alta', $fileLink['alta']);
                $stmt->bindParam(':direccion', $fileLink['direccion']);
                $stmt->bindParam(':email', $fileLink['email']);

                return $stmt->execute();

            } catch(PDOException $e) {
                return false;
            }
        }

        public function buscarClientePorCUIT($cuit) {
            try {
                $query = "SELECT * FROM clientes WHERE cuit = :cuit";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':cuit', $cuit);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                return false;
            }
        }
        

        public function actualizarCliente($fileLink) {
            try {
                $query = "UPDATE clientes SET condicion_iva = :condicion_iva, razon_social = :razon_social, 
                          alta = :alta, direccion = :direccion, email = :email WHERE cuit = :cuit";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':cuit', $fileLink['cuit']);
                $stmt->bindParam(':condicion_iva', $fileLink['condicion_iva']);
                $stmt->bindParam(':razon_social', $fileLink['razon_social']);
                $stmt->bindParam(':alta', $fileLink['alta']);
                $stmt->bindParam(':direccion', $fileLink['direccion']);
                $stmt->bindParam(':email', $fileLink['email']);
                return $stmt->execute();

            } catch (PDOException $e) {
                return false;
            }
        }
            */


    }

