<?php
ob_start();
error_reporting(0);
date_Default_timezone_set('Asia/Tashkent');

define('API_KEY',"8199560732:AAE2pl6EYhYZt1tQmNFbyd0Ec5DsAhNGUJ0");
$admins = [7530833627]; //1
$adminGL = "7530833627"; //2
$admin = array($adminGL); 
$bot = bot('getme',['bot'])->result->username;
$adminx = array($adminGL); // Admin ID larini o‘zgartiring

function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}}

function addstat($id){
$stat=file_get_contents("users");
$check=explode("\n",$stat);
if(!in_array($id,$check)){
file_put_contents("users","\n".$id,8);
}
}
function addblock($id){
$stat=file_get_contents("block");
$check=explode("\n",$stat);
if(!in_array($id,$check)){
file_put_contents("block","\n".$id,8);
}
}
function joinchat($id) {
    global $bot;
    static $lastMessageId = null; // Oldingi xabar ID sini saqlash uchun
    $kanallar = file_get_contents("channel.txt");
    
    if ($kanallar == null) {
        return true;
    }

    $ex = array_filter(explode("\n", $kanallar));
    $array = ['inline_keyboard' => []];
    $uns = false;

    foreach ($ex as $i => $first_line) {
        $first_ex = explode("@", $first_line);
        $url = trim($first_ex[1]);

        $chatInfo = bot('getChat', ['chat_id' => "@$url"]);
        $ism = $chatInfo->result->title ?? "Noma'lum kanal";

        $ret = bot("getChatMember", [
            "chat_id" => "@$url",
            "user_id" => $id,
        ]);
        
        $stat = $ret->result->status ?? null;

        if ($stat == "creator" || $stat == "administrator" || $stat == "member") {
            $array['inline_keyboard'][] = [['text' => "✅ $ism", 'url' => "https://t.me/$url"]];
        } else {
            $array['inline_keyboard'][] = [['text' => "❌ $ism", 'url' => "https://t.me/$url"]];
            $uns = true;
        }
    }

    $array['inline_keyboard'][] = [['text' => "🔄 Tekshirish", 'callback_data' => "checksuv"]];

    if ($uns) {
        if ($lastMessageId) {
            bot('deleteMessage', [
                'chat_id' => $id,
                'message_id' => $lastMessageId
            ]);
        }

        $msg = bot('sendMessage', [
            'chat_id' => $id,
            'text' => "<b>⚠️ Kanallarga obuna bo'ling!</b>",
            'parse_mode' => 'html',
            'reply_markup' => json_encode($array),
        ]);

        if (isset($msg->result->message_id)) {
            $lastMessageId = $msg->result->message_id;
        }

        return false;
    } else {
        return true;
    }
}
// Agar xabar muvaffaqiyatli yuborilgan bo‘lsa, eski xabarni o‘chirishga harakat qiladi
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$cid = $message->chat->id;
$name = $message->chat->first_name;
$tx = $message->text;
$step = file_get_contents("step/$cid.step");
$mid = $message->message_id;
$type = $message->chat->type;
$text = $message->text;
$uid= $message->from->id;
$name = $message->from->first_name;
$familya = $message->from->last_name;
$bio = $message->from->about;
$username = $message->from->username;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$reply = $message->reply_to_message->text;
$nameru = "<a href='tg://user?id=$uid'>$name $familya</a>";

$botdel = $update->my_chat_member->new_chat_member; 
$botdelid = $update->my_chat_member->from->id; 
$userstatus= $botdel->status; 

$contact = $message->contact;
$contact_id = $contact->user_id;
$contact_user = $contact->username;
$contact_name = $contact->first_name;
$phone = $contact->phone_number;


//inline uchun metodlar
$data = $update->callback_query->data;
$qid = $update->callback_query->id;
$id = $update->inline_query->id;
$query = $update->inline_query->query;
$query_id = $update->inline_query->from->id;
$cid2 = $update->callback_query->message->chat->id;
$mid2 = $update->callback_query->message->message_id;
$callfrid = $update->callback_query->from->id;
$callname = $update->callback_query->from->first_name;
$calluser = $update->callback_query->from->username;
$surname = $update->callback_query->from->last_name;
$about = $update->callback_query->from->about;
$nameuz = "<a href='tg://user?id=$callfrid'>$callname $surname</a>";

$photo = $message->photo;
$file = $photo[count($photo)-1]->file_id;


mkdir("step");
mkdir("kino");

if(file_get_contents("kino/id.txt")==null){
file_put_contents("kino/id.txt",0);
}

$last_kino = file_get_contents("kino/id.txt");



if(file_get_contents("holat.txt")){
	}else{
		if(file_put_contents("holat.txt","Yoqilgan"));
}

if($botdel){ 
if($userstatus=="kicked"){ 
addblock($cid);
}}
if(isset($message)){
$block=file_get_contents("block");
$block=str_replace("\n".$cid,"",$block);
file_put_contents("block",$block);
}



$umum_d = date("d.m.Y H:i");
if(isset($message)){
addstat($cid);
}
$kanal_uz = file_get_contents("step/kanal.txt");
$kanalcha = file_get_contents("kino_ch.txt");
$holat = file_get_contents("holat.txt");
$menu = json_encode([
    'inline_keyboard'=>[
    [['text'=>"🗂️ Barcha kinolari",'url'=>"https://t.me/".str_ireplace("@",null,$kanalcha)]],
    ]
    ]);

