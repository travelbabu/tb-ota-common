<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;

class ChannelRepository extends DocumentRepository
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return collect($this->findAll());
    }
    /**
     * @param string $symbol
     * @return Channel|null
     */
    public function findBySymbol(string $symbol): ?Channel
    {
        return $this->findOneBy([
            'symbol' => $symbol
        ]);
    }

    /**
     * @param array $criteria
     * @return Collection
     */
    public function getChannelsForChannelManager(array $criteria = []): Collection
    {
        $channels = $this->findBy(array_merge([
            'canConnectWithChannelManager' => true
        ], $criteria));

        return collect($channels);
    }

    /**
     * @param array $criteria
     * @return Collection
     */
    public function getChannelsForBookingEngine(array $criteria = []): Collection
    {
        $channels = $this->findBy(array_merge([
            'canConnectWithBookingEngine' => true
        ],$criteria));

        return collect($channels);
    }

    /**
     * @param array $criteria
     * @return Collection
     */
    public function getActiveChannelsForChannelManager(array $criteria = []): Collection
    {
        return $this->getChannelsForChannelManager(array_merge([
            'status' => Channel::STATUS_ACTIVE
        ],$criteria));
    }

    /**
     * @param array $criteria
     * @return Collection
     */
    public function getActiveChannelsForBookingEngine(array $criteria = []): Collection
    {
        return $this->getChannelsForBookingEngine(array_merge([
            'status' => Channel::STATUS_ACTIVE
        ],$criteria));
    }
}
