var FoundCard = require('../components/FoundCard.react.js');
var React = require('react');

var FoundCards = React.createClass({
    render: function() {
        var cardNodes = this.props.data.map(function(card) {
            return (
                    <FoundCard multiverse_id={card.multiverse_id}>
                        {card.name}
                    </FoundCard>
                   );
        });

        return (
                <div className="foundCards row">
                    {cardNodes}
                </div>
               );
    }
});

module.exports = FoundCards;
