<?php
$I = new AcceptanceTester($scenario);
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
$I->seeElement('//*[@id="acf-field-group-wrap"]/h1');
$I->seeElement('//*[@id="post-4"]/td[1]/strong/a');
