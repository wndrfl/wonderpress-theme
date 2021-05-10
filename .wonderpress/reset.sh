#!/usr/bin/env bash

# Reset scripts
# This script should be run when attempting to reset Wonderpress
# to it's "pre-installed" state.

# Note: This script does NOT touch any PHP files. It will only reset
# static assets and development tools.

# Remove files and directories that were created during npm install
rm -rf css gulpfile.js images js node_modules package-lock.json statickit.json vendor

# Copy the original package.json from the archive, and replace
# the modified version
cp .wonderpress/archive/package.json package.json