<?php
include_once "db_connect.php";
class testimonials
{
    public $upload_id;
    private $conn;
    private $dir = "../../frontend/img/testimonials/";
public function __construct($conn)
{
$this->conn = $conn;
}
public function insert($content,$actors,$image_name,$image_name2,$image_size){
  $query = mysqli_query($this->conn, "SELECT COUNT(*) as total_count FROM `testimonials`");
   $count = mysqli_fetch_array($query)['total_count'];
    if ($count == 6){
        $array['response'] = "Error";
        $array['msg'] = "Файл с таким именем уже существует!";
    }else{
        $query = "INSERT INTO testimonials (content, authors, create_date) VALUES ('$content', '$actors', NOW())";
        if ($this->conn->query($query) !== TRUE) {
        } else{
            $query = mysqli_query($this->conn, "SELECT id FROM `testimonials` ORDER BY id DESC LIMIT 0 , 1");
            $Id = mysqli_fetch_array($query)['id'];
            $target_file = $this->dir . basename($image_name);
            if (file_exists($target_file)) {
                $array['response'] = "Error";
                $array['msg'] = "Файл с таким именем уже существует!";
            }
            if ($image_size >  1000000) {
                $array['response'] = "Error";
                $array['msg'] = "Файл слышком большого размера!";
            } else {
                $temp = ['jpg'];
                $newName = ($Id + 1 - 1) . '.' . end($temp);
                if (move_uploaded_file($image_name2, $this->dir . $newName)) {
                    $array['response'] = "Success";
                    $array['msg'] = "Картинка успешно загружен.";
                }else{
                    $array['response'] = "Error";
                    $array['msg'] = "Картинка не загружен. ";
                }
            } return $array;
        }
    }
}
    public function take_id ($id){
        $this->upload_id = $id;
        return $this->upload_id;
    }
public function upload_update($image_update_name,$image_update_name2,$image_update_size,$upload_id){
    $get_file = $this->dir . basename($image_update_name);
    $imageType = strtolower(pathinfo($get_file, PATHINFO_EXTENSION));
    if ($image_update_size > 1000000) {
        $datas['response'] = "Error";
        $datas['msg'] = "Файл слышком большого размера!";
    }
    if ($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg") {
        $datas['response'] = "Error";
        $datas['msg'] = "Только JPEG JPG PNG  формата!";
    }else{
        $tmp = ['jpg'];
        $Names = ($upload_id) . '.' . end($tmp);
        if (move_uploaded_file($image_update_name2, $this->dir . $Names)) {
            $datas['response'] = "Success";
            $datas['msg'] = "Картинка успешно загружен.";
        }else{
            $datas['response'] = "Error";
            $datas['msg'] = "Картинка не загружен.";
        } return $datas;
    }
}
public function update($update_id,$update_content,$update_authors){
    if ($update_authors !== "" && $update_content !== "") {
        $query = "UPDATE `testimonials` SET content='$update_content',authors='$update_authors'  WHERE id = '{$update_id}'";
        if ($this->conn->query($query) === TRUE) {
            $update_data['response'] = "success";
            $update_data['content'] = "Информация изменен";
        } else {
            $update_data['response'] = "Error";
            $update_data['content'] = "Информация не изменен";
        }
    }else{
        $update_data['response'] = "Error";
        $update_data['content'] = "Эта информация пуста";
    } return  $update_data;
}
public function delete($delete_id){
    $query = "DELETE FROM `testimonials` WHERE id='{$delete_id}'";
    if ($this->conn->query($query) === TRUE) {
       $path = $this->dir."{$delete_id}".".jpg";
       if (!unlink($path)){
           $delete_data['response'] = "Error";
           $delete_data['content'] = "Картинка не была удалена";
       }else{
           $delete_data['response'] = "success";
           $delete_data['content'] = "удаленный";
       }

    } else {
        $delete_data['response'] = "Error";
        $delete_data['content'] = "Информация не была удалена";
    } return $delete_data;
}
}
$content = $_POST['content'];
$actors = $_POST['actors'];
$insert = $_POST['insert'];
$update_image = $_POST['update'];
$obj = new testimonials($conn);
if ($insert == "insert"){
    $filecount = 0;
    $directory = "../../frontend/img/testimonials/";
    $files = glob($directory . "*");
    if ($files){
        $filecount = count($files);
    }
    $sa = "$filecount";
    $image_name = $_FILES["image"]["name"];
    $image_size = $_FILES["image"]["size"];
    $image_name2 =  $_FILES["image"]["tmp_name"];
    if ($sa < "7"){
        $insert = $obj->insert("{$content}","{$actors}",$image_name,$image_name2,$image_size);
    }
  echo json_encode($insert);
}
if (isset($_POST['action']) && $_POST['action'] == 'id_data'){
    $id = $_POST['id'];
    $take_id = $obj->take_id($id);
    echo json_encode($take_id);
}
if ($update_image == "update"){
    $image_update_name = $_FILES['image']['name'];
    $image_update_size = $_FILES['image']['size'];
    $image_update_name2 =  $_FILES["image"]["tmp_name"];
    $ids = $_POST['form_id'];
    $update_img = $obj->upload_update($image_update_name,$image_update_name2,$image_update_size,$ids);
    echo json_encode($update_img);
}
if (isset($_POST['action']) && $_POST['action'] == 'update'){
    $update_id = $_POST['id'];
    $update_content = $_POST['content'];
    $update_authors = $_POST['authors'];
        $update_response = $obj->update($update_id,"{$update_content}","{$update_authors}");
   echo json_encode($update_response);
}
if (isset($_POST['action']) && $_POST['action'] == 'delete'){
    $delete_id = $_POST['id'];
    $delete_response = $obj->delete($delete_id);
    echo json_encode($delete_response);
}



