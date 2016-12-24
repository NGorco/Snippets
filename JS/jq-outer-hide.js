/**
* Нажатие не на объект скрывает {this}
*
* @params .clickObj -  объект, клик по которому не скроет this
*/
$.fn.outerHide = function(params)
{
    params = params ? params : {};

    if(!params.clickObj) return false;

    var self = this;

    $(document).bind('click.myEvent', function(e) {

        if ($(e.target).closest(self).length == 0 && e.target != self && $.inArray($(e.target)[0], $(params.clickObj)) == -1)
        {
            if(params.clbk)
            {
                params.clbk();
            }else{
                $(self).hide();
            }
        }
    });
}