var CardsWebAPIUtils = require('../utils/CardsWebAPIUtils');
var PricerAppDispatcher = require('../dispatcher/PricerAppDispatcher');
var PricerConstants = require('../constants/PricerConstants.js');

var ActionTypes = PricerConstants.ActionTypes;

module.exports = {

    createWishListItem: function(card) {
        PricerAppDispatcher.dispatch({
            type: ActionTypes.CLICK_ADD_TO_WISHLIST,
            card: card
        });
    },

    removeWishListItem: function(card) {
        PricerAppDispatcher.dispatch({
            type: ActionTypes.REMOVE_FROM_WISHLIST,
            card: card
        });
    },

    wishListItemAdded: function(card) {
        PricerAppDispatcher.dispatch({
            type: ActionTypes.ADDED_TO_WISHLIST,
            card: card
        });
        CardsWebAPIUtils.getCardPrice(card);
    }

};
