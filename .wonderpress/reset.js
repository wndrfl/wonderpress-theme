#!/usr/bin/env node

import fs from 'fs';

// Reset scripts
// This script should be run when attempting to reset Wonderpress
// to it's "pre-installed" state.

// Note: This script does NOT touch any PHP files. It will only reset
// static assets and development tools.

console.log('Resetting to original Wonderpress state...');

// Remove files that were created during npm install
let files = ['gulpfile.js','package-lock.json','statickit.json'];
files.forEach((v,i) => {
	fs.unlink(v, (err) => {
		if (err) {
			console.log('The file ' + v + ' was not deleted', err);
		} else {
			console.log('The file ' + v + ' was deleted');
		}
	});
});

// Remove directories that were created during npm install
let dirs = ['css','images','js','node_modules','vendor'];
dirs.forEach((v,i) => {
	fs.rmdir(v, { recursive: true }, (err) => {
	    if (err) {
			console.log('The directory ' + v + ' was not deleted', err);
	    } else {
			console.log('The directory ' + v + ' was deleted');
	    }
	});
});

// Copy the original package.json from the archive, and replace
// the modified version
fs.copyFile('.wonderpress/archive/package.json', 'package.json', (err) => {
	if (err) throw err;
	console.log('Original package.json was restored');
});