$usermenu = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🔍 Qidirish"],['text'=>"🎟 Buyurtma"]],
[['text'=>"✉️ Yordam"]]
]
]);
$admenu = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🔍 Qidirish"],['text'=>"🎟 Buyurtma"]],
[['text'=>"✉️ Yordam"]],
[['text'=>"🔒 Admin Panel"]]
]
]);


$panel = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"📢 Kanallarni sozlash"]],
[['text'=>"📊 Statistika"],['text'=>"✉ Xabar Yuborish"]],
[['text'=>"📤 Kino Yuklash"],['text'=>'🗑 Kino O\'chirish']],
[['text'=>"🤖 Bot holati"],['text'=>"◀️Bosh sahifa"]],
]
]);
if ($text == "/start" or $text=="◀️Bosh sahifa") {
    if (in_array($cid,$admin)) { // Agar foydalanuvchi obuna bo‘lgan bo‘lsa
        bot('sendPhoto', [
            'photo' => 'https://67e96a318e592.myxvest1.ru/uzbekcinema/image.png',
            'chat_id' => $cid,
            'caption' => "- 👋 Assalomu alaykum <b>$name</b>, botimizga xush kelibsiz!\n👨‍💻 Adminlar ro'yxati:<blockquote>$adminGL</blockquote>",
            'parse_mode' => 'html',
            'reply_markup' => $admenu
        ]);
    }
    elseif (joinchat($cid)) { // Agar foydalanuvchi obuna bo‘lgan bo‘lsa
        bot('sendPhoto', [
            'photo' => 'https://67e96a318e592.myxvest1.ru/uzbekcinema/image.png',
            'chat_id' => $cid,
            'caption' => "- 👋 Assalomu alaykum <b>$name</b>, botimizga xush kelibsiz!",
            'parse_mode' => 'html',
            'reply_markup' => $usermenu
        ]);
    }
}/*
if ($text == "/start") {
    if (in_array($cid,$admin)) { // Agar foydalanuvchi obuna bo‘lgan bo‘lsa
        bot('sendMessage', [
            'chat_id' => $cid,
            'text' => "Xush kelibsiz ",
            'parse_mode' => 'html',
            'reply_markup' => $admenu
        ]);
    }
}*/
/*USER PANEL*/
/*
SEARCH MENU
 */

$searchmenu = json_encode([
    'inline_keyboard' => [
        [['text' => "#️⃣ Kodi bilan", 'callback_data' => "bycode"]],
        [['text' => "🔠 Nomi bilan", 'callback_data' => "byname"]],
        [['text' => "🎲 Tasodifiy", 'callback_data' => "byrandom"]],
    ]
]);


if ($text == "🔍 Qidirish" or $text == "/search") {
    bot('sendMessage', [
        'chat_id' => $cid,
        'text' => "🔍 Qidirish menyusi:",
        'parse_mode' => 'html',
        'reply_markup' => $searchmenu
    ]);
    file_put_contents("step/$cid.step", "search"); // Foydalanuvchi bosqichi saqlanadi
    exit();
}

$mbu = json_encode([
    'inline_keyboard' => [
        [['text' => "🗂️ Barcha kinolari", 'url' => "https://t.me/".str_ireplace("@", "", $kanalcha)]],
        [['text' => "🔙 Orqaga", 'callback_data' => "backmenu"]],
    ]
]);

if ($data == "backmenu") {
    bot('editMessageText', [
        'chat_id' => $cid2,
        'message_id' => $mid2,
        'text' => "🔍 Qidirish menyusi:",
        'parse_mode' => 'html',
        'reply_markup' => $searchmenu
    ]);
    
    if (file_exists("step/$cid2.step")) {
        unlink("step/$cid2.step"); // Foydalanuvchi bosqichini tozalash
    }
    
    exit();
}

if ($data == "bycode") {
    file_put_contents("step/$cid2.step", "bycode");
    bot('editMessageText', [
        'chat_id' => $cid2,
        'message_id'=>$mid2,
        'text' => "#️⃣ Kodni kiriting:",
        'parse_mode' => 'html',
        'reply_markup'=>$mbu
    ]);
}

if ($data == "byname") {
    file_put_contents("step/$cid2.step", "byname");
    bot('editMessageText', [
        'chat_id' => $cid2,
        'message_id'=>$mid2,
        'text' => "🔠 Kino nomini kiriting:",
        'parse_mode' => 'html',
        'reply_markup'=>$mbu
    ]);
}

if ($data == "byrandom") {
    $folders = array_filter(glob("kino/*"), 'is_dir');
    if (count($folders) > 0) {
        $random = $folders[array_rand($folders)];
        send_kino($cid2, $random);
    } else {
        bot('editMessageText', [
            'chat_id' => $cid2,
            'message_id'=>$mid2,
            'text' => "Hech qanday kino topilmadi.",
            'reply_markup'=>$menu
        ]);
    }
}

