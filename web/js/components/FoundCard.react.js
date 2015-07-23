var WishListCardActionCreators = require('../actions/WishListCardActionCreators');
var React = require('react');

var FoundCard = React.createClass({
    render: function() {
        var image_url = 'http://api.mtgdb.info/content/card_images/' + this.props.card.multiverse_id + '.jpeg';
        return (
                <div className="foundCard item">
                    <div className="content ui grid">
                        <div className="five wide column">
                            <img src={this.setIcon(this.props.card)} className="set-icon" /><a className="cardName">{this.props.card.name}</a>
                            <div className="foundTerm" dangerouslySetInnerHTML={this.foreignName(this.props.card, this.props.search_term)}></div>
                        </div>
                        <div className="two wide column">
                            <div className="mana-cost" dangerouslySetInnerHTML={this.manaCost(this.props.card)}></div>
                        </div>
                        <div className="eight wide column">
                            <span>{this.props.card.type}</span>
                            <div className="card-text" dangerouslySetInnerHTML={this.iconifyText(this.props.card.text||"")}></div>
                        </div>
                        <div className="one wide column middle aligned right aligned">
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
                '<i class="'+foreignName.language.code+' flag"></i>'+ foreignName.name
                .replace(
                        regexp,
                        '<i>$1</i>'
                        )
        };
        return text;
    },

    cardImageTpl: '<span class="mana small s{cost}"></span>',

    manaCost: function(card) {
        if (!card.mana_cost)
            return { __html: "" };

        var cost = card.mana_cost.match(/{([^}]+)}/g);
        var costImages = "";
        var that = this;
        cost.forEach(function(c) {
            code = c.match(/[0-9a-zA-Z]/g).join('').toLowerCase();
            costImages += that.cardImageTpl.replace('{cost}', code);
        });
        return {
            __html: costImages
        };
    },

    iconifyText: function(text) {
        var that = this;
        text = text.replace(/{([^}]*)}/g, function(match, p1){
            return that.cardImageTpl.replace('{cost}', p1.toLowerCase())
        });
        return {
            __html: '<i>'+text+'</i>'
        };
    },

    setIcon: function(card) {
        rarity_code = card.sets[0].code.toLowerCase() + '_';
        rarity_code += card.rarity.name.substring(0, 1).toLowerCase().replace('b', 'c');

        return '/images/sets/'+rarity_code+'.png';
    }
});

module.exports = FoundCard;
