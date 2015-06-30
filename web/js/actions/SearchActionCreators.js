var CardsWebAPIUtils = require('../utils/CardsWebAPIUtils');
var PricerAppDispatcher = require('../dispatcher/PricerAppDispatcher');
var PricerConstants = require('../constants/PricerConstants.js');

var ActionTypes = PricerConstants.ActionTypes;

module.exports = {

    search: function(term) {
        PricerAppDispatcher.dispatch({
            type: ActionTypes.SEARCH,
            term: term
        });
        CardsWebAPIUtils.getCardsBySearchTerm(term);
    }

};
