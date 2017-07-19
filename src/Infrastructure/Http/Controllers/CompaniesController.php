<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Francken\Application\Career\CompanyRepository;

final class CompaniesController
{
    private $companies;

    public function __construct(CompanyRepository $companies)
    {
        $this->companies = $companies;
    }

    public function index()
    {
        return view('career.companies.index')
            ->with('companies', $this->companies->profiles());
    }

    public function show($slug)
    {
        return view('career.companies.show')
            ->with('companies', $this->companies->profiles())
            ->with('company', $this->companies->findByLink($slug));
    }
}
