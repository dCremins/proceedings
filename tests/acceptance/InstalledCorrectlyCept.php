<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('See that plugin and acf fields are installed correctly');

$I->amGoingTo('login as an administrator');
$I->amOnPage('/login');
$I->waitForElement('#loginform', 60); // secs
$I->loginAsAdmin();
$I->dontSee('ERROR');
$I->see('Dashboard', 'h1');

$I->expect('proceedings plugin is installed');
$I->amOnPluginsPage();
$I->seePluginActivated('ICOET Proceedings');

$I->expectTo('see proceedings as a post option');
$I->amOnPage('/');
$I->see('Proceedings');

$I->expectTo('see custom fields as an option');
$I->see('Custom Fields');
$I->doubleClick('Custom Fields');
$I->see('Field Groups', 'h1');
$I->see('Proceeding Info');

$I->moveMouseOver(['css' => '#wp-admin-bar-my-account']);
$I->waitForElement('#wp-admin-bar-logout', 60); // secs
$I->click('#wp-admin-bar-logout');