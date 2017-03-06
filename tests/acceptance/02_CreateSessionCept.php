<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create a new session as an editor');

$I->amGoingTo('create an editor user');
$I->cli('user create AcceptanceTester test@test.com --role=editor --user_pass=newTest');

$I->amGoingTo('log in as an editor');
$I->loginAs('AcceptanceTester', 'newTest');
$I->dontSee('ERROR');
$I->see('Dashboard', 'h1');

$I->amGoingTo('create a new session');
$I->see('Sessions');
$I->click('Sessions');
$I->click('Sessions');
$I->see('Sessions', 'h1');
$I->see('Add New', '//*[@id="wpbody-content"]/div[3]/a');
$I->click('//*[@id="wpbody-content"]/div[3]/a');
$I->fillField('#title', 'Some Session');
$I->selectOption('Room', '101');
//date
$I->fillField('//*[@id="acf-group_58b9876bba2fc"]/div/div[3]/div[2]/div/input[2]', '2/16/17');
$I->pressKey('//*[@id="acf-group_58b9876bba2fc"]/div/div[3]/div[2]/div/input[2]', WebDriverKeys::ENTER);
//start
$I->fillField('//*[@id="acf-group_58b9876bba2fc"]/div/div[4]/div[2]/div/input[2]', '2:00 pm');
$I->pressKey('//*[@id="acf-group_58b9876bba2fc"]/div/div[4]/div[2]/div/input[2]', WebDriverKeys::ENTER);
//end
$I->fillField('//*[@id="acf-group_58b9876bba2fc"]/div/div[5]/div[2]/div/input[2]', '4:00 pm');
$I->pressKey('//*[@id="acf-group_58b9876bba2fc"]/div/div[5]/div[2]/div/input[2]', WebDriverKeys::ENTER);

$I->amGoingTo('publish a new session');
$I->click('#publish');
$I->wait(15);
$I->see('Post published', '//*[@id="message"]');

$I->expect('proceeding is available on site');
$I->see('All Sessions');
$I->click('All Sessions');
$I->see('Some Session');
$I->see('Published');

$I->wantTo('create a new proceeding');

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

$I->seeElement('//*[@id="s2id_acf-field_58b98ba351166-input"]/a');
$I->click('//*[@id="s2id_acf-field_58b98ba351166-input"]/a');
$I->wait(30);
$I->see('Some Session');
$I->click('Some Session');
$I->fillField('Speaker', 'Bob Schwartzman');

$I->amGoingTo('publish and view a new proceeding');
$I->click('#publish');
$I->wait(15);
$I->see('Post published', '//*[@id="message"]');

$I->expect('proceeding is available on site');
$I->see('All Proceedings');
$I->click('All Proceedings');
$I->see('Some kind of title!');
$I->see('Published');
