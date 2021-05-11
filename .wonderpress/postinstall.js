#!/usr/bin/env node

const {execSync} = require('child_process');
const fs = require('fs');

// Post-Install scripts
// This script should be run after npm has completed its
// initial installation, during the `postinstall` hook.

// Create an archive directory for storing various things
fs.mkdir('.wonderpress/archive', true, (err) => {
    if (err) {
        return console.error(err);
    }
    console.log('Directory created successfully!');
});

// Copy the original package.json, in case we need to reset later
fs.copyFile('package.json', '.wonderpress/archive/package.json', (err) => {
	if (err) throw err;
	console.log('Original package.json was copied to .wonderpress/archive/package.json');
});

// Copy the original .gitignore because it may be overwritten
// during install
fs.copyFile('.gitignore', '.wonderpress/archive/.gitignore', (err) => {
	if (err) throw err;
	console.log('Original .gitignore was copied to .wonderpress/archive/.gitignore');
});

// Install Static Kit
execSync("npx statickit .");

// We no longer need the Static Kit CLI, remove it
execSync("npm uninstall -D @wndrfl/static-kit-cli");
execSync("npm prune");

// Copy the original .gitignore back
fs.copyFile('.wonderpress/archive/.gitignore', '.gitignore', (err) => {
	if (err) throw err;
	console.log('Original .gitignore was restored');
});
