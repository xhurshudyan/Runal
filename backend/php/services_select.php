<?php

require 'db_connect.php';

class services_select {
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function select() {
        $target_dir = "../img/services/";
        $files = scandir($target_dir);
        array_splice($files, 0, 2);
        array_multisort($files, SORT_NUMERIC, SORT_DESC);

        $query = mysqli_query($this->conn,"SELECT * FROM `services` ORDER BY id DESC;");
        while ($result = mysqli_fetch_array($query)) {
            $id[] = $result['id'];
            $title[] = $result['title'];
            $content[] = $result['content'];
            $date[] = $result['create_date'];
        }

        if(!empty($id)) {
           $count = count($id);
        }

        for ($i = 0; $i < $count; $i ++) {
            echo "<div class='row services-list-block'>
                    <div class='col-sm-12 services-list'><h3>{$title[$i]}</h3></div>
                    <div class='col-sm-12 hidden-list'>
                    <div class='row col-sm-4 update-img'>
                    <h4>Заменить фото</h4>
                    <div class='col-sm-9'><img src='../img/services/{$files[$i]}' class='img-thumbnail'></div>
                    <div class='col-sm-12 file-update'>
                       <form action='services.php' method='post' enctype='multipart/form-data' class='form-list'>
                          <div class='custom-file mb-3'>
                             <input type='hidden' name='hidden_id' value='{$id[$i]}'>
                             <input type='file' class='custom-file-input hidden' id='CustomFile-{$id[$i]}' name='filename'>
                             <label class='custom-file-label' for='CustomFile-{$id[$i]}'>Выбрать файл</label>
                          </div>
                          <div class='mt-3'>
                             <button type='submit' id='file-btn-2' class='btn file-btn-2' name='file-btn-2'>Заменить</button>
                          </div>
                       </form>
                    </div>
                    </div>
                    <div class='row col-sm-8'>
                       <h4>Изменить или удалить данные</h4> 
                       <form  method='post' class='form-list-2'>
                          <input type='hidden' name='hidden_id' value='{$id[$i]}'>
                          <div class='form-group col-sm-12'>
                              <textarea class='form-control update-title' rows='1'  name='update-title'>{$title[$i]}</textarea>
                          </div>
                          <div class='form-group col-sm-12'>
                              <textarea class='form-control update-content' rows='5' name='update-content'>{$content[$i]}</textarea>
                          </div>
                          <div class='col-sm-8'><h4>{$date[$i]}</h4></div>
                          <div class='mt-3 col-sm-4'>
                              <button type='submit'  name='update-btn' class='btn update-btn'>Изменить</button>
                              <button type='submit'  name='delete-btn' class='btn delete-btn'>Удалить</button>
                          </div>
                       </form>
                    </div>
                    </div>
                 </div>";
        }
    }
}

$select = new services_select($conn);
$select->select();





