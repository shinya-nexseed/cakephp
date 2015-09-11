<?php
    // // 配列の復習
    // $members = array("Rei","Shogo","Shinya");
    // // echo $members;
    // // echoよりも更にデータの詳細を表示してくれるvar_dump()
    // var_dump($members);

    // // デバッグ手法
    // // ピュアPHPやフレームワークを使ったWEBサービス開発では、
    // // var_dumpを使って自分が作った変数の中身を表示して
    // // 間違いがないか探すことがよくある。
    // // この間違い探しの方法をデバッグと言います。

    // // 他サンプル
    // $str1 = "NexSeed";
    // $str2 = "ネクシード";
    // $int = 12;
    // var_dump($str1);
    // var_dump($str2);
    // var_dump($int);

    // // 連想配列
    // $members2 = array("Yamashiro" => "Rei", "Kobari" => "Shogo", "Hirai" => "Shinya");
    // var_dump($members2);

    // // 配列の各要素の取り出し方
    // $member1 = $members[0];
    // var_dump($member1);

    // // 連想配列の各要素の取り出し方
    // $member2 = $members2["Kobari"];
    // var_dump($member2);

    // /app/Controller/PostsController.phpファイルのindexアクション内で定義した
    // $this->set('posts', $this->Post->find('all'));の部分。
    //               ↑ このpostsがView側で$をつけて使用できるようになる
    
    // Index0の要素すべて出力
    var_dump($posts[0]['Post']['id']);
    var_dump($posts[0]['Post']['title']);
    var_dump($posts[0]['Post']['body']);
    var_dump($posts[0]['Post']['created']);
    var_dump($posts[0]['Post']['modified']);

    // すべての要素のtitleのみ取得
    // var_dump($posts[0]['Post']['title']);
    // var_dump($posts[1]['Post']['title']);
    // var_dump($posts[2]['Post']['title']);
?>

<?php
    echo $this->Html->link( // <a>タグを作成
        'Add Post', // 画面に表示するリンク文字
        array('controller' => 'posts', 'action' => 'add') // Controllerとactionを指定
    );
?>

<!-- ピュアPHPでadd画面へのリンク -->
<a href="/posts/add">Add Post</a>

<h1>Blog posts</h1>
<h2>for文の場合</h2>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <!-- ここから、$posts配列をループして、投稿記事の情報を表示 -->
    <?php for ($i = 0; $i < count($posts); $i++): ?>
    <?php 
        echo $i;
        // $iは、0から始まり、count($posts)の数に達するまで毎回1ずつ増えます。
        // その$iを利用して、$postsの最初の配列のindexに当て込めば、
        // 繰り返し処理があるごとに違うデータを取得できます。
    ?>
    <tr>
      <td><?php echo $posts[$i]['Post']['id']; ?></td>
      <td><a href="/posts/view/<?php echo $posts[$i]['Post']['id']; ?>"><?php echo $posts[$i]['Post']['title']; ?></a></td>
      <td><?php echo $posts[$i]['Post']['created']; ?></td>
    </tr>
    <?php endfor; ?>
</table>

<h2>foreachの場合</h2>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Category</th>
        <th>Action</th>
        <th>Created</th>
    </tr>

    <!-- ここから、$posts配列をループして、投稿記事の情報を表示 -->
    <?php foreach ($posts as $post): ?>
    <?php var_dump($post) ?>
    <tr>
      <td><?php echo $post['Post']['id']; ?></td>
      <td><?php echo $this->Html->link($post['Post']['title'],
array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?></td>
      <td><?php echo $post['Category']['name']; ?></td>
      <td>
        <?php echo $this->Form->postLink(
            'Delete',
            array('action' => 'delete', $post['Post']['id']),
            array('confirm' => 'Are you sure?'));
        ?>
        <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id'])); ?>
      </td>
      <td><?php echo $post['Post']['created']; ?></td>
    </tr>
    <?php endforeach; ?>

</table>




















