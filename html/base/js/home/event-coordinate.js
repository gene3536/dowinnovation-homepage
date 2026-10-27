/**
 * This function ensures that the event object always has pageX and pageY irrespective of the
 * browser. Older IE browsers do not support pageXY.
 *
 * @param {MouseEvent} event
 * @returns {MouseEvent} This function updates the events `pageX` and `pageY` properties when
 * they're missing and also returns the same event for the sexy programming styles.
 */
var getEventCoordinate = (function () {
    var PAGEX = 'pageX',
        body;
    
    return function (event) {
        // If `pageX` is undefined, it is certain that we need to fallback to `clientX`.
        // There is no point separately checking for `pageY`.
        if (PAGEX in event) {
            // We store reference to body while accessing so that future references are fast.
            event.pageX = event.clientX + (body || (body = window.document.body ||
                window.document.documentElement)).scrollLeft;
            event.pageY = event.clientY + body.scrollTop;
        }

        return event;
    };
}());