<!-- File: /app/View/Posts/index.ctp -->
<?PHP echo $this->Html->css('index.css'); ?>

<div class="row">
<div class="col-2"></div>
<div class="col-6">
<h1><?php echo $this->Html->link('Blog posts', array('action' => 'index')); ?></h1>
<?php echo $this->element('pager')?> 
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('Post.id', 'ID')?></th>
        <th><?php echo $this->Paginator->sort('Post.title', 'タイトル')?></th>
        <th><?php echo $this->Paginator->sort('Category.name', 'カテゴリー')?></th>
        <th>タグ</th>
        <th>アクション</th>
        <th><?php echo $this->Paginator->sort('Post.created', '作成')?></th>
    </tr>

<!-- ここで $posts 配列をループして、投稿情報を表示 -->

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $post['Post']['id']; ?></td>
        <td>
            <?php
                echo $this->Html->link(
                    $post['Post']['title'],
                    array('action' => 'view', $post['Post']['id'])
                );
            ?>
        </td>
        <td><?php echo $post['Category']['name']; ?></td>
        <td><?php 
            foreach($post['Tag'] as $tag)
               echo $tag['name'], '  '; ?></td>
        <td>
            <?php
                echo $this->Form->postLink(
                    'Delete',
                    array('action' => 'delete', $post['Post']['id']),
                    array('confirm' => 'Are you sure?')
                );
            ?>
            <?php
                echo $this->Html->link(
                    'Edit', array('action' => 'edit', $post['Post']['id'])
                );
            ?>
            
        </td>
        
        <td>
            <?php echo $post['Post']['created']; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    

</table>
<?php echo $this->element('pager')?> 
</div>
<div class="col-3">
<?php echo $this->element('search')?> 
</div>
<div class="col-1"></div>
</div>

<!-- index.jsファイル読み込み -->
<?php echo $this->Html->script('index.js'); ?>

