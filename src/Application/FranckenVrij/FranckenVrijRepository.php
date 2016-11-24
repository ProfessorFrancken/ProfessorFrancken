<?php

declare(strict_types=1);

namespace Francken\Application\FranckenVrij;

use Francken\Application\ReadModelRepository;
use Francken\Domain\FranckenVrij\EditionId;

final class FranckenVrijRepository
{
    private $repo;

    public function __construct(ReadModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function save(Edition $edition)
    {
        $this->repo->save($edition);
    }

    public function find(EditionId $id)
    {
        return $this->repo->find((string)$id);
    }

    public function findAll() : array
    {
        return $this->repo->findAll();
    }

    public function volumes() : array
    {
        $volumes = [];

        // Group each edition into a volume
        foreach ($this->findAll() as $vrij) {
            $volumes[$vrij->volume()] ?? ['volume' => $vrij->volume(), 'editions' => []];
            $volumes[$vrij->volume()]['editions'][] = $vrij;
            $volumes[$vrij->volume()]['volume'] = $vrij->volume();
        }

        // Map the volumes to a Volume object
        $v = array_map(function ($volume) {
            return new Volume($volume['volume'], $volume['editions']);
        }, $volumes);

        usort($v, function (Volume $a, Volume $b) {
            return $b->volume() <=> $a->volume();
        });

        return $v;
    }
}
