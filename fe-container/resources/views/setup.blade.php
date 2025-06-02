<?php
// Check if the APP_SETUP variable is set to true in the .env file
if (env('APP_SETUP') == 'true') {
    header('Location: /');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Laravel Setup Check</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
    margin: 0;
    padding: 2rem;
    color: #333;
  }
  h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 1rem;
  }
  .check-list {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.1);
    padding: 2rem;
  }
  .check-item:last-child {
    border-bottom: none;
  }
  .status {
    font-weight: bold;
    color: #27ae60;
  }
  .status.fail {
    color: #c0392b;
  }
  .path {
    color: #34495e;
    font-family: monospace;
  }
  .footer {
    text-align: center;
    margin-top: 3rem;
    font-size: 0.85rem;
    color: #888;
  }
  .next-btn {
    display: block;
    margin: 2rem auto 0 auto;
    padding: 0.75rem 2rem;
    font-size: 1rem;
    background: #27ae60;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s;
  }
  .next-btn.enabled {
    opacity: 1;
    cursor: pointer;
  }
  .next-btn:disabled {
    cursor: not-allowed;
    opacity: 0.5;
  }
</style>
</head>
<body>
<h1>Laravel Setup Check</h1>
<div class="check-list">
<?php
function checkPermission($dir, $requiredPerm) {
    if (!file_exists($dir)) {
        return ['status' => false, 'message' => 'Directory does not exist'];
    }
    $perms = substr(sprintf('%o', fileperms($dir)), -3);
    $pass = ($perms === $requiredPerm);
    return ['status' => $pass, 'message' => "Permission is {$perms}"];
}
function checkExtension($ext) {
    return extension_loaded($ext);
}

$allChecksPass = true;

// Check storage/app/public permission
$dir = '/storage/app/public';
// $permCheck = checkPermission($dir, '755');
// if (!$permCheck['status']) $allChecksPass = false;

// echo "<h2>Directory Permission (should be 755)</h2>";
// $cls = $permCheck['status'] ? 'status' : 'status fail';
// $icon = $permCheck['status'] ? '&#10004;' : '&#10060;';
// echo "<div class='check-item'>";
// echo "<div><strong>storage/app/public</strong> <span class='path'>($dir)</span></div>";
// echo "<div class='{$cls}'>{$icon} {$permCheck['message']}</div>";
// echo "</div>";

// ...existing code...
// $dir = 'storage/app/public';
// if (!file_exists($dir)) {
//     $permCheck = ['status' => false, 'message' => 'Directory does not exist'];
//     $allChecksPass = false;
// } elseif (!is_readable($dir) || !is_writable($dir)) {
//     $permCheck = ['status' => false, 'message' => 'Directory must be readable and writable'];
//     $allChecksPass = false;
// } else {
//     $perms = substr(sprintf('%o', fileperms($dir)), -3);
//     $permCheck = ['status' => true, 'message' => "Permission is {$perms} (read/write OK)"];
// }

// echo "<h2>Directory Permission (should be 755, readable & writable)</h2>";
// $cls = $permCheck['status'] ? 'status' : 'status fail';
// $icon = $permCheck['status'] ? '&#10004;' : '&#10060;';
// echo "<div class='check-item'>";
// echo "<div><strong>storage/app/public</strong> <span class='path'>($dir)</span></div>";
// echo "<div class='{$cls}'>{$icon} {$permCheck['message']}</div>";
// echo "</div>";
// // ...existing code...


// Check storage/app/public permission
$dir = '/var/www/html/storage/app/public';
if (!file_exists($dir)) {
    $permCheck = ['status' => false, 'message' => 'Directory does not exist'];
    $allChecksPass = false;
} elseif (!is_readable($dir) || !is_writable($dir)) {
    $permCheck = ['status' => false, 'message' => 'Directory must be readable and writable'];
    $allChecksPass = false;
} else {
    $perms = substr(sprintf('%o', fileperms($dir)), -3);
    $permCheck = ['status' => true, 'message' => "Permission is {$perms} (read/write OK)"];
}

echo "<h2>Directory Permission (should be 755, readable & writable)</h2>";
$cls = $permCheck['status'] ? 'status' : 'status fail';
$icon = $permCheck['status'] ? '&#10004;' : '&#10060;';
echo "<div class='check-item'>";
echo "<div><strong>storage/app/public</strong> <span class='path'>($dir)</span></div>";
echo "<div class='{$cls}'>{$icon} {$permCheck['message']}</div>";
echo "</div>";

// Check PHP extensions
$requiredExtensions = [
    'mbstring',
    'openssl',
    'pdo',
    'tokenizer',
    'xml',
    'ctype',
];
echo "<h2>PHP Extensions Required for Laravel</h2>";
foreach ($requiredExtensions as $ext) {
    $loaded = checkExtension($ext);
    if (!$loaded) $allChecksPass = false;
    $cls = $loaded ? 'status' : 'status fail';
    $icon = $loaded ? '&#10004;' : '&#10060;';
    echo "<div class='check-item'>";
    echo "<div><strong>Extension:</strong> <span class='path'>{$ext}</span></div>";
    echo "<div class='{$cls}'>{$icon} " . ($loaded ? 'Loaded' : 'Missing') . "</div>";
    echo "</div>";
}
?>
</div>

<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['app_url'])) {
    $_SESSION['app_url'] = $_POST['app_url'];
}
$appUrl = isset($_SESSION['app_url']) ? $_SESSION['app_url'] : (env('APP_URL') ?? 'http://localhost');
?>
<!-- ...existing code... -->
<div class="check-list">
    <form method="POST" style="margin-bottom: 2rem;" action="/next-setup-step">
        <input type="hidden" name="_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
        <label for="app_url"><strong>Application URL:</strong></label>
        <input type="text" id="app_url" name="app_url" value="<?php echo htmlspecialchars($appUrl); ?>" style="width:100%;padding:0.5rem;margin-top:0.5rem;">
        <button type="submit" id="nextBtn" class="next-btn<?php echo $allChecksPass ? ' enabled' : ''; ?>" <?php echo $allChecksPass ? '' : 'disabled'; ?>>Save and Next →</button>
    <!-- ...rest of your checks... -->

{{-- <button id="nextBtn" class="next-btn<?php echo $allChecksPass ? ' enabled' : ''; ?>" <?php echo $allChecksPass ? '' : 'disabled'; ?>>Next</button> --}}
<div class="footer">Laravel Setup Permission and PHP Extension Check</div>
<script>
document.getElementById('nextBtn').addEventListener('click', function() {
    if (!this.disabled) {
        window.location.href = '/next-setup-step'; // Change this to your next setup route
    }
});
</script>
  </form>
</body>
</html>