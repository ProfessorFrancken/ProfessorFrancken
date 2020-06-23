<?php

declare(strict_types=1);

namespace Francken\Career;

use League\CommonMark\CommonMarkConverter;

final class CompanyRepository
{
    private $companies;

    public function __construct(array $companies)
    {
        $toHtml = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $this->companies = array_map(function ($company) use ($toHtml) {
            $company['summary'] = $toHtml->convertToHtml($company['summary']);
            return $company;
        }, $companies);
    }

    public function profiles() : array
    {
        return array_filter(
            $this->companies,
            function ($company) {
                return $company['show-profile'] == true;
            }
        );
    }

    public function findByLink($slug) : array
    {
        return array_first(
            array_filter($this->profiles(), function ($company) use ($slug) {
                return str_slug($company['name']) === $slug;
            })
        );
    }

    /**
     * Return a list of companies who should be shown in the footer
     */
    public function forFooter() : array
    {
        return array_filter(
            $this->companies,
            function ($company) {
                return $company['show-in-footer'] == true;
            }
        );
    }
}
