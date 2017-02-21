<?php


class ProceedingsCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function checkPlugin(AcceptanceTester $I)
    {
      $I->wantTo('See that plugin and acf fields are installed correctly');

      $I->amOnPage('/');
      $I->amGoingTo('login as an administrator');
      $I->loginAsAdmin();
      $I->dontSee('ERROR');
      $I->see('Dashboard', 'h1');

      $I->expect('proceedings plugin is installed');
      $I->amOnPluginsPage();
      $I->seePluginActivated('icoet-proceedings');

      $I->expectTo('see proceedings as a post option');
      $I->see('Proceedings');

      $I->expectTo('see custom fields as an option');
      $I->see('Custom Fields');
      $I->seeElement('//*[@id="toplevel_page_edit-post_type-acf-field-group"]/a');
      $I->doubleClick('//*[@id="toplevel_page_edit-post_type-acf-field-group"]/a');
      $I->seeInSource('<h1 class="wp-heading-inline">Field Groups</h1>');
      $I->seeInSource('<strong><a class="row-title" href="http://wordpress.dev/wp-admin/post.php?post=1&amp;action=edit" aria-label="“Proceeding Info” (Edit)">Proceeding Info</a></strong>');
      $I->seeElement('//*[@id="post-4"]/td[1]/strong/a');
    }

    public function newProceeding(AcceptanceTester $I)
    {
      $I->wantTo('create and view a new proceeding as an admin');

      $I->amGoingTo('create an editor user');
      $I->cli('user create AcceptanceTester test@test.com --role=editor --user_pass=newTest');

      $I->amGoingTo('log in as an editor');
      $I->loginAs('AcceptanceTester', 'newTest');
      $I->dontSee('ERROR');
      $I->see('Dashboard', 'h1');

      $I->amGoingTo('create a new proceeding');
      $I->see('Proceedings');
      $I->click('Proceedings');
      $I->click('Proceedings');
      $I->see('Proceedings', 'h1');
      $I->see('Add New', '//*[@id="wpbody-content"]/div[3]/a');
      $I->click('//*[@id="wpbody-content"]/div[3]/a');
      $I->fillField('#title', 'Some kind of title!');
      $I->seeElement('#content-html');
      $I->click('#content-html');
      $I->waitForElementVisible('#content');
      $I->fillField('#content', 'Test content! Imagine this is an abstract.');
      $I->selectOption('Session', '101');
      $I->click('//*[@id="acf-group_588fa4019d4bf-2"]/div/div[2]/div[2]/div/input[2]');
      $I->fillField('//*[@id="acf-group_588fa4019d4bf-2"]/div/div[2]/div[2]/div/input[2]', '2/16/17');
      $I->pressKey('//*[@id="acf-group_588fa4019d4bf-2"]/div/div[2]/div[2]/div/input[2]', WebDriverKeys::ENTER);
      $I->selectOption('//*[@id="acf-field_588fa508b8276"]', '202');
      $I->fillField('Speaker', 'Bob Schwartzman');

      $I->amGoingTo('publish and view a new proceeding');
      $I->click('#publish');
      $I->wait(30);
      $I->see('Post published', '//*[@id="message"]');
      $I->expect('proceeding is available on site');

      $I->see('All Proceedings');
      $I->click('All Proceedings');
      $I->amOnPage('/');
      $I->amOnPage('/proceedings');
      $I->amOnPage('/proceedings/some-kind-of-title');
      $I->see('Test content');
    }
}
