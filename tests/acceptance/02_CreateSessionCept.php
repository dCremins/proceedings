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
//$I->click('//*[@id="acf-group_58b9876bba2fc"]/div/div[3]/div[2]/div');
$I->fillField('//*[@id="acf-field_58b987ab70d6b"]', '2/16/17');
$I->pressKey('//*[@id="acf-field_58b987ab70d6b"]', WebDriverKeys::ENTER);
//start
//$I->click('//*[@id="acf-group_58b9876bba2fc"]/div/div[4]/div[2]/div');
//$I->fillField('//*[@id="acf-field_58b987ab70d6b"]', '2:00 pm');
//$I->pressKey('//*[@id="acf-field_58b987ab70d6b"]', WebDriverKeys::ENTER);
//end
//$I->click('//*[@id="acf-group_58b9876bba2fc"]/div/div[5]/div[2]/div');
//$I->fillField('//*[@id="acf-group_58b9876bba2fc"]/div/div[5]/div[2]/div', '4:00 pm');
//$I->pressKey('//*[@id="acf-group_58b9876bba2fc"]/div/div[5]/div[2]/div', WebDriverKeys::ENTER);

$I->amGoingTo('publish a new session');
$I->click('#publish');
$I->wait(15);
$I->see('Post published', '//*[@id="message"]');

$I->expect('proceeding is available on site');
$I->see('All Sessions');
$I->click('All Sessions');
$I->see('Some Session');
$I->see('Published');
