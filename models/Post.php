<?php
class Post
{
    //DB Stuff
    private $conn; //Connection
    private $table = 'posts'; //Table name

    //Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Posts
    public function read()
    {
        //create query
        $query = 'SELECT
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
        ' . $this->table . ' p
        LEFT JOIN
        categories c ON p.category_id = c.id
        ORDER BY
        p.created_at DESC';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    //Get Single Post
    public function read_single()
    {
        //create query
        $query = 'SELECT
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
        ' . $this->table . ' p
        LEFT JOIN
        categories c ON p.category_id = c.id
        WHERE
        p.id = ?
        LIMIT 0,1';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Set properties
        $this->title = $row['title']; //sets the title property to the title column in the row
        $this->body = $row['body']; //sets the body property to the body column in the row
        $this->author = $row['author']; //sets the author property to the author column in the row
        $this->category_id = $row['category_id']; //sets the category_id property to the category_id column in the row
        $this->category_name = $row['category_name']; //sets the category_name property to the category_name column in the row

    }
}
