var Events = {};

Events.actions = {};

/**
 * Set an action to perform when the specified event emits.
 * @param eventName
 * @param actionCallable
 */
Events.on = function (eventName, actionCallable) {
    if (typeof this.actions[eventName] === 'undefined') {
        this.actions[eventName] = [];
    }
    this.actions[eventName].push(actionCallable);
};


/**
 * Emit an event and run all actions.
 * @param eventName
 * @param data
 */
Events.emit = function(eventName, data) {
    if (!Array.isArray(this.actions[eventName])) return;

    for (var i = 0; i < this.actions[eventName].length; i++) {
        var action = this.actions[eventName][i];
        action(data);
    }
};


module.exports = Events;