<?php

class CollectionController {
    private $collection;

    public function __construct() {
        $this->collection = new Collection();
    }

    public function index() {
        $collections = $this->collection->getCollections();
        require_once 'app/views/collections.php';
    }
}
