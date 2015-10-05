/*
* jQuery based AJAX framework created by Alex Petlenko aka Massique
* http://massique.com
*
* This framework allows to control names of server 
* PHP-methods and JS-functions, also it structurizing AJAX-requests in one way.
* You can have one JS and one PHP - 
* that's all you need to perform handy AJAX-requests. And jQuery of course :)
*/

var JQ = $ || jQuery;

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
        JQ.post("/",{"method":method, "params":params, "AJAX_REQUEST":"Y"},function(data,callback){
            
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

    self.userRequest = function(method,params,callback_fnc, data_type)
    {        
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

        JQ.post("/",{"method":method, "params":params, "AJAX_REQUEST":"Y"},function(data,callback)
        {            
            if(data_type == '' || data_type == undefined)
            {
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

                if(data_type == 'raw')
                {
                    JSONobj = data;
                }
            }
        
            callback_fnc(JSONobj);
        });
    }

};
var Handy = new HandyAjax();

var Hlp = {

    getMthName:function(obj,mth) 
    {
        var mthName = '';
        for (var i in obj) 
        {
            if(obj[i]===mth)
            {
                mthName =  i;
                break;
            }
        };
        return mthName;
    }
}


var Util = {
    bid: function(id)
    {
        if(!!id)
        {
            return document.getElementById(id);
        }
    },
    rmv: function(Node)
    {
        Node.parentNode.removeChild(Node, Node.parentNode);
    },
    rmvAllCh: function(Node)
    {
        var cnt = Node.children.length;
        
        for(var k = 0; k < cnt; k++)
        {        
            Util.rmv(Node.children[0]);
        }
    },
    bc: function(className)
    {    
        var Node = document.getElementsByClassName(className);
        
        if(Node.length==1)
        {            
            return Node[0];
        }else{
            return Node;
        }
    },
    crt: function(Node, className, attr)
    {
        var tmp = document.createElement(Node); 
        if((typeof className === 'string')&&(className!=''))
        {
            tmp.className = className;
        }
        
        if(typeof attr === 'object'&&attr != null)
        {
            for(var i in attr)
            {            
                tmp[i] = attr[i];
            }
        }
        return tmp;
    }

}

jQuery(function($)
{
     $('form[handy-form]').submit(function()
     {
        if(Handy[$(this).attr('action')])
        {
            Handy[$(this).attr('action')](this);
        }else{

            Handy.formSubmit(this);
        }
        
        return false;
    });

     $('*[handy-click]').click(function()
     {
        if(Handy[$(this).attr('handy-click')])
        Handy[$(this).attr('handy-click')]();
     });
});

/**
 * jQuery serializeObject
 * @copyright 2014, macek <paulmacek@gmail.com>
 * @link https://github.com/macek/jquery-serialize-object
 * @license BSD
 * @version 2.5.0
 */
(function(root, factory) {

  // AMD
  if (typeof define === "function" && define.amd) {
    define(["exports", "jquery"], function(exports, $) {
      return factory(exports, $);
    });
  }

  // CommonJS
  else if (typeof exports !== "undefined") {
    var $ = require("jquery");
    factory(exports, $);
  }

  // Browser
  else {
    factory(root, (root.jQuery || root.Zepto || root.ender || root.$));
  }

}(this, function(exports, $) {

  var patterns = {
    validate: /^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,
    key:      /[a-z0-9_]+|(?=\[\])/gi,
    push:     /^$/,
    fixed:    /^\d+$/,
    named:    /^[a-z0-9_]+$/i
  };

  function FormSerializer(helper, $form) {

    // private variables
    var data     = {},
        pushes   = {};

    // private API
    function build(base, key, value) {
      base[key] = value;
      return base;
    }

    function makeObject(root, value) {

      var keys = root.match(patterns.key), k;

      // nest, nest, ..., nest
      while ((k = keys.pop()) !== undefined) {
        // foo[]
        if (patterns.push.test(k)) {
          var idx = incrementPush(root.replace(/\[\]$/, ''));
          value = build([], idx, value);
        }

        // foo[n]
        else if (patterns.fixed.test(k)) {
          value = build([], k, value);
        }

        // foo; foo[bar]
        else if (patterns.named.test(k)) {
          value = build({}, k, value);
        }
      }

      return value;
    }

    function incrementPush(key) {
      if (pushes[key] === undefined) {
        pushes[key] = 0;
      }
      return pushes[key]++;
    }

    function encode(pair) {
      switch ($('[name="' + pair.name + '"]', $form).attr("type")) {
        case "checkbox":
          return pair.value === "on" ? true : pair.value;
        default:
          return pair.value;
      }
    }

    function addPair(pair) {
      if (!patterns.validate.test(pair.name)) return this;
      var obj = makeObject(pair.name, encode(pair));
      data = helper.extend(true, data, obj);
      return this;
    }

    function addPairs(pairs) {
      if (!helper.isArray(pairs)) {
        throw new Error("formSerializer.addPairs expects an Array");
      }
      for (var i=0, len=pairs.length; i<len; i++) {
        this.addPair(pairs[i]);
      }
      return this;
    }

    function serialize() {
      return data;
    }

    function serializeJSON() {
      return JSON.stringify(serialize());
    }

    // public API
    this.addPair = addPair;
    this.addPairs = addPairs;
    this.serialize = serialize;
    this.serializeJSON = serializeJSON;
  }

  FormSerializer.patterns = patterns;

  FormSerializer.serializeObject = function serializeObject() {
    return new FormSerializer($, this).
      addPairs(this.serializeArray()).
      serialize();
  };

  FormSerializer.serializeJSON = function serializeJSON() {
    return new FormSerializer($, this).
      addPairs(this.serializeArray()).
      serializeJSON();
  };

  if (typeof $.fn !== "undefined") {
    $.fn.serializeObject = FormSerializer.serializeObject;
    $.fn.serializeJSON   = FormSerializer.serializeJSON;
  }

  exports.FormSerializer = FormSerializer;

  return FormSerializer;
}));