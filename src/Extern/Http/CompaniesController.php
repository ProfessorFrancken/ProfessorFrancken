<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\CompanyRepository;
use Francken\Extern\JobOpeningRepository;
use Francken\Extern\JobType;
use Francken\Extern\Sector;
use Illuminate\View\View;

final class CompaniesController
{
    private CompanyRepository $companies;

    private JobOpeningRepository $jobs;

    public function __construct(CompanyRepository $companies, JobOpeningRepository $jobs)
    {
        $this->companies = $companies;
        $this->jobs = $jobs;
    }

    public function index() : View
    {
        return view('career.companies.index')
            ->with('companies', $this->companies->profiles())
            ->with('breadcrumbs', [
                ['url' => '/career', 'text' => 'Career'],
                ['url' => '/career/companies', 'text' => 'Company profiles'],
            ]);
    }

    public function show(string $slug) : View
    {
        $company = $this->companies->findByLink($slug);
        $jobs = $this->jobs->search(
            null, $company['name']
        );

        return view('career.companies.show')
            ->with('companies', $this->companies->profiles())
            ->with('company', $company)
            ->with('jobs', $jobs)
            ->with('sectors', Sector::all()->mapWithKeys(function (Sector $sector) : array {
                return [$sector->name => $sector->icon];
            }))
            ->with('types', JobType::TYPES)
            ->with('breadcrumbs', [
                ['url' => '/career', 'text' => 'Career'],
                ['url' => '/career/companies', 'text' => 'Company profiles'],
                ['text' => $company['name']],
            ]);
    }
}
