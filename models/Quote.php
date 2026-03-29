<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    // Properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    public $author_name;
    public $category_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Quotes
    public function read($author_id = null, $category_id = null) {
        $query = 'SELECT q.id, q.quote, a.author as author_name, c.category as category_name 
                FROM ' . $this->table . ' q
                LEFT JOIN authors a ON q.author_id = a.id
                LEFT JOIN categories c ON q.category_id = c.id
                WHERE 1=1'; // "1=1" makes appending "AND" conditions easier

        // Filter by author_id if provided
        if ($author_id !== null) {
            $query .= ' AND q.author_id = :author_id';
        }

        // Filter by category_id if provided
        if ($category_id !== null) {
            $query .= ' AND q.category_id = :category_id';
        }

        $query .= ' ORDER BY q.id DESC';
        
        $stmt = $this->conn->prepare($query);

        // Bind parameters if they exist
        if ($author_id !== null) {
            $stmt->bindParam(':author_id', $author_id);
        }
        if ($category_id !== null) {
            $stmt->bindParam(':category_id', $category_id);
        }

        $stmt->execute();
        return $stmt;
    }

    // Get Single Quote
    public function read_single() {
        $query = 'SELECT q.id, q.quote, a.author as author_name, c.category as category_name 
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = ? LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->quote = $row['quote'];
            $this->author_name = $row['author_name'];
            $this->category_name = $row['category_name'];
            return true;
        }
        return false;
    }

    // Create Quote
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) 
                  VALUES (:quote, :author_id, :category_id)';
        
        $stmt = $this->conn->prepare($query);

        // Clean
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        try {
            if($stmt->execute()) return true;
        } catch (PDOException $e) {
            // This captures if the foreign key IDs don't exist
            return false;
        }
        return false;
    }
}