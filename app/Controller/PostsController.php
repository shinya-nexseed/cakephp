<?php
    class PostsController extends AppController {
        public $helpers = array('Html','Form');
        public function index() {
            $posts = $this->Post->find('all');

            $this->set('posts', $posts);

            // PostsControllerのindex()関数について
            // Controller内で定義された関数のことを、フレームワークではアクションと呼びます。
            // 今回は、「PostsControllerにindexアクションを定義した」ことになります。
            // これは、ブラウザから「/posts/index」というリクエストを受け取った時に呼ばれる。

            // $thisについて
            // Controller内ではよく$thisの表現を使います。
            // この「this」は、単に自分自身 (PostsController) を指すような言葉として理解してください。

            // $this->Postについて
            // $this->Postで、Postモデルを呼び出すことができます。
            // Postモデルは、DB内のpostsテーブルの情報を取得してくれるので、
            // $this->Postで「postsテーブルの情報を取得する」という意味になります。

            // find('all')について
            // モデルにはモデルが持っているデータを操作するためのいくつかの関数が用意されています。
            // 今回はその中のfind()関数にallという引数を与えています。
            // find()関数は、与えられた引数に応じてモデルの中のデータを検索し取得する関数で、
            // allを付けることで「全件取得する」という意味になります。

            // $this->set(A,B)について
            // $this->set(A,B)は、モデルから取得したデータをViewに渡せるように変換する関数です。
            // Aの部分が実際にView側で呼ぶことのできる変数名、
            // Bの部分がそのAに入れたいデータ本体。

            // 以上のことから、今回のコードは、、
            // /posts/indexのリクエストがあった際、postsテーブルのデータを全件取得し、
            // postsという変数にそのデータを代入してViewで使えるようにするためのコードです。

        }

        public function view($id = null) {
            if (!$id) {
                throw new NotFoundException(__('Invalid post'));
            }

            // findById()関数
            // この関数は、指定したテーブルのidが一致するデータ一件を取得する
            // このコードの場合、$this->Postでpostsテーブルの中を、
            // findById($id)で$idに入ってきたid(URLの/posts/view/id)を
            // 使って検索している。
            // その結果を$post変数に代入している
            $post = $this->Post->findById($id);
            
            if (!$post) {
                throw new NotFoundException(__('Invalid post'));
            }

            // $postとしてview側で使用できるようにsetする
            $this->set('post', $post);
        }


    }
?>















