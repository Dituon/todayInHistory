<?php
$secret = '1145141919810';
$res_path = __DIR__ . '/res';
$git_url = 'git@github.com:Dituon/today.git';

if (!file_exists($res_path)) {
    mkdir($res_path, 0777, true);
    exec("cd $res_path && git clone $git_url");
    exec('git config --global credential.helper store');
    echo '初始化成功';
}

$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
if (!$signature) return http_response_code(404);

$json = file_get_contents('php://input');
$content = json_decode($json, true);
list($algo, $hash) = explode('=', $signature, 2);

if ($hash !== hash_hmac($algo, $json, $secret)) {
    return http_response_code(404);
}

echo exec("cd $res_path/today && git pull 2>&1");

//$edit_list = array_merge($content['head_commit']['added'], $content['head_commit']['removed']);
$edit_list = $content['head_commit']['added'];
$is_exit = false;
$move_num = 0;
foreach ($edit_list as $file) {
    if (substr($file, -5, strlen($file)) !== '.json') continue;
    $file_path = explode('/', $file);

    if ($file_path[2] !== 'autoFile') continue;

    $file = $res_path . '/today/' . $file;
    $file_json = json_decode(file_get_contents($file), true);
    $date = strtotime($file_json['date']);


    $index_path = $res_path . '/today/data/' . $file_path[1] . '/index.json';
    setIndex($index_path, date('m-d', $date));


    $res_file = substr($file_json['res'], 0, 1) === '.' ?
        $file_json['id'] . $file_json['res'] : $file_json['res'];
    $new_path = $res_path . '/today/data/' .
        $file_path[1] . '/' . date('m-d', $date);

    if (!file_exists($new_path)) mkdir($new_path, 0777, true);
    rename($file, $new_path . '/' . array_pop($file_path));
    rename($res_path . '/today/' . implode('/', $file_path) . '/' . $res_file,
        $new_path . '/' . $res_file);


    $index_path = $new_path . '/index.json';
    setIndex($index_path, $file_json['id']);

    $is_exit = true;
    $move_num++;
}

if ($is_exit) {
    echo exec("cd $res_path/today && 
    git add -A &&
    git commit -m \"[AutoFileBot] move $move_num file(s)\" &&
    git push 2>&1");
}

function setIndex($path, $data)
{
    if (!file_exists($path)) {
        file_put_contents($path, '{"index":[]}');
    }
    $json = json_decode(file_get_contents($path), true);
    if(!in_array($data, $json['index'])){
        $json['index'][] = $data;
        file_put_contents($path, json_encode($json));
    }
}