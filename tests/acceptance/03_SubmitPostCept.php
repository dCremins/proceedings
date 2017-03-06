<?php
$I = new AcceptanceTester($scenario);
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
$I->seeElement('#select2-drop-mask');
$I->click('#select2-drop-mask');
$I->waitForElementVisible('#s2id_autogen1_search');
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
