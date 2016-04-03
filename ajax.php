<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="utf-8">
   <title>jQuery::非同期通信::Ajaxリクエスト::jQuery.ajax(options)の使用例</title>
   <!-- JS -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
   <script>
   function addTextToData(data) {
	   return 'This is Ajax: ' + data;
	 }


         $.ajax({
             type: "GET",
             url: "./ajax2.php",
             dataType: "json",

             success: function(json_data) {   // 200 OK時

                 alert("AAA "+json_data["abc"]);
             },
             error: function() {         // HTTPエラー時
                 alert("Server Error. Pleasy try again later.");
             }

         });


   </script>
<link rel="stylesheet" type="text/css" href="/common/css/example.css"></head>
<body id='example3' class='example'><div class="ads" style="margin:32px auto;text-align:center;"></div><h1 class='h'><a href='/'>PHP &amp; JavaScript Room</a> :: 設置サンプル</h1>
<h2 class='h'>jQuery.ajaxの使用例</h2>
<h3 class='h'>実行結果</h3>
<!-- CONTENT -->
   <h1>jQuery::非同期通信::Ajaxリクエスト::jQuery.ajax(options)の使用例</h1>
   <p>JavaScriptファイルを読み込んで実行します。アラートが表示されるはずです。</p>
<!-- CODE -->
<!-- / CODE -->
<!-- / CONTENT -->
</body>
</html>