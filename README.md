## タイトル
Lavavel + Vue でyoutube動画紹介サイト

## 機能紹介
ユーザー登録(Laravelの既存システム流用)<br>
動画登録<br>
　・YoutubeAPIより、動画タイトル/サムネイル画像/動画説明/チャンネル名/チャンネル画像/タグなどの情報を取得<br>
　・動画を登録したユーザーと動画を紐づけ<br>
　・動画を登録したユーザーは登録後、動画説明/動画タイトルを編集/削除が可能<br>
いいね機能<br>
　・Vue.jsで非同期でいいねが反映<br>
 <br>
## 各ロールで可能な機能<br>
 【管理人】<br>
　 ・動画登録<br>
 　・すべての登録動画の編集/削除<br>
 　・いいね機能<br>
 　<br>
 【登録ユーザ】<br>
　・動画登録<br>
　・自分が登録した動画の編集/削除<br>
　・いいね機能<br>
<br>
【非登録ユーザー】<br>
　・登録されている動画を閲覧<br>
 <br>
## 公開URL
https://youtube-fan.herokuapp.com/<br>
<br>
動作チェックは以下のアカウントでログインできます。<br>
【ロール：管理人】<br>
ID：admin@admin.com<br>
PassWord：adminpassword<br>
