<?php

namespace PragmaRX\Google2FA\Support;

trait qrCode
{
    /**
     * Creates a qr code url.
     *
     * @param string $company
     * @param string $holder
     * @param string $secret
     *
     * @return string
     */
    public function getqrCodeUrl($company, $holder, $secret)
    {
        return 'otpauth://totp/'.
            rawurlencode($company).
            ':'.
            rawurlencode($holder).
            '?secret='.
            $secret.
            '&issuer='.
            rawurlencode($company).
            '&algorithm='.
            rawurlencode(strtoupper($this->getAlgorithm())).
            '&digits='.
            rawurlencode(strtoupper((string) $this->getOneTimePasswordLength())).
            '&period='.
            rawurlencode(strtoupper((string) $this->getKeyRegeneration())).
            '';
    }
}
