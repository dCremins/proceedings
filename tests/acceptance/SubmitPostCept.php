<?php
$I = new AcceptanceTester($scenario);
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
$I->fillField('Enter title here', 'Some kind of title!');
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
$I->click('//*[@id="message"]/p/a');
$I->wait(30);
$I->see('Test content');
