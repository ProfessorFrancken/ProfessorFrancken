<?php

declare(strict_types=1);

namespace Francken\Career\Http;

use Francken\Career\CompanyRepository;
use Francken\Career\JobOpeningRepository;
use Francken\Career\JobType;
use Francken\Career\Sector;

final class CompaniesController
{
    private $companies;
    private $jobs;

    public function __construct(CompanyRepository $companies, JobOpeningRepository $jobs)
    {
        $this->companies = $companies;
        $this->jobs = $jobs;
    }

    public function index()
    {
        return view('career.companies.index')
            ->with('companies', $this->companies->profiles())
            ->with('breadcrumbs', [
                ['url' => '/career', 'text' => 'Career'],
                ['url' => '/career/companies', 'text' => 'Company profiles'],
            ]);
    }

    public function show($slug)
    {
        $company = $this->companies->findByLink($slug);
        $jobs = $this->jobs->search(
            null, $company['name']
        );

        return view('career.companies.show')
            ->with('companies', $this->companies->profiles())
            ->with('company', $company)
            ->with('jobs', $jobs)
            ->with('sectors', Sector::SECTORS)
            ->with('types', JobType::TYPES)
            ->with('breadcrumbs', [
                ['url' => '/career', 'text' => 'Career'],
                ['url' => '/career/companies', 'text' => 'Company profiles'],
                ['text' => $company['name']],
            ]);
    }
}
