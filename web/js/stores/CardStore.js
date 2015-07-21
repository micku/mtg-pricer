var PricerAppDispatcher = require('../dispatcher/PricerAppDispatcher');
var PricerConstants = require('../constants/PricerConstants.js');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');

var ActionTypes = PricerConstants.ActionTypes;
var SEARCH_EVENT = 'search';
var RECEIVE_EVENT = 'receive';

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
        this.removeListener(SEARCH_EVENT, callback);
    },

    emitReceiveByTerm: function() {
        this.emit(RECEIVE_EVENT);
    },

    addReceiveSearchListener: function(callback) {
        this.on(RECEIVE_EVENT, callback);
    },

    removeReceiveSearchListener: function(callback) {
        this.removeListener(RECEIVE_EVENT, callback);
    },

    get: function(id) {
        return _cards[id];
    },

    getAll: function() {
        return { 'cards': _cards, 'search_term': _term};
    }
});

CardStore.dispatchToken = PricerAppDispatcher.register(function(action) {
    switch(action.type) {
        case ActionTypes.RECEIVE_CARDS_LIST:
            _cards = action.cards;
            CardStore.emitReceiveByTerm();
            break;
        case ActionTypes.SEARCH:
            _term = action.term;
            CardStore.emitSearch();
            break;
        default:
    }
});

module.exports = CardStore;
