#!/bin/bash

WEBHOOK_URL="https://discord.com/api/webhooks/1363994991432564767/BrkN2vjvTlvWHa95YQfBY-lyBEm0BMCOdnVmZljSLNhMCgepq3Lnnf_m4DKXDiB-sE8y"
TIMESTAMP=$(date '+%Y-%m-%d %H:%M:%S')
MESSAGE="✅ Task executed successfully at $TIMESTAMP"

curl -H "Content-Type: application/json" \
  -X POST \
  -d '{"content": "'"$MESSAGE"'"}' \
  "$WEBHOOK_URL"