if (file_exists("step/$cid.step")) {
    $step = file_get_contents("step/$cid.step");
    unlink("step/$cid.step");

    if ($step == "bycode") {
        $path = "kino/$text";
        if (file_exists("$path/film.txt")) {
            send_kino($cid, $path);
        } else {
            bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "❌ Bunday koddagi kino topilmadi."
            ]);
        }
    }

    if ($step == "byname") {
        $text = mb_strtolower($text);
        $found = false;
        foreach (glob("kino/*/nomi.txt") as $file) {
            $nomi = file_get_contents($file);
            if (mb_stripos(mb_strtolower($nomi), $text) !== false) {
                send_kino($cid, dirname($file));
                $found = true;
                break;
            }
        }
        if (!$found) {
            bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "❌ Bunday nomli kino topilmadi."
            ]);
        }
    }
}

function send_kino($chat_id, $path) {
    global $bot, $kanalcha;

    $code = basename($path);
    $nomi = @file_get_contents("$path/nomi.txt");
    $tili = @file_get_contents("$path/tili.txt");
    $formati = @file_get_contents("$path/formati.txt");
    $janri = @file_get_contents("$path/janri.txt");
    $yosh = @file_get_contents("$path/yosh.txt");
    $video_id = @file_get_contents("$path/film.txt");

    $downcount = file_exists("$path/downcount.txt") ? file_get_contents("$path/downcount.txt") : 0;
    $downcount++;
    file_put_contents("$path/downcount.txt", $downcount);

    bot('sendVideo', [
        'chat_id' => $chat_id,
        'video' => $video_id,
        'caption' => "
<b>🎬| Kino Nomi: $nomi
➖➖➖➖➖➖➖➖➖➖➖➖
🌐| Tili: $tili
💾| Sifati: $formati
🎭| Janri:  $janri
⛔️| Yosh chegarasi: $yosh
➖➖➖➖➖➖➖➖➖➖➖➖
🔗| Kanal: $kanalcha
📁 Yuklash: $downcount

🤖 Bizning bot: @$bot</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "📋 Ulashish", 'url' => "https://t.me/share/url?url=https://t.me/$bot?start=$code"]]
            ]
        ])
    ]);
}



/*
SEARCH MENU
 */


  /*USER PANEL*/
$back = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]
]);

$boshqarish = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqarish"]],
]
]);

$holat = file_get_contents("holat.txt");
if($text){
 if($holat == "O'chirilgan"){
	if(in_array($cid,$admin)){
}else{
	bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"⛔️ <b>Bot vaqtinchalik o'chirilgan!</b>

<i>Botda ta'mirlash ishlari olib borilayotgan bo'lishi mumkin!</i>",
'parse_mode'=>'html',
]);
exit();
}
}
}

if($data){
 if($holat == "O'chirilgan"){
	if(in_array($cid2,$admin)){
}else{
	bot('answerCallbackQuery',[
		'callback_query_id'=>$qid,
		'text'=>"⛔️ Bot vaqtinchalik o'chirilgan!

Botda ta'mirlash ishlari olib borilayotgan bo'lishi mumkin!",
		'show_alert'=>true,
		]);
exit();
}
}
}

if($data=="checksuv"){
bot('deleteMessage',[
	'chat_id'=>$cid2,
	'message_id'=>$mid2,
	'text'=>"Obuna tasdiqlandi ✅\n/start"
	]);
if(joinchat($cid2) == true){
$text=file_get_contents("step/$cid2.kino_ids");
if($text!==null){
$nomi=file_get_contents("kino/$text/nomi.txt");
$tili=file_get_contents("kino/$text/tili.txt");
$formati=file_get_contents("kino/$text/formati.txt");
$janri=file_get_contents("kino/$text/janri.txt");
$yosh=file_get_contents("kino/$text/yosh.txt");
$downcount=file_get_contents("kino/$text/downcount.txt");
$downcount=+1;
file_put_contents("kino/$text/downcount.txt",$downcount);
$video_id=file_get_contents("kino/$text/film.txt");
bot('sendVideo',[
'chat_id'=>$cid2,
'video'=>$video_id,
'caption'=>"<b>🎬| Kino Nomi: $nomi
➖➖➖➖➖➖➖➖➖➖➖➖
🌐| Tili: $tili
💾| Sifati: $formati
🎭| Janri:  $janri
⛔️| Yosh chegarasi: $yosh
➖➖➖➖➖➖➖➖➖➖➖➖
🔗| Kanal: $kanalcha
📁 Yuklash: $downcount

🤖 Bizning bot: @$bot</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📋 Ulashish",'url'=>"https://t.me/share/url?url=https://t.me/$bot?start=$text"]],
]
])
]);
unlink("step/$cid2.kino_ids");
exit();
}else{
	bot('SendMessage',[
	'chat_id'=>$cid2,
	'text'=>"<b>✅ Obunangiz tasdiqlandi!</b>",
	'parse_mode'=>'html'
	]);
    bot('sendPhoto', [
        'chat_id' => $cid,
        'photo' => 'image.png', // Rasm URL manzili
        'caption' => "👋 Assalomu Alaykum, **$name**!\n\nMarhamat, kino kodini yuboring:",
        'parse_mode' => 'Markdown',
        'reply_markup' => $menu
    ]);
	exit();
}
}
}


