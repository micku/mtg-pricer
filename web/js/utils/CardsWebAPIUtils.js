var CardsServerActionCreators = require('../actions/CardsServerActionCreators');
var WishListCardServerActionCreators = require('../actions/WishListCardServerActionCreators');

var WEB_API_URL = '/api/search/{term}/';
var WEB_API_PRICE_URL = '/api/card/{card_id}/{card_name}/';

module.exports = {

    searching: null,
    xhr: null,
    lastTerm: '',
    lastResult: [],

    getCardsBySearchTerm: function(term) {
        if (term.length < 3) {
            CardsServerActionCreators.receiveBySearchTerm([]);
            return;
        }
        if (term === this.lastTerm) {
            CardsServerActionCreators.receiveBySearchTerm(this.lastResult);
            return;
        }
        if (this.searching) clearTimeout(this.searching);
        var that = this;
        this.lastTerm = term;

        this.searching = setTimeout(function() {
            if (that.xhr) that.xhr.abort();
            that.xhr = $.ajax({
                url: WEB_API_URL.replace('{term}', term),
                dataType: 'json',
                cache: false
            })
            .done(function(data) {
                CardsServerActionCreators.receiveBySearchTerm(data);
                that.lastResult = data;
                that.searching = null;
                that.xhr = null;
            })
            .fail(function(xhr, status, err) {
                if (status!=="abort") console.error(status, err.toString());
                that.searching = null;
                that.xhr = null;
            });
        }, 300);
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
