(function() {
    tinymce.create('tinymce.plugins.customvalue', {
        init : function(ed, url) {
			var url2 = url.substring( 0, url.lastIndexOf( "/" ) + 1);
            ed.addButton('custom_value', {
                title : 'Custom Value',
                image : url2+'/images/icon.png',
                /*onclick : function() {
                     ed.selection.setContent('[get-my-values key="my_value(0)"]');// + ed.selection.getContent() + '[/custom_value]');
 
                }*/
				onclick : function() {
               var posts = prompt("Enter Custom value ID like 0 or 1 or 2..", "0");
               //var text = prompt("List Heading", "This is the heading text");

               //if (text != null && text != ''){
                  if (posts != null && posts != '')
                     ed.execCommand('mceInsertContent', false, '[get-my-values key="my_value('+posts+')"]');
                  else
                     ed.execCommand('mceInsertContent', false, '[recent-posts]'+text+'[/recent-posts]');
              /* }
               else{
                  if (posts != null && posts != '')
                     ed.execCommand('mceInsertContent', false, '[recent-posts posts="'+posts+'"]');
                  else
                     ed.execCommand('mceInsertContent', false, '[recent-posts]');
               }*/
            }
				
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('custom_value', tinymce.plugins.customvalue);
})();