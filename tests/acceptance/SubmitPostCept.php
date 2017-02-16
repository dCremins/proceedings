<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create and view a new proceeding as an admin');

$I->cli('user create AcceptanceTester test@test.com --role=editor --user_pass=newTest');
$notAdmin = $I->cli('user get AcceptanceTester --field=login');
$I->comment($notAdmin);

$I->amGoingTo('log in as an editor');
$I->loginAs('AcceptanceTester', 'newTest');
$I->makeScreenshot('dashboard');
$I->dontSee('ERROR');
$I->see('Dashboard', 'h1');

$I->amGoingTo('create a new proceeding');
$I->see('Proceedings');
$I->makeScreenshot('proceeding');
$I->click('Proceedings');
$I->makeScreenshot('proceeding2');
$I->click('Proceedings');
$I->makeScreenshot('proceeding3');
$I->see('Proceedings', 'h1');
$I->see('Add New', ['css' => 'a']);
$I->click('Add New');
$I->makeScreenshot('add new');
$I->fillField('Enter title here', 'newTest');
$I->fillField('content', 'Test content! Imagine this is an abstract.');
$I->selectOption('Session', '101');
$I->fillField('Session Date', '2/16/17');
$I->selectOption('//*[@id="acf-field_588fa508b8276"]', '202');
$I->fillField('Speaker', 'Bob Schwartzman');
$I->makeScreenshot('fields');

$I->amGoingTo('publish and view a new proceeding');
$I->click('#publish');
$I->makeScreenshot('published');
$I->see('Post published');
$I->expect('proceeding is available on site');
$I->click('View post');
$I->makeScreenshot('content');
$I->see('Test content');
