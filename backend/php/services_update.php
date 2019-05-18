<?php
require_once 'db_connect.php';

class services_update {
    private $conn;
    public $data = [];

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function update($id, $title, $content) {
        if (empty($title)) {
            $this->data['error'][] = "<h3 class='error__content'>"."Заполните заголовок!"."</h3>";
        }else {
            $title = $this->test_input($title);
        }
        if (empty($content)) {
            $this->data['error'][] = "<h3 class='error__content'>"."Заполните контент!"."</h3>";
        }else {
            $content = $this->test_input($content);
        }
        if(!empty($this->data)) {
            echo json_encode($this->data);
        }else {
            $query = "UPDATE `services` SET `title` = '{$title}', `content` = '{$content}' WHERE `id` = '{$id}'";
            if ($this->conn->query($query) !== TRUE) {
                $this['error'] = $this->conn->error;
                echo json_encode($this->data);
            }else {
                $this->data['success'] = "<h3 class='success__content'>" . " Данные успешно изменены." . "</h3>";
                echo json_encode($this->data);
            }
        }
    }

    public function delete($id) {
        $id = $this->test_input($id);
        $query = "DELETE FROM `services` WHERE `id` = '{$id}'";
        if ($this->conn->query($query) !== TRUE) {
            $this->data['error'][] = $this->conn->error;
            echo json_encode($this->data);
        }else {
            $target_dir = "../img/services/";
            $files = scandir($target_dir);
            array_splice($files, 0, 2);
            array_multisort($files, SORT_NUMERIC, SORT_DESC);
            unlink($target_dir.$id.'.jpg');
            $this->data['success'] = "<h3 class='success__content'>" . "Данные успешно удалены." . "</h3>";
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

$data = new services_update($conn);
if (isset($_POST['action']) && $_POST['action'] === 'update'){
    $data->update($_POST['hidden_id'], $_POST['update-title'],$_POST['update-content']);
}
if (isset($_POST['action']) && $_POST['action'] === 'delete'){
    $data->delete($_POST['hidden_id']);
}



