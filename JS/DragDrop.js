/**
 * Vanilla JS Draggable and droppable
 */
!function() {

    'use strict';

    /**
     * Draggable item
     * 
     * @param  {DOMnode} options.container - container of draggable item
     * @param  {function} options.onDragStart - drag start callback
     * @param  {function} options.onDrag - drag callback
     * @param  {function} options.onDragEnd - drag end callback
     * @param  {bool} options.dispatchDragEvents - will custom events be fired while mouse do smth
     * @param  {bool} options.useDrop - will custom events be fired while mouse do smth
     */
    var draggable = function(options) {

        this.handle = options.elem;
        this.elem = options.elem;
        this.container = options.container || null;
        this.onDragStart = typeof options.onDragStart == 'function' ? options.onDragStart : function() {};
        this.onDrag = typeof options.onDrag == 'function' ? options.onDrag : function() {};
        this.onDragEnd = typeof options.onDragEnd == 'function' ? options.onDragEnd : function() {};
        this.dispatchDragEvents = ( options.dispatchDragEvents || options.useDrop ) || false;

        var self = this;
        this.selected = false;

        if ( options.handler_selector != undefined ) {

            this.handle = this.elem.querySelector(options.handler_selector);
        }

        var self = this;

        var innerOffset = {x: 0, y: 0};

        /** Events */

        /** Drag start */
        this.handle.addEventListener('mousedown', function(e) {

            self.selected = true;           
            innerOffset.x = pageC(e, 'x') - ( parseInt(self.elem.style.left) || 0 );
            innerOffset.y = pageC(e, 'y') - ( parseInt(self.elem.style.top) || 0 );

            self.onDragStart(e);

            e.stopPropagation();

            document.addEventListener('mouseup', mouseUpHandler);
            document.addEventListener('mousemove', mouseMoveHandler);
        });

        /** Drag */
        function mouseMoveHandler(e) {

        	if ( ! self.selected ) return;

            e.stopPropagation();

            var x_pos = - innerOffset.x + pageC(e, 'x');
            var y_pos = - innerOffset.y + pageC(e, 'y');

            self.elem.style.left = x_pos + 'px';
            self.elem.style.top = y_pos + 'px';

            self.onDrag(e);

            if ( ! self.dispatchDragEvents ) return;

            document.dispatchEvent(new CustomEvent('draggableMove', {
            	detail: {

            		draggedItem: self,
            		draggedDOM: self.elem,
            		mouseEv: e	
            	}
            }));
        }

        /** Drag end */
        function mouseUpHandler(e) {

        	self.selected = false;
            self.onDragEnd(e);

            if ( ! self.dispatchDragEvents ) return;

            e.stopPropagation();

            document.dispatchEvent(new CustomEvent('draggableEnd', {
            	detail: {
            		draggedItem: self,
            		draggedDOM: self.elem,
            		mouseEv: e
            	}
            }));
            
            removeMouseUp();
            document.removeEventListener('mousemove', mouseMoveHandler);
        }

        function removeMouseUp() { document.removeEventListener('mouseup', mouseUpHandler); }
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

!function() {

    'use strict';

    /**
     * Droppable class
     * 
     * @param  {elem} options.elem - draggable DOM node
     * @param  {function} options.dragOver - drag over callback (when draggable over)
     * @param  {function} options.onDrop - draggable ended drag over this droppable
     * @param  {bool} options.dispatchDropEvent - create custom Drop event on this droppable
     */
    var droppable = function(options) {

        this.elem = options.elem;
        this.dragOver = options.dragOver || function(){};
        this.onDrop = options.onDrop || function(){};
        this.onWillDropIn = options.onWillDropIn || function(){};
        this.onNotWillDropIn = options.onNotWillDropIn || function(){};
        this.dispatchDropEvent = options.dispatchDropEvent || false;

        var self = this;
        self.draggedElementOver = false;

        document.addEventListener('draggableMove', function(e) {

        	if ( intersect(self.elem, e.detail.draggedDOM) ) {

        		self.dragOver(e);
        		self.draggedElementOver = true;
        	} else {

        		self.draggedElementOver = false;
        	}
        });

        this.elem.addEventListener('WillDropIn', function(e) {

            self.onWillDropIn(e);
        });


        document.addEventListener('getDragOverAreas', function(e) {

        	if ( !! self.draggedElementOver ) {

        		e.detail.sendArea(self);
        	}
        });

        document.addEventListener('notWillDropIn', function(e) {

        	self.onNotWillDropIn({dropAreaItem: self, dropAreaDOM: self.elem});
        });

        document.addEventListener('draggableEnd', function(e) {

        	if ( !! self.WillDropIn ) {

                var ev = {
                    dropAreaItem: self,
                    dropAreaDOM: self.elem,
                    droppedItem: e.detail.draggedItem,
                    droppedDOM: e.detail.draggedDOM,
                    mouseEv: e.detail.mouseEv
                }

        		self.onDrop(ev);

        		if ( ! self.dispatchDropEvent ) return;

        		self.elem.dispatchEvent(new CustomEvent('droppableDrop', {
        			detail: ev
        		}));
        	}

        	// Init state
        	self.draggedElementOver = false;
        	self.WillDropIn = false;
        });

        /** Utils */
        function intersect(DOM1, DOM2) {

        	var obj1 = DOM1.getBoundingClientRect(),
        		obj2 = DOM2.getBoundingClientRect(),
        		obj1point1 = {x: obj1.left, y: obj1.top},
        		obj1point2 = {x: obj1.left + obj1.width, y: obj1.top + obj1.height},
        		obj2point1 = {x: obj2.left, y: obj2.top},
        		obj2point2 = {x: obj2.left + obj2.width, y: obj2.top + obj2.height};


        	if ( obj1point1.x < obj2point1.x && obj2point1.x < obj1point2.x &&
        		 obj1point1.y < obj2point1.y && obj2point1.y < obj1point2.y ) return true;

        	if ( obj1point1.x < obj2point2.x && obj2point2.x < obj1point2.x &&
        		 obj1point1.y < obj2point2.y && obj2point2.y < obj1point2.y ) return true;

        	if ( obj1point1.x < obj2point2.x && obj2point2.x < obj1point2.x &&
        		 obj1point1.y < obj2point1.y && obj2point1.y < obj1point2.y ) return true;

        	if ( obj1point1.x < obj2point1.x && obj2point1.x < obj1point2.x &&
        		 obj1point1.y < obj2point2.y && obj2point2.y < obj1point2.y ) return true;

        	return false;
        }
    }

    /** Droppable areas manager
	 *
	 *  Problem is: if draggable over several elements, where to drop?
	 *  Solution is droppable Manager
     */
    document.addEventListener('draggableMove', function() {

    	var areas = [];

    	// Clear all WillDropIn flags
    	document.dispatchEvent(new CustomEvent('notWillDropIn'));
    	document.dispatchEvent(new CustomEvent('getDragOverAreas', {
    		detail: {
    			sendArea: function(area) {

    				areas.push(area);
    			}
    		}
    	}));

    	areas.forEach(function(item, i) {

    		if ( i == 0 ) {

    			item.WillDropIn = true;
                item.elem.dispatchEvent(new CustomEvent('WillDropIn', {

                    detail: {
                        DOMitem: item.elem,
                        item: item
                    }
                }));
    		} else {

    			item.WillDropIn = false;
    		}
    	});
    });


    window.droppable = droppable;
}();

/**
 * Extension of MouseEvent object.
 *
 * Provides EventDataTransfer object, with ability to
 * save, clear and get custom data.
 *
 * Object stores in e.EventDataTransfer
 */
!function() {

    if ( ! MouseEvent.prototype.EventDataTransfer ) {

    	var EventDataTransfer = function() {

            var data = {};

            data.clearData = function() {

                data = {};
            }

            data.setData = function(name, value) {

                if ( ! data[ name ] ) {

                    data[ name ] = value;
                }

                return true;
            }

            data.getData = function(name) {

                if ( typeof name !== 'string' ) return false;
                if ( ! data[ name ] ) return null;

                return data[ name ];
            }

            return data;
        }

        CustomEvent.prototype.EventDataTransfer = MouseEvent.prototype.EventDataTransfer = new EventDataTransfer;
    }
}();
