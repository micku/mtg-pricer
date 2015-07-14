var CardsServerActionCreators = require('../actions/CardsServerActionCreators');
var WishListCardServerActionCreators = require('../actions/WishListCardServerActionCreators');

var WEB_API_SEARCH_URL = '/api/search/{term}/';
var WEB_API_PRICE_URL = '/api/card/{card_id}/{card_name}/';

module.exports = {

    getCardsBySearchTerm: function(term) {
        if (term.length < 3) {
            CardsServerActionCreators.receiveBySearchTerm([]);
            return;
        }
        $.ajax({
            url: WEB_API_SEARCH_URL.replace('{term}', term),
            dataType: 'json',
            cache: false
        })
        .done(function(data) {
            CardsServerActionCreators.receiveBySearchTerm(data);
        })
        .fail(function(xhr, status, err) {
            console.error(status, err.toString());
        });
    },

    getCardPrice: function(card) {
        $.ajax({
            url: WEB_API_PRICE_URL
                .replace('{card_id}', card.id)
                .replace('{card_name}', card.name),
            dataType: 'json',
            cache: false
        })
        .done(function(data) {
            WishListCardServerActionCreators.receiveCardPrice(data);
        })
        .fail(function(xhr, status, err) {
            console.error(status, err.toString());
        });
    }

};
