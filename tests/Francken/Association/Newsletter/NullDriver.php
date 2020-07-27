<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Newsletter;

use DrewM\MailChimp\MailChimp;
use Illuminate\Support\Facades\Log;
use Spatie\Newsletter\Newsletter;

class NullDriver extends Newsletter
{
    private bool $logCalls;

    public function __construct(bool $logCalls = false)
    {
        $this->logCalls = $logCalls;
    }

    public function __call($name, $arguments) : void
    {
        if ($this->logCalls) {
            Log::debug('Called Spatie Newsletter facade method: ' . $name . ' with:', $arguments);
        }
    }

    public function subscribe(string $email, array $mergeFields = [], string $listName = '', array $options = []) : void
    {
    }

    public function subscribePending(string $email, array $mergeFields = [], string $listName = '', array $options = []) : void
    {
    }

    public function subscribeOrUpdate(string $email, array $mergeFields = [], string $listName = '', array $options = []) : void
    {
    }

    public function getMembers(string $listName = '', array $parameters = []) : void
    {
    }

    public function getMember(string $email, string $listName = '') : void
    {
    }

    public function getMemberActivity(string $email, string $listName = '') : void
    {
    }

    public function hasMember(string $email, string $listName = '') : bool
    {
        return false;
    }

    public function isSubscribed(string $email, string $listName = '') : bool
    {
        return false;
    }

    public function unsubscribe(string $email, string $listName = '') : void
    {
    }

    public function updateEmailAddress(string $currentEmailAddress, string $newEmailAddress, string $listName = '') : void
    {
    }

    public function delete(string $email, string $listName = '') : void
    {
    }

    public function deletePermanently(string $email, string $listName = '') : void
    {
    }

    public function getTags(string $email, string $listName = '') : void
    {
    }

    public function addTags(array $tags, string $email, string $listName = '') : void
    {
    }

    public function removeTags(array $tags, string $email, string $listName = '') : void
    {
    }

    public function createCampaign(
        string $fromName,
        string $replyTo,
        string $subject,
        string $html = '',
        string $listName = '',
        array $options = [],
        array $contentOptions = []) : void
    {
    }

    public function updateContent(string $campaignId, string $html, array $options = []) : void
    {
    }

    public function getApi() : MailChimp
    {
        return new Mailchimp();
    }

    /**
     * @return string|false
     */
    public function getLastError() : bool
    {
        return false;
    }

    public function lastActionSucceeded() : bool
    {
        return false;
    }
}
