# http_server
主要是用来练习php守护进程的写法并展示了php如何编写 daemon server!
用php编写了一个简单的http server，
这个server以daemon process的形式运行。
当然，为了把重点放在如何使用php编写daemon，
没有为这个http server实现具体业务逻辑，
但它可以监听指定端口，接受http请求并返回给客户端一条固定的文本，
整个过程通过socket实现，全部由php编写而成。
