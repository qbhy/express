# express
简单的快递查询接口。

## 安装
```
$ composer require 96qbhy/express:dev-master
```

## 使用
1. 为 Express::$http 赋值
```php
Express::$http = new \GuzzleHttp\Client();
```
> 第一次使用的时候赋值即可。重复使用无需重复赋值。

2. 查询快递
```php
$result = Express::query(885744925321174309);
print_r($result);

```





