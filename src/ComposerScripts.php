<?php
namespace Mty95\Framework;

class ComposerScripts
{
    public static function postInstall()
    {
        self::createFolders();
        self::unzipApp();
        self::unzipRootFiles();
        self::unzipMty95Framework();
        self::unzipPublicFiles();
    }

    private static function makeFolderIfNotExists($path)
    {
        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }
    }

    private static function createFolders()
    {
        $folders = [
            'src',
            'src/Models',
            'src/Observers',
            'public',
            'writable',
        ];

        foreach ($folders as $folder) {
            self::makeFolderIfNotExists(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . $folder);
        }
    }

    private static function unzipApp(): void
    {
        self::extractTo(
            dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Files' . DIRECTORY_SEPARATOR . 'app.zip',
            dirname(__FILE__, 5) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
        );
    }

    private static function unzipRootFiles(): void
    {
        self::extractTo(
            dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Files' . DIRECTORY_SEPARATOR . 'root_files.zip',
            dirname(__FILE__, 5) . DIRECTORY_SEPARATOR
        );
    }

    private static function unzipMty95Framework(): void
    {
        self::extractTo(
            dirname(__FILE__, 5) . DIRECTORY_SEPARATOR . 'mty95_framework.zip',
            dirname(__FILE__, 5) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'ThirdParty' . DIRECTORY_SEPARATOR
        );
    }

    private static function unzipPublicFiles(): void
    {
        self::extractTo(
            dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Files' . DIRECTORY_SEPARATOR . 'public_files.zip',
            dirname(__FILE__, 5) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR
        );
    }

    private static function extractTo(string $file, string $destination): void
    {
        $zip = new \ZipArchive();

        if ($zip->open($file) === true)
        {
            $zip->extractTo($destination);
            $zip->close();
        } else {
            throw new \RuntimeException('failed to unzip file: ' . $file);
        }
    }
}
