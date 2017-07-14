<?php

namespace mermshaus\TinyTinyRiver;

/**
 * Class TinyTinyRssApi
 */
class TinyTinyRssApi
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $sessionId = '';

    /**
     * TinyTinyRssApi constructor.
     *
     * @param string $url
     * @param string $user
     * @param string $password
     */
    public function __construct($url, $user = '', $password = '')
    {
        $this->url = $url;

        $ret = $this->doQuery(array(
            'op'       => 'login',
            'user'     => $user,
            'password' => $password
        ));

        $this->sessionId = $ret['content']['session_id'];
    }

    /**
     * @param array $params
     * @return mixed
     */
    private function doQuery(array $params)
    {
        $options = array(
            CURLOPT_URL            => $this->url,
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 8,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($params)
        );

        $ch = curl_init();

        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);

        if (!is_string($result)) {
            trigger_error(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($result, true);
    }

    /**
     * @param $operation
     * @param array $params
     * @return mixed
     */
    public function query($operation, array $params = array())
    {
        $params['sid'] = $this->sessionId;

        $params['op'] = $operation;

        $res = $this->doQuery($params);

        return $res['content'];
    }
}
