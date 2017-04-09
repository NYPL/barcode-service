<?php
namespace NYPL\Starter\Model\ModelTrait;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use NYPL\Starter\Cache;
use NYPL\Starter\Config;
use NYPL\Starter\APIException;

trait SierraTrait
{
    protected static $cacheKey = 'PatronService:Sierra:Token';

    private $timeoutSeconds = 10;

    /**
     * @param string $id
     *
     * @return string
     */
    abstract public function getSierraPath($id = '');

    /**
     * @return string
     */
    abstract public function getRequestType();

    /**
     * @param string $id
     *
     * @return string
     */
    public function getSierraId($id = '')
    {
        if (is_numeric(substr($id, 0, 1))) {
            return $id;
        }

        return substr($id, 1);
    }

    /**
     * @param string $path
     * @param bool $ignoreNoRecord
     * @param array $headers
     *
     * @return string
     * @throws APIException
     */
    protected function sendRequest($path = '', $ignoreNoRecord = false, array $headers = [])
    {
        $client = new Client();

        $headers['Authorization'] = 'Bearer ' . $this->getAccessToken();

        try {
            $request = $client->request(
                $this->getRequestType(),
                Config::get('SIERRA_BASE_API_URL') . '/' . $path,
                [
                    'verify' => false,
                    'headers' => $headers,
                    'body' => $this->getBody(),
                    'timeout' => $this->getTimeoutSeconds()
                ]
            );
        } catch (ConnectException $connectException) {
            throw new APIException(
                'Error connecting to ' . $connectException->getRequest()->getUri() . ': ' .
                $connectException->getMessage(),
                $connectException
            );
        } catch (ClientException $clientException) {
            if (!$ignoreNoRecord) {
                throw new APIException(
                    (string) $clientException->getMessage(),
                    null,
                    0,
                    null,
                    $clientException->getResponse()->getStatusCode()
                );
            }
        }

        return (string) $request->getBody();
    }

    /**
     * @param array $token
     */
    protected function saveToken(array $token = [])
    {
        $token['expire_time'] = time() + $token['expires_in'];

        Cache::getCache()->set($this->getCacheKey(), serialize($token));
    }

    /**
     * @return bool|array
     */
    protected function getCachedAccessToken()
    {
        $token = Cache::getCache()->get($this->getCacheKey());

        if (!$token) {
            return false;
        }

        $token = unserialize($token);

        if ($token['expire_time'] <= time()) {
            return false;
        }

        return $token;
    }

    /**
     * @return string
     */
    protected function getAccessToken()
    {

        if ($token = $this->getCachedAccessToken()) {
            return $token['access_token'];
        }

        $token = json_decode($this->getNewToken(), true);

        $this->saveToken($token);

        return $token['access_token'];
    }

    /**
     * @return string
     * @throws APIException
     */
    protected function getNewToken()
    {
        $client = new Client();

        $request = $client->request(
            'POST',
            Config::get('SIERRA_OAUTH_TOKEN_URI'),
            [
                'auth' => [
                    Config::get('SIERRA_OAUTH_CLIENT_ID', null, true),
                    Config::get('SIERRA_OAUTH_CLIENT_SECRET', null, true)
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials'
                ],
                'verify' => false,
                'timeout' => $this->getTimeoutSeconds()
            ]
        );

        return (string) $request->getBody();
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return (string) self::$cacheKey . ':' . md5(Config::get('SIERRA_BASE_API_URL'));
    }

    /**
     * @return int
     */
    public function getTimeoutSeconds()
    {
        return $this->timeoutSeconds;
    }

    /**
     * @param int $timeoutSeconds
     */
    public function setTimeoutSeconds($timeoutSeconds)
    {
        $this->timeoutSeconds = (int) $timeoutSeconds;
    }
}
