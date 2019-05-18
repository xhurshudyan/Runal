<?php
require_once 'db_connect.php';

class services_home {
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getData() {
        $target_dir = "../backend/img/services/";
        $files = scandir($target_dir);
        array_splice($files, 0, 2);
        array_multisort($files, SORT_NUMERIC, SORT_DESC);

        $query = mysqli_query($this->conn, "SELECT COUNT(*) as count FROM `services`");
        $count = mysqli_fetch_array($query)['count'];
        $notesOnPage = 3;
        $pages = ceil($count / $notesOnPage);

        for ($i = 0; $i < $pages; $i ++) {
            $from = $i * $notesOnPage;
            $title = [];
            $text = [];
            $query = mysqli_query($this->conn,"SELECT * FROM `services` ORDER BY ID DESC LIMIT $from, $notesOnPage");
            while ($result = mysqli_fetch_array($query)) {
                $title[] = $result['title'];
                $text[] = $result['content'];
            }
            $image = array_slice($files, $from, $notesOnPage);

            if ($i == 0) {
                echo '<div class="item active">';
            } else {
                echo '<div class="item">';
            }
            echo '<div class="row">';
            for ($j = 0; $j < count($title); $j++) {
                echo '<div class="col-sm-4">';
                echo "<div class='service-media'>  <img src='../backend/img/services/{$image[$j]}' alt='' /></div>";
                echo '<div class="service-desc">';
                echo '<h3>' . $title[$j] . '</h3>';
                echo '<p>' . $text[$j] . '</p>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        }
        if($pages > 1) {
            echo  ' <div class="blog-carousel-control"> <a class="left fa fa-angle-left" href="#blogCarousel" data-slide="prev"></a> <a class="right fa fa-angle-right" href="#blogCarousel" data-slide="next"></a> </div>';
        }
    }
}

$data = new services_home($conn);
$data->getData();