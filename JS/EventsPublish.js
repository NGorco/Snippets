var Events = (function()  // События и слушатели
{
    var topics = {};

    return {
        subscribe: function(topic, listener) 
        {
            if (!topics[topic]) topics[topic] = { queue: [] }; // создаем объект topic, если еще не создан

            var index = topics[topic].queue.push(listener) - 1; // добавляем listener в очередь

            return { // предоставляем возможность удаления темы
                remove: function()
                {
                    delete topics[topic].queue[index];
                }
            };
        },
        publish: function(topic, info)
        {
            if (!topics[topic] || !topics[topic].queue.length) return; // если темы не существует или нет подписчиков, не делаем ничего

            var items = topics[topic].queue; // проходим по очереди и вызываем подписки
            items.forEach(function(item)
            {
                item(info || {});
            });
        }
    };
})();