#!/usr/bin/env bash
mkdir -p .wonderpress/archive
cp package.json .wonderpress/archive/package.json
cp .gitignore .wonderpress/archive/.gitignore
cp .wonderpress/postinstall/package.json package.json
npx statickit .
npm uninstall -D @wndrfl/static-kit-cli
npm prune
cp .wonderpress/archive/.gitignore .gitignore