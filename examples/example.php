<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Avanti\Avanti;

// 初始化SDK
$avanti = new Avanti('https://api.example.com');

try {
    // 1. 获取应用访问令牌
    echo "1. 获取应用访问令牌\n";
    $tokenResponse = $avanti->auth()->getToken(
        'your_app_id',
        'your_app_secret',
        'API Token',
        ['read', 'write'],
        '2024-12-31 23:59:59'
    );
    print_r($tokenResponse);
    
    // 设置访问令牌
    $avanti->setAccessToken($tokenResponse['data']['access_token']);
    
    // 2. 创建新用户
    echo "\n2. 创建新用户\n";
    $userResponse = $avanti->account()->createUser(
        'test_user',
        'password123',
        '测试用户',
        'test@example.com'
    );
    print_r($userResponse);
    
    // 3. 获取用户访问令牌
    echo "\n3. 获取用户访问令牌\n";
    $userTokenResponse = $avanti->account()->getToken('test_user', 'password123');
    print_r($userTokenResponse);
    
    // 4. 更新用户信息
    echo "\n4. 更新用户信息\n";
    $updateResponse = $avanti->account()->updateUser(
        $userResponse['id'],
        '新用户名',
        'new@example.com'
    );
    print_r($updateResponse);
    
    // 5. 重置用户密码
    echo "\n5. 重置用户密码\n";
    $resetResponse = $avanti->account()->resetPassword($userResponse['id']);
    print_r($resetResponse);
    
    // 6. 设置新密码
    echo "\n6. 设置新密码\n";
    $setPasswordResponse = $avanti->account()->setPassword(
        $userResponse['id'],
        'new_password123'
    );
    print_r($setPasswordResponse);
    
    // 7. 获取令牌信息
    echo "\n7. 获取令牌信息\n";
    $tokenInfoResponse = $avanti->auth()->getTokenInfo();
    print_r($tokenInfoResponse);
    
    // 8. 撤销用户令牌
    echo "\n8. 撤销用户令牌\n";
    $revokeResponse = $avanti->account()->revokeToken($userResponse['id']);
    print_r($revokeResponse);
    
    // 9. 删除用户
    echo "\n9. 删除用户\n";
    $deleteResponse = $avanti->account()->deleteUser($userResponse['id']);
    print_r($deleteResponse);
    
    // 10. 撤销应用令牌
    echo "\n10. 撤销应用令牌\n";
    $revokeAppTokenResponse = $avanti->auth()->revokeToken($tokenResponse['data']['access_token']);
    print_r($revokeAppTokenResponse);
    
} catch (Exception $e) {
    echo "发生错误: " . $e->getMessage() . "\n";
    echo "错误代码: " . $e->getCode() . "\n";
    echo "错误堆栈: " . $e->getTraceAsString() . "\n";
} 