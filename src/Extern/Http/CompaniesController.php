<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\CompanyRepository;
use Francken\Extern\JobOpeningRepository;
use Francken\Extern\JobType;
use Francken\Extern\Sector;

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
