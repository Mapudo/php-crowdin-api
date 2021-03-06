<?php

namespace Akeneo\Crowdin\Api;

use \InvalidArgumentException;

/**
 * Add a directory to the Crowdin project.
 *
 * @author Julien Janvier <j.janvier@gmail.com>
 * @see https://crowdin.com/page/api/add-directory
 */
class AddDirectory extends AbstractApi
{
    /** @var string */
    protected $directory;

    /** @var bool */
    protected $isBranch = false;

    /** @var string */
    protected $branch;

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if (null == $this->directory) {
            throw new InvalidArgumentException('There is no directory to create.');
        }
        
        $this->addUrlParameter('key', $this->client->getProjectApiKey());

        $path = sprintf(
            "project/%s/add-directory?%s",
            $this->client->getProjectIdentifier(),
            $this->getUrlQueryString()
        );

        $parameters = ['name' => $this->directory];
        if ($this->isBranch) {
            $parameters['is_branch'] = '1';
        }
        if (null !== $this->branch) {
            $parameters['branch'] = $this->branch;
        }

        $data = ['form_params' => $parameters];
        $response = $this->client->getHttpClient()->post($path, $data);

        return $response->getBody();
    }

    /**
     * @param mixed $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return mixed
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param bool $isBranch
     */
    public function setIsBranch($isBranch)
    {
        $this->isBranch = $isBranch;
    }

    /**
     * @return bool
     */
    public function getIsBranch()
    {
        return $this->isBranch;
    }

    /**
     * @param string $branch
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
    }

    /**
     * @return string|null
     */
    public function getBranch()
    {
        return $this->branch;
    }
}
