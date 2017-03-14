/**
 * Vanilla JS Draggable
 */
!function() {

    'use strict';

    var draggable = function(elem, handler_selector) {

        this.handle = elem;
        this.elem = elem;
        this.selected = false;

        if ( handler_selector != undefined ) {

            this.handle = elem.querySelector(handler_selector);
        }

        var self = this;

        var innerOffset = {x: 0, y: 0};

        /** Styles */

        var calcStyles = getComputedStyle(this.elem);
        this.elem.style.position = 'absolute';
        this.elem.style.top = window.innerHeight / 2 - parseInt(calcStyles.height) / 2 + 'px';
        this.elem.style.left = window.innerWidth / 2 - parseInt(calcStyles.width) / 2 + 'px';

        this.handle.addEventListener('mousedown', function(e) {

            self.selected = true;           
            innerOffset.x = pageC(e, 'x') - parseInt(self.elem.style.left);
            innerOffset.y = pageC(e, 'y') - parseInt(self.elem.style.top);
        });

        document.addEventListener('mousemove', function(e) {

            if ( ! self.selected ) return;

            var x_pos = - innerOffset.x + pageC(e, 'x');
            var y_pos = - innerOffset.y + pageC(e, 'y');

            self.elem.style.left = x_pos + 'px';
            self.elem.style.top = y_pos + 'px';
        });

        document.addEventListener('mouseup', function() {

            self.selected = false;
        });

        function pageC(e, type) {

            if ( type == 'x' ) {
                
                return document.all ? window.event.clientX : e.pageX;
            } else {

                return document.all ? window.event.clientY : e.pageY;
            }
        }
    }

    window.draggable = draggable;
}();
