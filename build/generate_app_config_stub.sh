#!/usr/bin/env sh

# generate a mock app config file
# otherwise tests will trigger CLI prompts
printf '{\n    "app_id": "00000000-0000-0000-0000-000000000000",\n    "language": "ASL",\n    "meeting_night": "Thursday"\n}' > $PWD/config/app_config.json
