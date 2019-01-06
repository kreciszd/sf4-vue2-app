<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class BeersCountOrderFilter extends AbstractContextAwareFilter
{
    /**
     * @var string Keyword used to retrieve the value
     */
    protected $orderParameterName = 'beersCount';

    /**
     * @param RequestStack|null $requestStack No prefix to prevent autowiring of this deprecated property
     */
    public function __construct(ManagerRegistry $managerRegistry, $requestStack = null, string $orderParameterName = 'beersCount', LoggerInterface $logger = null, array $properties = null)
    {

        if (null !== $properties) {
            $properties = array_map(function ($propertyOptions) {
                // shorthand for default direction
                if (\is_string($propertyOptions)) {
                    $propertyOptions = [
                        'default_direction' => $propertyOptions,
                    ];
                }

                return $propertyOptions;
            }, $properties);
        }

        parent::__construct($managerRegistry, $requestStack, $logger, $properties);
        $this->orderParameterName = $orderParameterName;
    }

    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (
            !$this->isPropertyEnabled($property, $resourceClass)
        ) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        if(strtolower($value) === 'asc' || strtolower($value) === 'desc') {
            $direction = $value;
        } else {
            return;
        }

        $queryBuilder
            ->addSelect('(SELECT count(b) FROM App\Entity\Beer b WHERE b.brewer = '.$rootAlias.'.id) as HIDDEN beers_count')
            ->orderBy('beers_count',$direction);
    }

    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["regexp_$property"] = [
                'property' => $property,
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter using a beers count',
                    'name' => 'beersCount',
                    'type' => 'Brewer',
                ],
            ];
        }

        return $description;
    }
}