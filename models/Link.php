<?php
class Link {
    private $conn;
    private $table = 'link';

    //Properties
    public $id;
    public $category_id;
    public $sort_order;
    public $url;
    public $title;
    public $source;
    public $author;
    public $target;

    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    // Get Links
    public function read(){
        $query = 'SELECT 
            c.name as category_name,
            l.id,
            l.category_id,
            l.sort_order,
            l.url,
            l.title,
            l.source,
            l.author,
            l.target
        FROM
            ' . $this->table . ' l
        LEFT JOIN
            category c ON l.category_id = c.id
        ORDER BY
            l.sort_order, l.title';

        // Prepare statements
         $statement = $this->conn->prepare($query);

        // Execute
        $statement->execute();

        return $statement;
    }
 
    //Get single post
    public function read_by_id() {
        $query = 'SELECT 
            l.id,
            l.category_id,
            l.sort_order,
            l.url,
            l.title,
            l.source,
            l.author,
            l.target
        FROM
            ' . $this->table . ' l
        WHERE l.id = ?
        LIMIT 0,1'
        ;

        // Prepare statements
        $statement = $this->conn->prepare($query);

        // Bind ID
        $statement->bindParam(1, $this->id);

        // Execute query
        $statement->execute();

        // Set properties
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->category_id = $row['category_id'];
        $this->sort_order = $row['sort_order'];
        $this->url = $row['url'];
        $this->title = $row['title'];
        $this->source = $row['source'];
        $this->author = $row['author'];
        $this->target = $row['target'];

        return $row;
    }

    // Create record
    public function create(){
        //Create query
        $query = 'INSERT INTO ' . 
            $this->table . '
            SET
                `category_id` = :category_id,
                `sort_order` = :sort_order,
                `url` = :url,
                `title` = :title,
                `source` = :source,
                `author` = :author,
                `target` = :target
                ';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        //Clean data
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->sort_order = htmlspecialchars(strip_tags($this->sort_order));
        $this->url = htmlspecialchars(strip_tags($this->url));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->source = htmlspecialchars(strip_tags($this->source));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->target = htmlspecialchars(strip_tags($this->target));

        // Bind data
        $statement->bindParam(':category_id', $this->category_id);
        $statement->bindParam(':sort_order', $this->sort_order);
        $statement->bindParam(':url', $this->url);
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':source', $this->source);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':target', $this->target);

        echo ("title: " . $this->title);

        // Execute query
        if($statement->execute()) {
            return true;
        }

        // Print error
        printf("\n\nError: %s.\n", $statement->error);
        return false;
    }

    
    // Update record
    public function update(){
        //Create query
        $query = 'UPDATE ' . 
            $this->table . '
            SET
                `category_id` = :category_id,
                `sort_order` = :sort_order,
                `url` = :url,
                `title` = :title,
                `source` = :source,
                `author` = :author,
                `target` = :target
            WHERE
                `id` = :id
                ';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->sort_order = htmlspecialchars(strip_tags($this->sort_order));
        $this->url = htmlspecialchars(strip_tags($this->url));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->source = htmlspecialchars(strip_tags($this->source));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->target = htmlspecialchars(strip_tags($this->target));

        // Bind data
        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':category_id', $this->category_id);
        $statement->bindParam(':sort_order', $this->sort_order);
        $statement->bindParam(':url', $this->url);
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':source', $this->source);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':target', $this->target);

        echo ("title: " . $this->title);

        // Execute query
        if($statement->execute()) {
            return true;
        }

        // Print error
        printf("\n\nError: %s.\n", $statement->error);
        return false;
    }
    
    //Delete post
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $statement = $this->conn->prepare($query);
  
        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

       // Bind data
       $statement->bindParam(':id', $this->id);

        // Execute query
        if($statement->execute()) {
            return true;
        }

        // Print error
        printf("\n\nError: %s.\n", $statement->error);
        return false;
    }

}