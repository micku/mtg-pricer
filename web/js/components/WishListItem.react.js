var WishListCardActionCreators = require('../actions/WishListCardActionCreators');
var CardPrice = require('../components/CardPrice.react');
var WishListStore = require('../stores/WishListStore');
var React = require('react');
var classNames = require('classnames');

var WishListItem = React.createClass({

    getInitialState: function() {
        var s = {
            card: this.props.card,
            loading: false
        }
        return s;
    },

    render: function() {
        var classes = classNames({
            'ui': true,
            'clearing': true,
            'segment': true,
            'wish-list-item': true,
            'loading': this.state.loading
        });
        return (
                <div className={classes}>
                        <button className="ui right floated icon tiny button" onClick={this._onRemove}>
                            <i className="fa fa-trash-o fa-1x"></i>
                        </button> 
                    <strong><span>{this.state.card.quantity}x</span> {this.state.card.name}</strong>
                    <div><CardPrice card={this.state.card} /></div>
                </div>
               );
    },

    _onRemove: function(e) {
        e.preventDefault();
        WishListCardActionCreators.removeWishListItem(this.props.card);
    }
            
});

module.exports = WishListItem;
