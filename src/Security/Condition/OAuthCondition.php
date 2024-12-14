<?php

namespace App\Security\Condition;

use App\Entity\User;
use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContextInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Condition\TwoFactorConditionInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Trusted\TrustedDeviceManagerInterface;

readonly class OAuthCondition implements TwoFactorConditionInterface
{
    public function __construct(
        private TrustedDeviceManagerInterface $trustedDeviceManager,
        private bool $extendTrustedToken = true,
    ) {
    }

    public function shouldPerformTwoFactorAuthentication(AuthenticationContextInterface $context): bool
    {
        /** @var User $user */
        $user = $context->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $googleAuthId = $user->getGoogleAuthId();

        if (!empty($googleAuthId)) {
            return false;
        }

        $firewallName = $context->getFirewallName();

        // Skip two-factor authentication on trusted devices
        if ($this->trustedDeviceManager->isTrustedDevice($user, $firewallName)) {
            if (
                $this->extendTrustedToken
                && $this->trustedDeviceManager->canSetTrustedDevice($user, $context->getRequest(), $firewallName)
            ) {
                $this->trustedDeviceManager->addTrustedDevice($user, $firewallName);
            }

            return false;
        }

        return true;
    }
}
