Object.defineProperties(Object.prototype, // Расширяем функционал объектов
{
    define: 
    {
        value: function(key, descriptor) 
        {
            if(descriptor) 
            {
                Object.defineProperty(this, key, descriptor);
            } else {
                Object.defineProperties(this, key);
            }

            return this;
        },
        enumerable: false
    },
    extendNotEnum: 
    {
        value: function(key, property)
        {
            if(property) 
            {
                this.define(key, 
                {
                    value: property,
                    enumerable: false,
                    configurable: true
                });
            }else{

                for(var prop in key) if(key.hasOwnProperty(prop))
                {
                    this.extendNotEnum(prop, key[ prop ] );
                }
            }
        },
        enumerable: false
    }
});

Object.prototype.extendNotEnum( // Деление числа по разрядам
{ 
    'dPos' : function()
    {
		return this.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
	} 
});