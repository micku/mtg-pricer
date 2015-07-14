var PricerAppDispatcher = require('../dispatcher/PricerAppDispatcher');
var PricerConstants = require('../constants/PricerConstants.js');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');

var ActionTypes = PricerConstants.ActionTypes;
var CHANGE_EVENT = 'change';

var _wishList = [];

var WishListStore = assign({}, EventEmitter.prototype, {
    emitChange: function() {
        this.emit(CHANGE_EVENT);
    },

    addChangeListener: function(callback) {
        this.on(CHANGE_EVENT, callback);
    },

    removeChangeListener: function(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    },

    get: function(id) {
        var ret = _wishList.filter(function(candidate) {
            return candidate.id === id;
        });
        return ret[0] || null;
    },

    getPrice: function(id) {
        var ret = _wishList.filter(function(candidate) {
            return candidate.id === id;
        });
        card = ret[0];
        card.quantity_price = Math.round((card.quantity * card.unit_price) * 100) / 100;
        return card.quantity_price || 0;
    },

    getAll: function() {
        return _wishList;
    }
});

function _receiveCards(rawCards) {
    _wishList = [];
    rawCards.forEach(function (card) {
        _wishList[card.id] = card;
    });
}

WishListStore.dispatchToken = PricerAppDispatcher.register(function(action) {
    switch(action.type) {
        case ActionTypes.PRICE_RECEIVED:
            var card_id = parseInt(action.card_id);
            var prices = action.prices;
            var storedCard = WishListStore.get(card_id);
            storedCard.unit_price = prices.AVG;
            storedCard.quantity_price = prices.AVG * storedCard.quantity;
            WishListStore.emitChange();
            break;
        case ActionTypes.ADDED_TO_WISHLIST:
            var card = action.card;
            var storedCard = WishListStore.get(card.id);
            var quantity = storedCard.quantity;
            //Call API, AVG price, multiply per quantity
            WishListStore.emitChange();
            break;
        case ActionTypes.CLICK_ADD_TO_WISHLIST:
            var card = action.card;
            var storedCard = WishListStore.get(card.id);
            if (storedCard) {
                storedCard.quantity += 1;
            }
            else {
                card.quantity = 1
                _wishList = _wishList.concat(card);
            }
            WishListStore.emitChange();
            break;
        case ActionTypes.REMOVE_FROM_WISHLIST:
            var card = action.card;
            var storedCard = WishListStore.get(card.id);
            if (storedCard) {
                if (storedCard.quantity > 1) {
                    storedCard.quantity -= 1;
                }
                else {
                    _wishList = _wishList.filter(function(candidate) {
                        return candidate.id !== card.id;
                    });
                }
                WishListStore.emitChange();
            }
            break;
        case ActionTypes.RECEIVE_WISHLIST:
            _wishList = _receiveCards(action.cards);
            WishListStore.emitChange();
            break;
        /*
        case ActionTypes.CLICK_ADD_TO_WISHLSIT:
            WishListStore.emitCreate();
            break;
        case ActionTypes.RECEIVE_WISHLIST:
            _wishList[id] = card
            WishListStore.emitReceive();
            break;
        */
        default:
    }
});

module.exports = WishListStore;
