<?php
/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2016 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Phrasea\Databox\Caption;

use Alchemy\Phrasea\Core\Event\Record\MetadataChangedEvent;
use Alchemy\Phrasea\Core\Event\Record\RecordEvents;
use Alchemy\Phrasea\Databox\DataboxBoundRepositoryProvider;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CaptionCacheInvalider implements EventSubscriberInterface
{
    /**
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            /** @uses onMetadataChange */
            RecordEvents::METADATA_CHANGED => 'onMetadataChange',
        ];
    }

    /**
     * @var callable
     */
    private $locator;

    /**
     * @param callable $locator CachedCaptionDataRepository provider
     */
    public function __construct(callable $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @param MetadataChangedEvent $event
     * @throws AssertionFailedException
     */
    public function onMetadataChange(MetadataChangedEvent $event)
    {
        $record = $event->getRecord();

        $repository = $this->getCaptionRepository($record->getDataboxId());
        $repository->invalidate($record->getRecordId());
    }

    /**
     * @param $databoxId
     * @return object
     * @throws AssertionFailedException
     */
    private function getCaptionRepository($databoxId)
    {
        $locator = $this->locator;

        /** @var DataboxBoundRepositoryProvider $repositoryProvider */
        $repositoryProvider = $locator();

        Assertion::isInstanceOf($repositoryProvider, DataboxBoundRepositoryProvider::class);

        $repository = $repositoryProvider->getRepositoryForDatabox($databoxId);

        Assertion::isInstanceOf($repository, CachedCaptionDataRepository::class);

        return $repository;
    }
}
