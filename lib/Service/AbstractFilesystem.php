<?php

namespace DMo\ServerFileGate\Service;

abstract class AbstractFilesystem
{
    /**
     * @var array $icons
     */
    protected $icons = [

        // Microsoft Office
        'doc' => ['doc', 'Word Document'],
        'xls' => ['xls', 'Excel Spreadsheet'],
        'ppt' => ['ppt', 'PowerPoint Presentation'],
        'pps' => ['ppt', 'PowerPoint Presentation'],
        'pot' => ['ppt', 'PowerPoint Presentation'],

        'mdb' => ['access', 'Access Database'],
        'vsd' => ['visio', 'Visio Document'],
        'rtf' => ['rtf', 'RTF File'],

        // XML
        'htm' => ['htm', 'HTML Document'],
        'html' => ['htm', 'HTML Document'],
        'xml' => ['xml', 'XML Document'],

         // Images
        'jpg' => ['image', 'JPEG Image'],
        'jpe' => ['image', 'JPEG Image'],
        'jpeg' => ['image', 'JPEG Image'],
        'gif' => ['image', 'GIF Image'],
        'bmp' => ['image', 'Windows Bitmap Image'],
        'png' => ['image', 'PNG Image'],
        'tif' => ['image', 'TIFF Image'],
        'tiff' => ['image', 'TIFF Image'],

        // Audio
        'mp3' => ['audio', 'MP3 Audio'],
        'wma' => ['audio', 'WMA Audio'],
        'mid' => ['audio', 'MIDI Sequence'],
        'midi' => ['audio', 'MIDI Sequence'],
        'rmi' => ['audio', 'MIDI Sequence'],
        'au' => ['audio', 'AU Sound'],
        'snd' => ['audio', 'AU Sound'],

        // Video
        'mpeg' => ['video', 'MPEG Video'],
        'mpg' => ['video', 'MPEG Video'],
        'mpe' => ['video', 'MPEG Video'],
        'wmv' => ['video', 'Windows Media File'],
        'avi' => ['video', 'AVI Video'],

        // Archives
        'zip' => ['zip', 'ZIP Archive'],
        'rar' => ['zip', 'RAR Archive'],
        'cab' => ['zip', 'CAB Archive'],
        'gz' => ['zip', 'GZIP Archive'],
        'tar' => ['zip', 'TAR Archive'],
        'zip' => ['zip', 'ZIP Archive'],

        // OpenOffice
        'sdw' => ['oo-write', 'OpenOffice Writer document'],
        'sda' => ['oo-draw', 'OpenOffice Draw document'],
        'sdc' => ['oo-calc', 'OpenOffice Calc spreadsheet'],
        'sdd' => ['oo-impress', 'OpenOffice Impress presentation'],
        'sdp' => ['oo-impress', 'OpenOffice Impress presentation'],

        // Others
        'txt' => ['txt', 'Text Document'],
        'js' => ['js', 'Javascript Document'],
        'dll' => ['binary', 'Binary File'],
        'pdf' => ['pdf', 'Adobe Acrobat Document'],
        'php' => ['php', 'PHP Script'],
        'ps' => ['ps', 'Postscript File'],
        'dvi' => ['dvi', 'DVI File'],

        // Unkown
        'default' => ['txt', 'Unkown Document']
    ];

    abstract public function __construct(string $baseDir);
    abstract public function mkDir(string $targetDir, string $name);
    abstract public function getFilesInDirectory(string $targetDir);
    abstract public function getDirectoriesInBetweenFromBaseDir(string $targetDir);
    abstract public function getDirectoriesInDirectory(string $targetDir);
    abstract public function getBaseDir();
}
