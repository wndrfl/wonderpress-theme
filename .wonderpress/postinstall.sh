#!/usr/bin/env bash

# Post-Install scripts
# This script should be run after npm has completed its
# initial installation, during the `postinstall` hook.

# Create an archive directory for storing various things
mkdir -p .wonderpress/archive

# Copy the original package.json, in case we need to reset later
cp package.json .wonderpress/archive/package.json

# Copy the original .gitignore because it may be overwritten
# during install
cp .gitignore .wonderpress/archive/.gitignore

# Install Static Kit
npx statickit .

# We no longer need the Static Kit CLI, remove it
npm uninstall -D @wndrfl/static-kit-cli
npm prune

# Copy the original .gitignore back
cp .wonderpress/archive/.gitignore .gitignore