if($text == "◀️ Orqaga" and joinchat($cid) == true){        
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"👋 Salom, $name!

Marhamat, kino kodini yuboring:",
'parse_mode'=>'html',
'disable_web_page_preview'=>true,
'reply_markup'=>$menu
]);
unlink("step/$cid.step");
exit();
}


if($text == "🗄 Boshqarish" or $text=="🔒 Admin Panel"){
	if(in_array($cid,$admin)){
	bot('SendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>Admin paneliga xush kelibsiz!</b>",
	'parse_mode'=>'html',
	'reply_markup'=>$panel,
	]);
	unlink("step/$cid.step");
   unlink("step/test.txt");
   unlink("step/$cid.txt");
	exit();
}
}

if($data == "boshqarish"){
	bot('deleteMessage',[
	'chat_id'=>$cid2,
	'message_id'=>$mid2,
	]);
	bot('SendMessage',[
	'chat_id'=>$cid2,
	'text'=>"<b>Admin paneliga xush kelibsiz!</b>",
	'parse_mode'=>'html',
	'reply_markup'=>$panel,
	]);
	exit();
}


if($text == "📢 Kanallarni sozlash"){
if(in_array($cid,$admin)){
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 Majburiy obuna",'callback_data'=>"kqosh"]],
[['text'=>"*️⃣ Qo'shimcha kanallar",'callback_data'=>"qoshimchakanal"]],
]
])
]);
exit();
}
}

if($data == "kanalsozla"){
if(in_array($cid2,$admin)){
bot('editMessageText',[
'chat_id'=>$cid2,
'message_id'=>$mid2,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 Majburiy obuna",'callback_data'=>"kqosh"]],
[['text'=>"*️⃣ Qo'shimcha kanallar",'callback_data'=>"qoshimchakanal"]],
]
])
]);
exit();
}
}

if($data=="qoshimchakanal"){
bot('editMessageText',[
'chat_id'=>$cid2,
'message_id'=>$mid2,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📝 Kino kanal",'callback_data'=>"kinokanal"]],
[['text'=>"🔙 Orqaga",'callback_data'=>"kanalsozla"]],
]
])
]);
exit();
}

if($data=="kinokanal"){
bot('deleteMessage',[
'chat_id'=>$cid2,
'message_id'=>$mid2
]);
bot('sendMessage',[
'chat_id'=>$cid2,
'text'=>"<b>Kinolar yuboriladigan kanalni kiriting:</b>

<i>Namuna: @username</i>",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid2.step",'kinokanal');
exit();
}

if($step=="kinokanal" and in_array($cid,$admin)){
if(stripos($text,"@")!==false){
file_put_contents("kino_ch.txt",$text);
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>✅ Saqlandi!</b>",
'parse_mode'=>'html',
'reply_markup'=>$panel,
]);
unlink("step/$cid.step");
exit();
}else{
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⛔️ Faqat kanalning foydalanuvchi nomini yuboring!</b>",
'parse_mode'=>'html'
]);
exit;
}
}

if($data=="kanallar"){
bot('editMessageText',[
'chat_id'=>$cid2,
'message_id'=>$mid2,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ Kanal Qo'shish",'callback_data'=>"kqosh"],['text'=>"🗑 Kanallarni O'chirish",'callback_data'=>"kochir"]],
[['text'=>"📑 Kanallar Ro'yxat",'callback_data'=>"mroyxat"]],
[['text'=>"➡️ Orqafa",'callback_data'=>"kanalsozla"]],
]
])
]);
exit();
}

/*Kanal obuna bo'lish*/
if($data == "kqosh"){
	if($text=="/start"){
unlink("step/$cid.step");
}else{
bot('editMessagetext',[
'chat_id'=>$cid2,
	'message_id'=>$mid2,
'text'=>"*📢 Kerakli kanalni manzilini yuboring:*",
'parse_mode'=>'MarkDown',
'reply_markup'=>$back1
]);
file_put_contents("step/$cid2.step",'qosh');
}}

if($step == "qosh"){
if($text=="/start"){
unlink("step/$cid.step");
}else{
if(stripos($text,"@")!==false){
if($kanallar == null){
file_put_contents("channel.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>$text - kanal qo'shildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$panel,
]);
unlink("step/$cid.step");
}else{
file_put_contents("channel.txt","$kanallar\n$text");
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>$text - kanal qo'shildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$panel,
]);
unlink("step/$cid.step");
}}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Kanal manzili kiritishda xatolik:</b>

Masalan: @LiveBuildersNews",
'parse_mode'=>'html',
]);
}}}

if($data=="kochir"){
bot('deleteMessage',[
'chat_id'=>$cid2,
'message_id'=>$mid2,
]);
bot('sendMessage',[
'chat_id'=>$cid2,
'text'=>"<b>🗑 Kanallar o'chirildi!</b>",
'parse_mode'=>"html",
]);
unlink("channel.txt");
}

