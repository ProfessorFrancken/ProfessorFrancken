<?php

namespace Francken\Extern\Companies;
// phpactor class:transform src/Extern/Companies/Company.php --transform=complete_constructor
// phpactor class:transform src/Extern/Companies/Company.php --transform=fix_namespace_class_name

final Class Company
    {
    /**
     * @var array
     */
    private $hoi;
    /**
     * @var array
     */
    private $da;
    /**
     * @var string
     */
    private $h;

        public function __construct(array $hoi, array $da, string $h)
            {
        $this->hoi = $hoi;
        $this->da = $da;
        $this->h = $h;

            }

    }
