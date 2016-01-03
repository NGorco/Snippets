/**
 * Содержит настройки TestsGarden для Mocha и пример добавления тестов
 */
var assert = chai.assert;
mocha.setup('bdd');
TGarden.prototype.runTests = function(){ mocha.run(); }
TGarden.prototype.clearQueue = function(){
	document.getElementById("mocha").innerHTML = "";
	mocha.suite.suites = [];
}

/**
 * Добавление тестов
 */
var ArmTests = new TGarden();
ArmTests.balance = new TGarden();
ArmTests.balance.block1 = new TGarden({
	testFunc: function()
	{
		console.log('it runned!!!!');
	}
});

ArmTests.balance.block1.testFunc = new TGarden({
	ololo: function()
	{
		describe("Equalizer", function() {
			var player;
			var song;

			it("kl should be equal to 45", function() {
				var kl = true;
				assert.ok(kl, 'kl is ok');
			});
		});
	},
	ololo3: function()
	{
		describe("Trololo", function() {
			var player;
			var song;

			it("kl two be 73 to 45", function() {
				var kl = true;
				assert.ok(kl, 'kl is ok');
			});

			it("12 should be equ64al to 45", function() {
				var kl = false;
				assert.ok(kl, 'kl is ok');
			});

			it("gre 66 be equal to 45", function() {
				var kl = true;
				assert.equal(kl, 'kl is ok');
			});
		});
	},
	ololo1: function()
	{
		describe("Kontrollers", function() {
			var player;
			var song;

			it("kl should be equal to 45", function() {
				var kl = true;
				assert.ok(kl, 'kl is ok');
			});
		});
	}
});

window.onload = function()
{
	ArmTests.run();	
}
