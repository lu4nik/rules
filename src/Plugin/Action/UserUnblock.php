<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Action\UserUnblock.
 */

namespace Drupal\rules\Plugin\Action;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rules\Core\RulesActionBase;
use Drupal\Core\Session\SessionManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides "Unblock User" action.
 *
 * @Action(
 *   id = "rules_user_unblock",
 *   label = @Translation("Unblock a user"),
 *   category = @Translation("User"),
 *   context = {
 *     "user" = @ContextDefinition("entity:user",
 *       label = @Translation("User"),
 *       description = @Translation("Specifies the user, that should be unblocked.")
 *     )
 *   }
 * )
 *
 * @todo: Add access callback information from Drupal 7.
 */
class UserUnblock extends RulesActionBase {

    /**
     * {@inheritdoc}
     */
    public function summary() {
        return $this->t('Unblock a user');
    }

    /**
     * {@inheritdoc}
     */
    public function execute() {
        /**
         * @var $user \Drupal\user\UserInterface
         */
        $user = $this->getContextValue('user');

        // Do nothing if user is anonymous or isn't blocked.
        if ($user->isAuthenticated() && $user->isBlocked()) {
            $user->activate();
        }
    }

}
