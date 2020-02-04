<!-- File: /app/View/Posts/view.ctp -->
<?PHP echo $this->Html->css('modal.css'); ?>


<h1><?php echo h($post['Post']['title']); ?></h1>

<p><small>Created: <?php echo $post['Post']['created']; ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p>

<!--　画像表示  -->
 <?php  
    $base = "/files/image/name/" ;
    $num = 0;
    foreach ($post['Image'] as $i) {
    echo $this->Html->image( $base . $i['image_dir'] . "/" . "thumb_".$i['name'] , array('class' => "display", 'id' => "${num}"));
    $num += 1;
    }

    $num2 = 0;
    foreach ($post['Image'] as $i) {
      //modal contents
 
      echo '<div class="popup '.$num2.'">';
      echo '<div class="container">';
      echo '<div class="popup-container row">';
      echo '<div class="col-2">';
      echo '<button class="rev">前へ</button>';
      echo '</div>';
      echo '<div class="content col-8">';
      echo $this->Html->image( $base . $i['image_dir'] . "/" . $i['name'] , array('class' => "modalImage"));
      echo '</div>';
      echo '<div class="col-2">';
      echo '<button class="next">次へ</button>';
      echo '</div>';
      echo '</div>';
      echo '<div class="under-container row">';
      echo '<div class="col-10">';
      echo '</div>';
      echo '<div class="col-2">';
      echo '<button class="end">閉じる</button>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';


      $num2 += 1;

    }
 ?>


 <?PHP echo $this->Html->script('modal.js'); ?>
 



