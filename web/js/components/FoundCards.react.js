var FoundCard = require('../components/FoundCard.react');
var CardStore = require('../stores/CardStore');
var React = require('react');

function getStateFromStores() {
    return {
        cards: CardStore.getAll()
    };
}

function getCardListItem(card) {
    return (
            <FoundCard card={card} />
           );
}

var FoundCards = React.createClass({
    getInitialState: function() {
        return getStateFromStores();
    },

    componentDidMount: function() {
        CardStore.addSearchListener(this._onSearch);
    },

    componentWillUnmount: function() {
        CardStore.removeSearchListener(this._onSearch);
    },

    render: function() {
        var cardNodes = this.state.cards.map(getCardListItem);

        return (
                <div className="foundCards row">
                    {cardNodes}
                </div>
               );
    },

    _onSearch: function() {
        this.setState(getStateFromStores());
    }
});

module.exports = FoundCards;
