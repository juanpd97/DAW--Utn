<?php

class VentaModel {
    private $id;
    private $tipoComprobante;
    private $puntoVenta;
    private $numeroComprobante;
    private $cuitCliente;
    private $importe;
    private $cliente;
    private $db;

    public function __construct() {
        $bda = new Database();
        $this->db = $bda->getConnection(); 
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTipoComprobante() {
        return $this->tipoComprobante;
    }

    public function getPuntoVenta() {
        return $this->puntoVenta;
    }

    public function getNumeroComprobante() {
        return $this->numeroComprobante;
    }

    public function getCuitCliente() {
        return $this->cuitCliente;
    }

    public function getImporte() {
        return $this->importe;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTipoComprobante($tipoComprobante) {
        $this->tipoComprobante = $tipoComprobante;
        return $this;
    }

    public function setPuntoVenta($puntoVenta) {
        $this->puntoVenta = $puntoVenta;
        return $this;
    }

    public function setNumeroComprobante($numeroComprobante) {
        $this->numeroComprobante = $numeroComprobante;
        return $this;
    }

    public function setCuitCliente($cuitCliente) {
        $this->cuitCliente = $cuitCliente;
        return $this;
    }

    public function setImporte($importe) {
        $this->importe = $importe;
        return $this;
    }

    // Método para guardar venta en la base de datos
    public function guardarVenta() {
        try {
            $query = "INSERT INTO ventas (tipoComprobante, puntoVenta, numeroComprobante, cuitCliente, importe) 
                      VALUES (:tipoComprobante, :puntoVenta, :numeroComprobante, :cuitCliente, :importe)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':tipoComprobante', $this->tipoComprobante);
            $stmt->bindParam(':puntoVenta', $this->puntoVenta);
            $stmt->bindParam(':numeroComprobante', $this->numeroComprobante);
            $stmt->bindParam(':cuitCliente', $this->cuitCliente);
            $stmt->bindParam(':importe', $this->importe);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
