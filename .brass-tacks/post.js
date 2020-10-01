const shelljs = require('shelljs');

shelljs.exec("npx statickit .");
shelljs.exec("npm uninstall -D @wndrfl/static-kit-cli");
shelljs.exec("npm prune");