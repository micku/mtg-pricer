var CardsServerActionCreators = require('../actions/CardsServerActionCreators');

var WEB_API_URL = '/api/search/{term}/';

module.exports = {

    getCardsBySearchTerm: function(term) {
        if (term.length < 3) {
            CardsServerActionCreators.receiveBySearchTerm([]);
            return;
        }
        $.ajax({
            url: WEB_API_URL.replace('{term}', term),
            dataType: 'json',
            cache: false
        })
        .done(function(data) {
            CardsServerActionCreators.receiveBySearchTerm(data);
        })
        .fail(function(xhr, status, err) {
            console.error(status, err.toString());
        });
    }

};
