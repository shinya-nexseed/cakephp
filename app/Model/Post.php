<?php
    // AppModel.phpを親クラスにして、機能を継承する
    class Post extends AppModel {

        // データに対する処理は本来Model側が持つのが原則です
        // ピュアPHPでは、FormなどがあるViewと同じファイル上で
        // データの検証なども行っていましたが、MVCの概念ではルール違反になります
        public $validate = array(
            // title部分がテーブルのカラムに対応した値
            'title' => array(
                'rule' => 'notEmpty'
            ),
            'body' => array(
                'rule' => 'notEmpty'
            )
        );
    }

?>
