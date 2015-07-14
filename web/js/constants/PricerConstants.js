var keyMirror = require('keymirror');

module.exports = {

    ActionTypes: keyMirror({
        ADDED_TO_WISHLIST: null,
        CLICK_ADD_TO_WISHLIST: null,
        REMOVE_FROM_WISHLIST: null,
        RECEIVE_WISHLSIT: null,
        SEARCH: null,
        RECEIVE_CARDS_LIST: null
    })
};
