var FoundCard = require('../components/FoundCard.react');
var CardStore = require('../stores/CardStore');
var React = require('react');

var search_term = null;

function getStateFromStores() {
    ret = CardStore.getAll();
    search_term = ret.search_term;
    return {
        cards: ret.cards
    };
}

function getCardListItem(card) {
    return (
            <FoundCard card={card} search_term={search_term} />
           );
}

var FoundCards = React.createClass({
    getInitialState: function() {
        return getStateFromStores();
    },

    componentDidMount: function() {
        CardStore.addReceiveSearchListener(this._onSearch);
    },

    componentWillUnmount: function() {
        CardStore.removeReceiveSearchListener(this._onSearch);
    },

    render: function() {
        var cardNodes = this.state.cards.map(getCardListItem);

        return (
                <div className="foundCards ui middle aligned divided list">
                    {cardNodes}
                </div>
               );
    },

    _onSearch: function() {
        this.setState(getStateFromStores());
    }
});

module.exports = FoundCards;