if($data=="mroyxat"){
if($kanallar==null){
bot('deleteMessage',[
'chat_id'=>$cid2,
'message_id'=>$mid2,
]);
bot('sendMessage',[
'chat_id'=>$cid2,
'text'=>"<b>Kanallar ulanmagan!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🏡 Bosh menyu",'callback_data'=>"profil"],['text'=>"◀️ Orqaga",'callback_data'=>"panel"]],
]])
]);
}else{
$soni = substr_count($kanallar,"@");
bot('editMessageText',[
'chat_id'=>$cid2,
'message_id'=>$mid2,
'text'=>"<b>Ulangan kanallar ro'yxati ⤵️</b>
➖➖➖➖➖➖➖➖

<i>$kanallar</i>

<b>Ulangan kanallar soni:</b> $soni ta",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🏡 Bosh menyu",'callback_data'=>"profil"],['text'=>"◀️ Orqaga",'callback_data'=>"panel"]],
]])
]);
}}

if($text == "📊 Statistika"){
if(in_array($cid,$admin)){
$ping=sys_getloadavg();
$stat=substr_count(file_get_contents("users"),"\n");
$nostat=substr_count(file_get_contents("block"),"\n")??0;
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"💡 <b>O'rtacha yuklanish:</b> <code>$ping[0]</code>

👥 <b>Foydalanuvchilar:</b> $stat ta 
⛔️ <b>Nofaol:</b> $nostat ta ",
'parse_mode'=>'html'
]);
exit();
}
}



if($text == "✉ Xabar Yuborish" or $text == "/help"){
if(in_array($cid,$admin)){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Yuboriladigan xabar turini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"👤 Userga",'callback_data'=>"user"]],
[['text'=>"🗣️ Oddiy",'callback_data'=>"send"]],
[['text'=>"Orqaga",'callback_data'=>"boshqarish"]],	
]
])
]);
exit();
}
}

if($data == "user"){
bot('deleteMessage',[
'chat_id'=>$cid2,
'message_id'=>$mid2,
]);
bot('sendMessage',[
'chat_id'=>$cid2,
'text'=>"<b>Foydalanuvchi iD raqamini kiriting:</b>",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid2.step",'user');
exit();
}

if($step == "user"){
if(in_array($cid,$admin)){
if(is_numeric($text)=="true"){
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Foydalanuvchiga yubormoqchi bo'lgan xabaringizni kiriting:</b>",
'parse_mode'=>'html',
]);
file_put_contents("step/$cid.step","xabar-$text");
exit();
}else{
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Faqat raqamlardan foydalaning!</b>",
'parse_mode'=>'html',
]);
exit();
}
}
}

if(mb_stripos($step, "xabar-") !== false){
if(in_array($cid,$admin)){
$id = explode("-", $step)[1];
$get = bot('getChat',[
'chat_id'=>$id,
]);
$first = $get->result->first_name;
$users = $get->result->username;
bot('copyMessage',[
'chat_id'=>$id,
'message_id'=>$mid,
'from_chat_id'=>$cid,
]);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"✅ <b>Foydalanuvchiga xabaringiz yuborildi!</b>",
'parse_mode'=>'html',
'reply_markup'=>$panel,
]);
unlink("step/$cid.step");
exit();
}
}



if($data == "send"){
bot('deleteMessage',[
'chat_id'=>$cid2,
'message_id'=>$mid2,
]);
bot('SendMessage',[
'chat_id'=>$cid2,
'text'=>"*Xabar matnini kiriting:*",
'parse_mode'=>'MarkDown',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid2.step","sendpost");
exit();
}

if($step == "sendpost"){
if(in_array($cid,$admin)){
unlink("step/$chat_id.step");
$users=file_get_contents("users");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"*Xabar Yuborish Boshlandi* ✅",
'parse_mode'=>'MarkDown',
]);
$a=explode("\n",$users);
$x=0;
$y=0;
foreach($a as $id){
$key=$message->reply_markup;
$keyboard=json_encode($key);
$ok=bot('copyMessage',[
'from_chat_id'=>$cid,
'chat_id'=>$id,
'message_id'=>$mid,
])->ok;
if($ok==true){
}else{
$okk=bot('copyMessage',[
'from_chat_id'=>$cid,
'chat_id'=>$id,
'message_id'=>$mid,
])->ok;
}
if($okk==true or $ok==true){
$x=$x+1;
bot('editMessageText',[
'chat_id'=>$cid,
'message_id'=>$mid,
'text'=>"✅ <b>Yuborildi:</b> $x

❌ <b>Yuborilmadi:</b> $y",
'parse_mode'=>'html',
'reply_markup'=>$panel
]);
}elseif($okk==false){
$y=$y+1;
bot('editmessagetext',[
'chat_id'=>$cid,
'message_id'=>$mid + 1,
'text'=>"✅ <b>Yuborildi:</b> $x

❌ <b>Yuborilmadi:</b> $y",
'parse_mode'=>'html',
]);
}
}
bot('editmessagetext',[
'chat_id'=>$cid,
'message_id'=>$mid + 1,
'text'=>"✅ <b>Yuborildi:</b> $x

❌ <b>Yuborilmadi:</b> $y",
'parse_mode'=>'html',
]);
}
}

