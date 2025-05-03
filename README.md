# Avanti PHP SDK

这是一个用于对接Avanti API的PHP SDK。

## 安装

使用Composer安装：

```bash
composer require avanti/php-sdk
```

## 使用示例

```php
<?php

require 'vendor/autoload.php';

use Avanti\Avanti;

// 初始化SDK
$avanti = new Avanti('https://api.example.com');

// 获取访问令牌
$tokenResponse = $avanti->auth()->getToken('your_app_id', 'your_app_secret');
$avanti->setAccessToken($tokenResponse['data']['access_token']);

// 创建用户
$userResponse = $avanti->account()->createUser(
    'username',
    'password',
    'User Name',
    'user@example.com'
);

// 获取用户token
$userTokenResponse = $avanti->account()->getToken('username', 'password');

// 更新用户信息
$updateResponse = $avanti->account()->updateUser(1, 'New Name', 'new@example.com');

// 重置用户密码
$resetResponse = $avanti->account()->resetPassword(1);

// 设置用户密码
$setPasswordResponse = $avanti->account()->setPassword(1, 'new_password');

// 撤销用户token
$revokeResponse = $avanti->account()->revokeToken(1);

// 删除用户
$deleteResponse = $avanti->account()->deleteUser(1);
```

## API文档

### 认证服务 (AuthService)

- `getToken(string $appId, string $appSecret, ?string $name = null, ?array $abilities = null, ?string $expiresAt = null): array`
- `revokeToken(string $token): array`
- `getTokenInfo(): array`

### 账户服务 (AccountService)

- `getToken(string $username, string $password): array`
- `createUser(string $username, string $password, string $name, string $email): array`
- `resetPassword(int $userId): array`
- `setPassword(int $userId, string $password): array`
- `revokeToken(int $userId): array`
- `updateUser(int $userId, ?string $name = null, ?string $email = null): array`
- `deleteUser(int $userId): array` 