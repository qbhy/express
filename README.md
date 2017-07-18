# express
简单的快递查询接口。

## 使用
1. 为 Express::$http 赋值
```php
Express::$http = new \GuzzleHttp\Client();
```
> 第一次使用的时候赋值即可。重复使用无需重复赋值。

2. 查询快递
```php
Express::query(885744925321174309);
```





