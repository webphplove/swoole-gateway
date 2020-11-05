# swoole-gateway
用swoole实现的简易网关

### 功能简介
目前系统分为四个模块：server模块、route模块、filter模块

server模块：接收用户的请求，经过route模块解析后得到目标服务地址，Http client发送请求得到结果后，server返回给用户
route模块：读取配置文件，加载路由配置，将不同的请求发送到不同的服务器
filter模块：对请求和返回进行处理