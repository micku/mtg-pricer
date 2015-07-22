var WishListCardActionCreators = require('../actions/WishListCardActionCreators');
var React = require('react');

var FoundCard = React.createClass({
    render: function() {
        var image_url = 'http://api.mtgdb.info/content/card_images/' + this.props.card.multiverse_id + '.jpeg';
        return (
                <div className="foundCard item">
                    <div className="content ui grid">
                        <div className="six wide column">
                            <a className="cardName">{this.props.card.name}</a>
                            <div className="foundTerm" dangerouslySetInnerHTML={this.foreignName(this.props.card, this.props.search_term)}></div>
                        </div>
                        <div className="two wide column">
                            <div className="mana-cost" dangerouslySetInnerHTML={this.manaCost(this.props.card)}></div>
                        </div>
                        <div className="six wide column">
                        </div>
                        <div className="two wide column middle aligned right aligned">
                            <button className="ui icon button mini green" onClick={this._onClick}>
                                <i className="fa fa-plus fa-1x right"></i>
                            </button>
                        </div>
                    </div>
                </div>
               );
    },

    _onClick: function(e) {
        e.preventDefault();
        WishListCardActionCreators.createWishListItem(this.props.card);
    },

    foreignName: function(card, term) {
        var regexp = new RegExp("(" + term + ")","ig");
        var foreignName = null;
        card.foreign_names.forEach(function(f) {
            if (!foreignName && f.name.match(regexp)) {
                foreignName = f;
            }
        });
        var text = {
            __html: 
                "["+foreignName.language.name+"] "+ foreignName.name
                .replace(
                        regexp,
                        '<i>$1</i>'
                        )
        };
        return text;
    },

    manaCost: function(card) {
        if (!card.mana_cost)
            return { __html: "" };

        cardImageTpl = '<span class="mana small s{cost}"></span>';
        cost = card.mana_cost.match(/{([^}]+)}/g);
        costImages = "";
        cost.forEach(function(c) {
            code = c.match(/[0-9a-zA-Z]/g).join('').toLowerCase();
            costImages += cardImageTpl.replace('{cost}', code);
        });
        return {
            __html: costImages
        };
    }
});

module.exports = FoundCard;