if($text == "🤖 Bot holati"){
	if(in_array($cid,$admin)){
	if($holat == "Yoqilgan"){
		$xolat = "O'chirish";
	}
	if($holat == "O'chirilgan"){
		$xolat = "Yoqish";
	}
	bot('SendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>Hozirgi holat:</b> $holat",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
[['text'=>"$xolat",'callback_data'=>"bot"]],
[['text'=>"Orqaga",'callback_data'=>"boshqarish"]]
]
])
]);
exit();
}
}

if($data == "xolat"){
	if($holat == "Yoqilgan"){
		$xolat = "O'chirish";
	}
	if($holat == "O'chirilgan"){
		$xolat = "Yoqish";
	}
	bot('deleteMessage',[
	'chat_id'=>$cid2,
	'message_id'=>$mid2,
	]);
	bot('SendMessage',[
	'chat_id'=>$cid2,
	'text'=>"<b>Hozirgi holat:</b> $holat",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
[['text'=>"$xolat",'callback_data'=>"bot"]],
[['text'=>"Orqaga",'callback_data'=>"boshqarish"]]
]
])
]);
exit();
}

if($data == "bot"){
if($holat == "Yoqilgan"){
file_put_contents("holat.txt","O'chirilgan");
     bot('editMessageText',[
        'chat_id'=>$cid2,
       'message_id'=>$mid2,
       'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"xolat"]],
]
])
]);
}else{
file_put_contents("holat.txt","Yoqilgan");
     bot('editMessageText',[
        'chat_id'=>$cid2,
       'message_id'=>$mid2,
       'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"xolat"]],
]
])
]);
}
}

if($text == "📤 Kino Yuklash"){
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"🍿 Kino nomini kiriting:",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid.step",'kinostep1');
exit();
}

if($step=="kinostep1" and isset($text)){
if(in_array($cid,$admin)){
$new_id=$last_kino+1;
mkdir("kino/$new_id");
file_put_contents("kino/id.txt",$new_id);
file_put_contents("step/new_kino",$new_id);
file_put_contents("kino/$new_id/nomi.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"🏞 Kino uchun banner yuboring:",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid.step",'kinostep20');
exit();
}
}

$newkino=file_get_contents("step/new_kino");
if($step=="kinostep20" and isset($message->photo)){
if(in_array($cid,$admin)){
$photo_id=$message->photo[count($message->photo)-1]->file_id;
file_put_contents("kino/$newkino/rasm.txt",$photo_id);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"🇺🇿 Kinoni qaysi tilga tarjima qilingan:",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid.step",'kinostep2');
exit();
}
}

if($step=="kinostep2" and isset($text)){
if(in_array($cid,$admin)){
file_put_contents("kino/$newkino/tili.txt",$text);
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"📹 Kino formatini kiriting:

<i>Namuna: 144p,240p,360p,720p,1080p</i>",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid.step",'kinostep3');
exit();
}
}

if($step=="kinostep3" and isset($text)){
if(in_array($cid,$admin)){
file_put_contents("kino/$newkino/formati.txt",$text);
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"🎭 Kino janrini kiriting:

<i>Namuna: Drama, Romantik</i>",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid.step",'kinostep4');
exit();
}
}

if($step=="kinostep4" and isset($text)){
if(in_array($cid,$admin)){
file_put_contents("kino/$newkino/janri.txt",$text);
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"🛑 Kino yosh chegarasini kiriting:

<i>Namuna: 0+, 12+, 16+, 18+</i>",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid.step",'kinostep5');
exit();
}
}

