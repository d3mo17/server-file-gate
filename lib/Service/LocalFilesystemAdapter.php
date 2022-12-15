<?php

namespace DMo\ServerFileGate\Service;

class LocalFilesystemAdapter extends AbstractFilesystem
{
    /**
     * @var string $baseDir
     */
    private $baseDir;

    /**
     * @param string $baseDir
     */
    function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }

    /**
     * @return string
     */
    public function getBaseDir()
    {
        return $this->baseDir;
    }

    /**
     * @param string $targetDir
     * @param string $directory
     * @return void|bool
     */
    public function mkDir(string $targetDir, string $name)
    {
        if (empty($name)) {
            return;
        }
        return @mkdir($targetDir.'/'.trim($name));
    }

    /**
     * @param string $targetDir
     * @return array
     */
    public function getFilesInDirectory(string $targetDir)
    {
        $paths = [];
        if ($dh = opendir($targetDir)) {
            while (($file = readdir($dh)) !== false) {
                $ext = pathinfo($file)['extension'];
                $iconKey = array_key_exists($ext, $this->icons) ? $ext : 'default';
                $memoryFile = $targetDir.'/'.$file;
                $fileInfo = 'File Type: '.$this->icons[$iconKey][1]."\n";
                $fileInfo .= 'Modified: '.@date ('F d Y H:i:s.', @filemtime($file))."\n";
                $fileInfo .= 'Size: '.@filesize($file).' bytes.';
                if (is_file($memoryFile) && $file != '.' && $file != '..') {
                    $paths[] = [
                        'fullpath' => $memoryFile,
                        'label' => str_replace($this->baseDir, '', $memoryFile),
                        'name' => $file,
                        'info' => $fileInfo,
                        'icon' => $this->icons[$iconKey][0].'.gif'
                    ];
                }
            }
        }

        return $paths;

    }

    /**
     * @param string $targetDir
     * @return array
     */
    public function getDirectoriesInBetweenFromBaseDir(string $targetDir)
    {
        $paths = [];
        $dirDiff = str_replace($this->baseDir, '', $targetDir);
        $dirsInBetween = preg_split('#/#', $dirDiff, -1, PREG_SPLIT_NO_EMPTY);
        $memoryDir = $this->baseDir;
        foreach ($dirsInBetween as $dir) {
            $memoryDir .= '/'.$dir;
            $paths[] = [
                'fullpath' => $memoryDir,
                'label' => str_replace($this->baseDir, '', $memoryDir),
                'name' => $dir
            ];
        }

        return $paths;
    }

    /**
     * @param string $targetDir
     * @return array
     */
    public function getDirectoriesInDirectory(string $targetDir)
    {
        $paths = [];
        if ($dh = opendir($targetDir)) {
            while (($file = readdir($dh)) !== false) {
                $memoryDir = $targetDir.'/'.$file;
                if (is_dir($memoryDir) && $file != '.' && $file != '..') {
                    $paths[] = [
                        'fullpath' => $memoryDir,
                        'label' => str_replace($this->baseDir, '', $memoryDir),
                        'name' => $file
                    ];
                }
            }
        }

        return $paths;
    }
}
