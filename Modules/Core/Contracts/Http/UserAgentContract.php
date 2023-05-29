<?php

namespace Modules\Core\Contracts\Http;

interface UserAgentContract {
    public function getDevice(): string;
    public function getBrowser(): string;
    public function getBrowserVersion(string $browser): string;

    public function getSessionPlatform(): string;
}
