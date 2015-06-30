var PricerAppDispatcher = require('../dispatcher/PricerAppDispatcher');
var PricerConstants = require('../constants/PricerConstants.js');

var ActionTypes = PricerConstants.ActionTypes;

module.exports = {

    receiveBySearchTerm: function(cards) {
        PricerAppDispatcher.dispatch({
            type: ActionTypes.RECEIVE_CARDS_LIST,
            cards: cards
        });
    },
};
