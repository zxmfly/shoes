ThinkPHP 6.0
===============

> 运行环境要求PHP7.1+。

## 主要新特性

* 采用`PHP7`强类型（严格模式）
* 支持更多的`PSR`规范
* 原生多应用支持
* 更强大和易用的查询
* 全新的事件系统
* 模型事件和数据库事件统一纳入事件系统
* 模板引擎分离出核心
* 内部功能中间件化
* SESSION/Cookie机制改进
* 对Swoole以及协程支持改进
* 对IDE更加友好
* 统一和精简大量用法

## 安装

~~~
composer create-project topthink/think tp 6.0.*
~~~

如果需要更新框架使用
~~~
composer update topthink/framework
~~~

## 文档

[完全开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)

## 参与开发

请参阅 [ThinkPHP 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2020 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)

## 扩展
1、可以使用 font awesome 扩展图标

2、https://www.iconfont.cn/ 阿里图库

3、错误码：

    0 成功
    1 缺少参数
    2 验证失败
    3 操作失败
    4 数据不存在
    5 重复操作
    6 禁止操作
    
## nginx配置：
    1、nginx 要加入重写规则：
        location / {  
         
            # !!!url重写!!!
            if (!-e $request_filename) {  
                rewrite ^/index.php(.*)$ /index.php?s=$1 last;  
                rewrite ^(.*)$ /index.php?s=$1 last;  
                break;  
            }  
    2、解决ThinkPHP部署nginx时出现Access denied.
        修改php.ini
            vi /usr/local/php/etc/php.ini  #编辑文件
            #cgi.fix_pathinfo由0改为1
        修改 nginx.conf
            #添加TP5的三个配置
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_param   PATH_INFO   $fastcgi_path_info;
            fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;
        
