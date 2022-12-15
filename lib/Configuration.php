<?php

namespace DMo\ServerFileGate;

use DMo\ServerFileGate\Service\AuthInterface;
use DMo\ServerFileGate\Service\AbstractFilesystem;
use DMo\ServerFileGate\Service\NoAuthAdapter;

class Configuration
{
    /**
     * @var AuthInterface $auth
     */
    protected $auth;

    /**
     * @var string $dialogTpl
     */
    private $dialogTpl;

    /**
     * @var string $tplParams
     */
    private $tplParams;

    /**
     * @var array $allowedSuffixes
     */
    private $allowedSuffixes = [];

    /**
     * @var FilesystemInterface $filesystemAdapter
     */
    private $filesystemAdapter;

    /**
     * @param FilesystemInterface $filesystemAdapter
     * @param string $operationDirectory
     * @param string $dialogTemplate
     * @param array $templateParameters
     */
    public function __construct(
        AbstractFilesystem $filesystemAdapter,
        string $dialogTemplate,
        array $templateParameters = []
    ) {
        $this->auth = new NoAuthAdapter();
        $this->filesystemAdapter = $filesystemAdapter;
        $this->dialogTpl = $dialogTemplate;
        $this->tplParams = $templateParameters;
    }

    /**
     * @return FilesystemInterface
     */
    public function getFilesystemAdapter()
    {
        return $this->filesystemAdapter;
    }

    /**
     * @return AuthInterface
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return string
     */
    public function getOperationDirectory()
    {
        return $this->filesystemAdapter->getBaseDir();
    }

    /**
     * @return string
     */
    public function getDialogTemplate()
    {
        return $this->dialogTpl;
    }

    /**
     * @return array
     */
    public function getTemplateParameters()
    {
        return $this->tplParams;
    }

    /**
     * @return array
     */
    public function getAllowedFileTypeSuffixes()
    {
        return $this->allowedSuffixes;
    }

    /**
     * @param string $suffix
     * @return $this
     */
    public function addAllowedFileTypeSuffix(string $suffix)
    {
        $this->allowedSuffixes[] = $suffix;
        return $this;
    }

    /**
     * @param AuthInterface $auth
     * @return $this
     */
    public function setAuth(AuthInterface $auth)
    {
        $this->auth = $auth;
        return $this;
    }
}
