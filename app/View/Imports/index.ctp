<h1>管理画面</h1>
<br>
<h2>
    <?php
        echo $this->Html->link(
            "csvインポート",
            array('action' => 'upload')
        );
    ?>
</h2>
<h2>
    <?php
        echo $this->Html->link(
            "csv更新",
            array('action' => 'update')
        );
    ?>
</h2>
<h2>
    <?php
        echo $this->Html->link(
            "郵便番号検索",
            array('action' => 'search')
        );
    ?>
</h2>
<h2>
    <?php
        echo $this->Html->link(
            "地域検索",
            array('action' => 'select')
        );
    ?>
</h2>
