<!-- File: /app/View/Posts/add.ctp -->

<h1>Add Post</h1>
<?php
echo $this->Form->create('Post', array('type' => 'file'));
echo $this->Form->input('Category.id', 
    array('label' => 'カテゴリー',
        'options' => $select
        )
);
echo $this->Form->input('Post.title', array('label' => 'タイトル',));
echo $this->Form->input('Post.body', array( 'label' => '内容','rows' => '10'));
echo $this->Form->input('Tag.Tag', array( 
    'label' => 'タグ',
    'type' => 'select', 
    'multiple'=> 'checkbox',
    'options' =>  $check
));

//画像アップローダ
echo $this->Form->input('Image.0.name', array('type' => 'file', 'label' => "アップロード")); 
echo $this->Form->input('Image.0.model', array('type' => 'hidden', 'value' => 'Post')); 
echo $this->Form->input('Image.0.image_dir', array('type' => 'hidden'));
echo $this->Form->input('Image.1.name', array('type' => 'file', 'label' => false)); 
echo $this->Form->input('Image.1.model', array('type' => 'hidden', 'value' => 'Post')); 
echo $this->Form->input('Image.1.image_dir', array('type' => 'hidden'));
echo $this->Form->input('Image.2.name', array('type' => 'file', 'label' => false)); 
echo $this->Form->input('Image.2.model', array('type' => 'hidden', 'value' => 'Post')); 
echo $this->Form->input('Image.2.image_dir', array('type' => 'hidden'));
echo $this->Form->submit(__('保存'), array("class"=>"btn btn-primary", "div"=>false));
echo $this->Form->end();
?>

