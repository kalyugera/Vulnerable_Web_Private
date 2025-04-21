#!/bin/bash

WEBHOOK_URL="https://discord.com/api/webhooks/yourtoken"
TIMESTAMP=$(date '+%Y-%m-%d %H:%M:%S')
MESSAGE="✅ Task executed successfully at $TIMESTAMP"

curl -H "Content-Type: application/json" \
  -X POST \
  -d '{"content": "'"$MESSAGE"'"}' \
  "$WEBHOOK_URL"