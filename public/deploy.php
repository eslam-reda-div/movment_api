<?php
$secret = 'movment_api_eslam_deploy_lightsail_instace_fjkasdf_9iiqfiaasd';

// التحقق من الـ Secret
$signature = 'sha256=' . hash_hmac('sha256', file_get_contents('php://input'), $secret);
if (!hash_equals($signature, $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '')) {
    http_response_code(403);
    exit('Forbidden');
}

// تنفيذ سكربت التحديث بصلاحيات sudo
// shell_exec('sudo bash /var/www/html/movment_api/deploy.sh 2>&1');
echo 'Deployed successfully!';
