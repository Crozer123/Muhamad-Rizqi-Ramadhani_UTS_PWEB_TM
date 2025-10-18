<?php
class Product {
    public $id;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $image_url; 
    public $created_at;

    public function __construct($id=null, $name=null, $desc=null, $price=null, $stock=null, $created_at=null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $desc;
        $this->price = $price;
        $this->stock = $stock;
        $this->created_at = $created_at;
    }
}
?>