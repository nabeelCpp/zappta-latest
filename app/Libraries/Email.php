<?php
namespace App\Libraries;

use CodeIgniter\Email\Email as BaseEmail;

class Email extends BaseEmail
{
    

    /**
     * Valid $protocol values
     *
     * @see Email::$protocol
     *
     * @var array
     */
    protected $protocols = [
        'mail',
        'sendmail',
        'smtp',
        'esmtp',
        'eesmtp',
        'gsmtp',
    ];

    /**
     * Whether to perform SMTP authentication
     *
     * @var bool
     */
    protected $SMTPAuth = true;

    
    /**
     * Send using Gsmtp
     *
     * @return bool
     */
    protected function sendWithGsmtp()
    {
        if ($this->SMTPHost === '') {
            $this->setErrorMessage(lang('Email.noHostname'));

            return false;
        }

        if (! $this->SMTPConnect() || ! $this->SMTPAuthenticate()) {
            return false;
        }

        if (! $this->sendCommand('from', $this->cleanEmail($this->headers['From']))) {
            $this->SMTPEnd();

            return false;
        }

        foreach ($this->recipients as $val) {
            if (! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        foreach ($this->CCArray as $val) {
            if ($val !== '' && ! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        foreach ($this->BCCArray as $val) {
            if ($val !== '' && ! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        if (! $this->sendCommand('data')) {
            $this->SMTPEnd();

            return false;
        }

        // perform dot transformation on any lines that begin with a dot
        $this->sendData($this->headerStr . preg_replace('/^\./m', '..$1', $this->finalBody));
        $this->sendData($this->newline . '.');
        $reply = $this->getSMTPData();
        $this->setErrorMessage($reply);
        $this->SMTPEnd();

        if (strpos($reply, '250') !== 0) {
            $this->setErrorMessage(lang('Email.SMTPError', [$reply]));

            return false;
        }

        return true;
    }

    
    /**
     * Send using Esmtp
     *
     * @return bool
     */
    protected function sendWithEsmtp()
    {
        if ($this->SMTPHost === '') {
            $this->setErrorMessage(lang('Email.noHostname'));

            return false;
        }

        if (! $this->SMTPConnect() || ! $this->SMTPAuthenticate()) {
            return false;
        }

        if (! $this->sendCommand('from', $this->cleanEmail($this->headers['From']))) {
            $this->SMTPEnd();

            return false;
        }

        foreach ($this->recipients as $val) {
            if (! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        foreach ($this->CCArray as $val) {
            if ($val !== '' && ! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        foreach ($this->BCCArray as $val) {
            if ($val !== '' && ! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        if (! $this->sendCommand('data')) {
            $this->SMTPEnd();

            return false;
        }

        // perform dot transformation on any lines that begin with a dot
        $this->sendData($this->headerStr . preg_replace('/^\./m', '..$1', $this->finalBody));
        $this->sendData($this->newline . '.');
        $reply = $this->getSMTPData();
        $this->setErrorMessage($reply);
        $this->SMTPEnd();

        if (strpos($reply, '250') !== 0) {
            $this->setErrorMessage(lang('Email.SMTPError', [$reply]));

            return false;
        }

        return true;
    }


    /**
     * Send using Eesmtp
     *
     * @return bool
     */
    protected function sendWithEesmtp()
    {
        if ($this->SMTPHost === '') {
            $this->setErrorMessage(lang('Email.noHostname'));

            return false;
        }

        if (! $this->SMTPConnect() || ! $this->SMTPAuthenticate()) {
            return false;
        }

        if (! $this->sendCommand('from', $this->cleanEmail($this->headers['From']))) {
            $this->SMTPEnd();

            return false;
        }

        foreach ($this->recipients as $val) {
            if (! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        foreach ($this->CCArray as $val) {
            if ($val !== '' && ! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        foreach ($this->BCCArray as $val) {
            if ($val !== '' && ! $this->sendCommand('to', $val)) {
                $this->SMTPEnd();

                return false;
            }
        }

        if (! $this->sendCommand('data')) {
            $this->SMTPEnd();

            return false;
        }

        // perform dot transformation on any lines that begin with a dot
        $this->sendData($this->headerStr . preg_replace('/^\./m', '..$1', $this->finalBody));
        $this->sendData($this->newline . '.');
        $reply = $this->getSMTPData();
        $this->setErrorMessage($reply);
        $this->SMTPEnd();

        if (strpos($reply, '250') !== 0) {
            $this->setErrorMessage(lang('Email.SMTPError', [$reply]));

            return false;
        }

        return true;
    }


}