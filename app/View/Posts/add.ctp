<?php
    var_dump($categories);
?>

<h1>Add Post</h1>
<?php

// Postに対応するFormのひな形を作成する
echo $this->Form->create('Post');

// 指定したテーブルのカラムに対応するinputタグを作成する
echo $this->Form->input('title');

echo $this->Form->input('category_id',array('options'=>$categories));
// array()を使って詳細オプションを指定できる(classを指定してcssと連携するなど)
echo $this->Form->input('body', array('rows' => '3','class' => 'hogehoge'));
// submitボタンを作成しFormをくくる
echo $this->Form->end('Save Post');
?>


<h1>ピュアPHPでのAdd</h1>

<form action="/posts/add" method="post">
  <input type="text" name="title">
  <select name="category_id">
    <?php for ($i = 1;$i <= count($categories); $i++): ?>
        <option value="<?php echo $i ?>"><?php echo $categories[$i] ?></option>
    <?php endfor; ?>
  </select>
  <textarea name="body" cols="30" rows="10"></textarea>
  <input type="submit" value="Save">
</form>
