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
                <li className="collection-item">No items yet!</li>
                );
        if (this.state.wishList.length>0) {
            wishListItems = this.state.wishList.map(getWishListItem);
        }

        return (
                <div className="row">
                    <div className="col s12">
                        <ul className="wishlist collection">
                            {wishListItems}
                        </ul>
                    </div>
                </div>
               );
    },

    _onChange: function() {
        this.setState(getStateFromStores());
    }
});

module.exports = WishList;
