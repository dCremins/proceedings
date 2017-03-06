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
$I->click('#dp1488817249198');
$I->fillField('#dp1488817249198', '2/16/17');
$I->pressKey('#dp1488817249198', WebDriverKeys::ENTER);
//start
$I->click('#dp1488817249199');
$I->fillField('#dp1488817249199', '2:00 pm');
$I->pressKey('#dp1488817249199', WebDriverKeys::ENTER);
//end
$I->click('#dp1488817249200');
$I->fillField('#dp1488817249200', '4:00 pm');
$I->pressKey('#dp1488817249200', WebDriverKeys::ENTER);

$I->amGoingTo('publish a new session');
$I->click('#publish');
$I->wait(15);
$I->see('Post published', '//*[@id="message"]');

$I->expect('proceeding is available on site');
$I->see('All Sessions');
$I->click('All Sessions');
$I->see('Some Session');
$I->see('Published');
