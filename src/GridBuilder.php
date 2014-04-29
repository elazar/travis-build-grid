<?php

namespace Elazar\TravisBuildGrid;

use Guzzle\Http\Client as HttpClient;

class GridBuilder
{
    const API_ROOT = 'https://api.travis-ci.org';

    /**
     * @var array
     */
    protected $repos = array();

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $configSection = 'php';

    /**
     * Returns a list of the repositories being analyzed.
     *
     * @return array
     */
    public function getRepos()
    {
        return $this->repos;
    }

    /**
     * Sets the repositories to be analyzed.
     *
     * @param string $repos
     */
    public function setRepos(array $repos)
    {
        $this->repos = $repos;
    }

    /**
     * Returns the HTTP client in use for interacting with the Travis API.
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new HttpClient;
        }
        return $this->httpClient;
    }

    /**
     * Sets the HTTP client to use for interacting with the Travis API.
     *
     * @param \GuzzleHttp\Client $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Returns the configuration section used to determine build versions.
     *
     * @return string
     */
    public function getConfigSection()
    {
        return $this->configSection;
    }

    /**
     * Sets the configuration section used to determine build versions.
     *
     * @param string $configSection
     */
    public function setConfigSection($configSection)
    {
        $this->configSection = $configSection;
    }

    /**
     * Returns a grid of build results.
     *
     * @return array Associative array indexed by repo, then build version,
     *         each containing an associative array of information for the
     *         last build
     */
    public function getGridData()
    {
        $httpClient = $this->getHttpClient();
        $repos = $this->getRepos();
        $configSection = $this->getConfigSection();
        $grid = array();

        foreach ($repos as $repo) {
            $buildsUrl = self::API_ROOT . '/repos/' . $repo . '/builds';
            $request = $httpClient->get($buildsUrl);
            $response = $httpClient->send($request);
            $json = $response->json();
            $buildId = $json[0]['id'];

            $request = $httpClient->get($buildsUrl . '/' . $buildId);
            $response = $httpClient->send($request);
            $json = $response->json();
            $matrix = $json['matrix'];

            $grid[$repo] = array();
            foreach ($matrix as $row) {
                $jobId = $row['id'];
                $jobUrl = 'https://travis-ci.org/' . $repo . '/jobs/' . $jobId;
                $buildVersion = (string) $row['config'][$configSection];
                $buildResult = $row['result'] ? 'failed' : 'passed';
                $grid[$repo][$buildVersion] = array(
                    'url' => $jobUrl,
                    'result' => $buildResult,
                );
            }
        }

        return $grid;
    }
}
