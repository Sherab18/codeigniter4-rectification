<?php
echo "<h3>Checking Required Extensions</h3>";

$required = ['intl', 'mbstring', 'curl', 'openssl', 'json'];

foreach ($required as $ext) {
    echo $ext . ": " . (extension_loaded($ext) ? "✓ ENABLED" : "✗ MISSING") . "<br>";
}

echo "<hr>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Memory Limit: " . ini_get('memory_limit') . "<br>";
?>