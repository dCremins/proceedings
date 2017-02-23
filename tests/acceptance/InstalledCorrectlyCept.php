<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('See that plugin and acf fields are installed');

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
