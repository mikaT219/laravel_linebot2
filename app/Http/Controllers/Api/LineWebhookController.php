<?php

namespace App\Http\Controllers\Api;
//Log::info(‘ログ出力テスト’);
use Log;//一番上でね
//Log::debug($data);
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Exception;

class LineWebhookController extends Controller
{

    public function webhook (Request $request)
    {
      {

      $channel_secret = env('LINE_CHANNEL_SECRET');
      $access_token = env('LINE_ACCESS_TOKEN');
      $request_body = $request->getContent();
      $hash = hash_hmac('sha256', $request_body, $channel_secret, true);
      $signature = base64_encode($hash);

      if($signature === $request->header('X-Line-Signature')) {   // LINEからの送信を検証

          $client = new CurlHTTPClient($access_token);
          $bot = new LINEBot($client, ['channelSecret' => $channel_secret]);

          try {

              $events = $bot->parseEventRequest($request_body, $signature);

              foreach ($events as $event) {

                  if($event instanceof MessageEvent && $event instanceof TextMessage) {   // テキストメッセージの場合

                      $text = $event->getText();              // LINEで送信されたテキスト
                      $reply_token = $event->getReplyToken(); // 返信用トークン

                      // QRコード作成
                      //$filename = Str::random() .'.png';
                      //$path = public_path('qr_code/'. $filename);
                      //$qrCode = new QrCode($text);
                      //$qrCode->writeFile($path);

                      // 画像メッセージで返信
                      //$url = url('qr_code/'. $filename);
                      //$replying_message = new ImageMessageBuilder(
                          //$url,
                          //$url
                      //);
                      $bot->replyMessage($reply_token, "ハロー");

                  }

              }

          } catch (\Exception $e) {}

      }

  }

}
