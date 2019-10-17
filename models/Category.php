<?php
class Category {
    private $conn;
    private $table = 'category';

    //Properties
    public $id;
    public $parent_id;
    public $name;
    public $sort_order;

    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    // Get Links
    public function read(){
        $query = 'SELECT 
            c.id,
            c.parent_id,
            c.name,
            c.sort_order
        FROM
            ' . $this->table . ' c
        ORDER BY
            c.sort_order, c.name';

        // Prepare statements
         $statement = $this->conn->prepare($query);

        // Execute
        $statement->execute();

        return $statement;
    }

    //Get single post
    public function read_by_id() {
        $query = 'SELECT 
            c.id,
            c.parent_id,
            c.name,
            c.sort_order
        FROM
            ' . $this->table . ' c
        WHERE c.id = ?
        LIMIT 0,1'
        ;


        // Prepare statements
        $statement = $this->conn->prepare($query);

        // Bind ID
        $statement->bindParam(1, $this->id);

        // Execute query
        $statement->execute();

        return $statement;
    }

    public function read_by_parent_id(){
        $query = 'SELECT 
            c.id,
            c.parent_id,
            c.name,
            c.sort_order
        FROM
            ' . $this->table . ' c
        WHERE c.parent_id = ?
        ORDER BY
            c.sort_order, c.name';


        // Prepare statements
         $statement = $this->conn->prepare($query);

        // Bind ID
        $statement->bindParam(1, $this->parent_id);

        // Execute
        $statement->execute();

        return $statement;
    }

    // Create record
    public function create(){
        //Create query
        $query = 'INSERT INTO ' . 
            $this->table . '
            SET
                `parent_id` = :parent_id,
                `name` = :name,
                `sort_order` = :sort_order';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        //Clean data
        $this->parent_id = htmlspecialchars(strip_tags($this->parent_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->sort_order = htmlspecialchars(strip_tags($this->sort_order));

        // Bind data
        $statement->bindParam(':parent_id', $this->parent_id);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':sort_order', $this->sort_order);

        // Execute query
        if($statement->execute()) {
            return true;
        }

        // Print error
        printf("\n\nError: %s.\n", $statement->error);
        return false;
    }

}