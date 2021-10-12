#!/usr/bin/env node

import { execSync } from 'child_process';
import fs from 'fs';

// Post-Install scripts
// This script should be run after npm has completed its
// initial installation, during the `postinstall` hook.

console.log('Running various postinstall scripts...');

// Create an archive directory for storing various things
const archivePath = '.wonderpress/archive';
if(!fs.existsSync(archivePath)) {
	fs.mkdir(archivePath, true, (err) => {
	    if (err) {
	        return console.error(err);
	    }
	    console.log('Archive directory created successfully!');
	});
}

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


// Attempt to install Static Kit

console.log('Attempting to detect if it is safe to install Static Kit...');

let isSafeToInstall = true;

const shouldNotExist = [
	'statickit.json',
	'css',
	'js',
	'images'
];

shouldNotExist.forEach((path) => {
	if(fs.existsSync(path)) {
		isSafeToInstall = false;
	}
});

if(!isSafeToInstall) {
	console.log('Detected files or folders that would be overwritten by installing Static Kit. Moving on...');

} else {

	console.log('It appears safe to install Static Kit. Proceeding...');
	
	// Install Static Kit
	execSync("npx statickit .");

	// We no longer need the Static Kit CLI, remove it
	execSync("npm uninstall -D @wndrfl/static-kit-cli");
	execSync("npm prune");// Copy the original .gitignore back
	
	fs.copyFile('.wonderpress/archive/.gitignore', '.gitignore', (err) => {
		if (err) throw err;
		console.log('Original .gitignore was restored');
	});
}


// Remove postinstall script from the npm scripts
// This will prevent later developers from accidentally installing
// Static Kit again...

// Grab the package.json
let newPackageData = fs.readFileSync('package.json');
let newPackageJson = JSON.parse(newPackageData);

if(newPackageJson.scripts && newPackageJson.scripts.postinstall) {
	delete newPackageJson.scripts.postinstall;
}

let data = JSON.stringify(newPackageJson, null, 2);
fs.writeFileSync('package.json', data);