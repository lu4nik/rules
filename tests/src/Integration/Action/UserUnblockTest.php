<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Integration\Action\UserUnBlockTest.
 */

namespace Drupal\Tests\rules\Integration\Action;

use Drupal\Tests\rules\Integration\RulesEntityIntegrationTestBase;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\Action\UserUnBlock
 * @group rules_actions
 */
class UserUnblockTest extends RulesEntityIntegrationTestBase {

  /**
   * Constant used for authenticated test when mocking a user.
   */
  const AUTHENTICATED = TRUE;

  /**
   * Constant used for authenticated test when mocking a user.
   */
  const ANONYMOUS = FALSE;

  /**
   * Constant used for active test when mocking a user.
   */
  const ACTIVE = TRUE;

  /**
   * Constant used for active test when mocking a user.
   */
  const BLOCKED = FALSE;

  /**
   * The action to be tested.
   *
   * @var \Drupal\rules\Engine\RulesActionInterface
   */
  protected $action;


  /**
   * @dataProvider userProvider
   * @covers ::execute
   */
  public function testUnblockUser($active, $authenticated, $expects) {
    $user = $this->getMock('Drupal\user\UserInterface');

    $user = $this->getMock('Drupal\user\UserInterface');

    $user->expects($this->any())
      ->method('isBlocked')
      ->willReturn(!$active);


    $user->expects($this->any())
      ->method('isAuthenticated')
      ->willReturn($authenticated);

    $user->expects($this->{$expects}())
      ->method('activate');

    $this->action->setContextValue('user', $user);

    $this->action->execute();
  }

  /**
   * Data provider for ::testUnblockUser.
   */
  public function userProvider() {
    return [
      // Test blocked authenticated user.
      [self::BLOCKED, self::AUTHENTICATED, 'once'],
      // Test active anonymous user.
      [self::ACTIVE, self::ANONYMOUS, 'never'],
      // Test active authenticated user.
      [self::ACTIVE, self::AUTHENTICATED, 'never'],
      // Test blocked anonymous user.
      [self::BLOCKED, self::ANONYMOUS, 'never'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->enableModule('user');
    $this->action = $this->actionManager->createInstance('rules_user_unblock');
  }

  /**
   * Test the summary method.
   *
   * @covers ::summary
   */
  public function testSummary() {
    $this->assertEquals('Unblock a user', $this->action->summary());
  }

}
