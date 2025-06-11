<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Avanti\Avanti;

// 初始化SDK
$avanti = new Avanti('https://api.example.com');

try {
    // 1. 获取订单列表
    echo "1. 获取订单列表\n";
    $listResponse = $avanti->instantOrder()->getList([
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
    print_r($listResponse);

    // 2. 获取订单详情（通过ID）
    echo "\n2. 获取订单详情（通过ID）\n";
    $detailResponse = $avanti->instantOrder()->getDetail(1);
    print_r($detailResponse);

    // 3. 获取订单详情（通过订单编号）
    echo "\n3. 获取订单详情（通过订单编号）\n";
    $detailByNoResponse = $avanti->instantOrder()->getDetailByNo('CGI202403201234567890');
    print_r($detailByNoResponse);

    // 4. 创建订单
    echo "\n4. 创建订单\n";
    $createResponse = $avanti->instantOrder()->create([
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
    print_r($createResponse);

} catch (Exception $e) {
    echo "发生错误: " . $e->getMessage() . "\n";
    echo "错误代码: " . $e->getCode() . "\n";
    echo "错误堆栈: " . $e->getTraceAsString() . "\n";
} 