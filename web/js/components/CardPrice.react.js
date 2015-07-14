var WishListCardActionCreators = require('../actions/WishListCardActionCreators');
var WishListStore = require('../stores/WishListStore');
var React = require('react');

function getStateFromStores(id) {
    return {
        price: WishListStore.getPrice(id)
    };
}

var CardPrice = React.createClass({
    getInitialState: function() {
        return getStateFromStores(this.props.card.id);
    },

    componentDidMount: function() {
        WishListStore.addChangeListener(this._onChange);
        WishListCardActionCreators.wishListItemAdded(this.props.card);
    },

    componentWillUnmount: function() {
        WishListStore.removeChangeListener(this._onChange);
    },

    render: function() {
        return (
                <span className="card-price">&euro; {this.state.price.toFixed(2)}</span>
               );
    },

    _onChange: function() {
        state = getStateFromStores(this.props.card.id);
        this.setState(state);
    }
});

module.exports = CardPrice;

