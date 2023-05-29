<?php

namespace Modules\Core\Services\Http;

use Jenssegers\Agent\Agent;
use Modules\Core\Contracts\Http\UserAgentContract;
use Modules\Core\Exceptions\Http\InvalidUserAgent;

final class UserAgentService implements UserAgentContract
{
    /**
     * @var Agent
     */
    private Agent $objAgent;

    /**
     * @param Agent $objAgent
     */
    public function __construct(Agent $objAgent)
    {
        $this->objAgent = $objAgent;
    }

    /**
     * @return string
     * @throws InvalidUserAgent
     */
    public function getDevice(): string
    {
        $strDevice = $this->objAgent->device();

        if (is_null($strDevice))
        {
            throw new InvalidUserAgent();
        }

        return $strDevice;
    }

    /**
     * @return string
     * @throws InvalidUserAgent
     */
    public function getBrowser(): string
    {
        $strBrowser = $this->objAgent->browser();

        if (is_null($strBrowser))
        {
            throw new InvalidUserAgent();
        }

        return $strBrowser;
    }

    /**
     * @return string
     * @throws InvalidUserAgent
     */
    public function getSessionPlatform(): string
    {
        $strBrowser = $this->getBrowser();

        return $strBrowser . " " . $this->getBrowserVersion($strBrowser) . " " . $this->getDevice();
    }

    public function getBrowserVersion(string $browser): string
    {
        return $this->objAgent->version($browser);
    }
}
