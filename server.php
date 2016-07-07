#!/usr/bin/env php
<?php
//接受客户端的请求,返回"Simple HTTP Server"
function handle_http_request(){
    $max_backlog = 100;
    $res_content = "Simple HTTP Server";
    $res_content_len = strlen($res_content);
    $response = <<<RESPONSE
HTTP/1.1 200 OK
Content-Length: {$res_content_len}
Content-Type: text/plain; charset=UTF-8

{$res_content}
RESPONSE;

    $response_len = strlen($response);
    //创建一个SOCKET
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if(!$socket) exit("Create socket failed!\n");
    $address = '127.0.0.1';
    $port = '8089';
    //接下来去绑定SOCKET
    if(!socket_bind($socket,$address,$port)) exit("Bind socket failed!\n");
    if(!socket_listen($socket,$max_backlog)) exit("Listen socket failed!\n");

    while(true){
        $accept_socket = socket_accept($socket);
        if(!$accept_socket) continue;
        else {
            socket_write($accept_socket,$response,$response_len);
            socket_close($accept_socket);
        }
    }
}
//以守护进程的方式运行程序
function run(){
    $pid = pcntl_fork();
    if($pid) exit;//主进程需要杀掉
    //子进程继续
    posix_setsid();//设置子进程为进程组长
    $pid = pcntl_fork();
    if($pid) exit;//子进程需要关闭
    //孙进程继续
    handle_http_request();
}
//主函数
run();