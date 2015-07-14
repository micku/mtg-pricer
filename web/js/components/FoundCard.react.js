var WishListCardActionCreators = require('../actions/WishListCardActionCreators');
var React = require('react');

var FoundCard = React.createClass({
    render: function() {
        var image_url = 'http://api.mtgdb.info/content/card_images/' + this.props.card.multiverse_id + '.jpeg';
        return (
                <div className="foundCard col s12 m3">
                    <div className="card small blue-grey darken-1">
                        <div className="card-image">
                          <img src={image_url} />
                          <p className="cardName card-title">{this.props.card.name}</p>
                        </div>
                        <div className="card-content white-text">
                            <a onClick={this._onClick} href="#"><i className="fa fa-plus-square-o fa-2x right"></i></a>
                            <p className="cardName">{this.props.card.name}</p>
                            <p className="foundTerm" dangerouslySetInnerHTML={this.foreignName(this.props.card, this.props.search_term)}></p>
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
        var text = {
            __html: 
                "["+card.foreign_names[0].language.name+"] "+ card.foreign_names[0].name
                .replace(
                        regexp,
                        '<i>$1</i>'
                        )
        };
        return text;
    }
});

module.exports = FoundCard;
