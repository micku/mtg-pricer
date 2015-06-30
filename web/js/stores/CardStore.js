var PricerAppDispatcher = require('../dispatcher/PricerAppDispatcher');
var PricerConstants = require('../constants/PricerConstants.js');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');

var ActionTypes = PricerConstants.ActionTypes;
var SEARCH_EVENT = 'search';
var RECEIVE_EVENT = 'search';

var _cards = [];
var _term = '';

var CardStore = assign({}, EventEmitter.prototype, {
    emitSearch: function() {
        this.emit(SEARCH_EVENT);
    },

    addSearchListener: function(callback) {
        this.on(SEARCH_EVENT, callback);
    },

    removeSearchListener: function(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    },

    emitReceiveByTerm: function() {
        this.emit(RECEIVE_EVENT);
    },

    addSearchListener: function(callback) {
        this.on(RECEIVE_EVENT, callback);
    },

    removeSearchListener: function(callback) {
        this.removeListener(RECEIVE_EVENT, callback);
    },

    get: function(id) {
        return _cards[id];
    },

    getAll: function() {
        return _cards;
    }
});

CardStore.dispatchToken = PricerAppDispatcher.register(function(action) {
    switch(action.type) {
        case ActionTypes.RECEIVE_CARDS_LIST:
            _cards = action.cards;
            CardStore.emitReceiveByTerm();
            break;
        case ActionTypes.CLICK_ADD_CARD:
            break;
        case ActionTypes.SEARCH:
            _term = action.term;
            CardStore.emitSearch();
            break;
        default:
    }
});

module.exports = CardStore;
