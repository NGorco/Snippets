/**
 * TestsGarden
 * 
 * TGarden - класс для структурированого запуска тестов
 *
 * @property function runTests - запускает тесты
 * @property function clearQueue - очищает очередь запуска тестов
 */
var TGarden = function(testsObject)
{
	if(!this.clearQueue) throw 'No clearQueue function declared!';
	if(!this.runTests) throw 'No runTests function declared!';

	testsObject = (typeof(testsObject) == 'object') ? testsObject : {};
	for(var km in testsObject){
		if(!this[km] && testsObject[km] instanceof Function){
			this[km] = new GTest(testsObject[km]);
		}
	}

	/**
	 * Функция рекурсивно запускает тесты текущего уровня и тесты нижних уровней
	 * 
	 * @param object params - набор параметров запуска тестов
	 * @param bool debug - показывать в консоли технические сведения прохождения тестов
	 */
	this.run = function(params)
	{
		/// Короткое объявление параметра debug: true
		if(typeof(params) == 'boolean'){
			params = {debug: params}
		}

		/// Объявление дефолтных параметров запуска
		var params = (typeof params == 'object') ? params : {
			debug: false
		};

		var root_run = params.root_run || false;

		/// На этом этапе очищаем список проходимых тестов, чтоб потом добавить
		if(!root_run){
			this.clearQueue();
			params.root_run = true;
		}		

		for(var zt in this){
			if(zt == 'run') continue;

			if(this[zt] instanceof GTest){	
				if(params.debug){
					console.info("Passing test: " + zt);
				}	
			}

			if(this.hasOwnProperty(zt) && this[zt].run){
				this[zt].run(params);
			}
		}

		/// Тесты добавлены в очередь, запуск
		if(!root_run){
			this.runTests();
		}
	}
}


/**
 * GardenTest
 *
 * Класс представляет тест в иерархической структуре
 * 
 * @param function testFunc функция-тестировщик
 */
var GTest = function(testFunc)
{
	/**
	 * Запускает тест
	 *
	 * @param object params - глобальные параметры запуска тестов
	 */
	this.run = function(params)
	{
		testFunc();
	}	
}