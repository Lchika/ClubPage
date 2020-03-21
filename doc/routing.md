# ルーティング設計書

## API 

|URL|メソッド|認証|内容|
|-|-|-|-|
|/api/posts|GET||記事 一覧取得|
|/api/posts|POST|*|記事 投稿|
|/api/posts/{ポストID}|GET||記事 詳細取得|
|/api/posts/{ポストID}|PUT|*|記事 更新|
|/api/posts/{ポストID}/comments|POST||コメント 投稿|
|/api/login|POST||ログイン|
|/api/logout|POST|*|ログアウト|

## API以外

|URL|メソッド|認証|内容|
|-|-|-|-|
|/|GET||ルートHTML返却|

## フロントエンド

|URL|メソッド|認証|内容|
|-|-|-|-|
|/|GET||トップページ|
|/posts/{ポストID}|GET||記事詳細ページ|