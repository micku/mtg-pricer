var WishListCardActionCreators = require('../actions/WishListCardActionCreators');
var React = require('react');

var WishListItem = React.createClass({

    render: function() {
        return (
                <li className="wish-list-item collection-item">
                    <a onClick={this._onRemove} href="#"><i className="fa fa-minus-square-o fa-1x right"></i></a>
                    <span>{this.props.card.quantity}x</span> {this.props.card.name}
                </li>
               );
    },

    _onRemove: function(e) {
        e.preventDefault();
        WishListCardActionCreators.removeWishListItem(this.props.card);
    }
            
});

module.exports = WishListItem;
