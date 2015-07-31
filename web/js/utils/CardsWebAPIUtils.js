var CardsServerActionCreators = require('../actions/CardsServerActionCreators');
var WishListCardServerActionCreators = require('../actions/WishListCardServerActionCreators');

var WEB_API_URL = '/api/search/{term}/';
var WEB_API_PRICE_URL = '/api/card-price/{card_id}/{card_name}/';

module.exports = { 

    searching: null,
    xhr: null,
    lastTerm: '',
    lastResult: [],

    getCardsBySearchTerm: function(term) {
        if (term.length < 3) {
            CardsServerActionCreators.receiveBySearchTerm([]);
            if (this.searching) clearTimeout(this.searching);
            if (this.xhr) this.xhr.abort();
            return;
        }
        if (term === this.lastTerm) {
            CardsServerActionCreators.receiveBySearchTerm(this.lastResult);
            if (this.searching) clearTimeout(this.searching);
            if (this.xhr) this.xhr.abort();
            return;
        }
        if (this.searching) clearTimeout(this.searching);
        if (this.xhr) this.xhr.abort();
        var that = this;

        this.searching = setTimeout(function() {
            that.xhr = $.ajax({
                url: WEB_API_URL.replace('{term}', term),
                dataType: 'json',
                cache: false
            })
            .done(function(data) {
                CardsServerActionCreators.receiveBySearchTerm(data);
                that.lastTerm = term;
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
