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

// 获取订单列表
$ordersResponse = $avanti->instantOrder()->getList([
    'no' => 'CGI20240320',
    'customer_id' => 1,
    'merchant_id' => 1,
    'type' => 'avanti',
    'delivery_method' => 'shipping',
    'start_date' => '2024-03-01',
    'end_date' => '2024-03-31',
    'page' => 1,
    'per_page' => 15
]);

// 获取订单详情（通过ID）
$orderDetailResponse = $avanti->instantOrder()->getDetail(1);

// 获取订单详情（通过订单编号）
$orderDetailByNoResponse = $avanti->instantOrder()->getDetailByNo('CGI202403201234567890');

// 创建订单
$createOrderResponse = $avanti->instantOrder()->create([
    'customer_id' => 1,
    'merchant_id' => 1,
    'agent_id' => 1,
    'type' => 'avanti',
    'delivery_method' => 'shipping',
    'expected_date' => '2024-03-20',
    'expected_begin_at' => '2024-03-20 10:00:00',
    'expected_end_at' => '2024-03-20 18:00:00',
    'total_amount' => 100.00,
    'freight_amount' => 10.00,
    'remark' => '请尽快发货',
    'origin' => [
        'sender' => '张三',
        'cellphone' => '13800138000',
        'address' => '北京市朝阳区xxx'
    ],
    'destination' => [
        'recipient' => '李四',
        'cellphone' => '13900139000',
        'address' => '上海市浦东新区xxx'
    ],
    'details' => [
        [
            'name' => '商品1',
            'quantity' => 1,
            'price' => 90.00,
            'remark' => '商品备注'
        ]
    ]
]);
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

### 订单服务 (InstantOrderService)

- `getList(array $params = []): array`
  - 参数说明：
    - `no`: 订单号（支持模糊查询）
    - `customer_id`: 客户ID
    - `merchant_id`: 商户ID
    - `type`: 订单类型（avanti/ec/sm/to）
    - `delivery_method`: 配送方式（unconfirmed/pickup/shipping）
    - `start_date`: 开始日期（YYYY-MM-DD）
    - `end_date`: 结束日期（YYYY-MM-DD）
    - `page`: 页码（默认1）
    - `per_page`: 每页数量（默认15，最大100）

- `getDetail(int $id): array`
  - 参数说明：
    - `id`: 订单ID

- `getDetailByNo(string $no): array`
  - 参数说明：
    - `no`: 订单编号

- `create(array $data): array`
  - 参数说明：
    - `customer_id`: 客户ID（必填）
    - `merchant_id`: 商户ID（必填）
    - `agent_id`: 代理商ID
    - `type`: 订单类型（必填，avanti/ec/sm/to）
    - `delivery_method`: 配送方式（必填，unconfirmed/pickup/shipping）
    - `expected_date`: 期望日期
    - `expected_begin_at`: 期望开始时间
    - `expected_end_at`: 期望结束时间
    - `total_amount`: 订单总金额（必填）
    - `freight_amount`: 运费金额
    - `remark`: 备注
    - `origin`: 发货信息（必填）
      - `sender`: 发货人
      - `cellphone`: 联系电话
      - `address`: 发货地址
    - `destination`: 收货信息（必填）
      - `recipient`: 收货人
      - `cellphone`: 联系电话
      - `address`: 收货地址
    - `details`: 订单商品明细
      - `name`: 商品名称
      - `quantity`: 商品数量
      - `price`: 商品单价
      - `remark`: 商品备注 