if($step=="kinostep5" and isset($text)){
if(in_array($cid,$admin)){
file_put_contents("kino/$newkino/yosh.txt",$text);
file_put_contents("kino/$newkino/downcount.txt",0);
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"📺 Endi esa filmmi yuboring:",
'parse_mode'=>'html',
'reply_markup'=>$boshqarish,
]);
file_put_contents("step/$cid.step",'kino');
exit();
}
}
if($text == "🗑 Kino O'chirish"){
    bot('SendMessage',[
        'chat_id' => $cid,
        'text' => "📂 O'chirish uchun kino kodini kiriting:",
        'parse_mode' => 'html',
        'reply_markup' => $boshqarish,
    ]);
    file_put_contents("step/$cid.step", 'kinostep_del');
    exit();
}
if($step == "kinostep_del" && isset($text)){
    if(in_array($cid, $admin)){
        $kino_id = $text;
        
        // Kino ID bo'yicha papka mavjudligini tekshirish
        if (file_exists("kino/$kino_id")) {
            // Papkani va ichidagi fayllarni o'chirish
            array_map('unlink', glob("kino/$kino_id/*"));
            rmdir("kino/$kino_id");
            
            // Kino muvaffaqiyatli o'chirildi
            bot('SendMessage', [
                'chat_id' => $cid,
                'text' => "🎬 Kino (ID: $kino_id) muvaffaqiyatli o'chirildi!",
                'parse_mode' => 'html',
                'reply_markup' => $boshqarish,
            ]);
        } else {
            // Kino topilmadi
            bot('SendMessage', [
                'chat_id' => $cid,
                'text' => "❌ Bunday kino kodiga ega kino topilmadi! Iltimos, to'g'ri kino kodini kiriting.",
                'parse_mode' => 'html',
                'reply_markup' => $boshqarish,
            ]);
        }
        
        // Stepni reset qilish
        file_put_contents("step/$cid.step", '');
        exit();
    }
}
/* POST */
if($step=="kino" and isset($message->video)){
    $video = $message->video;
    $file_id = $message->video->file_id;
    file_put_contents("kino/$newkino/film.txt",$file_id);
    bot('sendmessage',[
    'chat_id'=>$cid,
    'text'=>"✅ Kino kanal va botga joylandi $kanalcha",
    'reply_markup'=>$panel,
    ]);
    $nomi=file_get_contents("kino/$newkino/nomi.txt");
    $tili=file_get_contents("kino/$newkino/tili.txt");
    $formati=file_get_contents("kino/$newkino/formati.txt");
    $janri=file_get_contents("kino/$newkino/janri.txt");
    $yosh=file_get_contents("kino/$newkino/yosh.txt");
    $downcount=file_get_contents("kino/$newkino/downcount.txt");
    $downcount=+1;
    file_put_contents("kino/$newkino/downcount.txt",$downcount);
    $rasm=file_get_contents("kino/$newkino/rasm.txt");
    bot('sendPhoto',[
    'chat_id'=>$kanalcha,
    'photo'=>$rasm,
    'caption'=>"
<b>
🎬| Kino nomi: $nomi
➖➖➖➖➖➖➖➖➖➖➖➖
🌐| Tili: $tili
💾| Sifati: $formati
🎭| Janri:  $janri
⛔️| Yosh chegarasi: $yosh
➖➖➖➖➖➖➖➖➖➖➖➖
🤖 Bizning bot: @$bot</b>",
'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>"🎥 Kinoni yuklab olish",'url'=>"https://t.me/$bot?start=$newkino"]],
    [['text'=>"📋 Ulashish",'url'=>"https://t.me/share/url?url=https://t.me/$bot?start=$newkino"]],
    ]
    ])
    ]);
    unlink("step/$cid.step");
    exit();
    }else{
        bot('sendMessage',[
            'chat_id'=>$id,
            'text'=>"<b>1</b>",
            'parse_mode'=>'html',
            'disable_web_page_preview'=>true,
            'reply_markup'=>$menu,
        ]);
    }
    /* Kod orqali */
    if(mb_stripos($text,"/start")!==false){
    $exp=explode(" ",$text);
    $text=$exp[1];
    if(joinchat($cid)==1){
    $nomi=file_get_contents("kino/$text/nomi.txt");
    $tili=file_get_contents("kino/$text/tili.txt");
    $formati=file_get_contents("kino/$text/formati.txt");
    $janri=file_get_contents("kino/$text/janri.txt");
    $yosh=file_get_contents("kino/$text/yosh.txt");
    $downcount=file_get_contents("kino/$text/downcount.txt");
    $downcount=+1;
    file_put_contents("kino/$text/downcount.txt",$downcount);
    $video_id=file_get_contents("kino/$text/film.txt");
    bot('sendVideo',[
    'chat_id'=>$cid,
    'video'=>$video_id,
    'caption'=>"
<b>
🎬| Kino Nomi: $nomi
➖➖➖➖➖➖➖➖➖➖➖➖
🌐| Tili: $tili
💾| Sifati: $formati
🎭| Janri:  $janri
⛔️| Yosh chegarasi: $yosh
➖➖➖➖➖➖➖➖➖➖➖➖
🔗| Kanal: $kanalcha
📁 Yuklash: $downcount
    
    🤖 Bizning bot: @$bot</b>",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>"📋 Ulashish",'url'=>"https://t.me/share/url?url=https://t.me/$bot?start=$text"]],
    ]
    ])
    ]);
    exit();
    }
    }
    
    if(is_numeric($text)==true and empty($step)){
    if(joinchat($cid)==1){
    $nomi=file_get_contents("kino/$text/nomi.txt");
    $tili=file_get_contents("kino/$text/tili.txt");
    $formati=file_get_contents("kino/$text/formati.txt");
    $janri=file_get_contents("kino/$text/janri.txt");
    $yosh=file_get_contents("kino/$text/yosh.txt");
    $downcount=file_get_contents("kino/$text/downcount.txt")+1;
    file_put_contents("kino/$text/downcount.txt",$downcount);
    $video_id=file_get_contents("kino/$text/film.txt");
    bot('sendVideo',[
    'chat_id'=>$cid,
    'video'=>$video_id,
    'caption'=>"
<b>
🎬| Kino Nomi: $nomi
➖➖➖➖➖➖➖➖➖➖➖➖
🌐| Tili: $tili
💾| Sifati: $formati
🎭| Janri:  $janri
⛔️| Yosh chegarasi: $yosh
➖➖➖➖➖➖➖➖➖➖➖➖
🔗| Kanal: $kanalcha
📁 Yuklash: $downcount   

🤖 Bizning bot: @$bot</b>",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>"📋 Ulashish",'url'=>"https://t.me/share/url?url=https://t.me/$bot?start=$text"]],
    ]
    ])
    ]);
    }
    }

$backz = json_encode([
    'inline_keyboard' => [
        
        [['text' => "Bekor qilish 🚫", 'callback_data' => "baz"]],
    ]
]);

