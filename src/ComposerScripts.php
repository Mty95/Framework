<?php
namespace Mty95\Framework;

class ComposerScripts
{
    public static function postInstall()
    {
        self::createFolders();
        self::unzipApp();
    }

    private static function makeFolderIfNotExists($path)
    {
        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }
    }

    private static function unzipApp()
    {
        $file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Files' . DIRECTORY_SEPARATOR . 'app.zip';

        $zip = new \ZipArchive();

        if ($zip->open($file) === true)
        {
            $zip->extractTo(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR);
            $zip->close();
        } else {
            throw new \RuntimeException('failed to unzip file: ' . $file);
        }
    }

    private static function createFolders()
    {
        $folders = [
            'src',
            'src/Models',
            'src/Observers',
        ];

        foreach ($folders as $folder) {
            self::makeFolderIfNotExists(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . $folder);
        }
    }
}
