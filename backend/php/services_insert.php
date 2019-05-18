<?php
require_once 'db_connect.php';

class services_insert {
    private $conn;
    private $fileName;
    private $title;
    private $content;
    private $hiddenId;
    private $target_dir = "../img/services/";
    public $data = [];

    public function __construct($conn, $fileName, $title, $content, $hiddenId)
    {
        $this->conn = $conn;
        $this->fileName = $fileName;
        $this->title = $title;
        $this->content = $content;
        $this->hiddenId = $hiddenId;
    }

    public function Create() {
        $target_file = $this->target_dir . basename($this->fileName["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = @getimagesize($this->fileName["tmp_name"]);
        if ($check === false) {
            $this->data['error'][] = "<h3 class='error__content'>" . "Выберите файл!" . "</h3>";
        }
        if (file_exists($target_file)) {
            $this->data['error'][] = "<h3 class='error__content'>" . "Файл с таким именем уже существует!" . "</h3>";
        }
        if ($this->fileName["size"] > 500000) {
            $this->data['error'][] = "<h3 class='error__content'>" . "Файл слышком большого размера!" . "</h3>";
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $this->data['error'][] =  "<h3 class='error__content'>" . 'Только JPEG JPG PNG GIF формата!' . "</h3>";;
        }
        if(!empty($this->data)) {
            echo json_encode($this->data);
        }else {
            if (isset($this->title) && isset($this->content)) {
                if (empty($this->title)) {
                    $this->data['error'][] = "<h3 class='error__content'>"."Заполните заголовок!"."</h3>";
                }else {
                    $this->title = $this->test_input($this->title);
                }
                if (empty($this->content)) {
                    $this->data['error'][] = "<h3 class='error__content'>"."Заполните контент!"."</h3>";
                }else {
                    $this->content = $this->test_input($this->content);
                }
                if (!empty($this->data)) {
                    echo json_encode($this->data);
                }else {
                    $query = "INSERT INTO services (title, content, create_date)
                  VALUES ('$this->title', '$this->content', NOW())";
                    if ($this->conn->query($query) !== TRUE) {
                        $this->data['error'] = $this->conn->error;
                        echo json_encode($this->data);
                    } else {
                        $this->uploadFile();
                    }
                }
            }
            if(isset($this->hiddenId)) {
                $this->updateFile();
            }
        }
    }

    public function uploadFile() {
        $query = mysqli_query($this->conn,"SELECT id FROM `services` ORDER BY id DESC LIMIT 0 , 1");
        $lastId = mysqli_fetch_array($query)['id'];
        $temp = ['jpg'];
        $newFilename = $lastId . '.' . end($temp);
        if (move_uploaded_file($this->fileName["tmp_name"], $this->target_dir.$newFilename)) {
            $this->data['success'] = "<h3 class='success__content'>" . "Данные успешно добавлены." . "</h3>";
            echo json_encode($this->data);
        }
    }

    public function updateFile() {
        $temp = ['jpg'];
        $newFilename = $this->hiddenId . '.' . end($temp);
        if (move_uploaded_file($this->fileName["tmp_name"], $this->target_dir.$newFilename)) {
           $this->data['success'] = "<h3 class='success__content'>" . "Фото успешно заменен." . "</h3>";
           echo json_encode($this->data);
        }
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$fileName = $_FILES['filename'];
$title = $_POST['insert-title'];
$content = $_POST['insert-content'];
$hiddenId = $_POST['hidden_id'];

$data = new services_insert($conn, $fileName, $title, $content, $hiddenId);
$data->Create();






