<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create a new proceeding');

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
//*[@id="s2id_autogen1"]//*[@id="s2id_acf-field_58b98ba351166-input"]/a
