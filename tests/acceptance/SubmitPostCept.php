<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create and view a new proceeding as a non-admin user');

$I->amGoingTo('log in as an editor');
$I->amOnPage('/wp-login.php');
$I->fillField('Username or Email Address', 'AcceptanceTester');
$I->fillField('Password', 'newTest');
$I->click('Log In');
$I->see('Dashboard', 'h1');

$I->amGoingTo('create a new proceeding');
$I->see('Proceedings');
$I->click('Proceedings');
$I->see('Proceedings', 'h1');
$I->see('Add New');
$I->click(['class' => 'page-title-action']);
$I->fillField('Enter title here', 'newTest');
$I->fillField('content', 'Test content! Imagine this is an abstract.');
$I->selectOption('Session', '101');
$I->fillField('Session Date', '2/16/17');
$I->executeJS("$('input#photo_link').trigger(jQuery.Event('keypress', {keyCode: 13}));");
$I->selectOption('//*[@id="acf-field_588fa508b8276"]', '202');
$I->fillField('Speaker', 'Bob Schwartzman');

$I->amGoingTo('publish and view a new proceeding');
$I->click('#publish');
$I->see('Post published');
$I->expect('proceeding is available on site');
$I->click('View post');
$I->see('Test content');