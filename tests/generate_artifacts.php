<?php

require_once(__DIR__.'/bootstrap.php');

use Symfony\Component\Process\Process;

$function = function() {
    $projectPath = realpath(__DIR__ . '/../');

    $packagesPath = $projectPath . '/tests/res/packages';
    
    $runInProjectRoot = function ($command) use ($projectPath) {
        $process = new Process($command, $projectPath);
        $process->run();
        return $process;
    };
    
    $composerCommand = 'composer';
    if (getenv('TRAVIS') == "true") {
        $composerCommand = $projectPath . '/composer.phar';
    } elseif ($runInProjectRoot('composer.phar')->getExitCode() === 0) {
        $composerCommand = 'composer.phar';
    }
    
    $createComposerInstallerArtifact = function () use ($projectPath, $runInProjectRoot, $composerCommand) {

        $command = 'perl -pi.bak -e \'s/"test_version"/"version"/g\' ./composer.json';
        $process = $runInProjectRoot($command);
        if ($process->getExitCode() !== 0) {
            $message = sprintf(
                "process for <code>%s</code> exited with %s: %s%sError Message:%s%s%sOutput:%s%s",
                $process->getCommandLine(),
                $process->getExitCode(),
                $process->getExitCodeText(),
                PHP_EOL,
                PHP_EOL,
                $process->getErrorOutput(),
                PHP_EOL,
                PHP_EOL,
                $process->getOutput()
            );
            echo $message;
        }

        $basePath = $projectPath . '/tests/FullStackTest';
        @unlink($projectPath.'/vendor/theseer/directoryscanner/tests/_data/linkdir');
        @unlink($basePath.'/magento/vendor/theseer/directoryscanner/tests/_data/linkdir');
        @unlink($basePath.'/magento-modules/vendor/theseer/directoryscanner/tests/_data/linkdir');
        @unlink($projectPath.'/vendor/theseer/directoryscanner/tests/_data/nested/empty');
        @unlink($basePath.'/magento/vendor/theseer/directoryscanner/tests/_data/nested/empty');
        @unlink($basePath.'/magento-modules/vendor/theseer/directoryscanner/tests/_data/nested/empty');

        $command = $composerCommand.' archive --format=zip --dir="tests/FullStackTest/artifact" -vvv';
        $process = $runInProjectRoot($command);

        if ($process->getExitCode() !== 0) {
            $message = sprintf(
                "process for <code>%s</code> exited with %s: %s%sError Message:%s%s%sOutput:%s%s",
                $process->getCommandLine(),
                $process->getExitCode(),
                $process->getExitCodeText(),
                PHP_EOL,
                PHP_EOL,
                $process->getErrorOutput(),
                PHP_EOL,
                PHP_EOL,
                $process->getOutput()
            );
            echo $message;
        } else {
            // everything fine, I assume
        }
        $process = $runInProjectRoot('perl -pi.bak -e \'s/"version"/"test_version"/g\' ./composer.json');
        if ($process->getExitCode() !== 0) {
            $message = sprintf(
                "process for <code>%s</code> exited with %s: %s%sError Message:%s%s%sOutput:%s%s",
                $process->getCommandLine(),
                $process->getExitCode(),
                $process->getExitCodeText(),
                PHP_EOL,
                PHP_EOL,
                $process->getErrorOutput(),
                PHP_EOL,
                PHP_EOL,
                $process->getOutput()
            );
            echo $message;
        }
    };
    $createComposerInstallerArtifact();

    $directory = new \DirectoryIterator($packagesPath);
    /** @var \DirectoryIterator $fileinfo */
    foreach ($directory as $file) {
        if (!$file->isDot() && $file->isDir()) {
            $args = ' archive --format=zip --dir="'.$projectPath.'/tests/FullStackTest/artifact" -vvv';
            $process = new Process(
                $composerCommand . $args,
                $file->getPathname()
            );
            $process->run();
            if ($process->getExitCode() !== 0) {
                $message = sprintf(
                    "process for <code>%s</code> exited with %s: %s%sError Message:%s%s%sOutput:%s%s",
                    $process->getCommandLine(),
                    $process->getExitCode(),
                    $process->getExitCodeText(),
                    PHP_EOL,
                    PHP_EOL,
                    $process->getErrorOutput(),
                    PHP_EOL,
                    PHP_EOL,
                    $process->getOutput()
                );
                echo $message;
            }
        }
    };
};
    
$function();
unset($function);