if ($data == "baz") {
    bot('deleteMessage', [
        'chat_id' => $cid2,
        'message_id' => $mid2,
        'reply_markup' => $usermenu
    ]);
    bot('sendMessage', [
        'chat_id' => $cid2,
        'message_id' => $mid2,
        'text'=>"Bekor qilindi ⚠️",
        'reply_markup' => $usermenu
    ]);
    if (file_exists("step/$cid2.step")) {
        unlink("step/$cid2.step"); // Foydalanuvchi bosqichini tozalash
    }
    
    exit();
}

if($text == "🎟 Buyurtma" or $text == "/order"){
    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"<b>🎬 Kino haqida ma'lumot yuboring (nomi, tavsifi, rasm yoki video)</b>",
        'parse_mode'=>'html',
        'reply_markup'=>$backz,
    ]);
    file_put_contents("step/$cid.step", "help");
    exit();
}

if($step == "help"){
    unlink("step/$cid.step");
    
     // Admin ID-larini kiriting
    foreach ($admins as $admin_id) {
        bot('sendMessage',[
            'chat_id'=>$admin_id,
            'text'=>"📩 <b>Yangi buyurtma!</b>\n\n👤 <b>Foydalanuvchi:</b> <a href='tg://user?id=$cid'>$name</a>\n🆔 <b>ID:</b> $cid\n\n💬 <b>buyurtmar:</b> $text",
            'parse_mode'=>'html',
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"✍️ Javob berish", 'callback_data'=>"reply_$cid"]],
                ]
            ])
        ]);
    }
    
    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"✅ <b>So‘rovingiz adminlarga yuborildi. Tez orada javob berishadi.</b>",
        'parse_mode'=>'html',
    ]);
    exit();
}

if(strpos($data, "reply_") !== false){
    $user_id = str_replace("reply_", "", $data);
    bot('sendMessage',[
        'chat_id'=>$cid2,
        'text'=>"<b>Foydalanuvchiga yubormoqchi bo‘lgan xabaringizni yozing:</b>",
        'parse_mode'=>'html',
    ]);
    file_put_contents("step/$cid2.step", "reply-$user_id");
    exit();
}

if(mb_stripos($step, "reply-") !== false){
    $user_id = explode("-", $step)[1];
    unlink("step/$cid.step");
    
    bot('sendMessage',[
        'chat_id'=>$user_id,
        'text'=>"📩 <b>Admin javobi:</b>\n\n$text",
        'parse_mode'=>'html',
    ]);
    
    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"✅ <b>Xabaringiz foydalanuvchiga yuborildi!</b>",
        'parse_mode'=>'html',
    ]);
    exit();
}






if($text == "✉️ Yordam"){
    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"<b>Muammo yoki savolingizni yozing:</b>",
        'parse_mode'=>'html',
        'reply_markup'=>$backz,
    ]);
    file_put_contents("step/$cid.step", "help");
    exit();
}

if($step == "help"){
    unlink("step/$cid.step");
    
    // Admin ID-larini kiriting
    foreach ($admins as $admin_id) {
        bot('sendMessage',[
            'chat_id'=>$admin_id,
            'text'=>"📩 <b>Yangi yordam so‘rovi!</b>\n\n👤 <b>Foydalanuvchi:</b> <a href='tg://user?id=$cid'>$name</a>\n🆔 <b>ID:</b> <code>$cid</code>\n\n💬 <b>Xabar:</b> $text",
            'parse_mode'=>'html',
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"✍️ Javob berish", 'callback_data'=>"reply_$cid"]],
                ]
            ])
        ]);
    }
    
    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"✅ <b>So‘rovingiz adminlarga yuborildi. Tez orada javob berishadi.</b>",
        'parse_mode'=>'html',
    ]);
    exit();
}

if(strpos($data, "reply_") !== false){
    $user_id = str_replace("reply_", "", $data);
    bot('sendMessage',[
        'chat_id'=>$cid2,
        'text'=>"<b>Foydalanuvchiga yubormoqchi bo‘lgan xabaringizni yozing:</b>",
        'parse_mode'=>'html',
    ]);
    file_put_contents("step/$cid2.step", "reply-$user_id");
    exit();
}

if(mb_stripos($step, "reply-") !== false){
    $user_id = explode("-", $step)[1];
    unlink("step/$cid.step");
    
    bot('sendMessage',[
        'chat_id'=>$user_id,
        'text'=>"📩 <b>Admin javobi:</b>\n\n$text",
        'parse_mode'=>'html',
    ]);
    
    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"✅ <b>Xabaringiz foydalanuvchiga yuborildi!</b>",
        'parse_mode'=>'html',
    ]);
    exit();
}
if($text == "/about"){
    $ping=sys_getloadavg();
    $stat=substr_count(file_get_contents("users"),"\n");
    $nostat=substr_count(file_get_contents("block"),"\n")??0;
    bot('SendMessage',[
    'chat_id'=>$cid,
    'text'=>"
<blockquote><b>🗃  Kino kanal: $kanalcha</b></blockquote>
<blockquote><b>👥  Foydalanuvchilar:</b></blockquote> $stat ta 
<blockquote><b>⛔️Nofaol:</b></blockquote> $nostat ta ",
    'parse_mode'=>'html',
    'reply_markup'=>$usermenu
    ]);
}