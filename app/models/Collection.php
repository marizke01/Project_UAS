<?php

class Collection {
    private $db;

    public function __construct() {
        $this->db = (new Db())->getConnection();
    }

    public function getCollections() {
        $stmt = $this->db->query("SELECT * FROM collections");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
