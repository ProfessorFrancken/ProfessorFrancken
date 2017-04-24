<?php

declare(strict_types=1);

namespace Francken\Application\Committees;

final class Committee
{
    private $container;
    private $members = [];
    private $slug;
    private $id;
    private $name;
    private $logo;

    private $page;
    private $description;

    public function __construct($id, $name, $email, $logo, $link, $page, array $members)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->logo = $logo;
        $this->link = $link;
        $this->members = $members;
        $this->page = $page;
    }

    public function id()
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function logo()
    {
        return $this->logo;
    }

    public function link() : string
    {
        return $this->link;
    }

    public function page() : string
    {
        return is_null($this->page)
            ? 'committees.show'
            : $this->page;
    }

    public function members() : array
    {
        return $this->members;
    }
}
