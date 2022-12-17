<?php

namespace DMo\ServerFileGate\Presenter;

class DialogTrigger
{
    /**
     * @var string $dialogURL
     */
    protected $dialogURL;

    /**
     * @var array $parameters
     */
    protected $parameters;

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
        return sprintf(
            "<a href=\"javascript:window.open('%s?cb=%s&pDir=%s%s%s','dialogwin',"
                ."'width=%d,height=%d,resizable=1,toolbar=0,status=0')\">%s</a>",
            $this->dialogURL,
            $jsCallbackName,
            $absStartPath,
            empty($fileTypes) ? '' : '&filetypes='.$fileTypes,
            $this->getParameters(),
            $dialogWith,
            $dialogHeight,
            $linkLabel
        );
    }

    /**
     * @return string
     */
    private function getParameters()
    {
        return empty($this->parameters) ? '' : '&' . http_build_query($this->parameters);
    }
}
