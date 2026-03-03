<?php

declare(strict_types=1);

namespace App\Infrastructure\Persist\Carrier;

use App\Application\CarrierService\CarrierRepositoryInterface;
use App\Application\CarrierService\NoSuchCarrierException;
use App\Application\CarrierService\RepositoryException;
use App\Domain\Carrier\Carrier;
use App\Domain\Carrier\VO\Name;
use App\Domain\Carrier\VO\Slug;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final readonly class CarrierRepositoryUsesBuilder implements CarrierRepositoryInterface
{
    public function findCarrierBySlug(Slug $slug): Carrier
    {
        $key = $slug->value;
        $row = DB::table('carriers')
            ->select('name', 'slug', 'calculator')
            ->where('slug', $key)
            ->first();

        if ($row === null) {
            throw new NoSuchCarrierException(sprintf(
                'Carrier with slig %s not exist',
                $key
            ));
        }
        
        return $this->createFromRow($row);
    }

    public function list(): array
    {
        $carriers = [];
        $rows = DB::table('carriers')
            ->select('name', 'slug', 'calculator')
            ->get();
        foreach($rows as $row) {
            $carriers[] = $this->createFromRow($row);
        }
        return $carriers;
    }

    /** @throws RepositoryException */
    private function createFromRow(\stdClass $row): Carrier
    { 
        $name = $row->name ?? null;
        if ($name === null) {
            throw new RepositoryException('Carrier name is invalid');
        }

        $slug = $row->slug ?? null;
        if ($slug === null) {
            throw new RepositoryException('Carrier slug is invalid');
        }

        $classname = $row->calculator ?? null;
        if ($classname === null) {
            throw new RepositoryException('Carrier calculator is invalid');
        }

        try {
            $carrier = new Carrier(
                new Name($name),
                new Slug($slug),
                new $classname()
            );
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException(sprintf(
                'Carrier database data is invalid: %s',
                $e->getMessage()
            ));
        }

        return $carrier;
    }
}