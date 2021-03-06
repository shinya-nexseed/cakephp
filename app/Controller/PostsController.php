<?php
    class PostsController extends AppController {
        public $helpers = array('Html','Form');

        // アソシエーションで複数のModelとひもづける場合は明示的に指定する必要がある
        public $uses = array('Post','Category');

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

        public function add() {

            //categoriesデータ取得
            // find('list')
            // View側でvar_dump()して要確認
            // allと同じく全件を取得するが、取得する際一件一件に数字がつく
            // 選択ラベルなどを作成するのに便利なデータの取り方
            $categories = $this->Category->find('list');

            // 下記書き方の省略版
            // $this->set('categories', $categories);
            $this->set(compact('categories'));

            // if ($_REQUEST['POST'] == 'POST')
            // Twitter_bbsなどピュアPHPで実装してきた上記の意味
            // Formからsumit処理が行われた際のmethodの中身、リクエストがgetなのかpostなのかを判定し、
            // postならデータの入力として扱うための条件分岐。
            // $this->request->is()はリクエスト処理を判定するための記述
            if ($this->request->is('post')) {

                // データの追加
                // CakePHPでデータをDBに追加するには、
                // create()をまず呼び出し、その後にsave()を使って
                // requestの中にあるdataを保存する。
                $this->Post->create();
                if ($this->Post->save($this->request->data)) {
                    // Flashメッセージを出す
                    // ユーザーが行った処理が正常に実行されたかどうかをユーザー自身に
                    // 知らせるための機能
                    $this->Session->setFlash(__('Your post has been saved.'));

                    // $this->redirect()
                    // 指定したページに遷移する
                    // returnを入れることでここで一連の処理を終了する
                    // ピュアPHPで使っていたheader()と同じ役割
                    return $this->redirect(array('action' => 'index'));
                }
                $this->Session->setFlash(__('Unable to add your post.'));
            }
        }

        public function edit($id = null) {

            // まずは指定されたpostデータが存在するか検証
            if (!$id) {
                throw new NotFoundException(__('Invalid post'));
            }

            // 次にそのpostデータが空でないか検証
            $post = $this->Post->findById($id);
            if (!$post) {
                throw new NotFoundException(__('Invalid post'));
            }
            
            $categories = $this->Category->find('list');
            $this->set(compact('categories'));

            // リクエストがpostもしくはputかどうかで条件分岐
            // putとは、postと同じようにデータを送る側のリクエストメソッド
            // postは新規データの入力 (INSERT) であるのに対し、
            // putは既存データの更新 (UPDATE) の際のリクエスト

            // データがすでに存在していて、書き換える際の処理
            if ($this->request->is(array('post', 'put'))) {
                $this->Post->id = $id;
                if ($this->Post->save($this->request->data)) {
                    $this->Session->setFlash(__('Your post has been updated.'));
                    return $this->redirect(array('action' => 'index'));
                }
                $this->Session->setFlash(__('Unable to update your post.'));
            }

            // データが存在していなければそのまま新規で保存
            if (!$this->request->data) {
                $this->request->data = $post;
            }
        }

        public function delete($id) {
            if ($this->request->is('get')) {
                throw new MethodNotAllowedException();
            }

            // delete()でDELETE処理を実行 (引数に削除したいデータのidを指定)
            if ($this->Post->delete($id)) {
                $this->Session->setFlash(
                    __('The post with id: %s has been deleted.', h($id))
                );
            } else {
                $this->Session->setFlash(
                    __('The post with id: %s could not be deleted.', h($id))
                );
            }

            return $this->redirect(array('action' => 'index'));
        }
    }
?>















