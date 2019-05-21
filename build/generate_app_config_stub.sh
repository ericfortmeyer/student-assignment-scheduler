#!/usr/bin/env sh

# generate a mock app config file
# otherwise tests will trigger CLI prompts
printf '{\n    "language": "ASL",\n    "meeting_night": "Thursday"\n}' > $PWD/config/app_config.json
