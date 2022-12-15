<?php

namespace DMo\ServerFileGate\Presenter;

use DMo\ServerFileGate\Configuration;

class Dialog
{
    /**
     * @var Configuration $config
     */
    private $config;

    /**
     * @var array $requestParams
     */
    private $requestParams;

    /**
     * @var array $errors
     */
    private $errors = [];

    /**
     * @param Configuration $config
     * @param array $requestParams
     */
    protected function __construct(Configuration $config, array $requestParams)
    {
        $this->config = $config;
        $this->requestParams = $requestParams;
    }

    /**
     * @return string
     */
    private function getCurrentDir()
    {
        return !empty($this->requestParams['currDir'])
            ? $this->requestParams['currDir']
            : $this->config->getOperationDirectory();
    }

    /**
     * @return array
     */
    private function getErrorsForTemplate()
    {
        $params = $this->config->getTemplateParameters();
        $messages = [
            'wrongFiletype' => !empty($params['translation']['errors']['wrongFiletype'])
                ? $params['translation']['errors']['wrongFiletype']
                : 'Only files of following types allowed: %s!',
            'uploadError' => !empty($params['translation']['errors']['uploadError'])
                ? $params['translation']['errors']['uploadError']
                : 'An error occured during file upload: %s'
        ];
        $errors = [];
        foreach ($this->errors as $key => $info) {
            $errors[] = ['message' => sprintf($messages[$key], $info)];
        }
        return $errors;
    }

    /**
     * @return void
     */
    private function echoRenderedTemplate()
    {
        $m = new \Mustache_Engine(['entity_flags' => ENT_QUOTES]);
        $opDir = $this->config->getOperationDirectory();

        echo $m->render(
            $this->config->getDialogTemplate(), array_merge(
                $this->config->getTemplateParameters(), [
                    'opDir' => $opDir,
                    'parentDir' => $opDir === $this->getCurrentDir()
                        ? $opDir : dirname($this->getCurrentDir()),
                    'currentDir' => $this->getCurrentDir(),
                    'dirNavigation' => $this->config->getFilesystemAdapter()
                        ->getDirectoriesInBetweenFromBaseDir($this->getCurrentDir()),
                    'dirsInCurrentDir' => $this->config->getFilesystemAdapter()
                        ->getDirectoriesInDirectory($this->getCurrentDir()),
                    'filesInCurrentDir' => $this->config->getFilesystemAdapter()
                        ->getFilesInDirectory($this->getCurrentDir()),
                    'callbackName' => $this->requestParams['cb'],
                    'hiddenInputs' => [
                        ['name' => 'act', 'value' => '---'],
                        ['name' => 'variable', 'value' => '---'],
                        ['name' => 'cb', 'value' => $this->requestParams['cb']]
                    ],
                    'errors' => $this->getErrorsForTemplate()
                ]
            )
        );
    }

    /**
     * @param Configuration $config
     * @param array $requestParams
     * @return void
     */
    public static function handleRequest(Configuration $config, array $requestParams)
    {
        if ($config->getAuth()->accessDenied()) {
            return;
        }

        $dialog = new static($config, $requestParams);

        if ($_POST['act'] === 'AddDir') {
            $config->getFilesystemAdapter()->mkDir($dialog->getCurrentDir(), $_POST['variable']);
        }

        if (!empty($_FILES['upload']['tmp_name'])) {
            $allowedSuffixes = $config->getAllowedFileTypeSuffixes();
            if (!empty($allowedSuffixes) && !in_array(pathinfo($_FILES['upload']['name'])['extension'], $allowedSuffixes)) {
                $dialog->errors[] = [
                    'wrongFiletype' => implode(', ', $allowedSuffixes)
                ];
            } else {
                if (empty($_FILES['upload']['error'])) {
                    move_uploaded_file($_FILES['upload']['tmp_name'], $dialog->getCurrentDir() . '/' . $_FILES['upload']['name']);
                } else {
                    $dialog->errors[] = [
                        'uploadError' => $_FILES['upload']['error']
                    ];
                }
            }
        }

        $dialog->echoRenderedTemplate();
    }
}
