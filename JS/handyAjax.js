/*
* jQuery based AJAX framework created by Alex Petlenko aka Massique
* http://massique.com
*
* This framework allows to control names of server 
* PHP-methods and JS-functions, also it structurizing AJAX-requests in one way.
* You can have one JS and one PHP - 
* that's all you need to perform handy AJAX-requests. And jQuery of course :)
*/

var JQ = $;
function HandyAjax() {

   var self = this;
   self.request = function(method,params,callback_fnc, data_type){
        
        if(	
            (
                typeof method !== 'string'&&
                typeof method !== "function"
            )||
            typeof params !== "object"||
            params === null
        )
        throw "Core.request::Arguments isn't valid";
        
        if(typeof method !== 'string')
            method = Hlp.getMthName(this,method);
        
        if(method==='') throw "Core.request:: method is empty";
        JQ.post("/",{"method":method,"params":params, "AJAX_REQUEST":'Y'},function(data,callback){
            
            if(data_type == '' || data_type == undefined){
                try{var JSONobj = JSON.parse(data)}
                catch(e){
                    throw(e);
                }
                if(JSONobj.error){
                    throw "Core.request:: " + JSONobj.error;
                }
                
                if(JSONobj.notify_text){
                    
                    alert(JSONobj.notify_text);
                    throw "Core.request:: " + JSONobj.notify_text;
                }		
            }else{

                if(data_type == 'raw'){

                    JSONobj = data;
                }
            }
        
            callback_fnc(JSONobj);
        });
    };

       self.userRequest = function(method,params,callback_fnc, data_type){
        
        if( 
            (
                typeof method !== 'string'&&
                typeof method !== "function"
            )||
            typeof params !== "object"||
            params === null
        )
        throw "Core.request::Arguments isn't valid";
        
        if(method==='') throw "Core.request:: method is empty";
        JQ.post("/",{"method":method,"params":params, "AJAX_REQUEST":'Y'},function(data,callback){
            
            if(data_type == '' || data_type == undefined){
                try{var JSONobj = JSON.parse(data)}
                catch(e){
                    throw(e);
                }
                if(JSONobj.error){
                    throw "Core.request:: " + JSONobj.error;
                }
                
                if(JSONobj.notify_text){
                    
                    alert(JSONobj.notify_text);
                    throw "Core.request:: " + JSONobj.notify_text;
                }       
            }else{

                if(data_type == 'raw'){

                    JSONobj = data;
                }
            }
        
            callback_fnc(JSONobj);
        });
    }

};
var Handy = new HandyAjax();

var Hlp = {

    getMthName:function(obj,mth) {
        var mthName = '';
        for (var i in obj) {
            if(obj[i]===mth){
                mthName =  i;
                break;
            }
        };
        return mthName;
    }
}


var Util = {
    bid: function(id){
        if(!!id){
            return document.getElementById(id);
        }
    },
    rmv: function(Node){
        Node.parentNode.removeChild(Node, Node.parentNode);
    },
    rmvAllCh: function(Node){
        var cnt = Node.children.length;
        
        for(var k = 0; k < cnt; k++){
        
            Util.rmv(Node.children[0]);
        }
    },
    bc: function(className){
    
        var Node = document.getElementsByClassName(className);
        
        if(Node.length==1){
            
            return Node[0];
        }else{
            return Node;
        }
    },
    crt: function(Node, className, attr){
        var tmp = document.createElement(Node); 
        if((typeof className === 'string')&&(className!='')){
        
            tmp.className = className;
        }
        
        if(typeof attr === 'object'&&attr != null){
            for(var i in attr){
            
                tmp[i] = attr[i];
            }
        }
        return tmp;
    }

}

jQuery(function($){

     $('form[handy-form]').submit(function(){

        if(Handy[$(this).attr('action')]){

            Handy[$(this).attr('action')](this);
        }else{

            Handy.formSubmit(this);
        }
        
        return false;
    });

     $('*[handy-click]').click(function(){
        if(Handy[$(this).attr('handy-click')])
        Handy[$(this).attr('handy-click')]();
     });
});

(function($){
    $.fn.serializeObject = function () {
        "use strict";

        var result = {};
        var extend = function (i, element) {
            var node = result[element.name];

    // If node with same name exists already, need to convert it to an array as it
    // is a multi-value field (i.e., checkboxes)

            if ('undefined' !== typeof node && node !== null) {
                if ($.isArray(node)) {
                    node.push(element.value);
                } else {
                    result[element.name] = [node, element.value];
                }
            } else {
                result[element.name] = element.value;
            }
        };

        $.each(this.serializeArray(), extend);
        return result;
    };
})(jQuery);