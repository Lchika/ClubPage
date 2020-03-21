# データベース設計書

- サイトには作品紹介と記事を載せる。
- ~~それぞれ同じテーブルにしてよさそうとも思ったが、フロント側の取得方法がめんどくさくなりそうなので、テーブルを分ける。~~
  - やっぱりタグまわりがめんどくさくなりそうなので、テーブルをまとめる
  - カテゴリーで管理する
- 記事にはコメントできる。
- 作品及び記事はタグをつけることができる。
- 作品紹介には複数の記事を紐づけることができる。
- コラムには1つの作品を紐づけることができる。

## postsテーブル
|列名|型|PRIMARY|UNIQUE|NOT NULL|FOREIGN|
|-|-|-|-|-|-|
|id|VARCHAR(255)|*|*|*||
|title|TEXT|||*||
|category_id|INTEGER|||*|categorys(id)|
|abstract|TEXT|||||
|body|TEXT|||*||
|thumbnail|VARCHAR(255)|||||
|created_at|TIMESTAMP|||||
|updated_at|TIMESTAMP|||||

## commentsテーブル
|列名|型|PRIMARY|UNIQUE|NOT NULL|FOREIGN|
|-|-|-|-|-|-|
|id|SERIAL|*|*|*||
|post_id|VARCHAR(255)|||*|posts(id)|
|user_name|TEXT|||||
|user_link|TEXT|||||
|body|TEXT|||*||
|created_at|TIMESTAMP|||||
|updated_at|TIMESTAMP|||||

## tagsテーブル
|列名|型|PRIMARY|UNIQUE|NOT NULL|FOREIGN|
|-|-|-|-|-|-|
|id|SERIAL|*|*|*||
|name|VARCHAR(255)|||*||

## tagmapsテーブル
|列名|型|PRIMARY|UNIQUE|NOT NULL|FOREIGN|
|-|-|-|-|-|-|
|id|SERIAL|*|*|*||
|post_id|VARCHAR(255)|||*|posts(id)|
|tag_id|INTEGER|||*|tags(id)|

## categorysテーブル
|列名|型|PRIMARY|UNIQUE|NOT NULL|FOREIGN|
|-|-|-|-|-|-|
|id|SERIAL|*|*|*||
|name|VARCHAR(255)|||*||

## postrelationsテーブル
|列名|型|PRIMARY|UNIQUE|NOT NULL|FOREIGN|
|-|-|-|-|-|-|
|id|SERIAL|*|*|*||
|relate_post_id|VARCHAR(255)|||*|posts(id)|
|related_post_id|VARCHAR(255)|||*|posts(id)|

## 参考
- https://www.hypertextcandy.com/vue-laravel-tutorial-application-design/
- https://qiita.com/AkiYanagimoto/items/b363d673d9f2bf63fc0f