var WishListItem = require('../components/WishListItem.react');
var WishListStore = require('../stores/WishListStore');
var React = require('react');

function getStateFromStores() {
    return {
        wishList: WishListStore.getAll()
    };
}

function getWishListItem(card) {
    return (
            <WishListItem card={card} />
           );
}

var WishList = React.createClass({
    getInitialState: function() {
        return getStateFromStores();
    },

    componentDidMount: function() {
        //CardStore.addSearchListener(this._onSearch);
        WishListStore.addChangeListener(this._onChange);
    },

    componentWillUnmount: function() {
        WishListStore.removeChangeListener(this._onChange);
    },

    render: function() {
        var wishListItems = (
                <div className="ui segment"><p>No items yet!</p></div>
                );
        if (this.state.wishList.length>0) {
            wishListItems = this.state.wishList.map(getWishListItem);
        }

        return (
                <div className="wishlist ui segments">
                    {wishListItems}
                </div>
               );
    },

    _onChange: function() {
        this.setState(getStateFromStores());
    }
});

module.exports = WishList;
