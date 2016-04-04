#!/bin/sh
#
# Cloud Hook: post-code-deploy
#
# The post-code-deploy hook is run whenever you use the Workflow page to 
# deploy new code to an environment, either via drag-drop or by selecting
# an existing branch or tag from the Code drop-down list. See 
# ../README.md for details.
#
# Usage: post-code-deploy site target-env source-branch deployed-tag repo-url 
#                         repo-type

site="$1"
target_env="$2"
source_branch="$3"
deployed_tag="$4"
repo_url="$5"
repo_type="$6"

echo "$site.$target_env: The $source_branch branch has been updated on $target_env."

echo "Importing any config changes."
drush @$site.$target_env cim vcs -v

echo "Running any outstanding updates"
drush @$site.target_env updatedb -y -v

echo "Clearing the cache."
drush @$site.$target_env cr -v

echo "$site.$target_env: Deployed $deployed_tag."
