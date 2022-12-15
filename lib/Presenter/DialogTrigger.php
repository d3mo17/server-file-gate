<?php

namespace DMo\ServerFileGate\Presenter;

class DialogTrigger
{
    /**
     * @var string $dialogURL
     */
    private $dialogURL;

    /**
     * @var array $parameters
     */
    private $parameters;

    /**
     * @param string $urlToDialog
     * @param array $parameters
     */
    public function __construct(string $urlToDialog, array $parameters = [])
    {
        $this->dialogURL = $urlToDialog;
        $this->parameters = $parameters;
    }

    /**
     * @param string $absStartPath
     * @param string $jsCallbackName
     * @param string $fileTypes
     * @param string $linkLabel
     * @return string
     */
    public function getHTMLSnippet(
        string $absStartPath,
        string $jsCallbackName,
        string $fileTypes = '',
        string $linkLabel = '...',
        int $dialogWith = 590,
        int $dialogHeight = 420
    ) {
        return <<<html
        <a href="javascript:showFileDialog()">$linkLabel</a>
        <script>

            function showFileDialog()
            {
                window.open('$this->dialogURL?cb=$jsCallbackName&pDir=$absStartPath&filetypes=$fileTypes{$this->getParameters()}', 'dialogwin', 'width=$dialogWith,height=$dialogHeight,resizable=1,toolbar=0,status=0');
            }
        </script>
html;
    }

    /**
     * @return string
     */
    private function getParameters()
    {
        return empty($this->parameters) ? '' : '&' . http_build_query($this->parameters);
    }
}
