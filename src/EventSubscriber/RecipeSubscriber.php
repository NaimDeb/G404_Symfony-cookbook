<?php

namespace App\EventSubscriber;

use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RecipeSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function onPrePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Recipe) {
            return;
        }

        $user = $this->security->getUser();

        if ($user && $user instanceof User) {
            $entity->setCreatedBy($user);
            // Debugging statement
            error_log('User set in RecipeSubscriber: ' . $user->getUsername());
        } else {
            // Debugging statement
            error_log('No user found in RecipeSubscriber');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'prePersist' => 'onPrePersist',
        ];
    }
}
