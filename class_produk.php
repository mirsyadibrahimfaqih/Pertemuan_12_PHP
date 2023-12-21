<?php
class Produk {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getAllProduk() {
        $sql = "SELECT * FROM produk"; // Specify the columns you want to select
        $rs = $this->dbh->query($sql);
        return $rs;
    }

    public function getAllJenisProduk() {
        $sql = "SELECT * FROM jenis"; // Specify the columns you want to select
        $rs = $this->dbh->query($sql);
        return $rs;
    }
    
}
?>
