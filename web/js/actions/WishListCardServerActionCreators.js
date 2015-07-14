var PricerAppDispatcher = require('../dispatcher/PricerAppDispatcher');
var CardsWebAPIUtils = require('../utils/CardsWebAPIUtils');
var PricerConstants = require('../constants/PricerConstants.js');

var ActionTypes = PricerConstants.ActionTypes;

module.exports = {

    receiveCardPrice: function(price) {
        PricerAppDispatcher.dispatch({
            type: ActionTypes.PRICE_RECEIVED,
            card_id: price.card_id,
            prices: price.prices
        });
    }

};

